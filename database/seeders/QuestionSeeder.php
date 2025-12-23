<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // --- ストラテジ系 (経営・法律) ---
            [
                'id' => 1,
                'topic_id' => 1,
                'question_text' => '投資の優先度などの経営の戦略を策定するために、経済価値、希少性、模倣困難性及び組織の四つの要素で評価することによって、自社のもつ資源を分析する手法として、最も適切なものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'topic_id' => 1,
                'question_text' => '新しい概念やアイディアの実証を目的とした、開発の前段階における検証を表す用語はどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'topic_id' => 1,
                'question_text' => '生成AIにおいて、もっともらしいが事実とは異なる内容が出力されることを表す用語として、最も適切なものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- マネジメント系 (開発・管理) ---
            [
                'id' => 4,
                'topic_id' => 2,
                'question_text' => 'RPAに関する記述として、最も適切なものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'topic_id' => 2,
                'question_text' => '合意したサービス提供時間帯のうち、実際に顧客がITサービスを利用できた時間の割合で表されるものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'topic_id' => 2,
                'question_text' => 'システム開発の早い段階で、目に見える形で利用者の要求が確認できるように確認用のソフトウェアを作成するソフトウェア開発モデルとして、最も適切なものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- テクノロジ系 (技術・セキュリティ) ---
            [
                'id' => 7,
                'topic_id' => 3,
                'question_text' => 'Bluetoothに追加された仕様の一つであり、省電力性に優れているので、IoTシステムを長期間運用でき、送受信デバイス間の距離を知ることにも使われているものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'topic_id' => 3,
                'question_text' => 'DNSの説明として、適切なものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'topic_id' => 3,
                'question_text' => '情報セキュリティにおける脅威のうち、脆弱性を是正するセキュリティパッチをソフトウェアに適用することが最も有効な対策になるものはどれか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'topic_id' => 3,
                'question_text' => 'AIにおいて、広範囲かつ大量のデータで訓練されたものであり、ファインチューニングなどによって文章生成AIのような様々な用途に適応できる特徴をもつものを何というか。',
                'question_type' => 'multiple_choice',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('questions')->insert($questions);
    }
}
