<template>
  <div class="flex w-full mb-4 fade-in group"
    :class="message.sender === 'user' ? 'justify-end' : 'justify-start'">

    <!-- Message Bubble -->
    <div :class="[
      'p-5 md:p-6 max-w-[90%] md:max-w-[85%] text-[15px] md:text-base leading-relaxed shadow-md relative backdrop-blur-sm border',
      message.sender === 'user'
        ? 'bg-cyan-950/40 text-cyan-50 rounded-2xl rounded-tr-sm border-cyan-500/30 shadow-[0_4px_20px_rgba(6,182,212,0.05)]'
        : 'bg-slate-800/80 text-cyan-100 rounded-2xl rounded-tl-sm border-slate-700/50 shadow-lg'
    ]">
      <div v-if="message.sender === 'ai'"
        class="mb-3 text-[10px] font-bold text-cyan-500/80 flex items-center gap-2 select-none font-sans tracking-widest border-b border-white/5 pb-2">
        <div class="w-1.5 h-1.5 rounded-full bg-cyan-500"></div>
        <span v-if="message.type === 'question'">QUESTION</span>
        <span v-else>SOCRATES AI</span>
      </div>

      <div class="break-words" :class="[
        message.sender === 'ai'
          ? 'prose prose-invert prose-p:text-cyan-50/90 prose-strong:text-cyan-300 prose-headings:text-cyan-200 prose-a:text-cyan-400 max-w-none prose-p:font-serif prose-headings:font-serif'
          : 'whitespace-pre-wrap font-sans text-cyan-50/95'
      ]" v-html="parsedContent">
      </div>

      <div v-if="!message.isTyping && message.choices && message.choices.length > 0 && message.type === 'question'"
        class="pt-4 mt-6 space-y-3 border-t border-cyan-500/10 fade-in">
        <p class="text-[10px] font-sans tracking-widest text-cyan-500/60 text-center mb-2">- SELECTION -</p>
        <div class="grid gap-3">
          <button v-for="(choice, cIndex) in message.choices" :key="choice.id"
            @click="$emit('select', choice.choice_text)"
            @mouseover="localFocusedIndex = cIndex"
            :disabled="disabled"
            :class="[
                'text-left text-sm px-5 py-4 rounded-lg border transition-all duration-200 font-serif relative overflow-hidden group/btn flex items-center justify-between',
                localFocusedIndex === cIndex
                  ? 'bg-cyan-900/40 border-cyan-400/80 text-cyan-50 shadow-[0_0_15px_rgba(34,211,238,0.2)] translate-x-1'
                  : 'bg-slate-900/40 border-cyan-500/20 text-cyan-100 hover:border-cyan-400/50'
            ]">
            <span class="relative z-10 flex gap-3">
                <span class="font-mono text-xs text-cyan-500/50">[{{ cIndex + 1 }}]</span>
                {{ choice.choice_text }}
            </span>

            <!-- Arrow Indicator for Focus -->
            <span v-if="localFocusedIndex === cIndex" class="text-cyan-400 animate-pulse">
                ◀
            </span>

            <div
              class="absolute inset-0 transition-opacity duration-300 opacity-0 bg-cyan-400/5 hover:opacity-100">
            </div>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import { marked } from 'marked';

const props = defineProps({
  message: {
    type: Object,
    required: true
  },
  disabled: {
    type: Boolean,
    default: false
  },
  focusedIndex: {
      type: Number,
      default: -1
  }
});

defineEmits(['select', 'update:focusedIndex']);

const localFocusedIndex = ref(-1);

watch(() => props.focusedIndex, (newVal) => {
    if (newVal !== -1) {
        localFocusedIndex.value = newVal;
    }
});

const parsedContent = computed(() => {
  const text = props.message.text;
  if (text == null || typeof text !== 'string') {
    return '';
  }

  try {
    let cleanText = text;
    cleanText = cleanText.replace(/\\(\*)/g, '$1');
    cleanText = cleanText.replace(/\*\*\s*(.*?)\s*\*\*/g, '<strong class="text-cyan-300 font-bold drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]">$1</strong>');
    return marked.parse(cleanText);
  } catch (e) {
    console.error("Markdown parse error:", e);
    return text;
  }
});
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
