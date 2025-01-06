<?php

namespace Database\Seeders;

use App\Models\Event\EventSearch;
use App\Traits\SeedingFromCsv;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSearchTableSeeder extends Seeder
{
    use SeedingFromCsv;

    private $table = 'event_searches';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new EventSearch;
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::statement('TRUNCATE TABLE '.$this->table.';');
        DB::statement('ALTER TABLE '.$this->table.' AUTO_INCREMENT = 1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->insertFromCsv($this->table, $model, $this);
    }
}
