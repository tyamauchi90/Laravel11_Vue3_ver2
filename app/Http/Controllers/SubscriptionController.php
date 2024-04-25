<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    Stripe::setApiKey(env('STRIPE_SECRET'));
    $intent = auth()->user()->createSetupIntent();

    return Inertia::render('Subscription/Index', ['intent' => $intent]);
  }
}
