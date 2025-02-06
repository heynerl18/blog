<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class MediaFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Media::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */

  public function definition(): array
  {
    // Obtener el tipo de archivo (imagen o video) desde los atributos
    $fileType = $this->faker->randomElement(['image/jpeg', 'image/png', 'video/mp4']);

    if (strpos($fileType, 'image') !== false) {
      // Lista de archivos de imagen con diferentes extensiones
      $imageFiles = [
        'Image1.jpg',
        'Image2.png',
        'Image3.jpg',
      ];
      $fileName = $this->faker->randomElement($imageFiles);
    } else {
      // Lista de archivos de video
      $videoFiles = [
        'Video1.mp4',
      ];
      $fileName = $this->faker->randomElement($videoFiles);
    }

    // Source and destination paths
    $sourcePath = 'testing/' . $fileName;
    $destinationPath = 'uploads/' . $fileName;

    // Copy the test file to the storage folder
    Storage::disk('public')->put($destinationPath, file_get_contents(storage_path('app/' . $sourcePath)));

    // Generate the file URL manually
    $fileUrl = '/storage/' . $destinationPath;

    return [
      'url' => $fileUrl, // Ruta relativa para la URL
      'file_type' => $fileType, // Image or video MIME type
    ];
  }
}
