<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\RouteHelper;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::whereNull('deleted_at')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);

        Product::create([
            'product_name' => $validated['product_name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'created_by' => $currentUserId,
        ]);

        toastr()->success('Product added successfully');
        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'products');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        $currentUserId = auth('admin')->check() ? auth('admin')->user()->id : (auth()->check() ? auth()->user()->id : null);

        $product->update([
            'product_name' => $validated['product_name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'updated_by' => $currentUserId,
        ]);

        toastr()->success('Product updated successfully');
        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'products');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('admin.products')->with('error', 'Product not found.');
        }

        $product->delete();

        toastr()->success('Product deleted successfully');
        $routePrefix = RouteHelper::isSuperAdmin() ? 'admin.' : (RouteHelper::isCustomer() ? 'customer.' : 'staff.');
        return redirect()->route($routePrefix . 'products');
    }
}
