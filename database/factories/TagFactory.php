<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */

  protected $model = Tag::class;

  public function definition(): array
  {
    do {
      $name = $this->faker->unique()->word();
    } while (strlen($name) < 3);

    return [
      'name' => $this->faker->word(),
      'slug' => Str::slug($name),
    ];
  }

}
