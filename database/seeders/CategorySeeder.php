<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Category::factory()->count(15)->create();
    /* $categories = [
      'Tecnología', 'Programación', 'Diseño Web', 'Bases de Datos', 'Seguridad',
      'Frontend', 'Backend', 'Desarrollo Móvil', 'DevOps', 'Negocios'
    ];

    foreach ($categories as $category) {
      Category::firstOrCreate([
          'name' => $category,
          'slug' => Str::slug($category),
      ]);
    } */
  }
}
