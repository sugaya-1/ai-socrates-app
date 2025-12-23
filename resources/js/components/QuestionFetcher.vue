<template>
  <div
    class="w-full max-w-4xl h-[80vh] md:h-[85vh] bg-slate-900/70 backdrop-blur-xl rounded-2xl shadow-[0_0_50px_rgba(6,182,212,0.1)] flex flex-col overflow-hidden relative border border-cyan-500/20 z-10 transition-all duration-500 ring-1 ring-white/5">

    <div
      class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-cyan-500/30 rounded-tl-lg pointer-events-none">
    </div>
    <div
      class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 border-cyan-500/30 rounded-tr-lg pointer-events-none">
    </div>
    <div
      class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 border-cyan-500/30 rounded-bl-lg pointer-events-none">
    </div>
    <div
      class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-cyan-500/30 rounded-br-lg pointer-events-none">
    </div>

    <header
      class="py-4 px-6 border-b border-cyan-500/10 bg-slate-900/40 z-10 shrink-0 flex justify-between items-center shadow-sm">
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
      class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 custom-scrollbar relative bg-transparent scroll-smooth">

      <div v-if="!hasStarted" class="flex flex-col items-center justify-center h-full space-y-12 fade-in pb-10">
        <div
          class="bg-gradient-to-br from-slate-800/80 to-slate-900/80 backdrop-blur-md text-cyan-50 p-10 rounded-xl shadow-2xl border border-cyan-500/20 max-w-lg text-base leading-loose relative font-serif mx-4">

          <div
            class="mb-6 text-xs font-bold text-cyan-400 flex items-center justify-center gap-2 tracking-[0.2em] opacity-80">
            <span>INITIALIZING</span><span class="animate-pulse">...</span>
          </div>

          <p class="text-center font-medium drop-shadow-sm text-lg">
            「叡智の探求者よ、こんにちは。<br>
            <span class="text-cyan-200">問答</span>を通じて、思考の深淵へ。<br>
            準備はよろしいかな？」
          </p>
        </div>

        <button @click="startSession"
          class="group relative bg-cyan-950/60 text-cyan-100 text-lg font-serif font-bold py-4 px-16 rounded-full overflow-hidden border border-cyan-400/30 transition-all duration-300 hover:bg-cyan-900/80 hover:border-cyan-400/80 hover:shadow-[0_0_30px_rgba(34,211,238,0.2)] hover:-translate-y-1">
          <span class="relative z-10 tracking-widest">対話を始める</span>
          <div
            class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-cyan-400/20 to-transparent z-0">
          </div>
        </button>
      </div>

      <div v-else-if="isCompleted"
        class="flex flex-col items-center justify-center h-full space-y-8 fade-in text-center p-8 bg-slate-900/20 rounded-xl">
        <div class="relative">
          <div class="absolute inset-0 bg-cyan-400/20 blur-xl rounded-full animate-pulse"></div>
          <div class="text-7xl relative z-10 text-cyan-200 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]">✦</div>
        </div>
        <div>
          <h2 class="text-4xl font-bold text-cyan-50 font-serif mb-4 tracking-wider">真理への到達</h2>
          <p class="text-cyan-200/70 text-lg font-serif leading-relaxed">全問クリアしました。<br>あなたの探究心に敬意を表します。</p>
        </div>
        <button @click="resetSession"
          class="mt-8 px-8 py-3 rounded border border-cyan-500/30 text-cyan-400 hover:bg-cyan-900/30 hover:text-cyan-200 font-serif transition-all duration-300">システム再起動</button>
      </div>

      <template v-else>
        <div v-for="(message, index) in history" :key="index" class="flex w-full fade-in group mb-4"
          :class="message.sender === 'user' ? 'justify-end' : 'justify-start'">

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
            ]" v-html="parseMarkdown(message.text)">
            </div>

            <div v-if="message.choices && message.choices.length > 0 && message.type === 'question'"
              class="mt-6 pt-4 border-t border-cyan-500/10 space-y-3">
              <p class="text-[10px] font-sans tracking-widest text-cyan-500/60 text-center mb-2">- SELECTION -</p>
              <div class="grid gap-3">
                <button v-for="choice in message.choices" :key="choice.id"
                  class="text-left text-sm bg-slate-900/40 hover:bg-cyan-900/30 px-5 py-4 rounded-lg border border-cyan-500/20 text-cyan-100 shadow-sm hover:border-cyan-400/50 hover:text-cyan-50 transition-all duration-200 group-hover:shadow-[0_0_10px_rgba(34,211,238,0.1)] font-serif relative overflow-hidden">
                  <span class="relative z-10">{{ choice.choice_text }}</span>
                  <div
                    class="absolute inset-0 bg-cyan-400/5 opacity-0 hover:opacity-100 transition-opacity duration-300">
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="isSending || isLoading" class="flex justify-start fade-in pl-2">
          <div
            class="flex items-center gap-2 text-cyan-500/70 text-xs font-mono tracking-widest bg-slate-900/50 px-4 py-2 rounded-full border border-cyan-500/10">
            <span>THINKING</span>
            <div class="typing-indicator scale-75"><span></span><span></span><span></span></div>
          </div>
        </div>

        <div v-if="error" class="flex justify-center my-4 fade-in">
          <div
            class="bg-red-950/50 text-red-200 text-sm px-6 py-3 rounded-lg border border-red-500/30 shadow-lg flex items-center gap-3 font-serif backdrop-blur-md">
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
      class="p-4 md:p-6 bg-slate-900/60 backdrop-blur-xl z-10 shrink-0 border-t border-cyan-500/10">
      <div v-if="!isSufficient" class="fade-in w-full">
        <div class="flex items-end space-x-3 relative max-w-3xl mx-auto">
          <div class="flex-1 relative">
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
            <button @click="askOracle" :disabled="isSending || isLoading || !currentQuestionId"
              class="w-14 h-[56px] flex items-center justify-center bg-amber-600/20 text-amber-200 rounded-xl hover:bg-amber-600/40 border border-amber-500/30 active:scale-95 transition-all shadow-lg hover:shadow-[0_0_15px_rgba(245,158,11,0.2)] disabled:opacity-30 disabled:cursor-not-allowed backdrop-blur-sm group relative overflow-hidden"
              title="オラクル（ヒント）">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                  d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L12 3Z" />
              </svg>
            </button>
            <button @click="handleSend" :disabled="isSending || !inputAnswer.trim() || !currentQuestionId"
              class="w-14 h-[56px] flex items-center justify-center bg-cyan-600 text-white rounded-xl hover:bg-cyan-500 active:scale-95 transition-all shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.6)] disabled:opacity-30 disabled:cursor-not-allowed border border-cyan-400/20"
              title="送信">
              <svg v-if="!isSending" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
              <div v-else class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
            </button>
          </div>
        </div>
      </div>
      <div v-else class="fade-in w-full max-w-md mx-auto">
        <button @click="handleNextTopic"
          class="w-full bg-cyan-900/40 text-cyan-50 font-serif font-bold py-4 px-6 rounded-xl hover:bg-cyan-800/60 active:scale-[0.99] focus:outline-none transition-all shadow-lg hover:shadow-[0_0_20px_rgba(34,211,238,0.2)] flex items-center justify-center space-x-3 text-lg border border-cyan-400/30 backdrop-blur-sm group">
          <span>次の問いへ進む</span>
          <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
          </svg>
        </button>
      </div>
    </footer>
  </div>
</template>

<script setup>
// スクリプト部分はロジック変更なしなので、元のまま維持してください。
// インポート文などはそのまま利用可能です。
import { ref, nextTick } from 'vue';
import axios from 'axios';
import { marked } from 'marked';

// ... (以下、元のscript内容をそのままペーストしてください)
// ※機能変更禁止の要望に従い、JSロジックは一切触りません。
//   ただし、classの微調整に合わせてtemplate内は上記のように書き換えてください。

const chatWindow = ref(null);
const textareaRef = ref(null);
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

const parseMarkdown = (text) => {
  if (text == null || typeof text !== 'string') {
    return '';
  }

  try {
    let cleanText = text;
    cleanText = cleanText.replace(/\\(\*)/g, '$1');

    // サイバー感のある発光する青に変更
    cleanText = cleanText.replace(/\*\*\s*(.*?)\s*\*\*/g, '<strong class="text-cyan-300 font-bold drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]">$1</strong>');

    return marked.parse(cleanText);

  } catch (e) {
    console.error("Markdown変換エラー:", e);
    return text;
  }
};

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

const scrollToBottom = () => {
  nextTick(() => {
    if (chatWindow.value) {
      chatWindow.value.scrollTo({ top: chatWindow.value.scrollHeight, behavior: 'smooth' });
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
  scrollToBottom();
  try {
    // 先頭の http://localhost を消して / から始める
    const API_URL = `/api/topics/${currentTopicId.value}/next-question`;
    const response = await axios.get(API_URL);
    const data = response.data;
    currentQuestionId.value = data.id;
    nextTopicId.value = data.next_topic_id || null;
    history.value.push({ sender: 'ai', type: 'question', text: data.question_text, question_id: data.id, choices: data.choices });
  } catch (err) {
    if (err.response && err.response.status === 404) {
      isCompleted.value = true;
    } else {
      console.error("Error:", err);
      error.value = { message: '問題の取得に失敗しました。' };
    }
  } finally {
    isLoading.value = false;
    scrollToBottom();
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
  scrollToBottom();
  try {
    // 先頭の http://localhost を消して / から始める
    const API_URL = `/api/questions/${currentQuestionId.value}/check`;
    const response = await axios.post(API_URL, { answer_text: text });
    const data = response.data;
    history.value.push({ sender: 'ai', type: 'feedback', text: data.explanation, question_id: currentQuestionId.value, is_correct: data.is_correct });
    if (data.is_sufficient === true || (data.explanation && data.explanation.includes('[CORRECT]'))) {
      isSufficient.value = true;
    }
  } catch (err) {
    console.error("Send Error:", err);
    error.value = { message: '通信エラーが発生しました。' };
  } finally {
    isSending.value = false;
    scrollToBottom();
  }
};

const askOracle = () => {
  inputAnswer.value = "知恵を借してくれないか？";
  handleSend();
};

const handleEnterKey = (e) => {
  // 【最重要】IME変換中（日本語入力中）なら何もしない
  // これがないと、漢字変換の確定エンターで送信されてしまいます
  if (e.isComposing || e.keyCode === 229) {
    return;
  }

  // Shiftキーが押されているなら、通常の「改行」動作をさせる
  if (e.shiftKey) {
    return; // 何もしない＝ブラウザ標準の改行が入る
  }

  // それ以外（変換中でもなく、Shiftも押していないEnter）なら送信
  e.preventDefault(); // 改行が入らないように止める
  handleSend();       // 送信実行
};
</script>

<style scoped>
/* スタイルも基本維持ですが、スクロールバー等は調整しています */
@import url('https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;700&display=swap');

.font-serif {
  font-family: 'Shippori Mincho', serif;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
  /* 少し細くして上品に */
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
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
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

  0%,
  80%,
  100% {
    transform: scale(0);
  }

  40% {
    transform: scale(1.0);
  }
}

@keyframes shimmer {
  0% {
    transform: translateX(-150%) skewX(-15deg);
  }

  100% {
    transform: translateX(150%) skewX(-15deg);
  }
}
</style>
