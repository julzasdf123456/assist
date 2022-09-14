<?php

namespace Database\Factories;

use App\Models\ThirdPartyTokens;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThirdPartyTokensFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ThirdPartyTokens::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Company' => $this->faker->word,
        'AccessKey' => $this->faker->word,
        'Token' => $this->faker->word,
        'ExpiresIn' => $this->faker->word,
        'Status' => $this->faker->word,
        'Notes' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
