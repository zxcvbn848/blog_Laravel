<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datetime = $this->faker->dateTimeBetween('-1 day');

        return [
            'title' => $this->faker->unique()->word(),
            'article' => $this->faker->unique()->paragraph(),
            'category_id' => function() {
                return Category::factory()->create()->id;
            },
            'author_id' => function() {
                return User::factory()->create()->id;
            },
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];
    }
}
