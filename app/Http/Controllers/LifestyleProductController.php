<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LifestyleProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LifestyleProductController extends Controller
{
    /**
     * Display a listing of lifestyle products.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        
        $products = LifestyleProduct::query()
            ->active()
            ->when($category, function($query, $category) {
                return $query->where('category', $category);
            })
            ->latest()
            ->paginate(12);

        $categories = LifestyleProduct::active()
            ->distinct()
            ->pluck('category');

        return Inertia::render('lifestyle/products/index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(LifestyleProduct $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return Inertia::render('lifestyle/products/show', [
            'product' => $product
        ]);
    }
}