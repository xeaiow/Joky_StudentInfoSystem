<?php

use Faker\Generator as Faker;

$factory->define(App\AccountSector::class, function (Faker $faker) {
    return [
      'name' => $faker->catchPhrase,
      'type' => $faker->randomElement(['income','expense']),
      'school_id' => function () use ($faker) {
          if(App\School::count() == 0)
            return factory(App\School::class)->create()->id;
          else {
            return $faker->randomElement(App\School::pluck('id')->toArray());
          }
        },
    ];
});
