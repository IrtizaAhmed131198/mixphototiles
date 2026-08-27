<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CollectionsController extends Controller
{
    public function index()
    {
        $products = Product::where('type', 'collections')
            ->where('status', 1)
            ->whereNotNull('coordinates')
            ->orderBy('price', 'asc')
            ->paginate(10); // 10 per page

        return view('livewire.collections', compact('products'));
    }

    public function loadMoreProducts(Request $request)
    {
        $products = Product::where('type', 'collections')
            ->where('status', 1)
            ->whereNotNull('coordinates')
            ->orderBy('price', 'asc')
            ->paginate(10); // 10 per page

        if ($request->ajax()) {
            $html = view('partials.product_card', compact('products'))->render();
            return response()->json([
                'html' => $html,
                'hasMore' => $products->hasMorePages(),
            ]);
        }

        return view('livewire.collections', compact('products')); // initial load
    }
}
