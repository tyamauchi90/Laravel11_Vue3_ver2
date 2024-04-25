<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PurchaseController extends Controller
{
  /**
   * Process payment
   */
  public function processPayment(Request $request)
  {
    // トランザクション開始
    DB::beginTransaction();
    try {
      Stripe::setApiKey(env('STRIPE_SECRET'));

      $paymentMethodId = $request->input('paymentMethodId');
      $paymentIntent = PaymentIntent::create([
        'amount' => 1000,
        'currency' => 'jpy',
        // 'payment_method_types' => ['card'],
        'payment_method' => $paymentMethodId,
        'confirm' => true,
        'return_url' => 'http://localhost:8000/event',
        // 'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'], // リダイレクトを許可しない設定を追加
      ]);

      // 決済成功後の処理
      $validatedData = $request->validate([
        'event_id' => 'required|exists:events,id',
        'apply_date' => 'required|date',
        'is_paid' => 'required',
      ]);

      $validatedData['user_id'] = auth()->id();

      Application::create($validatedData);

      // トランザクションをコミット
      DB::commit();

      return redirect()->route('event.index')->with([
        'message' => '決済完了しました',
        'status' => 'success'
      ]);
    } catch (\Exception $e) {
      // エラーが発生した場合はロールバック
      DB::rollBack();
      Log::error('Payment processing failed: ' . $e->getMessage());
      return redirect()->route('event.index')->with([
        'message' => '決済に失敗しました',
        'status' => 'danger'
      ]);
    }
  }
}
