<template>
  <div class="flex flex-col items-center justify-center h-full p-8 space-y-8 text-center fade-in bg-slate-900/20 rounded-xl">
    <div class="relative">
      <div class="absolute inset-0 rounded-full bg-cyan-400/20 blur-xl animate-pulse"></div>
      <div class="text-7xl relative z-10 text-cyan-200 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]">✦</div>
    </div>
    <div>
      <h2 class="mb-4 font-serif text-4xl font-bold tracking-wider text-cyan-50">真理への到達</h2>
      <p class="font-serif text-lg leading-relaxed text-cyan-200/70">全問クリアしました。<br>あなたの探究心に敬意を表します。</p>
    </div>
    <button @click="$emit('reset')"
      class="px-8 py-3 mt-8 font-serif transition-all duration-300 border rounded border-cyan-500/30 text-cyan-400 hover:bg-cyan-900/30 hover:text-cyan-200">システム再起動</button>
  </div>
</template>

<script setup>
defineEmits(['reset']);
</script>

<style scoped>
.fade-in {
  animation: fadeIn 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
