<?php

namespace Database\Factories;

use App\Models\ThirdPartyExcelReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThirdPartyExcelReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ThirdPartyExcelReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'AccountNumber' => $this->faker->word,
        'BillingPeriod' => $this->faker->word,
        'AmountDue' => $this->faker->word,
        'Surcharge' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
