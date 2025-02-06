<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();

        // Generar contenido enriquecido con HTML
        $content = $this->generateRichTextContent();

        return [
            'title' => $this->faker->sentence, // Título aleatorio
            'content' => $content, // Contenido aleatorio (3 párrafos)
            'user_id' => $user->id, // Asignar un usuario existente
            'category_id' => $category->id, // Asignar una categoría existente
        ];
    }

    /**
     * Generate rich content with HTML.
     */
    private function generateRichTextContent(): string
    {
        // Generate multiple paragraphs with random text
        $paragraphs = $this->faker->paragraphs(3);

        // Convert paragraphs to HTML
        $content = '';
        foreach ($paragraphs as $paragraph) {
            $content .= "<p>$paragraph</p>";
        }

        // Add some additional HTML elements to simulate a rich text editor
        $content .= "<h2>{$this->faker->sentence}</h2>"; // a header
        $content .= "<p>{$this->faker->paragraph}</p>"; // another paragraph
        $content .= "<ul>"; // An unordered list
        for ($i = 0; $i < 3; $i++) {
            $content .= "<li>{$this->faker->sentence}</li>";
        }
        $content .= "</ul>";

        return $content;
    }
}
