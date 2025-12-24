# AI Socrates App (Agora Digitalis) - プロジェクト説明書

## 1. プロジェクト概要
**AI Socrates (Agora Digitalis)** は、古代ギリシャの哲学者ソクラテスを模したAIとの対話を通じて、ユーザーが知識を深めることができるWebアプリケーションです。
単なるクイズアプリではなく、**「問答法（Socratic Method）」** を用いて、ユーザーが自ら答えに辿り着けるようにAIが導く教育的な対話システムを搭載しています。

### 主な機能
- **対話型学習**: 選択問題に対するユーザーの回答（自由記述含む）をAIが評価。
- **足場かけ (Scaffolding)**: 不正解や不十分な記述に対し、AIが正解を教えるのではなく、ヒントや比喩を用いて思考を促す。
- **没入感のあるUI**: 古代ギリシャとサイバーパンクを融合した「Philosophia」なデザイン（Vue 3 + TailwindCSS）。
- **進捗管理**: 全問正解すると「真理への到達」として完了画面が表示される。

---

## 2. 技術スタック

### バックエンド (Laravel 12)
- **Framework**: Laravel 12.0
- **Language**: PHP 8.2
- **Database**: SQLite (推奨 / 開発環境), MySQL等
- **AI Integration**: Google Gemini API (`gemini-flash-latest`)
- **Key Services**:
    - `GeminiService`: AIとの対話プロンプト生成、API通信、履歴管理を担当。
    - `QuestionController`: 問題の提供、回答の受信、AIサービスへの委譲を担当。

### フロントエンド (Vue 3 + Vite)
- **Framework**: Vue.js 3.5 (Composition API)
- **Build Tool**: Vite 6.0
- **Styling**: TailwindCSS 3.4
- **State Management**: Pinia 2.3 (構成に含まれるが、主要コンポーネントではProps/EventsとLocal Stateが中心)
- **HTTP Client**: Axios
- **Markdown**: Marked (AIの応答をリッチテキストで表示)

---

## 3. システムアーキテクチャ

### ディレクトリ構造 (主要部分)
```
/
├── app/
│   ├── Http/Controllers/QuestionController.php  # APIエンドポイントの制御
│   ├── Models/                                  # Eloquentモデル (User, Question, Topic...)
│   └── Services/GeminiService.php               # AIロジックの中核
├── resources/js/
│   ├── components/QuestionFetcher.vue           # メインチャットUI
│   ├── App.vue                                  # アプリケーションルート
│   └── app.js                                   # エントリーポイント
├── routes/
│   ├── api.php                                  # APIルート定義
│   └── web.php                                  # SPA用ルート定義
└── database/                                    # マイグレーション、シーダー
```

### データモデル
- **Topic**: 学習テーマ（例: コンピュータアーキテクチャ）。
- **Question**: 各トピックに紐づく問題。選択肢 (`Choice`) を持つ。
- **Interaction**: ユーザーとAIの対話履歴。ユーザーの回答とAIのフィードバックをペアで保存。

---

## 4. コアロジック詳細

### 対話フロー (Backend Logic)
1. **問題取得**: `GET /api/topics/{id}/next-question`
    - ユーザーがまだクリアしていない最もIDが小さい問題を取得。
    - 該当問題に関する過去の「自分の」対話履歴をリセット（新規挑戦のため）。

2. **回答送信 & 判定**: `POST /api/questions/{id}/check`
    - **キーワード判定 (一次判定)**: 正解の選択肢に紐づくキーワードがユーザーの入力に含まれているか簡易チェック。
    - **AI評価 (GeminiService)**:
        - 過去の対話履歴 (`Interaction`) と最新の回答をAIに送信。
        - **System Prompt**: 「ソクラテス」として振る舞い、正解をすぐに教えず、ユーザーになぜその選択肢を選んだかを言語化させる。
        - **フィードバック**: AIからの応答文と、合格判定 (`[FINAL]` タグの有無) を返却。
    - **履歴保存**: 会話をデータベースに保存し、次回のコンテキストに利用。

### UI/UX (Frontend Logic)
- **QuestionFetcher.vue**:
    - **Markdown表示**: AIの応答をリアルタイムに近い感覚で表示（`marked`ライブラリ使用）。
    - **タイピング演出**: AI思考中 (`THINKING`) のアニメーション表示。
    - **視覚効果**: 背景のパララックス効果、サイバーパンク風の明滅演出など、学習への没入感を高める工夫。
    - **IME制御**: 日本語入力中の意図しない送信を防ぐ制御 (`isComposing`) が実装されている。

---

## 5. セットアップ / 実行方法

### 必要要件
- PHP >= 8.2
- Composer
- Node.js & NPM

### インストール手順
1. **依存関係のインストール**:
   ```bash
   composer install
   npm install
   ```
2. **環境設定**:
   - `.env.example` を `.env` にコピー。
   - `GEMINI_API_KEY` を設定。
   - データベース設定 (SQLiteの場合は `database/database.sqlite` を作成)。
3. **データベースの準備**:
   ```bash
   php artisan migrate --seed
   ```
4. **サーバー起動**:
   ```bash
   # 開発用サーバー (Vite + Laravel)
   npm run dev
   ```
