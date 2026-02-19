export const componentRegistry = {
    default: [
        {
            type: 'Hero',
            name: 'Hero Section',
            icon: 'LayoutTemplate',
            defaultSettings: {
                title: 'Keindahan <span class="text-orange-600 italic">Klasik</span> untuk Rumah Anda.',
                subtitle:
                    'Temukan koleksi furniture kayu jati pilihan yang dikerjakan dengan presisi tinggi oleh pengrajin terbaik kami.',
            },
        },
        {
            type: 'Featured',
            name: 'Featured Products',
            icon: 'Star',
            defaultSettings: {
                title: 'Koleksi <span class="italic text-orange-600">Terbaik</span> Kami',
                subtitle:
                    'Produk terpopuler yang menjadi pilihan utama pelanggan kami bulan ini.',
            },
        },
        {
            type: 'ProductGrid',
            name: 'Product Catalog',
            icon: 'ShoppingBag',
            defaultSettings: {
                title: 'All Products',
                limit: 12,
            },
        },
    ],
    basic: [
        {
            type: 'Hero',
            name: 'Modern Hero',
            icon: 'Monitor',
            defaultSettings: {
                title: 'Modern & <span class="italic font-light">Minimalist</span> Essentials.',
                subtitle: 'Curated collection for the contemporary lifestyle.',
            },
        },
        {
            type: 'Featured',
            name: 'Featured Collection',
            icon: 'Star',
            defaultSettings: {
                title: 'Seasonal <span class="italic font-light">Selects</span>',
                subtitle: 'Handpicked items for this season.',
            },
        },
        {
            type: 'Gallery',
            name: 'Photo Gallery',
            icon: 'Image',
            defaultSettings: {
                gridCols: 3,
            },
        },
    ],
};
