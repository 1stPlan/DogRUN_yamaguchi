<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ExportDbml extends Command
{
    protected $signature = 'dbml:export';

    protected $description = 'Export database schema to DBML format';

    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        $dbmlContent = '';

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            $dbmlContent .= "Table {$tableName} {\n";

            $columns = DB::select("SHOW COLUMNS FROM {$tableName}");
            foreach ($columns as $column) {
                $settings = '';

                // プライマリキーまたはユニークキーの設定
                if (strpos($column->Key, 'PRI') !== false) {
                    $settings = 'pk';
                } elseif (strpos($column->Key, 'UNI') !== false) {
                    $settings = 'unique';
                }

                // 型情報を追加
                $type = $column->Type; // MySQLの型情報をそのまま取得
                if (strpos($type, '(') !== false) {
                    $type = substr($type, 0, strpos($type, '(')); // 長さ指定を削除
                }

                $dbmlContent .= "  {$column->Field} {$type} {$settings}\n";
            }

            $dbmlContent .= "}\n\n";
        }

        // 保存先ディレクトリを作成（存在しない場合のみ）
        $directoryPath = storage_path('app/dbml');
        if (! File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true); // 第三引数: true で再帰的に作成
        }

        // DBML ファイルを保存
        $filePath = $directoryPath.'/schema.dbml';
        file_put_contents($filePath, $dbmlContent);

        $this->info("DBML file has been exported to {$filePath}");
    }
}
