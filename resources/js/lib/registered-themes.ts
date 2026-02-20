type THEMES = {
    id: string;
    name: string;
    description: string;
    preview: string;
}

const THEMES: THEMES[] =[
    {
        id: 'default',
        name: 'Default Theme',
        description: 'Premium, warm, and elegant design for furniture catalogs.',
        preview: '/theme-img/default.png'
    },
    {
        id: 'basic',
        name: 'Basic Modern Theme',
        description: 'Minimalist monochrome design with centered glassmorphism navigation.',
        preview: '/theme-img/basic.png'
    },
    {
        id: 'pro',
        name: 'KotaUkir Pro',
        description: 'Modern, professional bordered design with orange accents. No navbar for pure focus.',
        preview: '/theme-img/default.png' // You can update this preview image later
    }
];

export default THEMES;