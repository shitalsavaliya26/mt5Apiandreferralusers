<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Rank;

class RankApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_rank()
    {
        $rank = factory(Rank::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/ranks', $rank
        );

        $this->assertApiResponse($rank);
    }

    /**
     * @test
     */
    public function test_read_rank()
    {
        $rank = factory(Rank::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/ranks/'.$rank->id
        );

        $this->assertApiResponse($rank->toArray());
    }

    /**
     * @test
     */
    public function test_update_rank()
    {
        $rank = factory(Rank::class)->create();
        $editedRank = factory(Rank::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/ranks/'.$rank->id,
            $editedRank
        );

        $this->assertApiResponse($editedRank);
    }

    /**
     * @test
     */
    public function test_delete_rank()
    {
        $rank = factory(Rank::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/ranks/'.$rank->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/ranks/'.$rank->id
        );

        $this->response->assertStatus(404);
    }
}
