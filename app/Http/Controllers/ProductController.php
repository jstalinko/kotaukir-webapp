<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $products = $auth->role == 'admin'
            ? Product::with('category')->orderBy('id', 'desc')->get()
            : Product::with('category')->where('user_id', $auth->id)->orderBy('id', 'desc')->get();

        return Inertia::render('dashboard/product/ProductList', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auth = Auth::user();
        return Inertia::render('dashboard/product/ProductForm', [
            'isEdit' => false,
            'categories' => Category::where('user_id', $auth->id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'images' => 'nullable|array',
        ]);
        if ($validate->fails()) {
            //            dd($validate->errors());
            return redirect()->back()->with('error', $validate->errors()->first());
        }

        $auth = Auth::user();

        Product::create([
            'user_id' => $auth->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'tags' => json_encode($request->tags ?? []),
            'images' => json_encode($request->images ?? ['https://placehold.co/600x400/8d6e63/FFFFFF?text=NO+IMAGE']),
            'is_published' => $request->is_published ?? true,
            'published_at' => now(),
        ]);

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $auth = Auth::user();
        $product = Product::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        return Inertia::render('dashboard/product/ProductForm', [
            'isEdit' => true,
            'product' => $product,
            'categories' => Category::where('user_id', $auth->id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'images' => 'nullable|array',
        ]);

        $auth = Auth::user();
        $product = Product::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'tags' => json_encode($request->tags ?? []),
            'images' => json_encode($request->images ?? $product->images),
            'is_published' => $request->is_published ?? $product->is_published,
        ]);

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $auth = Auth::user();
        $product = Product::where('user_id', $auth->id)->where('id', $id)->firstOrFail();
        $product->delete();

        return redirect()->route('dashboard.product.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(string $id)
    {
        $auth = Auth::user();
        $product = Product::where('user_id', $auth->id)->where('id', $id)->firstOrFail();
        $product->update([
            'is_published' => !$product->is_published,
            'published_at' => !$product->is_published ? now() : $product->published_at,
        ]);

        return redirect()->route('dashboard.product.index')->with('success', 'Status produk berhasil diubah.');
    }
}
