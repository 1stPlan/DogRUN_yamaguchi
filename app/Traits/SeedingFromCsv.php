<?php

namespace App\Traits;

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use Log;

trait SeedingFromCsv {

    /**
     * @param $tableName
     * @param Model $model
     * @param Seeder $seeder
     */
    public function insertFromCsv($tableName, Model $model, Seeder $seeder) {

        // @TODO インスタンス::count()ってどうなんですかね。
        $existFlg = $model::count();
        if ($existFlg > 0) {
            $seeder->command->info($tableName.'テーブルにデータが存在しています。csvファイルからデータを挿入する場合は、テーブルを空にしてから再度コマンドを実行してください。');
            return;
        }

        $csvFileName = database_path('csvs/'.$tableName.'.csv');

        $insertArr = [];
        $headTitles = [];

        $seeder->command->info('[Start] import '.$tableName.' data.');

        $config = new LexerConfig();
        $config->setDelimiter(",");
        // $config->setEnclosure('"');
        $config->setFromCharset("UTF-8");
        //$config->setFromCharset("sjis-win");
        $lexer = new Lexer($config);
        $interpreter = new Interpreter();


        $headTitle = true;
        $interpreter->addObserver(function(array $row) use (&$headTitle, &$insertArr, &$headTitles) {
            // 各列のデータを取得
            if ($headTitle) {
                foreach ($row as $r) {
                    $headTitles[] = $r;
                }
                $headTitle = false;
                return;
            }

            // 登録処理をここに書く
            $tempArr = [];
            foreach ($headTitles as $index => $title) {
              // Log::debug($row[$index]);
                $tempArr[$title] = trim($row[$index]);
            }
            $insertArr[] = $tempArr;
        });

        $lexer->parse($csvFileName, $interpreter);
        $model::insert($insertArr);

        $seeder->command->info('[End] import '.$tableName.' data.');
    }
}
