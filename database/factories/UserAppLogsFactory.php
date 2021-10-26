<?php

namespace Database\Factories;

use App\Models\UserAppLogs;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAppLogsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAppLogs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Type' => $this->faker->word,
        'Details' => $this->faker->word,
        'LatLong' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
