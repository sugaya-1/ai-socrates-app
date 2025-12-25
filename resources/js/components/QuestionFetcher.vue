<template>
  <div
    class="w-full max-w-4xl h-[80dvh] md:h-[85vh] bg-slate-900/70 backdrop-blur-xl rounded-2xl shadow-[0_0_50px_rgba(6,182,212,0.1)] flex flex-col overflow-hidden relative border border-cyan-500/20 z-10 transition-all duration-500 ring-1 ring-white/5">

    <!-- Decorative Corners -->
    <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 rounded-tl-lg pointer-events-none border-cyan-500/30"></div>
    <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 rounded-tr-lg pointer-events-none border-cyan-500/30"></div>
    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 rounded-bl-lg pointer-events-none border-cyan-500/30"></div>
    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 rounded-br-lg pointer-events-none border-cyan-500/30"></div>

    <header
      class="z-10 flex items-center justify-between px-6 py-4 border-b shadow-sm border-cyan-500/10 bg-slate-900/40 shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_8px_rgba(34,211,238,0.8)]"></div>
        <h1 class="text-xl font-bold text-cyan-100 tracking-wide font-serif drop-shadow-[0_0_5px_rgba(34,211,238,0.3)]">
          AIソクラテス
        </h1>
      </div>
      <p
        class="text-[10px] text-cyan-500/70 font-mono tracking-widest uppercase border border-cyan-500/20 px-2 py-0.5 rounded-full bg-cyan-950/30">
        Philosophia / Online
      </p>
    </header>

    <main ref="chatWindow"
      class="relative flex-1 p-4 space-y-6 overflow-y-auto bg-transparent md:p-8 custom-scrollbar scroll-smooth">

      <!-- Component Switching Logic -->
      <TerminalLanding
        v-if="showLanding"
        :visible="showLanding"
        @complete="handleBootComplete"
      />

      <StartScreen
        v-else-if="!hasStarted"
        @start="startSession"
      />

      <CompletionScreen
        v-else-if="isCompleted"
        @reset="resetSession"
      />

      <!-- Chat History -->
      <template v-else>
        <ChatMessage
          v-for="(message, index) in history"
          :key="index"
          :message="message"
          :disabled="isSending || isLoading || isTyping"
          :focused-index="index === history.length - 1 && message.sender === 'ai' ? focusedChoiceIndex : -1"
          @select="selectChoice"
        />

        <!-- Typing Indicator (Thinking) -->
        <div v-if="isSending || isLoading" class="flex justify-start pl-2 fade-in">
          <div
            class="flex items-center gap-2 px-4 py-2 font-mono text-xs tracking-widest border rounded-full text-cyan-500/70 bg-slate-900/50 border-cyan-500/10">
            <span>THINKING</span>
            <div class="scale-75 typing-indicator"><span></span><span></span><span></span></div>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="flex justify-center my-4 fade-in">
          <div
            class="flex items-center gap-3 px-6 py-3 font-serif text-sm text-red-200 border rounded-lg shadow-lg bg-red-950/50 border-red-500/30 backdrop-blur-md">
            <!-- Icon SVG -->
            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>SYSTEM ERROR: {{ error.message }}</span>
          </div>
        </div>
      </template>

    </main>

    <footer v-if="hasStarted && !isCompleted"
      class="z-10 p-4 border-t md:p-6 bg-slate-900/60 backdrop-blur-xl shrink-0 border-cyan-500/10">
      <div v-if="!isSufficient" class="w-full fade-in">
        <div class="relative flex items-end max-w-3xl mx-auto space-x-3">
          <div class="relative flex-1">
            <textarea
                v-model="inputAnswer"
                @keydown.enter="handleEnterKey"
                :disabled="isSending || isLoading"
                rows="1"
                ref="textareaRef"
                @input="resizeTextarea"
                class="w-full p-4 pr-12 max-h-32 min-h-[56px] bg-slate-800/60 border border-cyan-500/30 rounded-xl focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition-all resize-none disabled:opacity-50 text-cyan-50 placeholder-cyan-500/30 text-base shadow-inner font-sans backdrop-blur-md focus:bg-slate-800/90"
                placeholder="あなたの思考を記述... (Shift+Enterで改行)"
                ></textarea>
            <div
              class="absolute bottom-4 right-4 text-[10px] text-cyan-600/50 font-mono hidden md:block pointer-events-none">
              RETURN ↵
            </div>
          </div>

          <div class="flex gap-2">
            <!-- Hint Button -->
            <button @click="askOracle" :disabled="isSending || isLoading || !currentQuestionId"
              class="w-14 h-[56px] flex items-center justify-center bg-amber-900/30 text-amber-200 rounded-xl hover:bg-amber-800/50 border border-amber-500/30 active:scale-95 transition-all shadow-lg hover:shadow-[0_0_15px_rgba(245,158,11,0.2)] disabled:opacity-30 disabled:cursor-not-allowed backdrop-blur-sm group relative overflow-hidden"
              title="オラクル（ヒント）">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-1 1.5-2 1.5-3.5a6 6 0 0 0-11 0c0 1.5.5 2.5 1.5 3.5.8.8 1.3 1.5 1.5 2.5"></path>
                <line x1="9" y1="18" x2="15" y2="18"></line>
                <line x1="10" y1="22" x2="14" y2="22"></line>
              </svg>
            </button>
            <!-- Skip Button -->
            <button @click="handleNextTopic" :disabled="isSending || isLoading || !currentQuestionId"
              class="w-14 h-[56px] flex items-center justify-center bg-slate-700/50 text-slate-300 rounded-xl hover:bg-slate-600/70 border border-slate-500/30 active:scale-95 transition-all shadow-lg hover:shadow-[0_0_15px_rgba(148,163,184,0.2)] disabled:opacity-30 disabled:cursor-not-allowed backdrop-blur-sm group relative overflow-hidden"
              title="別の話題へ（スキップ）">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h13M12 5l7 7-7 7"/>
              </svg>
            </button>
             <!-- Send Button -->
            <button @click="handleSend" :disabled="isSending || !inputAnswer.trim() || !currentQuestionId"
              class="w-14 h-[56px] flex items-center justify-center bg-cyan-600 text-white rounded-xl hover:bg-cyan-500 active:scale-95 transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.6)] disabled:opacity-30 disabled:cursor-not-allowed border border-cyan-400/20"
              title="送信">
              <svg v-if="!isSending" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
              <div v-else class="w-5 h-5 border-2 rounded-full border-white/30 border-t-white animate-spin"></div>
            </button>
          </div>
        </div>
      </div>
      <div v-else class="w-full max-w-md mx-auto fade-in">
        <button @click="handleNextTopic"
          class="w-full bg-cyan-900/40 text-cyan-50 font-serif font-bold py-4 px-6 rounded-xl hover:bg-cyan-800/60 active:scale-[0.99] focus:outline-none transition-all shadow-lg hover:shadow-[0_0_20px_rgba(34,211,238,0.2)] flex items-center justify-center space-x-3 text-lg border border-cyan-400/30 backdrop-blur-sm group">
          <span>次の問いへ進む</span>
          <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </button>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, nextTick, onMounted, onUnmounted, watch } from 'vue';
import axios from 'axios';
// Removed 'marked' import as parsing is now in ChatMessage.vue
import TerminalLanding from './TerminalLanding.vue';
import StartScreen from './StartScreen.vue';
import CompletionScreen from './CompletionScreen.vue';
import ChatMessage from './ChatMessage.vue';

const chatWindow = ref(null);
const textareaRef = ref(null);
const showLanding = ref(true);
const hasStarted = ref(false);
const isSufficient = ref(false);
const isCompleted = ref(false);
const history = ref([]);
const isLoading = ref(false);
const error = ref(null);
const inputAnswer = ref('');
const isSending = ref(false);
const currentQuestionId = ref(null);
const currentTopicId = ref(1);
const nextTopicId = ref(null);
const isTyping = ref(false);
const focusedChoiceIndex = ref(-1);

const handleBootComplete = () => {
    showLanding.value = false;
};

watch(history, () => {
    focusedChoiceIndex.value = -1;
}, { deep: true });

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

// Typewriter effect updates the text property of the message in history
// ChatMessage.vue reactively renders this text
const typeWriter = async (index, fullText, speed = 30) => {
  isTyping.value = true;
  history.value[index].isTyping = true;
  history.value[index].text = '';

  for (let i = 0; i < fullText.length; i++) {
    history.value[index].text += fullText.charAt(i);
    scrollToBottom({ behavior: 'auto' });
    let delay = speed;
    const char = fullText.charAt(i);
    // Punctuation delay for natural feeling
    if (char === '、' || char === ',') delay = speed * 2;
    if (char === '。' || char === '.' || char === '！' || char === '？') delay = speed * 3;

    await new Promise(r => setTimeout(r, delay));
  }

  history.value[index].isTyping = false;
  isTyping.value = false;
};

// parseMarkdown function removed - handled inside ChatMessage.vue

const startSession = async () => {
  hasStarted.value = true;
  history.value = [];
  await fetchNextQuestion();
};

const resetSession = () => {
  hasStarted.value = false;
  isCompleted.value = false;
  currentTopicId.value = 1;
  history.value = [];
};

const handleNextTopic = async () => {
  isSufficient.value = false;
  history.value.push({ sender: 'user', type: 'answer', text: '（次のトピックへ進む）' });
  if (nextTopicId.value) { currentTopicId.value = nextTopicId.value; } else { currentTopicId.value++; }
  await fetchNextQuestion();
};

const scrollToBottom = (options = {}) => {
  const { behavior = 'smooth', force = false } = options;
  nextTick(() => {
    if (chatWindow.value) {
      const el = chatWindow.value;
      const isNearBottom = el.scrollHeight - el.scrollTop - el.clientHeight < 100;

      if (force || isNearBottom) {
        el.scrollTo({ top: el.scrollHeight, behavior: behavior });
      }
    }
  });
};

const resizeTextarea = () => {
  const el = textareaRef.value;
  if (el) {
    el.style.height = 'auto';
    el.style.height = `${Math.min(el.scrollHeight, 128)}px`;
  }
};

const fetchNextQuestion = async () => {
  isLoading.value = true;
  error.value = null;
  scrollToBottom({ force: true });
  try {
    const API_URL = `/api/topics/${currentTopicId.value}/next-question`;
    const response = await axios.get(API_URL);
    const data = response.data;
    currentQuestionId.value = data.id;
    nextTopicId.value = data.next_topic_id || null;

    history.value.push({
      sender: 'ai',
      type: 'question',
      text: '',
      question_id: data.id,
      choices: data.choices,
      isTyping: true
    });

    await typeWriter(history.value.length - 1, data.question_text);
  } catch (err) {
    if (err.response && err.response.status === 404) {
      isCompleted.value = true;
    } else {
      console.error("Error:", err);
      error.value = { message: '問題の取得に失敗しました。' };
    }
  } finally {
    isLoading.value = false;
    scrollToBottom({ force: true });
  }
};

const handleSend = async () => {
  const text = inputAnswer.value.trim();
  if (isSending.value || !text || !currentQuestionId.value) return;
  inputAnswer.value = '';
  if (textareaRef.value) textareaRef.value.style.height = 'auto';
  isSending.value = true;
  error.value = null;
  history.value.push({ sender: 'user', type: 'answer', text: text, question_id: currentQuestionId.value });
  scrollToBottom({ force: true });
  try {
    const API_URL = `/api/questions/${currentQuestionId.value}/check`;
    const response = await axios.post(API_URL, { answer_text: text });
    const data = response.data;

    history.value.push({
      sender: 'ai',
      type: 'feedback',
      text: '',
      question_id: currentQuestionId.value,
      is_correct: data.is_correct,
      isTyping: true
    });

    await typeWriter(history.value.length - 1, data.explanation);

    if (data.is_sufficient === true || (data.explanation && data.explanation.includes('[CORRECT]'))) {
      isSufficient.value = true;
    }
  } catch (err) {
    console.error("Send Error:", err);
    error.value = { message: '通信エラーが発生しました。' };
  } finally {
    isSending.value = false;
    scrollToBottom({ force: true });
  }
};

const askOracle = () => {
  inputAnswer.value = "知恵を借してくれないか？";
  handleSend();
};

const handleEnterKey = (e) => {
  if (e.isComposing || e.keyCode === 229) {
    return;
  }
  if (e.shiftKey) {
    return;
  }
  e.preventDefault();
  handleSend();
};

const selectChoice = (text) => {
  if (isSending.value || isLoading.value || isTyping.value) return;
  inputAnswer.value = text;
  handleSend();
};

const handleKeydown = (e) => {
  if (isSending.value || isLoading.value || isTyping.value) return;

  const lastMessage = history.value[history.value.length - 1];

  if (!lastMessage || lastMessage.sender !== 'ai' || !lastMessage.choices || lastMessage.choices.length === 0) return;

  const choicesCount = lastMessage.choices.length;

  if (e.key >= '1' && e.key <= '9') {
      const index = parseInt(e.key) - 1;
      if (index < choicesCount) {
          e.preventDefault();
          selectChoice(lastMessage.choices[index].choice_text);
      }
      return;
  }

  if (e.key === 'ArrowDown') {
      e.preventDefault();
      focusedChoiceIndex.value = (focusedChoiceIndex.value + 1) % choicesCount;
  } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      focusedChoiceIndex.value = (focusedChoiceIndex.value - 1 + choicesCount) % choicesCount;
  }

  if (e.key === 'Enter') {
     if (document.activeElement !== textareaRef.value && focusedChoiceIndex.value !== -1) {
         e.preventDefault();
         selectChoice(lastMessage.choices[focusedChoiceIndex.value].choice_text);
     }
  }
};

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;700&display=swap');

.font-serif {
  font-family: 'Shippori Mincho', serif;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(34, 211, 238, 0.2);
  border-radius: 20px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(34, 211, 238, 0.5);
}

.fade-in {
  animation: fadeIn 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.typing-indicator {
  display: flex;
  align-items: center;
  gap: 3px;
}

.typing-indicator span {
  height: 4px;
  width: 4px;
  background-color: #22d3ee;
  border-radius: 50%;
  display: inline-block;
  animation: bounce 1.4s infinite ease-in-out both;
}

.typing-indicator span:nth-of-type(1) {
  animation-delay: -0.32s;
}

.typing-indicator span:nth-of-type(2) {
  animation-delay: -0.16s;
}

@keyframes bounce {
  0%, 80%, 100% { transform: scale(0); }
  40% { transform: scale(1.0); }
}
</style>
