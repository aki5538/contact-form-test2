<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'last_name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'gender' => $this->faker->numberBetween(0, 2),
            'email' => $this->faker->safeEmail(),
            'tel' => $this->faker->phoneNumber(), // ✅ これが必要！
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'message' => $this->faker->realText(100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
