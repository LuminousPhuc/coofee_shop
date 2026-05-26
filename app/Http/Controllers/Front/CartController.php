<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OptionValue;
use App\Models\Topping;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0;

        foreach ($cart as $key => $data) {
            $product = Product::find($data['product_id']);
            if (!$product) continue;

            $price = $product->base_price;
            $optionNames = [];
            $toppingNames = [];

            if (!empty($data['options'])) {
                $optionValues = OptionValue::whereIn('id', $data['options'])->get();
                foreach ($optionValues as $ov) {
                    $price += $ov->price_adjustment;
                    $optionNames[] = $ov->name . ($ov->price_adjustment > 0 ? ' (+' . number_format($ov->price_adjustment) . 'đ)' : '');
                }
            }

            if (!empty($data['toppings'])) {
                $toppingModels = Topping::whereIn('id', $data['toppings'])->get();
                foreach ($toppingModels as $tp) {
                    $price += $tp->price;
                    $toppingNames[] = $tp->name . ' (+' . number_format($tp->price) . 'đ)';
                }
            }

            $subtotal = $price * $data['quantity'];
            $total += $subtotal;

            $items[] = [
                'key'          => $key,
                'product'      => $product,
                'quantity'     => $data['quantity'],
                'options'      => $data['options'] ?? [],
                'toppings'     => $data['toppings'] ?? [],
                'option_names' => $optionNames,
                'topping_names'=> $toppingNames,
                'price'        => $price,
                'subtotal'     => $subtotal,
            ];
        }

        return view('front.cart', compact('items', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = $this->getCart();

        // Create unique key based on product + options + toppings
        // Options come as associative array keyed by group_id (from radio buttons)
        // e.g. options[1] = 3, options[2] = 7  → we want [3, 7]
        $rawOptions = $request->input('options', []);
        $options = is_array($rawOptions) ? array_values(array_filter($rawOptions)) : [];
        $toppings = $request->input('toppings', []);
        sort($options);
        sort($toppings);
        $cartKey = $id . '_' . md5(json_encode($options) . json_encode($toppings));

        $qty = max(1, (int)$request->input('quantity', 1));

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $qty;
        } else {
            $cart[$cartKey] = [
                'product_id' => $id,
                'quantity'   => $qty,
                'options'    => $options,
                'toppings'   => $toppings,
            ];
        }

        $this->saveCart($cart);

        if ($request->ajax()) {
            $cartCount = array_sum(array_column($cart, 'quantity'));
            return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!', 'cartCount' => $cartCount]);
        }

        return back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, $key)
    {
        $cart = $this->getCart();
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = max(1, (int)$request->input('quantity', 1));
            $this->saveCart($cart);
        }
        return back();
    }

    public function destroy($key)
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);
        return back()->with('success', 'Đã xóa khỏi giỏ hàng.');
    }

    private function getCart()
    {
        if (auth()->check()) {
            $cartModel = Cart::with('items')->firstOrCreate(['user_id' => auth()->id()]);
            $items = [];
            foreach ($cartModel->items as $item) {
                $options = $item->options ?? [];
                $toppings = $item->toppings ?? [];
                sort($options);
                sort($toppings);
                $key = $item->product_id . '_' . md5(json_encode($options) . json_encode($toppings));
                
                $items[$key] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'options'    => $options,
                    'toppings'   => $toppings,
                ];
            }
            return $items;
        }
        return session('cart', []);
    }

    private function saveCart($cart)
    {
        if (auth()->check()) {
            $cartModel = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $cartModel->items()->delete();
            
            foreach ($cart as $data) {
                $cartModel->items()->create([
                    'product_id' => $data['product_id'],
                    'quantity'   => $data['quantity'],
                    'options'    => $data['options'] ?? [],
                    'toppings'   => $data['toppings'] ?? [],
                ]);
            }
        } else {
            session(['cart' => $cart]);
        }
    }
}
