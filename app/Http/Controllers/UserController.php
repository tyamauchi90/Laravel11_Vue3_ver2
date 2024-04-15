<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function update(Request $request)
  {
    $user = Auth::user();
    $validatedData = $request->validate([
      'kana' => 'required|string|max:50|regex:/^[ァ-ヾ]+$/u', // カタカナのみ
      'role' => 'required|in:member,admin,master',
      'birthday' => 'required|date',
    ]);

    $user->update($validatedData);

    return redirect()->route('dashboard')->with('status', 'プロフィールが更新されました。');
  }
}
