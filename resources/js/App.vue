<script setup>
// QuestionFetcherコンポーネントをインポート
import QuestionFetcher from './components/QuestionFetcher.vue';
</script>

<template>
  <div id="app" class="relative min-h-screen overflow-hidden font-sans antialiased text-cyan-50 bg-slate-900">

    <div class="fixed inset-0 z-0">
      <div class="absolute inset-0 transform scale-105 bg-center bg-no-repeat bg-cover"
        :style="{ backgroundImage: `url('/bg-socrates.jpg')` }"></div>
      <div
        class="absolute inset-0 bg-slate-900/80 bg-gradient-to-b from-slate-900/50 via-slate-900/50 to-indigo-950/80 backdrop-blur-[2px]">
      </div>
      <!-- Ambient Orbs -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-cyan-400/30 rounded-full blur-[120px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[40%] h-[40%] bg-indigo-500/30 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[60%] h-[60%] bg-blue-600/30 rounded-full blur-[120px] animate-blob animation-delay-4000"></div>
      </div>
    </div>

    <header
      class="sticky top-0 z-50 w-full transition-all duration-300 border-b border-cyan-500/10 bg-slate-900/30 backdrop-blur-md">
      <div class="flex items-center justify-between px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div>
          <h1
            class="text-2xl md:text-3xl font-extrabold tracking-tight text-cyan-100 font-serif drop-shadow-[0_0_10px_rgba(34,211,238,0.6)]">
            Agora Digitalis
          </h1>
          <p class="mt-1 font-serif text-xs tracking-widest md:text-sm text-cyan-400/80">
            対話を通じてあなたの知識を深めます
          </p>
        </div>
        <div class="hidden text-right md:block">
          <span
            class="text-[10px] text-cyan-500/50 font-mono tracking-[0.2em] border border-cyan-500/20 px-2 py-1 rounded">SYSTEM:
            ONLINE</span>
        </div>
      </div>

      <div
        class="absolute bottom-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent">
      </div>
    </header>


    <main class="relative z-10 flex flex-col items-center justify-center min-h-[calc(100vh-140px)] p-4 md:p-8">
      <QuestionFetcher />
    </main>

    <footer class="relative z-10 py-6 font-serif text-xs tracking-widest text-center text-cyan-600/60">
      © 2025 AIソクラテス - System Philosophia
    </footer>
  </div>
</template>

<style>
/* Vue/Tailwindプロジェクトの基本スタイル */
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(50px, -80px) scale(1.2); }
  66% { transform: translate(-40px, 40px) scale(0.8); }
  100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
  animation: blob 7s infinite;
}
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}
</style>
