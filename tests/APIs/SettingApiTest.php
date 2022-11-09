<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Setting;

class SettingApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_setting()
    {
        $setting = factory(Setting::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/settings', $setting
        );

        $this->assertApiResponse($setting);
    }

    /**
     * @test
     */
    public function test_read_setting()
    {
        $setting = factory(Setting::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/settings/'.$setting->id
        );

        $this->assertApiResponse($setting->toArray());
    }

    /**
     * @test
     */
    public function test_update_setting()
    {
        $setting = factory(Setting::class)->create();
        $editedSetting = factory(Setting::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/settings/'.$setting->id,
            $editedSetting
        );

        $this->assertApiResponse($editedSetting);
    }

    /**
     * @test
     */
    public function test_delete_setting()
    {
        $setting = factory(Setting::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/settings/'.$setting->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/settings/'.$setting->id
        );

        $this->response->assertStatus(404);
    }
}
