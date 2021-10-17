<?php

namespace Database\Factories;

use App\Models\ArticleTag;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ArticleTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datetime = $this->faker->dateTimeBetween('-1 day');

        return [
            'article_id' => function() {
                return Article::factory()->create()->id;
            },
            'tag_id' => function() {
                return Tag::factory()->create()->id;
            } ,
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];
    }
}
