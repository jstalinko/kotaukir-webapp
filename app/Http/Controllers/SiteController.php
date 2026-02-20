<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Site;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;

class SiteController extends Controller
{
    private function shareGlobalDomainData(User $user, ?Site $site)
    {
        $best_products = Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('category')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        Inertia::share('domain', [
            'user' => $user->only(['name', 'email', 'address', 'city', 'province', 'postal_code', 'phone']),
            'site' => $site,
            'best_products' => $best_products,
        ]);
    }

    public function index($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $products = Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('category')
            ->orderBy('id', 'desc')
            ->get();

        $categories = Category::where('user_id', $user->id)
            ->where('is_published', true)
            ->get();

        $latest_posts = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->where('type', 'post')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return Inertia::render('domain/Index', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'products' => $products,
            'categories' => $categories,
            'latest_posts' => $latest_posts,
        ]);
    }

    public function products($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $products = Product::where('user_id', $user->id)
            ->where('is_published', true)
            ->with('category')
            ->orderBy('id', 'desc')
            ->get();

        $categories = Category::where('user_id', $user->id)
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
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $product = Product::where('user_id', $user->id)
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

    public function category($username, $slug)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $category = Category::where('user_id', $user->id)
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::where('user_id', $user->id)
            ->where('category_id', $category->id)
            ->where('is_published', true)
            ->with('category')
            ->get();

        $categories = Category::where('user_id', $user->id)
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
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();
        $query = request('q');

        $this->shareGlobalDomainData($user, $site);

        $products = Product::where('user_id', $user->id)
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
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->firstOrFail();

        $this->shareGlobalDomainData($user, $site);

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

    public function posts($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $posts = Post::where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('domain/Posts', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'posts' => $posts,
        ]);
    }

    public function post($username, $slug)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->first();

        $this->shareGlobalDomainData($user, $site);

        $post = Post::where('user_id', $user->id)
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return Inertia::render('domain/PostDetail', [
            'theme' => $site?->theme ?? 'default',
            'user' => $user,
            'site' => $site,
            'post' => $post,
        ]);
    }

    public function contact($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $site = Site::where('user_id', $user->id)->firstOrFail();

        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create([
            'site_id' => $site->id,
            'name' => request('name'),
            'email' => request('email'),
            'message' => request('message'),
        ]);

        return response()->json(['success' => true]);
    }
}
