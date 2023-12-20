<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stripe;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Exception;
use Stripe_Error;

class StripeController extends Controller
{
    public function stripeCheckOut(Request $request)
    {
        $product = [];
        $productId = $request->id;
        $userId = $request->userId;
        $quantity = $request->quantity;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $productDetails = Product::where('id', $productId)->get();
        $totalPrice = 0;
        foreach ($productDetails as $key => $products) {
            $totalPrice += $products->price;
            $product[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $products->title,
                        'description' => $products->description,
                    ],
                    'unit_amount' => $products->price * 100,
                ],
                'quantity' => $quantity,
            ];
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [$product],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost:4242/cancel',
        ]);

        $order = new Stripe();
        $order->product_id = $productId;
        $order->user_id = $userId;
        $order->status = 'unpaid';
        $order->amount = $totalPrice * $quantity;
        $order->card_number = $checkout_session;
        $order->save();

        return redirect()->away($checkout_session->url);
    }

    public function successStripe(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');

        $session = $stripe->checkout->sessions->retrieve($session_id);
        if (!$session) {
            throw new NotFoundHttpException;
        }
        // return $session['customer_details'];

        // return $customer = $stripe->customers->retrieve($session->name);
        return view('success');
        // return $session_id;
    }

    public function webHook()
    {
        $endpoint_secret = env('WEB_HOOK_SECRET_KEY');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        // This is your Stripe CLI webhook secret for testing your endpoint locally.

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response(400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response(400);

            // Handle the event
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    // ... handle other event types
                default:
                    echo 'Received unknown event type ' . $event->type;
            }
        }
        return response(400);
    }
}
