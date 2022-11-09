<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\UpdateSettingAPIRequest;
use App\Models\PaymentBank;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->middleware('auth:admin');
        $this->settingRepository = $settingRepo;
    }

    public function getSetting(Request $request)
    {
        if ($request->isMethod('get')) {
            $setting = Setting::first();
            $paymentSetting = PaymentBank::first();

            return view('admin.settings', compact('setting', 'paymentSetting'));
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'admin_email' => 'required',
                'withdraw_fees' => 'required|numeric',
                'minimum_withdraw_amount' => 'required|numeric',
                // 'topup_process_fees' => 'required|numeric',
            ]);

            $input = $request->except(['_token']);

            Setting::truncate();

            $setting = Setting::create($input);
            $setting->save();

            return redirect('/avanya-vip-portal/settings')->with('message', 'Settings updated successfully.');
        }
    }

    public function updatePaymentSetting(UpdateSettingAPIRequest $request)
    {
        $input = $request->all();

        PaymentBank::truncate();

        $payment = PaymentBank::create($input);
        $payment->save();

        return redirect('/avanya-vip-portal/settings')->with('message', 'Payments Setting Successfully Updated');
    }
}
