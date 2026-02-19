<script setup>
import { ref, onMounted } from 'vue';
import { Button } from '@/components/ui/button';


const businessName = ref('');
const isLoading = ref(false);
const isVisible = ref(false);
const statusMessage = ref('');
const statusType = ref(''); // 'success' or 'error'

onMounted(() => {
    // Trigger entrance animations
    setTimeout(() => {
        isVisible.value = true;
    }, 100);
});

const handleCreateWebsite = async () => {
    if (!businessName.value.trim()) {
        statusMessage.value = 'Masukkan nama usaha Anda';
        statusType.value = 'error';
        return;
    }

    statusMessage.value = '';
    isLoading.value = true;
    try {
        const slug = businessName.value
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9-]/g, '');

        const response = await fetch(`/api/check-username?username=${slug}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();

        if (data.available) {
            statusMessage.value = '✓ ' + data.message;
            statusType.value = 'success';
            // Redirect to register with username pre-filled
            setTimeout(() => {
                window.location.href = `/register?username=${slug}`;
            }, 800);
        } else {
            statusMessage.value = data.message;
            statusType.value = 'error';
        }
    } catch (error) {
        console.error('Error creating website:', error);
        statusMessage.value = 'Terjadi kesalahan, coba lagi nanti.';
        statusType.value = 'error';
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <section class="relative min-h-screen flex items-center justify-center bg-[#050505] overflow-hidden px-4 py-32">
        <!-- Animated Background Glow Effects -->
        <div class="absolute inset-0 z-0">
            <!-- Primary orbiting glow -->
            <div class="glow-orb glow-orb-1"></div>
            <!-- Secondary glow -->
            <div class="glow-orb glow-orb-2"></div>
            <!-- Tertiary glow -->
            <div class="glow-orb glow-orb-3"></div>
            <!-- Accent glow -->
            <div class="glow-orb glow-orb-4"></div>

            <!-- Animated grid lines -->
            <div class="absolute inset-0 grid-bg opacity-[0.03]"></div>

            <!-- Noise texture overlay -->
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 contrast-100 brightness-100">
            </div>

            <!-- Radial vignette -->
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_0%,#050505_70%)]"></div>
        </div>

        <!-- Floating particles -->
        <div class="absolute inset-0 z-[1] overflow-hidden pointer-events-none">
            <div v-for="n in 6" :key="n" class="particle" :style="{
                left: `${10 + (n * 15)}%`,
                animationDelay: `${n * 0.8}s`,
                animationDuration: `${6 + (n % 3) * 2}s`,
            }"></div>
        </div>

        <div class="relative z-10 w-full max-w-4xl mx-auto text-center space-y-12">
            <!-- Main Heading -->
            <div class="space-y-6" :class="{ 'animate-hero-enter': isVisible, 'opacity-0 translate-y-8': !isVisible }">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-white">
                    Platform <span class="text-shimmer">GRATIS</span>
                    untuk membuat<br class="hidden md:block" />
                    website furniture,
                    <span class="block mt-2 text-glow">
                        Dalam Sekejap!
                    </span>
                </h1>

                <div class="max-w-2xl mx-auto">
                    <p class="inline-block text-sm md:text-base font-semibold leading-relaxed text-gray-300/90">
                        <span class="px-2 py-0.5">Bangun etalase digital yang menampilkan karya
                            terbaik,</span><br class="hidden md:block" />
                        <span class="px-2 py-0.5">mengelola pesanan, dan menjangkau pelanggan
                            baru. KotaUkir.ID</span><br class="hidden md:block" />
                        <span class="px-2 py-0.5">membuat pembuatan website furniture jadi
                            cepat dan mudah.</span>
                    </p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="max-w-xl mx-auto relative group"
                :class="{ 'animate-hero-enter-delayed': isVisible, 'opacity-0 translate-y-8': !isVisible }">
                <!-- Animated glow ring -->
                <div
                    class="absolute -inset-1 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-500 glow-ring">
                </div>

                <div
                    class="relative flex flex-col sm:flex-row items-center gap-0 p-1.5 bg-black/50 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl group-hover:border-orange-500/20 transition-colors duration-500">
                    <div class="flex-1 w-full relative">
                        <input id="business-name" v-model="businessName" type="text" placeholder="namabisnis"
                            @keyup.enter="handleCreateWebsite"
                            class="w-full h-14 pl-6 pr-24 bg-transparent text-white placeholder-gray-500 focus:outline-none text-lg font-medium focus:placeholder-gray-400 transition-colors" />
                        <span
                            class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 font-medium pointer-events-none">
                            .kotaukir.id
                        </span>
                    </div>
                    <Button @click="handleCreateWebsite" :disabled="isLoading || !businessName.trim()"
                        class="w-full sm:w-auto h-14 px-8 bg-orange-600 hover:bg-orange-500 text-white font-bold text-lg rounded-xl transition-all shadow-lg shadow-orange-600/30 active:scale-95 disabled:opacity-50 disabled:active:scale-100 hover:shadow-orange-500/40 hover:shadow-xl btn-pulse">
                        <template v-if="isLoading">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Proses...
                            </span>
                        </template>
                        <template v-else>
                            Buat
                        </template>
                    </Button>
                </div>

                <!-- Status Message -->
                <div v-if="statusMessage" class="mt-3 text-center text-sm font-medium transition-all duration-300"
                    :class="statusType === 'success' ? 'text-green-400' : 'text-red-400'">
                    {{ statusMessage }}
                </div>
                <div
                    class="mt-4 flex flex-wrap items-center justify-center gap-6 text-[11px] font-bold uppercase tracking-widest text-gray-500">
                    <span class="flex items-center gap-2 hover:text-gray-300 transition-colors cursor-default">
                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        500+ Pengrajin
                    </span>
                    <span class="flex items-center gap-2 hover:text-gray-300 transition-colors cursor-default">
                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Domain Selamanya
                    </span>
                    <span class="flex items-center gap-2 hover:text-gray-300 transition-colors cursor-default">
                        <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Setup 1 Menit
                    </span>
                </div>
            </div>
        </div>

        <!-- Bottom Mouse Scroll Icon -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce opacity-20">
            <div class="w-5 h-8 border-2 border-white rounded-full flex justify-center p-1">
                <div class="w-1 h-2 bg-white rounded-full animate-scroll-dot"></div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* === Glow Orbs — animated background blobs === */
.glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    will-change: transform;
}

.glow-orb-1 {
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.15), transparent 70%);
    top: 30%;
    left: 40%;
    animation: float-1 8s ease-in-out infinite;
}

.glow-orb-2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(180, 83, 9, 0.12), transparent 70%);
    top: 50%;
    left: 20%;
    animation: float-2 10s ease-in-out infinite;
}

.glow-orb-3 {
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(210, 105, 30, 0.1), transparent 70%);
    bottom: 20%;
    right: 20%;
    animation: float-3 12s ease-in-out infinite;
}

.glow-orb-4 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(251, 146, 60, 0.08), transparent 70%);
    top: 20%;
    right: 30%;
    animation: float-4 9s ease-in-out infinite;
}

@keyframes float-1 {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    25% {
        transform: translate(30px, -40px) scale(1.05);
    }

    50% {
        transform: translate(-20px, 20px) scale(0.95);
    }

    75% {
        transform: translate(40px, 30px) scale(1.03);
    }
}

@keyframes float-2 {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    33% {
        transform: translate(-40px, 30px) scale(1.08);
    }

    66% {
        transform: translate(30px, -20px) scale(0.93);
    }
}

@keyframes float-3 {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    25% {
        transform: translate(50px, 20px) scale(1.06);
    }

    50% {
        transform: translate(-30px, -40px) scale(0.97);
    }

    75% {
        transform: translate(-20px, 30px) scale(1.04);
    }
}

@keyframes float-4 {

    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }

    50% {
        transform: translate(-30px, -30px) scale(1.1);
    }
}

/* === Grid background === */
.grid-bg {
    background-image:
        linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 60px 60px;
    animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
    0% {
        transform: translate(0, 0);
    }

    100% {
        transform: translate(60px, 60px);
    }
}

/* === Text shimmer effect for "GRATIS" === */
.text-shimmer {
    background: linear-gradient(110deg,
            #e2e8f0 0%,
            #ffffff 20%,
            #fb923c 40%,
            #ffffff 60%,
            #e2e8f0 80%,
            #fb923c 100%);
    background-size: 300% 100%;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: shimmer 4s ease-in-out infinite;
}

@keyframes shimmer {
    0% {
        background-position: 100% 50%;
    }

    50% {
        background-position: 0% 50%;
    }

    100% {
        background-position: 100% 50%;
    }
}

/* === Glowing text for "Dalam Sekejap!" === */
.text-glow {
    color: #f97316;
    text-shadow:
        0 0 10px rgba(249, 115, 22, 0.3),
        0 0 30px rgba(249, 115, 22, 0.15),
        0 0 60px rgba(249, 115, 22, 0.08);
    animation: text-pulse 3s ease-in-out infinite;
}

@keyframes text-pulse {

    0%,
    100% {
        text-shadow:
            0 0 10px rgba(249, 115, 22, 0.3),
            0 0 30px rgba(249, 115, 22, 0.15),
            0 0 60px rgba(249, 115, 22, 0.08);
    }

    50% {
        text-shadow:
            0 0 15px rgba(249, 115, 22, 0.5),
            0 0 40px rgba(249, 115, 22, 0.25),
            0 0 80px rgba(249, 115, 22, 0.12);
    }
}

/* === Animated glow ring around form === */
.glow-ring {
    background: linear-gradient(var(--glow-angle, 0deg),
            rgba(249, 115, 22, 0.3),
            rgba(210, 105, 30, 0.1),
            rgba(249, 115, 22, 0.3));
    animation: glow-rotate 4s linear infinite;
}

@keyframes glow-rotate {
    0% {
        --glow-angle: 0deg;
        filter: blur(16px);
    }

    100% {
        --glow-angle: 360deg;
        filter: blur(16px);
    }
}

@property --glow-angle {
    syntax: '<angle>';
    initial-value: 0deg;
    inherits: false;
}

/* === Button subtle pulse === */
.btn-pulse {
    animation: btn-breathe 3s ease-in-out infinite;
}

@keyframes btn-breathe {

    0%,
    100% {
        box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.3);
    }

    50% {
        box-shadow: 0 10px 25px -3px rgba(249, 115, 22, 0.5);
    }
}

/* === Floating particles === */
.particle {
    position: absolute;
    width: 3px;
    height: 3px;
    background: rgba(249, 115, 22, 0.4);
    border-radius: 50%;
    bottom: -10px;
    animation: rise linear infinite;
}

.particle:nth-child(odd) {
    width: 2px;
    height: 2px;
    background: rgba(210, 105, 30, 0.3);
}

@keyframes rise {
    0% {
        transform: translateY(0) translateX(0);
        opacity: 0;
    }

    10% {
        opacity: 1;
    }

    90% {
        opacity: 1;
    }

    100% {
        transform: translateY(-100vh) translateX(30px);
        opacity: 0;
    }
}

/* === Scroll dot animation === */
@keyframes scroll-dot-move {
    0% {
        transform: translateY(0);
        opacity: 1;
    }

    100% {
        transform: translateY(6px);
        opacity: 0;
    }
}

.animate-scroll-dot {
    animation: scroll-dot-move 1.5s ease-in-out infinite;
}

/* === Entrance animations === */
.animate-hero-enter {
    animation: hero-fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-hero-enter-delayed {
    animation: hero-fade-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
}

@keyframes hero-fade-up {
    from {
        opacity: 0;
        transform: translateY(32px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
