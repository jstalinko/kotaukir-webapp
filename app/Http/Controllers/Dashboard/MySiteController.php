<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Site;
use Inertia\Inertia;

class MySiteController extends Controller
{
    public function index()
    {
        $site = Site::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'site_name' => auth()->user()->name,
                'theme' => 'default',
                'components' => [],
                'pages' => [],
                'menus' => [],
            ]
        );

        // Seed default components if empty
        if (empty($site->components)) {
            $site->components = [
                'default' => [
                    [
                        'id' => 1,
                        'type' => 'Hero',
                        'settings' => [
                            'title' => 'Keindahan <span class="text-orange-600 italic">Klasik</span> untuk Rumah Anda.',
                            'subtitle' => 'Temukan koleksi furniture kayu jati pilihan yang dikerjakan dengan presisi tinggi oleh pengrajin terbaik kami. Keindahan abadi dalam setiap serat kayu.',
                            'image' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                        ]
                    ],
                    [
                        'id' => 2,
                        'type' => 'Featured',
                        'settings' => [
                            'title' => 'Koleksi <span class="italic text-orange-600">Terbaik</span> Kami',
                            'subtitle' => 'Produk terpopuler yang menjadi pilihan utama pelanggan kami bulan ini.'
                        ]
                    ]
                ],
                'basic' => [
                    [
                        'id' => 101,
                        'type' => 'Hero',
                        'settings' => [
                            'title' => 'Modern & <span class="italic font-light">Minimalist</span> Essentials.',
                            'subtitle' => 'Curated collection for the contemporary lifestyle.'
                        ]
                    ],
                    [
                        'id' => 102,
                        'type' => 'Featured',
                        'settings' => [
                            'title' => 'Seasonal <span class="italic font-light">Selects</span>',
                            'subtitle' => 'Handpicked items for this season.'
                        ]
                    ]
                ]
            ];
            $site->save();
        }

        // Seed default menus if empty
        if (empty($site->menus)) {
            $site->menus = [
                ['id' => 1, 'label' => 'Home', 'url' => '/domain/' . auth()->user()->name],
                ['id' => 2, 'label' => 'Produk', 'url' => '/domain/' . auth()->user()->name . '/category/all'],
                ['id' => 3, 'label' => 'Tentang Kami', 'url' => '#'],
                ['id' => 4, 'label' => 'Kontak', 'url' => '#'],
            ];
            $site->save();
        }

        return Inertia::render('dashboard/MySiteForm', [
            'site' => $site,
        ]);
    }

    public function themeStore()
    {
        return Inertia::render('dashboard/ThemeStore');
    }

    public function update(Request $request)
    {
        $site = Site::where('user_id', auth()->id())->firstOrFail();

        // Handle logo if it's sent as an array from ImagePicker
        if (is_array($request->site_logo)) {
            $request->merge(['site_logo' => $request->site_logo[0] ?? null]);
        }

        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|string',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string',
            'site_slogan' => 'nullable|string',
            'theme' => 'required|string',
            'components' => 'nullable|array',
            'pages' => 'nullable|array',
            'menus' => 'nullable|array',
        ]);

        $site->update($data);

        return back()->with('success', 'Site settings updated successfully.');
    }
}
