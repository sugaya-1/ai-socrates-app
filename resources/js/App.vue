<script setup>
// QuestionFetcherコンポーネントをインポート
import QuestionFetcher from './components/QuestionFetcher.vue';
</script>

<template>
  <div id="app" class="relative min-h-screen font-sans antialiased overflow-hidden text-cyan-50 bg-slate-900">

    <div class="fixed inset-0 z-0">
      <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transform scale-105"
        :style="{ backgroundImage: `url('/bg-socrates.jpg')` }"></div>
      <div
        class="absolute inset-0 bg-slate-900/80 bg-gradient-to-b from-slate-900/50 via-slate-900/50 to-indigo-950/80 backdrop-blur-[2px]">
      </div>
    </div>

    <header
      class="sticky top-0 z-50 w-full border-b border-cyan-500/10 bg-slate-900/30 backdrop-blur-md transition-all duration-300">
      <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div>
          <h1
            class="text-2xl md:text-3xl font-extrabold tracking-tight text-cyan-100 font-serif drop-shadow-[0_0_10px_rgba(34,211,238,0.6)]">
            Agora Digitalis
          </h1>
          <p class="text-xs md:text-sm text-cyan-400/80 font-serif tracking-widest mt-1">
            対話を通じてあなたの知識を深めます
          </p>
        </div>
        <div class="hidden md:block text-right">
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

    <footer class="relative z-10 text-center text-xs text-cyan-600/60 py-6 font-serif tracking-widest">
      © 2025 AIソクラテス - System Philosophia
    </footer>
  </div>
</template>

<style>
/* Vue/Tailwindプロジェクトの基本スタイル */
</style>
