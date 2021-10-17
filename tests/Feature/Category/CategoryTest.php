<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_category_link_can_be_requested()
    {
        // user login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // add category
        $category = Category::factory()->create();

        $response = $this->post('/api/category', [
            'category' => $category['category'],
        ]);

        $response->assertStatus(201);
    }

    public function test_delete_category_link_can_be_requested()
    {
        // user login
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        // add category
        $categoryId = Category::factory()->create()->id;

        // delete category
        $response = $this->delete('/api/category/'.$categoryId);

        $response->assertStatus(200);
    }
}
