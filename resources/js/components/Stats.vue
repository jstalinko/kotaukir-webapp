<script setup>
const stats = [
    {
        value: '100+',
        label: 'Web Bisnis Terbit',
        description: 'Pengrajin furniture yang sudah Go Digital.',
        color: 'from-orange-500 to-orange-600',
    },
    {
        value: '1JT',
        label: 'Inspirasi Harian',
        description: 'Pengunjung mencari karya terbaik setiap hari.',
        color: 'from-[#D2691E] to-[#8B4513]',
    },
    {
        value: '500K',
        label: 'Pesanan Terproses',
        description: 'Furniture berkualitas menemukan rumah barunya.',
        color: 'from-orange-400 to-[#D2691E]',
    },
];
</script>

<template>
    <section class="relative py-20 overflow-hidden bg-[#050505]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <div v-for="(stat, index) in stats" :key="index"
                    class="group relative p-8 rounded-3xl bg-black/40 backdrop-blur-xl border border-white/5 hover:border-orange-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-orange-500/10">
                    <!-- Glow background effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl">
                    </div>

                    <div class="relative space-y-4">
                        <span
                            :class="`text-5xl md:text-6xl font-black bg-clip-text text-transparent bg-gradient-to-r ${stat.color} tracking-tight block`">
                            {{ stat.value }}
                        </span>
                        <div class="space-y-1">
                            <h3 class="text-xl font-bold text-white">
                                {{ stat.label }}
                            </h3>
                            <p class="text-gray-400 leading-relaxed">
                                {{ stat.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subtle background glow -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-[100px] -mr-48"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#D2691E]/10 rounded-full blur-[100px] -ml-48"></div>
        </div>
    </section>
</template>
