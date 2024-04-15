<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'event_id' => Event::inRandomOrder()->first()->id,
      'user_id' => User::inRandomOrder()->first()->id,
      'apply_date' => $this->faker->dateTime('-1 month'),
      'is_paid' => '0'
    ];
  }
}
