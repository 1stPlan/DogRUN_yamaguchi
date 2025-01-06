<?php

namespace Database\Seeders;

use App\Models\Type\Question;
use App\Traits\SeedingFromCsv;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    use SeedingFromCsv;

    private $table = 'questions';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Question;
        DB::statement('TRUNCATE TABLE '.$this->table.';');
        DB::statement('ALTER TABLE '.$this->table.' AUTO_INCREMENT = 1;');
        $this->insertFromCsv($this->table, $model, $this);
    }
}
