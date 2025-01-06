<?php

namespace Database\Seeders;

use App\Models\Type\QuestionSet;
use App\Traits\SeedingFromCsv;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSetTableSeeder extends Seeder
{
    use SeedingFromCsv;

    private $table = 'question_sets';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new QuestionSet;
        DB::statement('TRUNCATE TABLE '.$this->table.';');
        DB::statement('ALTER TABLE '.$this->table.' AUTO_INCREMENT = 1;');
        $this->insertFromCsv($this->table, $model, $this);
    }
}
