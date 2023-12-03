<?php

namespace Modules\Currency\Database\factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Currency\Models\Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fakerAr = Faker::create('ar_SA');

        return [
            'name_en' => $this->faker->unique()->name(),
            'name_ar' => $fakerAr->unique()->name(),
            'description_en' => $this->faker->text(),
            'description_ar' => $fakerAr->text(),
            'rate' => $this->faker->numberBetween(1,50)
        ];
    }
}

