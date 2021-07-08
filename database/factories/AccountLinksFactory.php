<?php

namespace Database\Factories;

use App\Models\AccountLinks;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountLinksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountLinks::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'UserId' => $this->faker->word,
        'AccountNumber' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
