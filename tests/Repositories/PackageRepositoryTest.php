<?php namespace Tests\Repositories;

use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PackageRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PackageRepository
     */
    protected $packageRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->packageRepo = \App::make(PackageRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_package()
    {
        $package = factory(Package::class)->make()->toArray();

        $createdPackage = $this->packageRepo->create($package);

        $createdPackage = $createdPackage->toArray();
        $this->assertArrayHasKey('id', $createdPackage);
        $this->assertNotNull($createdPackage['id'], 'Created Package must have id specified');
        $this->assertNotNull(Package::find($createdPackage['id']), 'Package with given id must be in DB');
        $this->assertModelData($package, $createdPackage);
    }

    /**
     * @test read
     */
    public function test_read_package()
    {
        $package = factory(Package::class)->create();

        $dbPackage = $this->packageRepo->find($package->id);

        $dbPackage = $dbPackage->toArray();
        $this->assertModelData($package->toArray(), $dbPackage);
    }

    /**
     * @test update
     */
    public function test_update_package()
    {
        $package = factory(Package::class)->create();
        $fakePackage = factory(Package::class)->make()->toArray();

        $updatedPackage = $this->packageRepo->update($fakePackage, $package->id);

        $this->assertModelData($fakePackage, $updatedPackage->toArray());
        $dbPackage = $this->packageRepo->find($package->id);
        $this->assertModelData($fakePackage, $dbPackage->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_package()
    {
        $package = factory(Package::class)->create();

        $resp = $this->packageRepo->delete($package->id);

        $this->assertTrue($resp);
        $this->assertNull(Package::find($package->id), 'Package should not exist in DB');
    }
}
