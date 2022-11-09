<?php namespace Tests\Repositories;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class NewsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var NewsRepository
     */
    protected $newsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->newsRepo = \App::make(NewsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_news()
    {
        $news = factory(News::class)->make()->toArray();

        $createdNews = $this->newsRepo->create($news);

        $createdNews = $createdNews->toArray();
        $this->assertArrayHasKey('id', $createdNews);
        $this->assertNotNull($createdNews['id'], 'Created News must have id specified');
        $this->assertNotNull(News::find($createdNews['id']), 'News with given id must be in DB');
        $this->assertModelData($news, $createdNews);
    }

    /**
     * @test read
     */
    public function test_read_news()
    {
        $news = factory(News::class)->create();

        $dbNews = $this->newsRepo->find($news->id);

        $dbNews = $dbNews->toArray();
        $this->assertModelData($news->toArray(), $dbNews);
    }

    /**
     * @test update
     */
    public function test_update_news()
    {
        $news = factory(News::class)->create();
        $fakeNews = factory(News::class)->make()->toArray();

        $updatedNews = $this->newsRepo->update($fakeNews, $news->id);

        $this->assertModelData($fakeNews, $updatedNews->toArray());
        $dbNews = $this->newsRepo->find($news->id);
        $this->assertModelData($fakeNews, $dbNews->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_news()
    {
        $news = factory(News::class)->create();

        $resp = $this->newsRepo->delete($news->id);

        $this->assertTrue($resp);
        $this->assertNull(News::find($news->id), 'News should not exist in DB');
    }
}
