<template>
  <!-- Full Screen Terminal Overlay -->
  <div v-if="visible"
        @click="fastForward"
        class="fixed inset-0 z-50 flex flex-col items-start justify-end p-4 overflow-hidden font-mono text-green-500 bg-black cursor-pointer select-none md:p-10">

    <!-- Background Effects Container -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
      <!-- CRT Scanlines -->
      <div class="absolute inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[length:100%_4px,6px_100%] z-10 opacity-60"></div>

      <!-- CRT Vignette (Dark corners) -->
      <div class="absolute inset-0 z-20 pointer-events-none bg-[radial-gradient(circle_at_center,transparent_50%,rgba(0,0,0,0.8)_100%)]"></div>

      <!-- Noise Overlay (Horizontal Lines) -->
      <div class="absolute -inset-[100%] z-0 pointer-events-none opacity-[0.08] brightness-125 animate-noise-strong mix-blend-screen noise-bg">
      </div>

      <!-- Scanlines (Stronger) -->
      <div class="absolute inset-0 z-10 w-full h-full bg-repeat-y pointer-events-none opacity-10 animate-scanline"
            style="background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.5) 51%); background-size: 100% 4px;">
      </div>
    </div>

    <!-- Terminal Content -->
    <div class="relative z-30 w-full max-w-4xl mx-auto space-y-2 mb-20 text-xs md:text-sm lg:text-base leading-relaxed tracking-wider drop-shadow-[0_0_8px_rgba(34,197,94,0.6)]">
      <div v-for="(log, index) in bootLogs" :key="index" :class="{'text-cyan-400': log.includes('COMPLETE') || log.includes('READY'), 'text-red-500': log.includes('WARNING'), 'animate-pulse': index === bootLogs.length - 1 && !bootFinished}">
        <span class="mr-2 opacity-50">[{{ new Date().toLocaleTimeString('ja-JP') }}]</span>
        <span class="relative inline-block typing-effect"
              :class="{'glitch-text-periodic': log.includes('SYSTEM') || log.includes('CONNECTING')}">
          {{ log }}
        </span>
      </div>
      <div v-if="!bootFinished" class="text-green-400 animate-pulse">_</div>
    </div>

    <!-- Skip Prompt -->
    <div class="relative z-30 text-center w-full pb-10 opacity-50 text-[10px] uppercase tracking-[0.3em] animate-pulse">
        <span v-if="!bootFinished">Press Enter to Skip Initialization</span>
        <span v-else class="font-bold text-cyan-400">Press Enter to Initialize Interface</span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  visible: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['complete']);

const bootLogs = ref([]);
const bootFinished = ref(false);
let bootTimeout = null;

// The boot sequence text
const sequence = [
  "SYSTEM BOOT SEQUENCE INITIATED...",
  "CHECKING MEMORY INTEGRITY... OK",
  "LOADING ANCIENT_PHILOSOPHY.DAT...",
  "PARSING SOCRATIC_METHOD_V.400.BC...",
  "CONNECTING TO NEURAL NETWORK...",
  "WARNING: UNSTABLE CONNECTION DETECTED",
  "REROUTING THROUGH LOGIC GATES...",
  "SYNCHRONIZING WITH USER CONSCIOUSNESS...",
  "ESTABLISHING DIALOGUE INTERFACE...",
  "SYSTEM READY."
];

const typeLog = async (text, delay = 50) => {
  return new Promise(resolve => {
    bootLogs.value.push(text);
    bootTimeout = setTimeout(resolve, delay);
  });
};

const runBootSequence = async () => {
  bootLogs.value = [];
  bootFinished.value = false;

  for (const line of sequence) {
    if (bootFinished.value) break;
    // Random delay between lines for realism
    const randomDelay = Math.random() * 300 + 100; // 100ms to 400ms
    await typeLog(line, randomDelay);
  }

  if (!bootFinished.value) {
    bootFinished.value = true;
    // Auto-complete removed. Waiting for user input.
  }
};

const fastForward = () => {
  if (bootFinished.value) return;

  // Clear any existing timeout
  if (bootTimeout) clearTimeout(bootTimeout);

  // Show all logs immediately
  bootLogs.value = sequence;
  bootFinished.value = true;

  // Emit complete immediately
  emit('complete');
};

const handleKeydown = (e) => {
  if (props.visible && (e.key === 'Enter' || e.key === ' ')) {
    e.preventDefault();
    fastForward();
  }
};

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
  if (props.visible) {
    runBootSequence();
  }
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
  if (bootTimeout) clearTimeout(bootTimeout);
});
</script>

<style scoped>
.noise-bg {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='lineNoise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.002 0.5' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23lineNoise)'/%3E%3C/svg%3E");
}

@keyframes noise-strong {
  0% { transform: translate(0,0) }
  10% { transform: translate(-5%,-5%) }
  20% { transform: translate(-10%,5%) }
  30% { transform: translate(5%,-10%) }
  40% { transform: translate(-5%,15%) }
  50% { transform: translate(-10%,5%) }
  60% { transform: translate(15%,0) }
  70% { transform: translate(0,10%) }
  80% { transform: translate(-15%,0) }
  90% { transform: translate(10%,5%) }
  100% { transform: translate(5%,0) }
}
.animate-noise-strong {
  animation: noise-strong 0.2s steps(2) infinite;
}

@keyframes scanline {
  0% { transform: translateY(-100%); }
  100% { transform: translateY(100%); }
}
.animate-scanline {
  animation: scanline 8s linear infinite;
}

/* Glitch Effect Keyframes */
@keyframes glitch-skew {
  0% { transform: skew(0deg); }
  20% { transform: skew(-20deg); }
  40% { transform: skew(20deg); }
  60% { transform: skew(-5deg); }
  80% { transform: skew(5deg); }
  100% { transform: skew(0deg); }
}

@keyframes glitch-anim-1 {
  0% { clip: rect(20px, 9999px, 10px, 0); }
  20% { clip: rect(60px, 9999px, 80px, 0); }
  40% { clip: rect(10px, 9999px, 40px, 0); }
  60% { clip: rect(80px, 9999px, 20px, 0); }
  80% { clip: rect(30px, 9999px, 70px, 0); }
  100% { clip: rect(50px, 9999px, 30px, 0); }
}

@keyframes glitch-anim-2 {
  0% { clip: rect(80px, 9999px, 20px, 0); }
  20% { clip: rect(10px, 9999px, 40px, 0); }
  40% { clip: rect(50px, 9999px, 90px, 0); }
  60% { clip: rect(20px, 9999px, 60px, 0); }
  80% { clip: rect(70px, 9999px, 10px, 0); }
  100% { clip: rect(30px, 9999px, 50px, 0); }
}

@keyframes rgb-split-periodic {
  0%, 95% {
    text-shadow: none;
    transform: translate(0);
  }
  96% {
    text-shadow: 2px 0 red, -2px 0 blue;
    transform: translate(-2px, 0);
  }
  97% {
    text-shadow: -2px 0 red, 2px 0 blue;
    transform: translate(2px, 0);
  }
  98% {
    text-shadow: 2px 0 red, -2px 0 blue;
    transform: translate(-1px, 1px);
  }
  100% {
    text-shadow: none;
    transform: translate(0);
  }
}

.glitch-text-periodic {
  position: relative;
  display: inline-block;
  animation: rgb-split-periodic 3s infinite;
}
</style>
