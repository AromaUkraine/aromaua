<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Article\Entities\Article;

class ArticleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(Article::class, 30)->make()->each(function ($data){

            $article = Article::create([
                'parent_page_id' => 3,
                'published_at' => $data['published_at']
            ]);
            unset($data['published_at']);
            $article->page()->create($data->toArray());
        });*/
    }
}
