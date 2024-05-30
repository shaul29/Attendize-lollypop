<?php

$factory->define(App\Models\DateTimeFormat::class, function (Faker\Generator $faker) {
    return [
        'format' => "d-m-Y H:i:s",
        'picker_format' => "d-m-Y H:i:s",
        'label' => "utc",
    ];
});