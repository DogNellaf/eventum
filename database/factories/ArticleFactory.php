<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'    => $this->faker->sentence(4),
            'text'     => $this->faker->paragraphs(3, true),
            'created'  => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'event_id' => Event::factory(),
        ];
    }
}
