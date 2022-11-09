<?php namespace Tests\Repositories;

use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SettingRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SettingRepository
     */
    protected $settingRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->settingRepo = \App::make(SettingRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_setting()
    {
        $setting = factory(Setting::class)->make()->toArray();

        $createdSetting = $this->settingRepo->create($setting);

        $createdSetting = $createdSetting->toArray();
        $this->assertArrayHasKey('id', $createdSetting);
        $this->assertNotNull($createdSetting['id'], 'Created Setting must have id specified');
        $this->assertNotNull(Setting::find($createdSetting['id']), 'Setting with given id must be in DB');
        $this->assertModelData($setting, $createdSetting);
    }

    /**
     * @test read
     */
    public function test_read_setting()
    {
        $setting = factory(Setting::class)->create();

        $dbSetting = $this->settingRepo->find($setting->id);

        $dbSetting = $dbSetting->toArray();
        $this->assertModelData($setting->toArray(), $dbSetting);
    }

    /**
     * @test update
     */
    public function test_update_setting()
    {
        $setting = factory(Setting::class)->create();
        $fakeSetting = factory(Setting::class)->make()->toArray();

        $updatedSetting = $this->settingRepo->update($fakeSetting, $setting->id);

        $this->assertModelData($fakeSetting, $updatedSetting->toArray());
        $dbSetting = $this->settingRepo->find($setting->id);
        $this->assertModelData($fakeSetting, $dbSetting->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_setting()
    {
        $setting = factory(Setting::class)->create();

        $resp = $this->settingRepo->delete($setting->id);

        $this->assertTrue($resp);
        $this->assertNull(Setting::find($setting->id), 'Setting should not exist in DB');
    }
}
