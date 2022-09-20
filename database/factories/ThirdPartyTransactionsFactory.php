<?php

namespace Database\Factories;

use App\Models\ThirdPartyTransactions;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThirdPartyTransactionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ThirdPartyTransactions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'AccountNumber' => $this->faker->word,
        'ServicePeriodEnd' => $this->faker->word,
        'BillNumber' => $this->faker->word,
        'KwhUsed' => $this->faker->randomDigitNotNull,
        'Amount' => $this->faker->randomDigitNotNull,
        'Surcharge' => $this->faker->randomDigitNotNull,
        'TotalAmount' => $this->faker->randomDigitNotNull,
        'Company' => $this->faker->word,
        'Teller' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
