<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserDemo;

class UserDemoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_demo()
    {
        $userDemo = factory(UserDemo::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_demos', $userDemo
        );

        $this->assertApiResponse($userDemo);
    }

    /**
     * @test
     */
    public function test_read_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_demos/'.$userDemo->id
        );

        $this->assertApiResponse($userDemo->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();
        $editedUserDemo = factory(UserDemo::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_demos/'.$userDemo->id,
            $editedUserDemo
        );

        $this->assertApiResponse($editedUserDemo);
    }

    /**
     * @test
     */
    public function test_delete_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_demos/'.$userDemo->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_demos/'.$userDemo->id
        );

        $this->response->assertStatus(404);
    }
}
