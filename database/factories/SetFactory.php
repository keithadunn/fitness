<?php

namespace Database\Factories;

use App\Models\Set;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class SetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Set::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exercise_id' => Exercise::all()->random()->id,
            'workout_id' => Workout::all()->random()->id,
            'reps' => $this->faker->numberBetween($min = 1, $max = 30),
            'weight_lifted' => $this->faker->numberBetween($min = 5, $max = 1000),
        ];
    }
}
