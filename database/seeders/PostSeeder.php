<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Post::factory()
      ->count(2)
      ->create()
      ->each(function ($post) {
        $this->attachTagsToPost($post, 3);
        // Randomly decide if the post will have images or a video
        $hasImages = rand(0, 1); // 50% chance for each type

        if ($hasImages) {
          $imageFiles = [
            'Image1.jpg',
            'Image2.png',
            'Image3.jpg',
          ];

          // Limit the number of images to the minimum between the number requested and those available
          $numberOfImages = min(rand(2, 4), count($imageFiles));
          $usedImages = []; // Store images already used in this post

          for ($i = 0; $i < $numberOfImages; $i++) {
            $fileName = $this->createMedia($post->id, 'image', $usedImages);
            $usedImages[] = $fileName; // Register the image used
          }
        } else {
          $this->createMedia($post->id, 'video');
        }
      });
  }

  private function attachTagsToPost(Post $post, int $count = 3): void
  {
    $totalTags = Tag::count();
    if ($totalTags < $count) {
      throw new \Exception("No hay suficientes tags en la base de datos.");
    }
    // Get existing tags randomly
    $tags = Tag::inRandomOrder()->limit($count)->get();
    $post->tags()->attach($tags);
  }

  private function createMedia(int $postId, string $type, array &$usedImages = []): string
  {
    if ($type === 'image') {
      $imageFiles = [
        'Image1.jpg',
        'Image2.png',
        'Image3.jpg',
      ];

      // Filter unused images
      $availableImages = array_diff($imageFiles, $usedImages);

      if (empty($availableImages)) {
        throw new \Exception('No hay más imágenes disponibles para este post.');
      }

      $fileName = $availableImages[array_rand($availableImages)];
      $mimeType = (pathinfo($fileName, PATHINFO_EXTENSION) === 'jpg') ? 'image/jpeg' : 'image/png';
    } else {
      $videoFiles = [
        'Video1.mp4',
      ];
      $fileName = $videoFiles[array_rand($videoFiles)];
      $mimeType = 'video/mp4';
    }

    $uuid = Uuid::uuid4()->toString();
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    $uniqueFileName = $uuid. '.'. $extension;

    // Source and destination paths
    $sourcePath = 'testing/' . $fileName;
    $destinationPath = 'uploads/' . $uniqueFileName;

    Storage::disk('public')->put($destinationPath, file_get_contents(storage_path('app/' . $sourcePath)));
    $fileUrl = '/storage/' . $destinationPath;

    Media::create([
      'post_id' => $postId,
      'url' => $fileUrl,
      'file_type' => $mimeType,
    ]);

    // Return the name of the file to record its use
    return $fileName;
  }
}
