<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Article\Entities\Article;

$factory->define(Article::class, function (Faker $faker) {

    $locales = app()->languages->all()->slug();
    $data = [];
    foreach ($locales as $locale)
    {
        $name = $faker->sentence(10);
        $slug =  \Transliterate::slugify($name);
        $text = '';

        foreach ( $faker->paragraphs(5 ) as $el )
        {
            $text .='<p>'.$el.'</p>';
        }

        $data[$locale] = [
            'publish' =>  rand(0, 1),
            'name' => $name,
            'slug' => $slug,
            'description' => $faker->sentence(50),
            'text' => $text,
        ];
    }
    $data['published_at'] = $faker->dateTimeBetween($startDate = '-20 days', $endDate = 'now', $timezone = 'UTC');
    $data['method'] = 'get';
    $data['controller'] = 'App\Http\Controllers\Web\ArticleController';
    $data['action'] = 'view';

    return $data;
});
