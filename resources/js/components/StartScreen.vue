<template>
  <div class="flex flex-col items-center justify-center h-full pb-10 space-y-12 fade-in">
    <div
      class="relative max-w-lg p-10 mx-4 font-serif text-base leading-loose border shadow-2xl bg-gradient-to-br from-slate-800/80 to-slate-900/80 backdrop-blur-md text-cyan-50 rounded-xl border-cyan-500/20">

      <div
        class="mb-6 text-xs font-bold text-cyan-400 flex items-center justify-center gap-2 tracking-[0.2em] opacity-80">
        <span>INITIALIZING</span><span class="animate-pulse">...</span>
      </div>

      <p class="text-lg font-medium text-center drop-shadow-sm">
        「叡智の探求者よ、こんにちは。<br>
        <span class="text-cyan-200">問答</span>を通じて、思考の深淵へ。<br>
        準備はよろしいかな？」
      </p>
    </div>

    <button @click="$emit('start')"
      class="group relative bg-cyan-950/60 text-cyan-100 text-lg font-serif font-bold py-4 px-16 rounded-full overflow-hidden border border-cyan-400/30 transition-all duration-300 hover:bg-cyan-900/80 hover:border-cyan-400/80 hover:shadow-[0_0_30px_rgba(34,211,238,0.2)] hover:-translate-y-1">
      <span class="relative z-10 tracking-widest">対話を始める</span>
      <div
        class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-cyan-400/20 to-transparent z-0">
      </div>
    </button>
  </div>
</template>

<script setup>
defineEmits(['start']);
</script>

<style scoped>
/* Assuming Tailwind is available globally, but we might need some animations if they aren't global */
@keyframes shimmer {
  0% { transform: translateX(-150%) skewX(-15deg); }
  100% { transform: translateX(150%) skewX(-15deg); }
}

.fade-in {
  animation: fadeIn 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
