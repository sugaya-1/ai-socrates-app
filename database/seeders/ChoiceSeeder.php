<?php

namespace Database\Seeders;


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

            // --- 問3 (PDF問10: ハルシネーション) 正解: (エ) ---
            ['question_id' => 3, 'choice_text' => '(ア) エコーチェンバー', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(イ) シンギュラリティ', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(ウ) ディープフェイク', 'is_correct' => false, 'explanation' => null, 'created_at' => now(), 'updated_at' => now()],
            ['question_id' => 3, 'choice_text' => '(エ) ハルシネーション', 'is_correct' => true, 'explanation' => 'AIが事実に基づかない情報を、あたかも事実のように生成してしまう現象です（幻覚）。', 'created_at' => now(), 'updated_at' => now()],

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
        ];

        DB::table('choices')->insert($choices);
    }
}
