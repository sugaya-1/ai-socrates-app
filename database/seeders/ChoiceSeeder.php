<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $choices = [
            // --- 問1 (PDF問4: VRIO分析) 正解: (エ) ---
            ['question_id' => 1, 'choice_text' => '(ア) 4P', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 1, 'choice_text' => '(イ) PPM', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 1, 'choice_text' => '(ウ) SWOT 分析', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 1, 'choice_text' => '(エ) VRIO分析', 'is_correct' => true, 'explanation' => 'Value(経済価値)、Rarity(希少性)、Imitability(模倣困難性)、Organization(組織)の頭文字をとった分析手法です。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問2 (PDF問7: PoC) 正解: (イ) ---
            ['question_id' => 2, 'choice_text' => '(ア) CRM', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 2, 'choice_text' => '(イ) PoC', 'is_correct' => true, 'explanation' => 'Proof of Concept（概念実証）の略で、本格開発前の検証を指します。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 2, 'choice_text' => '(ウ) RAS', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 2, 'choice_text' => '(エ) SLA', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],

            // --- 問3 (PDF問10: ハルシネーション) 正解: (エ) ---
            // ※PDFの並び順（ア,イ,ウ,エ）に合わせて再整理
            ['question_id' => 3, 'choice_text' => '(ア) エコーチェンバー', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(イ) シンギュラリティ', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(ウ) ディープフェイク', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(エ) ハルシネーション', 'is_correct' => true, 'explanation' => 'AIが事実に基づかない情報を、あたかも事実のように生成してしまう現象です（幻覚）。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問4 (PDF問24: RPA) 正解: (エ) ---
            ['question_id' => 4, 'choice_text' => '(ア) 企業の一部の業務を外部の組織に委託すること', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 4, 'choice_text' => '(イ) 組立てや搬送などにハードウェアのロボットを用いること', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 4, 'choice_text' => '(ウ) システムの利用者が主体的にシステム管理や運用を行うこと', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 4, 'choice_text' => '(エ) ホワイトカラーの定型的な事務作業をソフトウェアのロボットに代替させること', 'is_correct' => true, 'explanation' => 'RPAはRobotic Process Automationの略で、定型業務の自動化技術です。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問5 (PDF問36: 可用性) 正解: (ア) ---
            ['question_id' => 5, 'choice_text' => '(ア) 可用性', 'is_correct' => true, 'explanation' => 'Availability。システムが必要な時にいつでも使える状態にある特性のことです。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 5, 'choice_text' => '(イ) 機能性', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 5, 'choice_text' => '(ウ) 効率性', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 5, 'choice_text' => '(エ) 使用性', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],

            // --- 問6 (PDF問44: プロトタイピング) 正解: (エ) ---
            ['question_id' => 6, 'choice_text' => '(ア) アジャイル', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 6, 'choice_text' => '(イ) ウォーターフォール', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 6, 'choice_text' => '(ウ) スパイラル', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 6, 'choice_text' => '(エ) プロトタイピング', 'is_correct' => true, 'explanation' => '試作品（プロトタイプ）を作成し、利用者のフィードバックを得ながら開発を進める手法です。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問7 (PDF問56: BLE) 正解: (ア) ---
            ['question_id' => 7, 'choice_text' => '(ア) BLE', 'is_correct' => true, 'explanation' => 'Bluetooth Low Energyの略です。省電力でIoT機器によく使われます。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 7, 'choice_text' => '(イ) IrDA', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 7, 'choice_text' => '(ウ) NFC', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 7, 'choice_text' => '(エ) PLC', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],

            // --- 問8 (PDF問58: DNS) 正解: (ウ) ---
            ['question_id' => 8, 'choice_text' => '(ア) IPアドレスを自動的に割り当てるプロトコル', 'is_correct' => false, 'explanation' => 'これはDHCPの説明です。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 8, 'choice_text' => '(イ) 通信を暗号化するプロトコル', 'is_correct' => false, 'explanation' => 'これはSSL/TLSの説明です。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 8, 'choice_text' => '(ウ) ホスト名やドメイン名と、IPアドレスを対応付ける仕組み', 'is_correct' => true, 'explanation' => 'DNS（Domain Name System）の主な役割です。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 8, 'choice_text' => '(エ) MACアドレスを対応付ける仕組み', 'is_correct' => false, 'explanation' => 'これはARPなどの説明です。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問9 (PDF問70: バッファオーバーフロー) 正解: (エ) ---
            ['question_id' => 9, 'choice_text' => '(ア) 総当たり攻撃', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 9, 'choice_text' => '(イ) ソーシャルエンジニアリング', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 9, 'choice_text' => '(ウ) パスワードリスト攻撃', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 9, 'choice_text' => '(エ) バッファオーバーフロー', 'is_correct' => true, 'explanation' => 'プログラムのメモリ領域（バッファ）に関する脆弱性を突く攻撃のため、修正パッチが有効です。', 'created_at' => now(), 'updated_at' => now()],

            // --- 問10 (PDF問80: 基盤モデル) 正解: (ウ) ---
            ['question_id' => 10, 'choice_text' => '(ア) アノテーション', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 10, 'choice_text' => '(イ) エキスパートシステム', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 10, 'choice_text' => '(ウ) 基盤モデル', 'is_correct' => true, 'explanation' => 'Foundation Modelとも呼ばれ、GPTなどの大規模言語モデル（LLM）のベースとなるモデルです。', 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 10, 'choice_text' => '(エ) 畳み込みニューラルネットワーク', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('choices')->insert($choices);
    }
}
