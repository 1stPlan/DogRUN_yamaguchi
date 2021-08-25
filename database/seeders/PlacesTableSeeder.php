<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Traits\SeedingFromCsv;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{

  use SeedingFromCsv;
  private $table = "places";
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $model = new Place();
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::statement('TRUNCATE TABLE ' . $this->table . ';');
    DB::statement('ALTER TABLE ' . $this->table . ' AUTO_INCREMENT = 1;');
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    $this->insertFromCsv($this->table, $model, $this);
  }
}
