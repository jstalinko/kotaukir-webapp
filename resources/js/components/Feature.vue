<script setup>
const features = [
    {
        icon: '🪑',
        title: 'Etalase produk rapi',
        description:
            'Tata koleksi berdasarkan kategori, ukuran, dan bahan sehingga pembeli menemukan produk dengan cepat.',
    },
    {
        icon: '📢',
        title: 'Integrasi promosi',
        description:
            'Bagikan promo terbaru, paket bundling, dan karya unggulan langsung dari dashboard.',
    },
    {
        icon: '💬',
        title: 'Pesan & konsultasi',
        description:
            'Terhubung dengan pelanggan untuk konsultasi desain, estimasi harga, hingga jadwal pengiriman.',
    },
];
</script>

<template>
    <section class="py-24 bg-[#0a0a0a] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                    Fitur Utama
                </h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-orange-500 to-[#D2691E] mx-auto rounded-full">
                </div>
            </div>

            <!-- Main Highlight Feature -->
            <div class="relative group max-w-5xl mx-auto mb-20">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-orange-500/20 to-[#D2691E]/20 rounded-3xl blur-xl opacity-75 group-hover:opacity-100 transition duration-1000">
                </div>
                <div
                    class="relative flex flex-col md:flex-row items-center bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 shadow-2xl">
                    <div class="text-5xl md:text-7xl mb-6 md:mb-0 md:mr-10 animate-bounce-slow">
                        🌟
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4 leading-tight">
                            Semua kebutuhan bisnis dalam satu tempat.
                        </h3>
                        <p class="text-lg text-gray-400 leading-relaxed">
                            Kelola katalog, promosi, dan komunikasi pelanggan dengan mudah.
                            Fokuskan waktu Anda untuk produksi dan kualitas.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sub Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div v-for="(feature, index) in features" :key="index"
                    class="group p-8 rounded-2xl bg-black/40 backdrop-blur-xl border border-white/5 hover:border-orange-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-orange-500/5 hover:-translate-y-1">
                    <div class="text-4xl mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        {{ feature.icon }}
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">
                        {{ feature.title }}
                    </h4>
                    <p class="text-gray-400 leading-relaxed">
                        {{ feature.description }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@keyframes bounce-slow {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }
}

.animate-bounce-slow {
    animation: bounce-slow 4s ease-in-out infinite;
}
</style>
