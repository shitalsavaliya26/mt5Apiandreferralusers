<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models as Model;
class ShareHolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shareHolders = Model\ShareHolder::OrderBY('percent');
        $shareHolders = $shareHolders->paginate(50);
        

        return view('admin.share_holder.index',compact('shareHolders'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sharePercent = 100 -  Model\ShareHolder::sum('percent');
        return view('admin.share_holder.create',compact('sharePercent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        /* validation start */
        $validatedData = $request->validate([
            'full_name' => 'required|max:255|unique:share_holders,name',
            'percent' => 'required|numeric',
        ]);
        $share = new Model\ShareHolder();
        $share->name = $request->full_name;
        $share->percent = $request->percent;
        $share->save();

        return redirect()->route('share-holder.index')->with('message', 'share-Holder saved successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         $share_holder = Model\ShareHolder::find($id);
        if($share_holder==null){
            return redirect()->back()->with('error',"Invalid ShareHolder...");
        }
        $share_holder->delete();

        return redirect()->back()->with('message','share-Holder delete successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $share_holder = Model\ShareHolder::find($id);
        if($share_holder==null){
            return redirect()->back()->with('error',"Invalid ShareHolder...");
        }
        $sharePercent = Model\ShareHolder::sum('percent');
        $sharePercent = (100 - $sharePercent) + $share_holder->percent;
        return view('admin.share_holder.edit',compact('share_holder','sharePercent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'full_name' => 'required|max:255|unique:share_holders,name,'.$id,
            'percent' => 'required|numeric',
        ]);
        $share = Model\ShareHolder::find($id);
        if($share==null){
            return redirect()->back()->with('error',"Invalid ShareHolder...");
        }
        $share->name = $request->full_name;
        $share->percent = $request->percent;
        $share->save();
        return redirect()->route('share-holder.index')->with('message',"ShareHolder update successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $share_holder = Model\ShareHolder::find($id);
        if($share_holder==null){
            return redirect()->back()->with('error',"Invalid ShareHolder...");
        }
        $share_holder->delete();

        return redirect()->back()->with('message','');
    }


    public function report(Request $request){
        $data = $request->all();
        $profit = Model\TradingProfit::select('*',\DB::raw('SUM(amount) as total_profit'),\DB::raw('SUM(residual) as total_residule'));

        $start_date = \Carbon\Carbon::now()->subDays(120)->format('Y-m-d');
        $end_date = \Carbon\Carbon::now()->format('Y-m-d');

        if($request->start_date && $request->end_date){
            $data['range'] = $request->range;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $start_date = date('Y-m-d',strtotime($request->start_date));
            $end_date = date('Y-m-d',strtotime($request->end_date));

        }else{
            $data['range']= '';//\Carbon\Carbon::now()->format('m/d/Y') .'-'. \Carbon\Carbon::now()->subDays(120)->format('m/d/Y');
            $data['start_date'] = '';
            $data['end_date'] = '';
        }
        $shareHolders = Model\ShareHolder::where('status','0');
        if($request->user_name){
             $shareHolders = $shareHolders->where('name','like','%'.$request->user_name.'%');

        }
        $shareHolders = $shareHolders->paginate(50);
        $profitData = $profit->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
        // dd($profit->toSql());
        $residual_income = $profitData->sum('residual');
        $profit = $profitData->sum('amount');

        return view('admin.share_holder.report',compact('profit','shareHolders','data','residual_income'));   
    }

    public function shareholderprofit(Request $request){
        $data = $request->all();
        $profit = Model\TradingProfit::select('*',\DB::raw('SUM(amount) as total_profit'),\DB::raw('SUM(residual) as total_residule'));

        $start_date = \Carbon\Carbon::now()->subDays(120)->format('Y-m-d');
        $end_date = \Carbon\Carbon::now()->format('Y-m-d');

        if($request->start_date && $request->end_date){
            $data['range'] = $request->range;
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $start_date = date('Y-m-d',strtotime($request->start_date));
            $end_date = date('Y-m-d',strtotime($request->end_date));

        }else{
            // $data['range']= \Carbon\Carbon::now()->format('m/d/Y') .'-'. \Carbon\Carbon::now()->subDays(120)->format('m/d/Y');
            $data['range']= '';
            $data['start_date'] = '';
            $data['end_date'] = '';
        }
        $shareHolders = Model\ShareHolder::where('status','0');
        if($request->user_name){
             $shareHolders = $shareHolders->where('name','like','%'.$request->user_name.'%');

        }
        $shareHolders = $shareHolders->paginate(50);
        $profitData = $profit->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") >= "'.$start_date.'"')->whereRaw('DATE_FORMAT(created_at,"%Y-%m-%d") <= "'.$end_date.'"');
        // dd($profit->toSql());
        $residual_income = $profitData->sum('residual');
        $profit = $profitData->sum('amount');

        return view('admin.share_holder.profit_report',compact('profit','shareHolders','data','residual_income'));   
    }

}
