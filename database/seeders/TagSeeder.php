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
    $tagsToCreate = 30;
    $createdTags = 0;

    while ($createdTags < $tagsToCreate) {
      $word = $this->generateUniqueWord(3);

      if (!Tag::where('name', $word)->exists()) {
        Tag::create(['name' => $word]);
        $createdTags++;
      }
    }
    /* $tags = [
      'Laravel', 'PHP', 'Backend', 'Frontend', 'Vue.js',
      'JavaScript', 'CSS', 'HTML', 'APIs', 'MySQL',
      'PostgreSQL', 'Security', 'DevOps', 'Testing', 'Git'
    ];

    foreach ($tags as $tag) {
      Tag::firstOrCreate(['name' => $tag]);
    } */
  }

  private function generateUniqueWord(int $minLength): string
  {
    $faker = \Faker\Factory::create();

    do {
      $word = $faker->unique()->word();
    } while (strlen($word) < $minLength);

    return $word;
  }
}
