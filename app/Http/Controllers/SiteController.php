<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index($username)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->first();

        $products = \App\Models\Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('category')
            ->orderBy('id', 'desc')
            ->get();

        $categories = \App\Models\Category::where('user_id', $user->id)
            ->where('is_published', true)
            ->get();

        return Inertia::render('domain/Index', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function products($username)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->first();

        $products = \App\Models\Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('category')
            ->orderBy('id', 'desc')
            ->get();

        $categories = \App\Models\Category::where('user_id', $user->id)
            ->where('is_published', true)
            ->get();

        return Inertia::render('domain/Products', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function product($username, $slug)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->first();

        $product = \App\Models\Product::where('user_id', $user->id)
            ->where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        return Inertia::render('domain/ProductDetail', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'product' => $product,
        ]);
    }

    public function contact($username)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->firstOrFail();

        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        \App\Models\Contact::create([
            'site_id' => $site->id,
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message'),
        ]);

        return response()->json(['success' => true]);
    }

    public function category($username, $slug)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->first();

        $category = \App\Models\Category::where('user_id', $user->id)
            ->where('slug', $slug)
            ->firstOrFail();

        $products = \App\Models\Product::where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('is_published', true)
            ->with('category')
            ->get();

        $categories = \App\Models\Category::where('user_id', $user->id)
            ->where('is_published', true)
            ->get();

        return Inertia::render('domain/Categories', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function search($username)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->first();
        $query = request('q');

        $products = \App\Models\Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->where('title', 'like', "%{$query}%")
            ->with('category')
            ->get();

        return Inertia::render('domain/Index', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'products' => $products,
            'search_query' => $query,
        ]);
    }

    public function page($username, $slug)
    {
        $user = \App\Models\User::where('name', $username)->firstOrFail();
        $site = \App\Models\Site::where('user_id', $user->id)->firstOrFail();

        // Find page by slug in the pages JSON array
        $pages = $site->pages ?? [];
        $pageData = collect($pages)->firstWhere('slug', $slug);

        if (!$pageData) {
            abort(404);
        }

        return Inertia::render('domain/Page', [
            'theme' => $site->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'page' => $pageData,
        ]);
    }
}
