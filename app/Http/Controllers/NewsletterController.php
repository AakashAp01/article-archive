<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    // 1. Subscribe a new user
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255'
        ]);

        $subscriber = Newsletter::where('email', $request->email)->first();

        if ($subscriber) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already subscribed.'
            ], 422);
        }

        Newsletter::create([
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully subscribed to the newsletter.'
        ]);
    }

    // 2. Show the confirmation page
    public function showUnsubscribeForm($email)
    {
        try {
            $decodedEmail = base64_decode(urldecode($email));

            if (!filter_var($decodedEmail, FILTER_VALIDATE_EMAIL)) {
                return view('newsletter.error', ['message' => 'Invalid email address.']);
            }
            
            $subscriber = Newsletter::where('email', $decodedEmail)->first();

            if (!$subscriber) {
                return view('newsletter.error', ['message' => 'Subscriber not found.']);
            }

            if ($subscriber->is_active == 0) {
                return view('newsletter.error', ['message' => 'You are already unsubscribed.']);
            }

            return view('newsletter.confirm-unsubscribe', ['encoded_email' => $email]);
            
        } catch (\Throwable $e) {
            abort(500);
        }
    }

    // 3. Process the unsubscription
    public function processUnsubscribe(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'reason' => 'nullable|string|max:500'
        ]);

        try {
            $decodedEmail = base64_decode(urldecode($request->token));

            $subscriber = Newsletter::where('email', $decodedEmail)->firstOrFail();

            $subscriber->update([
                'is_active' => 0,
                'unsubscribe_reason' => $request->reason
            ]);

            return view('newsletter.success', [
                'message' => 'You have been successfully unsubscribed.'
            ]);

        } catch (\Throwable $e) {
            return view('newsletter.error', ['message' => 'An error occurred while unsubscribing.']);
        }
    }
}