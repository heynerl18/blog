<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::create([
      'name' => 'Heyner Leiva Diaz',
      'email' => 'heynerleiva96@gmail.com',
      'password' => bcrypt(12345678),
      'email_verified_at' => Carbon::now(),
      'remember_token' => null,
    ])->assignRole('Admin');

    User::factory()->count(20)->create();
  }
}
