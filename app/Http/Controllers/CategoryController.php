<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $categories = Category::where('user_id', $auth->id)->orderBy('id', 'desc')->get();

        return Inertia::render('dashboard/category/CategoryList', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('dashboard/category/CategoryForm', [
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $auth = Auth::user();

        Category::create([
            'user_id' => $auth->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'image' => $request->image,
            'is_published' => $request->is_published ?? true,
        ]);

        return redirect()->route('dashboard.category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $auth = Auth::user();
        $category = Category::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        return Inertia::render('dashboard/category/CategoryForm', [
            'isEdit' => true,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $auth = Auth::user();
        $category = Category::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'image' => $request->image,
            'is_published' => $request->is_published ?? $category->is_published,
        ]);

        return redirect()->route('dashboard.category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $auth = Auth::user();
        $category = Category::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        // Ensure no products are using this category or handle it
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->route('dashboard.category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
