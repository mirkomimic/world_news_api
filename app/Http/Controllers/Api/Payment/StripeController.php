<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeController extends Controller
{
  protected $stripe;
  protected string $stripeSecret;

  public function __construct()
  {
    $this->stripeSecret = env('STRIPE_SECRET');
    $this->stripe = new StripeClient($this->stripeSecret);
  }

  public function listAllIntents(): object
  {
    $intents = $this->stripe->paymentIntents->all([
      'limit' => 100,
    ]);

    return response()->json([
      'intents' => $intents,
    ]);
  }

  public function createIntent(Request $request): object
  {

    $request->validate([
      'amount' => 'required|numeric'
    ]);

    $intent = $this->stripe->paymentIntents->create([
      'amount' => $request->amount * 100,
      'currency' => 'usd',
      // 'automatic_payment_methods' => ['enabled' => true],
      'payment_method_types' => ['card'],
    ]);

    return response()->json([
      'client_secret' => $intent->client_secret
    ], 200);
  }

  public function retrieveIntent(Request $request): object
  {
    $intent = $this->stripe->paymentIntents->retrieve("pi_3OkolGKnRuwVl5Iv1t5oeQpW");

    return response()->json([
      'intent' => $intent
    ]);
  }

  // public function confirmIntent(Request $request): object
  // {

  //   $response = $this->stripe->paymentIntents->confirm(
  //     'pi_3Okp9iKnRuwVl5Iv16GaPYd5',
  //     [
  //       'payment_method' => 'pm_card_visa',
  //       'return_url' => 'https://www.example.com',
  //     ]
  //   );

  //   return response()->json([
  //     'response' => $response
  //   ]);
  // }

  public function cancelIntent(Request $request): object
  {

    $intent = $this->stripe->paymentIntents->cancel('pi_3OkolGKnRuwVl5Iv1t5oeQpW', []);

    return response()->json([
      'intent' => $intent
    ]);
  }
}
