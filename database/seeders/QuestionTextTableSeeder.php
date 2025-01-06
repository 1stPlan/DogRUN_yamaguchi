<?php

namespace Database\Seeders;

use App\Models\Type\QuestionText;
use App\Traits\SeedingFromCsv;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTextTableSeeder extends Seeder
{
    use SeedingFromCsv;

    private $table = 'question_texts';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $model = new QuestionText;
        DB::statement('TRUNCATE TABLE '.$this->table.';');
        DB::statement('ALTER TABLE '.$this->table.' AUTO_INCREMENT = 1;');
        $this->insertFromCsv($this->table, $model, $this);
    }
}
