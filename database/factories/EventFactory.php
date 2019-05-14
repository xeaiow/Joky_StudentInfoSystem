<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'file_path' => $faker->url,
        'title' => $faker->sentences(1, true),
        'description' => $faker->sentences(3, true),
        'active' => $faker->randomElement([0, 1]),
        'school_id' => $faker->randomElement(App\School::pluck('id')->toArray()),
        'user_id' => function () use ($faker) {
          if(App\User::count() == 0)
            return factory(App\User::class)->create()->id;
          else {
            return $faker->randomElement(App\User::pluck('id')->toArray());
          }
        },
    ];
});
