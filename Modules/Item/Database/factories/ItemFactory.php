<?php

namespace Modules\Item\Database\factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Item\Models\Item::class;

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
            'type' => 'ITEM',
            'barcode' => $this->faker->unique()->text(5),
            'sku' => $this->faker->unique()->text(5),
            'available_stock' => $this->faker->numberBetween(1, 100),
            'min_stock' => $this->faker->numberBetween(1, 10),
        ];
    }
}
