<?php namespace Tests\Repositories;

use App\Models\UserDemo;
use App\Repositories\UserDemoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserDemoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserDemoRepository
     */
    protected $userDemoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userDemoRepo = \App::make(UserDemoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_demo()
    {
        $userDemo = factory(UserDemo::class)->make()->toArray();

        $createdUserDemo = $this->userDemoRepo->create($userDemo);

        $createdUserDemo = $createdUserDemo->toArray();
        $this->assertArrayHasKey('id', $createdUserDemo);
        $this->assertNotNull($createdUserDemo['id'], 'Created UserDemo must have id specified');
        $this->assertNotNull(UserDemo::find($createdUserDemo['id']), 'UserDemo with given id must be in DB');
        $this->assertModelData($userDemo, $createdUserDemo);
    }

    /**
     * @test read
     */
    public function test_read_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();

        $dbUserDemo = $this->userDemoRepo->find($userDemo->id);

        $dbUserDemo = $dbUserDemo->toArray();
        $this->assertModelData($userDemo->toArray(), $dbUserDemo);
    }

    /**
     * @test update
     */
    public function test_update_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();
        $fakeUserDemo = factory(UserDemo::class)->make()->toArray();

        $updatedUserDemo = $this->userDemoRepo->update($fakeUserDemo, $userDemo->id);

        $this->assertModelData($fakeUserDemo, $updatedUserDemo->toArray());
        $dbUserDemo = $this->userDemoRepo->find($userDemo->id);
        $this->assertModelData($fakeUserDemo, $dbUserDemo->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_demo()
    {
        $userDemo = factory(UserDemo::class)->create();

        $resp = $this->userDemoRepo->delete($userDemo->id);

        $this->assertTrue($resp);
        $this->assertNull(UserDemo::find($userDemo->id), 'UserDemo should not exist in DB');
    }
}
