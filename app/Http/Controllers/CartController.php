<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Toon de winkelwagen
    public function showCart()
    {
        $cart = session()->get('cart', []);

        return view('cart.cart', compact('cart'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        // Haal het aantal uit de request (standaard naar 1 als het niet is meegegeven)
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity; // Voeg het opgegeven aantal toe
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity, // Bewaar het aantal correct
                "price" => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('products')->with('success', 'Product toegevoegd aan winkelwagen!');
    }

    public function updateCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->input('quantity', 1);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    // Verwijder product uit winkelwagen
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Product verwijderd uit de winkelwagen.');
    }

    // Verwijder de winkelwagen
    public function deleteCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->delete();
        }

        session()->forget('cart');

        return redirect()->route('cart.show')->with('success', 'Winkelwagen verwijderd!');
    }

    // Plaats de bestelling
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Je winkelwagen is leeg.');
        }

        $user = auth()->user();
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Controleer of de gebruiker "Eigen saldo" als betaalmethode heeft gekozen
        if ($request->input('payment_method') === 'own_money') {
            if ($user->credits < $totalPrice) {
                return redirect()->route('cart.show')->with('error', 'Je hebt niet genoeg saldo om deze bestelling te plaatsen.');
            }

            // Trek het bedrag af van het saldo **voor** de transactie
            $user->credits -= $totalPrice;
            $user->save();
        }

        try {
            \DB::beginTransaction(); // Start database-transactie

            // Maak de bestelling aan
            $order = $user->orders()->create([
                'status' => 'geplaatst',
                'completed_at' => now(),
                'payment_method' => $request->input('payment_method'),
            ]);

            // Voeg de producten toe aan de bestelling
            foreach ($cart as $productId => $item) {
                $order->orderLines()->create([
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                ]);
            }

            \DB::commit(); // Bevestig de database-operaties

            session()->forget('cart'); // Winkelwagen legen

            return redirect()->route('orders.show', $order->id)->with('success', 'Bestelling geplaatst!');
        } catch (\Exception $e) {
            \DB::rollBack(); // Herstel wijzigingen als er iets misgaat
            return redirect()->route('cart.show')->with('error', 'Er is iets misgegaan bij het afrekenen. Probeer het opnieuw.');
        }
    }

    public function getCartCount()
    {
        return session('cart') ? count(session('cart')) : 0;
    }
}
