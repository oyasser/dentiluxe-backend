<?php

namespace Modules\ClientCategory\Database\factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\ClientCategory\Models\ClientCategory::class;

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
        ];
    }
}

