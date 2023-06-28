<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\support\Str ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name= $this->faker->sentence(6);
        return [
            'parent_id'=>null,
            'name'=>$name ,
            'slug'=>Str::slug($name),
            'description'=>$this->faker->text(),
            'image'=>$this->faker->imageUrl(),
        ];
    }
}
