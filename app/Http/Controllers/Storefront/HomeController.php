<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with([
                'category',
                'activeVariants',
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $popularProducts = $products
            ->where('is_popular', true)
            ->take(8);

        $heroBanners = Banner::query()
            ->where('is_active', true)
            ->where('position', 'hero')
            ->where(function ($query): void {
                $query
                    ->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query): void {
                $query
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            })
            ->orderBy('sort_order')
            ->get();

        return view('pages.home', compact(
            'categories',
            'products',
            'popularProducts',
            'heroBanners',
        ));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'category',
            'activeVariants',
        ]);

        $relatedProducts = Product::query()
            ->with('activeVariants')
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('pages.product-show', compact(
            'product',
            'relatedProducts',
        ));
    }
}