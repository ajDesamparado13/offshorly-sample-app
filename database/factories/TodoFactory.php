<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Subsystem\Status\Constants\StatusConst;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subject' => $this->faker->text(50),
            'body'      => $this->faker->text,
            'status_id' => Arr::random(array_flip(StatusConst::VALUES)),
        ];
    }
}
