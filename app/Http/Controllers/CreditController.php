<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditTransaction;

class CreditController extends Controller
{
    // Laat het huidige saldo en transacties zien
    public function show()
    {
        $user = Auth::user();
        $transactions = CreditTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('credits.credit', compact('user', 'transactions'));
    }

    // Voeg krediet toe
    public function addCredit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Normaal zou hier een betaling plaatsvinden via Mollie, Stripe, etc.
        $user->credits += $amount;
        $user->save();

        // Transactie opslaan
        CreditTransaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'payment_method' => $request->input('payment_method'),
        ]);

        return redirect()->route('credits')->with('success', "Je hebt €{$amount} toegevoegd aan je saldo!");
    }
}