<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Package;

class PackageApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_package()
    {
        $package = factory(Package::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/packages', $package
        );

        $this->assertApiResponse($package);
    }

    /**
     * @test
     */
    public function test_read_package()
    {
        $package = factory(Package::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/packages/'.$package->id
        );

        $this->assertApiResponse($package->toArray());
    }

    /**
     * @test
     */
    public function test_update_package()
    {
        $package = factory(Package::class)->create();
        $editedPackage = factory(Package::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/packages/'.$package->id,
            $editedPackage
        );

        $this->assertApiResponse($editedPackage);
    }

    /**
     * @test
     */
    public function test_delete_package()
    {
        $package = factory(Package::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/packages/'.$package->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/packages/'.$package->id
        );

        $this->response->assertStatus(404);
    }
}
