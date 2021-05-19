<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercises = [
            ['name' => 'Squat'],
            ['name' => 'Leg Press'],
            ['name' => 'Lunge'],
            ['name' => 'Deadlift'],
            ['name' => 'Leg Extension'],
            ['name' => 'Leg Curl'],
            ['name' => 'Standing Calf Raise'],
            ['name' => 'Seated Calf Raise'],
            ['name' => 'Hip Adductor'],
            ['name' => 'Barbbell Chest Press'],
            ['name' => 'Dumbell Chest Press'],
            ['name' => 'Chest Fly'],
            ['name' => 'Push-Up'],
            ['name' => 'Pull-Down'],
            ['name' => 'Pull-Up'],
            ['name' => 'Chin-Up'],
            ['name' => 'Bent-Over Row'],
            ['name' => 'Upright Row'],
            ['name' => 'Shoulder Press'],
            ['name' => 'Arnold Press'],
            ['name' => 'Shoulder Fly'],
            ['name' => 'Front Lateral Raise'],
            ['name' => 'Side Lateral Raise'],
            ['name' => 'Shoulder Shrug'],
            ['name' => 'Pushdown'],
            ['name' => 'Overhead Triceps Extension'],
            ['name' => 'Biceps Curl'],
            ['name' => 'Back Extension'],
            ['name' => 'Leg Raise']
          ];
   
          foreach($exercises as $e) {
            Exercise::insert($e);
          }
    }
}
