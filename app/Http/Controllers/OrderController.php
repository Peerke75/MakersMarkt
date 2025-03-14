<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validatie
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:ideal,paypal,creditcard,v-pay',
        ]);

        // Order aanmaken
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'verzonden', // Eventueel later aanpassen
            'completed_at' => now(),
        ]);

        // OrderLine toevoegen
        OrderLine::create([
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        // Redirect met succesbericht
        return redirect()->route('orders.show', $order->id)->with('success', 'Bestelling geplaatst!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('orderLines.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
