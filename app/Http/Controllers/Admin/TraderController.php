<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateTraderAPIRequest;
use App\Http\Requests\API\UpdateTraderAPIRequest;
use App\Models\Trader;
use Carbon\Carbon;
use App\Repositories\TraderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Response;
use App\Models\TraderHistory;
use App\Models\TradersTranslation;

/**
 * Class TraderController
 * @package App\Http\Controllers\API
 */
class TraderController extends AppBaseController
{
    /** @var  TraderRepository */
    private $traderRepository;

    public function __construct(TraderRepository $traderRepo)
    {
        $this->middleware('auth:admin');
        $this->traderRepository = $traderRepo;
    }

    /**
     * Display a listing of the Trader.
     * GET|HEAD /trader
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $traders = Trader::orderBy('orders','asc')->orderBy('created_at','desc')->paginate(50);

        return view('admin.admin_traders', compact('traders'));
    }

    public function trader_history(Request $request)
    {
        $traders_history = TraderHistory::whereHas('get_user')->whereHas('traders')->orderBy('id','desc')->paginate(10);

        return view('admin.admin_traders_history', compact('traders_history'));
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'remarks' => 'required'
        ]);

        $input = $request->all();
        // print_r($input);die();

        $traders_history = TraderHistory::find($input['history_id']);
        if (empty($traders_history)) {
            return $this->sendError('not found');
        }
        $traders_history->remarks = $request->remarks;
        if($traders_history){
            
            if($request->status == '1'){
                $message = 'approved';
                $traders_history->start_date = Carbon::now();
                $traders_historyPast = TraderHistory::where(['status'=>1,'user_id'=>$traders_history->user_id,'trader_id'=>$traders_history->trader_id])->update(['status'=>3]);
            }else{
                $message = 'rejected';
            }
            $traders_history->status = $request->status;
            $traders_history->save();

            return redirect()->back()->with('message','Traders request has been '.$message.' successfully');
        }

        return redirect()->back()->with('errorFails','Whoops something goes wrong.!');
    }

    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin_create_trader');
    }


    /**
     * Store a newly created Trader in storage.
     * POST /trader
     *
     * @param CreateTraderAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateTraderAPIRequest $request)
    {
        /* validation start */
        $validatedData = $request->validate([
            'name' => 'required|array',
            // 'name.*'=> 'required',
            'subtitle' => 'required|array',
            // 'subtitle.*'=> 'required',
            'best_trader_image' => 'required|mimes:jpeg,jpg,png,gif'
        ],[
            'name.required' => 'Name field is required',
            // 'name.*.required' => 'Name field is required',
            'subtitle.required' => 'Subtitle field is required',
            // 'subtitle.*.required' => 'Subtitle field is required',
        ]);
        foreach ($request->lang as $key => $value) {

            if($value=='en'){

                $en_input['name'] = $request->name[$key] ;
                $en_input['subtitle'] = $request->subtitle[$key] ;
                $en_input['description'] = $request->description[$key];

                $profilePicture = $request->file('profile_picture');
                $graphPicture = $request->file('graph_picture');
                $bestTraderPicture = $request->file('best_trader_image');

                $profilePictureName = md5(time().rand()).'.'.$profilePicture->getClientOriginalExtension();
                $graphPictureName = md5(time().rand()).'.'.$graphPicture->getClientOriginalExtension();
                if($bestTraderPicture){
                    
                    $bestTraderImageName = md5(time().rand()).'.'.$bestTraderPicture->getClientOriginalExtension();
                    $bestTraderPicture->storeAs('traders/besttrader', $bestTraderImageName);
                    $en_input['best_trader_image'] = $bestTraderImageName;
                }

                $profilePicture->storeAs('traders', $profilePictureName);
                $graphPicture->storeAs('traders/graphs', $graphPictureName);

                $en_input['profile_picture'] = $profilePictureName;
                $en_input['graph_picture'] = $graphPictureName;
                $en_input['minimum_amount'] = $request->minimum_amount;
                $en_input['maximum_amount'] = $request->maximum_amount;
                $en_input['mt5_username'] = $request->mt5_username;
                $en_input['mt5_password'] = $request->mt5_password;

                $trader = $this->traderRepository->create($en_input);
            }
            if($request->name[$key] != null){
                $translation = new TradersTranslation;
                $translation->trader_id = $trader->id;
                $translation->name = $request->name[$key];
                $translation->subtitle = $request->subtitle[$key];
                $translation->description = $request->description[$key]!=""?$request->description[$key]:" ";
                $translation->language = $value;
                $translation->save();
            }
            
            
        }
        return redirect('avanya-vip-portal/traders')->with('message', 'trader successfully created');
    }

    /**
     * Display the specified Trader.
     * GET|HEAD /trader/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var Trader $trader */
        $trader = $this->traderRepository->find($id);

        if (empty($trader)) {
            return $this->sendError('Trader not found');
        }

        return view('admin.show_trader', compact('trader'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        
        /** @var Trader $trader */
        $traders = Trader::where('id',$id)->first();
        $plans = [];
        $langs = $lang = ['en'=>"English",'id'=>'Indonesian'];

        foreach ($langs as $key => $value) {
            $trader = [];
            $translate  = TradersTranslation::where('trader_id',$id)->where('language',$key)->first();
            $trader['name'] = $translate!=null?$translate->name:"";
            $trader['subtitle'] = $translate!=null?$translate->subtitle:"";
            $trader['description'] = $translate!=null?$translate->description:"";
            $trader['language'] = $key;
            $plans[]=(object)$trader;
        }

        if (empty($trader)) {
            return $this->sendError('Trader not found');
        }


        return view('admin.admin_edit_trader', compact('traders','plans'));
    }

    /**
     * Update the specified Trader in storage.
     * PUT/PATCH /trader/{id}
     *
     * @param int $id
     * @param UpdateTraderAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UpdateTraderAPIRequest $request)
    {
        // print_r($request->all());die();
         /* validation start */
        $validatedData = $request->validate([
            'name' => 'required|array',
            'subtitle' => 'required|array',
            'lang'=>'required'
        ],[
            'name.required' => 'Name field is required',
            'subtitle.required' => 'Subtitle field is required',
        ]);

        /** @var Trader $trader */
        $trader = $this->traderRepository->find($id);
        foreach ($request->lang as $key => $value) {
            
            if($value=='en'){

                    $en_input['name'] = $request->name[$key];
                    $en_input['subtitle'] = $request->subtitle[$key] ;
                    $en_input['description'] = $request->description[$key];

                    $en_input['minimum_amount'] = $request->minimum_amount;
                    $en_input['maximum_amount'] = $request->maximum_amount;
                    $en_input['mt5_username'] = $request->mt5_username;
                    $en_input['mt5_password'] = $request->mt5_password;
                if (empty($trader)) {
                    return $this->sendError('Trader not found');
                }


                if ($request->status == 1) {
                    $checkTraderReq = TraderHistory::where('trader_id',$id)->whereIn('status',[0,1])->first();

                    if (!empty($checkTraderReq)) {
                        return redirect()->back()->with('trader-error','Some users are belong with this Trader , So not able to delete.');
                    }
                }

                if ($request->hasFile('profile_picture')) {

                    $profileImage = public_path("traders/{$trader->profile_picture}"); // get previous image from folder
                    if (File::exists($profileImage)) {  // unlink or remove previous image from folder
                        unlink($profileImage);
                    }

                    $profilePicture = $request->file('profile_picture');
                    $profilePictureName = md5(time().rand()).'.'.$profilePicture->getClientOriginalExtension();

                    $en_input['profile_picture'] = $profilePictureName;
                    $trader = $this->traderRepository->update($en_input, $id);

                    $profilePicture->storeAs('traders', $profilePictureName);
                }

                if ($request->hasFile('graph_picture')) {

                    $graphImage = public_path("traders/graphs/{$trader->graph_picture}"); // get previous image from folder

                    if (File::exists($graphImage)) { // unlink or remove previous image from folder
                        unlink($graphImage);
                    }

                    $graphPicture = $request->file('graph_picture');
                    $graphPictureName = md5(time().rand()).'.'.$graphPicture->getClientOriginalExtension();

                    $en_input['graph_picture'] = $graphPictureName;

                    $trader = $this->traderRepository->update($en_input, $id);

                    $graphPicture->storeAs('traders/graphs', $graphPictureName);
                }
                if ($request->hasFile('best_trader_image')) {

                    $besttraderImage = public_path("traders/besttrader/{$trader->best_trader_image}"); // get previous image from folder

                    if (File::exists($besttraderImage) && $trader->best_trader_image != '') { // unlink or remove previous image from folder
                        unlink($besttraderImage);
                    }

                    $besttraderPicture = $request->file('best_trader_image');
                    $besttraderPictureName = md5(time().rand()).'.'.$besttraderPicture->getClientOriginalExtension();

                    $en_input['best_trader_image'] = $besttraderPictureName;

                    $trader = $this->traderRepository->update($en_input, $id);

                    $besttraderPicture->storeAs('traders/besttrader', $besttraderPictureName);
                }

                $this->traderRepository->update($en_input, $id);
            }
            if($request->name[$key]!=null ){
                TradersTranslation::where('trader_id',$trader->id)->where('language',$value)->delete();
                $translation = new TradersTranslation;
                $translation->trader_id = $trader->id;
                $translation->name = $request->name[$key];
                $translation->subtitle = $request->subtitle[$key];
                $translation->description = $request->description[$key]!=""?$request->description[$key]:" ";
                $translation->language = $value;
                $translation->save();
            }

        }

        return redirect('avanya-vip-portal/traders')->with('message', 'trader successfully updated');
    }

    /**
     * Remove the specified Trader from storage.
     * DELETE /trader/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var Trader $trader */
        $trader = $this->traderRepository->find($id);

        $checkTraderReq = TraderHistory::where('trader_id',$id)->whereIn('status',[0,1])->first();

        if (!empty($checkTraderReq)) {
            return redirect()->back()->with('trader-error','Some users are belong with this Trader , So not able to delete.');
        }

        if (empty($trader)) {
            return $this->sendError('Trader not found');
        }

        $trader->delete();

        return back()->with('message', 'Trader deleted successfully');
    }

    public function reorder(Request $request){
        $traderOrder = explode(',', $request->traderOrder);
        for($i=0;$i<(count($traderOrder)-1);$i++){
            $trader = $this->traderRepository->find($traderOrder[$i]);
            $trader->update(['orders'=>$i+1]);
        }
        return response()->json([
                    'message' => 'Reorder successfully',
                    'status' => 'success'
                ]);
    }
}
