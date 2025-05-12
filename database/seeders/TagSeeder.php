<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
   
    Tag::factory()->count(15)->create();
    /* $tags = [
      'Laravel', 'PHP', 'Backend', 'Frontend', 'Vue.js',
      'JavaScript', 'CSS', 'HTML', 'APIs', 'MySQL',
      'PostgreSQL', 'Security', 'DevOps', 'Testing', 'Git'
    ];

    foreach ($tags as $tag) {
      Tag::firstOrCreate(['name' => $tag]);
    } */
  }
}
