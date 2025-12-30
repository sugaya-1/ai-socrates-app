<?php

namespace App\Services;

use App\Models\Interaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiUrl;
    private string $model = 'gemini-flash-latest';



    public function __construct()
    {
        $apiKey = env('GEMINI_API_KEY', '');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key=" . $apiKey;
    }

    /**
     * AIの応答を生成し、Interaction履歴をデータベースに保存する
     */
    public function generateAndSaveResponse(
        ?int $userId, // ★ここに「?」を追加してください
        int $questionId,
        string $questionText,
        string $userAnswerText,
        string $correctAnswerText,
        bool $isCorrect,
        Collection $pastInteractions,
        $choices = null
    ): array {
        // 選択肢リストをテキスト化
        $choicesText = "";
        if ($choices) {
            foreach ($choices as $choice) {
                $text = $choice->choice_text ?? $choice->text ?? '';
                $choicesText .= "- {$text}\n";
            }
        }

        // 会話履歴の構築
        $chatHistory = [];
        foreach ($pastInteractions as $interaction) {
            $chatHistory[] = ['role' => 'user', 'parts' => [['text' => '私の前の回答: ' . $interaction->user_answer]]];

            // 履歴に含まれるバックスラッシュを除去してAPIエラーを防ぐ
            $cleanAiResponse = str_replace(['\\'], '', $interaction->ai_response);
            $chatHistory[] = ['role' => 'model', 'parts' => [['text' => $cleanAiResponse]]];
        }

        $chatHistory[] = ['role' => 'user', 'parts' => [['text' => '最新の私の回答: ' . $userAnswerText]]];

        // プロンプト構築
        $baseInstruction = "【あなたの役割：優しいソクラテス】
あなたは、学習者の「リフレクション（内省）」を促し、かつ「学習意欲を維持させる」優しいメンターです。
単に正解を教えるのではなく、学習者が答えに詰まったらすぐに「ヒント」や「思考の足がかり（Scaffolding）」を提供し、自律的な学びを支援してください。古代ギリシャの哲学者ですが、口調はとても親切で、学習者を励ますように話します。

【現在の問題】
{$questionText}

【選択肢】
{$choicesText}

【正解】
{$correctAnswerText}

【あなたのタスク】
ユーザーの回答「{$userAnswerText}」を分析し、以下のいずれかの「学習者の状態」であると仮説を立て、対応してください。

1. **知識の孤立 (Isolated Knowledge)**
   - 状態: 正解しているが、理由が説明できない。丸暗記。
   - 戦略: 「素晴らしい！大正解です。」と褒めた上で、「では、もし〇〇だったらどうなるでしょう？」と応用を問い、知識をつなげさせる。

2. **誤った体系化 (Misconception)**
   - 状態: 一見問題なく答えているが、論理や知識の結びつきが間違っている。
   - 戦略: **全否定せず受け止める。** 「その考え方も一理ありますね。ただ、〇〇の観点で見るとどうでしょう？」と矛盾に気づくヒントを出す。

3. **知識の欠落 (Missing Knowledge)**
   - 状態: 「わからない」、無回答、または当てずっぽう。間違い。
   - 戦略: **すぐに助け舟を出す。** 「大丈夫です、少し難しい用語ですよね。例えるなら～のようなものです」と具体例や比喩（Scaffolding）を提示し、小さな問いから再度始める。

【重要：対話のスタイル】
- **共感的であること**: 「難しいですよね」「その視点は面白いですね」と寄り添う。
- **ヒントを惜しまない**: 質問攻めにせず、答えに近づくための具体的なヒントや比喩を出す。
- **否定しない**: 間違いを指摘する際も、「それは違います」ではなく、「なるほど。ではこの場合はどうなりますか？」と気づきを促す。
- **重要: 以前の問題（CPUなど）の内容と混同しないこと。必ず上記の【現在の問題】に基づいて対話してください。**
- 学習者が概念を正しく理解し、合格ラインに達したと判断したら、文末に [FINAL] を出力してください。";

        $isInitialCheck = ($pastInteractions->count() === 0);

        if ($isInitialCheck) {
            // 初回フェーズ
            $taskInstruction = "
            【状況】これは学習者の『最初の回答』です。

            【指示】
            1. まず、ユーザーの回答が正解か不正解かを、優しくハッキリと伝えてください。
            2. その後、上記の【学習者の状態】に基づき、適切な問いかけやヒントを行ってください。";
        } else {
            // 深掘りフェーズ
            $taskInstruction = "
            【状況】これは対話の続き（深掘りフェーズ）です。
            学習者はすでに選択肢を選び終え、その理由や定義について説明しようとしています。

            【禁止事項】
            ・「どの選択肢を選びましたか？」と再度確認してはいけません。
            ・「Aですか？Bですか？」と記号での回答を求めてはいけません。

            【指示】
            ユーザーの説明（「{$userAnswerText}」）に対して、優しくフィードバックを行ってください。
            ・説明が正しい場合 → 大いに褒めて、さらに補足知識を問うか、[FINAL]を出してください。
            ・説明が誤り・不足の場合 → 否定せず、「では、〇〇という観点ではどうだろう？」と別の角度からヒントを出してください。";
        }

        $systemInstructionText = $baseInstruction . "\n\n" . $taskInstruction;

        $explanation = "AIとの対話でエラーが発生しました.";

        // Gemini API 呼び出し
        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'contents' => $chatHistory,
                'systemInstruction' => [
                    'parts' => [['text' => $systemInstructionText]]
                ],
                'generationConfig' => [
                    'temperature' => 0.3
                ]
            ]);

            if ($response->successful()) {
                $generatedText = $response->json('candidates.0.content.parts.0.text');
                $explanation = $generatedText ?: "AI応答取得エラー";
                $explanation = str_replace(['\\'], '', $explanation);
            } else {
                Log::error('Gemini API request failed.', ['status' => $response->status()]);
                $explanation = "AI通信エラー";
            }
        } catch (\Exception $e) {
            Log::error('Gemini API connection error.', ['error' => $e->getMessage()]);
            $explanation = "AI接続エラー";
        }

        // 終了判定と保存
        $isSufficient = false;
        if (str_contains($explanation, '[FINAL]')) {
            $isSufficient = true;
            $explanation = str_replace('[FINAL]', '', $explanation);
        }

        try {
            Interaction::create([
                'user_id' => $userId, // ここでユーザーIDを保存
                'question_id' => $questionId,
                'user_answer' => $userAnswerText,
                'ai_response' => $explanation,
                'is_correct' => $isCorrect,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save interaction.', ['question_id' => $questionId, 'error' => $e->getMessage()]);
        }

        return [
            'explanation' => $explanation,
            'is_correct' => $isCorrect,
            'is_sufficient' => $isSufficient
        ];
    }
}
