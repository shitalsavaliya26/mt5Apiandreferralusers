<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\News;

class NewsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_news()
    {
        $news = factory(News::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/news', $news
        );

        $this->assertApiResponse($news);
    }

    /**
     * @test
     */
    public function test_read_news()
    {
        $news = factory(News::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/news/'.$news->id
        );

        $this->assertApiResponse($news->toArray());
    }

    /**
     * @test
     */
    public function test_update_news()
    {
        $news = factory(News::class)->create();
        $editedNews = factory(News::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/news/'.$news->id,
            $editedNews
        );

        $this->assertApiResponse($editedNews);
    }

    /**
     * @test
     */
    public function test_delete_news()
    {
        $news = factory(News::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/news/'.$news->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/news/'.$news->id
        );

        $this->response->assertStatus(404);
    }
}
