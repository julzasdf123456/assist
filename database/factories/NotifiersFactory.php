<?php

namespace Database\Factories;

use App\Models\Notifiers;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotifiersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notifiers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Type' => $this->faker->word,
        'Title' => $this->faker->word,
        'Details' => $this->faker->word,
        'Town' => $this->faker->word,
        'Barangay' => $this->faker->word,
        'DateTimeFrom' => $this->faker->date('Y-m-d H:i:s'),
        'DateTimeTo' => $this->faker->date('Y-m-d H:i:s'),
        'CommentsEnabled' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
