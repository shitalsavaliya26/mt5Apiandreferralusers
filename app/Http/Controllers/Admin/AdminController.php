<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\EmailVerificationNotification as EmailVerificationNotification;
use App\Notifications\UserWelcomeMailNotification as UserWelcomeMailNotification;

use App\Exports\UsersExport;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Imports\UsersImport;
use App\Models\Country;
use App\Models\ImportHistory;
use App\Models\NetworkTree;
use App\Models\Rank;
use App\Models\UserBank;
use App\Models\Wallet;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserWallet;
use Session;
use App\Models\Support;
use App\Models\TicketMessage;
use Auth;

class AdminController extends AppBaseController
{

    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth:admin');
        $this->userRepository = $userRepo;
    }

    public function dashboard()
    {
        $openedTickets = Support::where('status',0)->orderby('id','desc')->get();
        $supportIds = [];
        if (isset($openedTickets) && count($openedTickets) > 0) {
            foreach ($openedTickets as $key => $value) {
                array_push($supportIds, $value->id);
            }
        }
        $openedMsg = TicketMessage::whereIn('support_id',$supportIds)->limit(50)->orderby('id','desc')->get();

        $totalUser = \App\User::where('status','active')->count(); 
        $totalFunding = UserWallet::sum('topup_fund'); 
        $todayPayout =  \App\Models\TotalReport::whereDate('created_at',date('Y-m-d'))->sum('total');
        $totalPayout =  \App\Models\TotalReport::all()->sum('total');

        return view('admin.dashboard',compact('openedTickets','openedMsg','totalFunding','todayPayout','totalPayout','totalUser'));
    }

    public function allUsers(Request $request)
    {
        // dd('test');
        $data = $request->all();
        $userName =$full_name = '';
	    $query = User::with('rank');
        if (!empty($request->global_search)) {
            $userName = $request->global_search;
            $query = $query->where('user_name', 'like', "%{$userName}%")->orWhere('full_name', 'like', "%'{$userName}'%")->orWhere('mt4_username', $request->global_search);
        }
        if($request->start_date && $request->end_date && $request->start_date!="" && $request->end_date!="" ){
            $query =  $query->whereRaw(" Date(created_at) >= '".date('Y-m-d',strtotime($request->start_date))."' and  Date(created_at) <= '".date('Y-m-d',strtotime($request->end_date))."' ");   
        }
        $users = $query->where('deleted_at',null)->orderby('id','desc')->paginate(100)->appends($request->except('_token'));
        //$users = User::with('rank')->paginate(5);
        return view('admin.admin_users', compact('users','userName','full_name','data'));

    }

    public function createUser()
    {
        $countries = Country::get();

        return view('admin.admin_create_user', compact('countries'));
    }


    /**
     * Store a newly created UserDemo in storage.
     * POST /userDemos
     *
     * @param CreateUserAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeUser(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $input['secure_password'] = Hash::make($input['secure_password']);
        // $input['mt4_password'] = ($input['mt4_password']);
        $input['rank_id'] = isset($input['rank_id'])?$input['rank_id']:'1';
        // $input['email_verified_at'] = date('Y-m-d H:i:s');
        $user = User::create($input);
        $userBank = new UserBank([
            'name' => $input['name'],
            'branch' => $input['branch'],
            'account_holder' => $input['account_holder'],
            'account_number' => $input['account_number'],
            'swift_code' => $input['swift_code'],
            'bank_country_id' => $input['bank_country_id'],
        ]);

        NetworkTree::create([
            'refferal_id' => $user->id,
            'parent_id' => $input['sponsor']
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'total_balance' => 500
        ]);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $UserWallet = UserWallet::create([
            'user_id' => $user->id,
        ]);

        $user->userBank()->save($userBank);
        $user->save();
        Mail::send('emails.welcome', ['user' => $user,'title'=>'Welcome to Avanya!','password'=>$request->password,'secure_password'=>$request->secure_password], function ($message) use ($user) {
            $message->subject("Welcome to Avanya!");
            $message->to($user->email);
        });

        event(new Registered($user));
	
	   // $user->notify(new EmailVerificationNotification($user));

        return redirect('/avanya-vip-portal/users')->with('message', 'User saved successfully.');
    }

    public function editUser($id)
    { 
        /** @var User $user */
        $user = $this->userRepository->find($id);
	        
    	$sponsor = User::select('user_name','id')->where('id',$user->sponsor)->first();
    	
    	$userBank = UserBank::where('user_id', $id)->first();

        $countries = Country::get();
        $ranks = Rank::all()->pluck('name','id');
        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return view('admin.admin_edit_user', compact('user', 'userBank', 'countries','sponsor','ranks'));
    }


    /**
     * Update the specified UserDemo in storage.
     * PUT/PATCH /userDemos/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateUser($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if (isset($input['password'])) {

            $request->validate([
                'password' => 'confirmed',
            ]);

            $input['password'] = Hash::make($request->password);
        } else {
            $input['password'] = $user->password;
        }

	   if (isset($input['sponsor'])) {
            $sponsor = User::where('user_name',$input['sponsor'])->first();
            if($sponsor==null){
                Session::flash('error',"Sponsor name is not valid, Please enter valid sonsor");   
                return redirect()->back()->with(["error_msg","Invalid Spnsor ID"]);
            }
            // dd([$sponsor,$user]);
            $ids = User::where('sponsor',$id)->pluck('id')->toArray();
            $input['sponsor'] = $input['sponsor'];   
            if(in_array($input['sponsor'], $ids) || $id == $sponsor->id){
                Session::flash('error',"Don not allow direct downline ids");   
                return redirect()->back()->with(["error_msg","Don not allow direct downline ids or own name"]);
            }

            if (empty($user)) {
                Session::flash('error',"Don not allow direct downline ids");   
                return redirect()->back()->with(["error_msg","Don not allow direct downline ids or own name"]);
                // return $this->sendError('User not found');
            }
            $input['sponsor'] = $sponsor->id; 
            NetworkTree::where('refferal_id',$id)->delete();
            NetworkTree::create([
                'refferal_id' => $id,
                'parent_id' => $sponsor->id
            ]);  

        }

        if (isset($input['secure_password'])) {

            $request->validate([
                'secure_password' => 'confirmed',
            ]);

            $input['secure_password'] = Hash::make($request->secure_password);
        } else {
            $input['secure_password'] = $user->secure_password;
        }

        if (isset($input['mt4_password'])) {

            $input['mt4_password'] = $request->mt4_password;
        } else {
            $input['mt4_password'] = $user->mt4_password;
        }

        $user = $this->userRepository->update($input, $id);

        $userBank = UserBank::where('user_id', $id)->first();

        $userBank->update([
            'name' => $input['name'],
            'branch' => $input['branch'],
            'account_holder' => $input['account_holder'],
            'account_number' => $input['account_number'],
            'swift_code' => $input['swift_code'],
            'bank_country_id' => $input['bank_country_id'],
        ]);

        return redirect('/avanya-vip-portal/users')->with('message', 'User updated successfully.');

    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }
	$sponsor = User::select('user_name')->where('id', $user->sponsor)->first();
        return view('admin.show_user', compact('user','sponsor'));
    }


    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);
	
	if (empty($user)) {
            return $this->sendError('User not found');
        }
	
	$user->where('id',$id)->update(['deleted_at' => now()]);
	//$user->delete();
        
        return redirect()->back()->with('message', 'User deleted successfully.');
    }

    /**
     * Show the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSponsorUser(Request $request)
    {
        if (!empty($request)) {
            $sponsorUserName = $request->input('user_name');
            $user = User::where('user_name', $sponsorUserName)->where('sponsor', '!=', $request->input('user_id'))->first();
            if ($user) {
                return response()->json([
                    'message' => 'The sponsor username is verified!',
                    'user_id' => $user->id,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => 'Sponsor name is not valid, Please enter valid username',
                    'status' => 'error',
                ]);
            }
        }
    }
    /**
     * Show the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkSponsorUserExit(Request $request)
    {
        if (!empty($request)) {
            $sponsorUserName = $request->input('user_name');
            $user = User::where('user_name', $sponsorUserName)->where('sponsor', '!=', $request->input('user_id'))->first();
            if ($user) {
                // dd($user);
                if ($user->id == $request->input('user_id')) {
                    return response()->json([
                        'message' => 'Do not allow to use same username, Please try with other username',
                        'status' => 'error',
                    ]);
                }
                return response()->json([
                    'message' => 'The sponsor username is verified!',
                    'user_id' => $user->id,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'message' => 'Sponsor name is not valid, Please enter valid username',
                    'status' => 'error',
                ]);
            }
        }
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * return view
     */
    public function importUserView()
    {
        $importHistory = ImportHistory::paginate(5);
        Session::forget('insert');
        return view('admin.import_user', compact('importHistory'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function usersExport($ext,Request $request)
    {
        if (!empty($ext)) {
            $headings = ['#','Sponsor','Fullname','Username','Email','Identification_number','Address','City','State','Country','Phone number','MT5 username','MT5 Password','Rank','Status','Registration Date'];
            return Excel::download(new UsersExport($headings,$request->all()), 'users_'.time().'.' . $ext);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function usersImport(Request $request)
    {
        try {
            
        
            $fileName = $request->file;

            if ($request->file->getClientOriginalExtension() !== 'xlsx' && $request->file->getClientOriginalExtension() !== 'xls' ) {
            	# code...
            	return back()->with(['custom_error' => "CSV Format is not valid,Please select valid CSV file"]);
            }
            Excel::import(new UsersImport, $fileName);
            // $array = Excel::toCollection(function(){}, $fileName);
            if(empty(session::get('errors_message')) && empty(session::get('exist_errors_message')) && empty(session::get('duplicate_errors_message')) && empty(session::get('email_error_message')) && Session::get('insert') <= 0){
                // dd(Session::all());
                Session::forget('insert');
                return back()->with(['custom_error' => "No data available to insert or update sheet."]);
            }

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            // dd($e->getMessage());
            return back()->with(['custom_error' => "CSV Format is not valid,Please select valid CSV file"]);
        }
        ImportHistory::create(['file_name' => $fileName->getClientOriginalName()]);
       
        $error = $exist = '';

        if (session()->has('errors_message') && Session::get('insert') <= 0) {
            $error = "No data available to insert or update sheet.";
            $request->session()->forget('errors_message');
        }

        if (session()->has('email_error_message')) {
 
            $existUsers = '';       
            
            foreach (session::get('email_error_message') as $value) {
                
                if (strlen($value) > 1 && !strstr($existUsers, $value)) {
                    $existUsers .= $value.',';
                }
            }

            if (!empty($existUsers)) {
                $exist .= 'Email already  ';
                $exist .= rtrim($existUsers, ',');
                $exist .= ' already exist';
            }
            $request->session()->forget('email_error_message');
        }   
        if (session()->has('duplicate_errors_message')) {
 
            $existUsers = '';       
            
            foreach (session::get('duplicate_errors_message') as $value) {
                
                if (strlen($value) > 1 && !strstr($existUsers, $value)) {
                    $existUsers .= $value.',';
                }
            }

            if (!empty($existUsers)) {
                $exist .= 'Identification Number ';
                $exist .= rtrim($existUsers, ',');
                $exist .= ' already exist';
            }
            $request->session()->forget('exist_errors_message');
        }   

        if (empty($error) && empty($exist)) {
            return back()->with(['message' => 'User imported successfully.']);
        }
        
        if (!empty($error) && !empty($exist)) {
            return back()->with(['custom_error' => $error, 'user_exist' => $exist]);
        } else if (!empty($error)) {
            return back()->with(['custom_error' => $error]);
        } else {
            return back()->with(['user_exist' => $exist]);
        }
    }
    public function updateEmailVerification(Request $request)
    {
        try {
             if($request->collection){
                    $user = User::find($request->collection);
                    if($user!=null){
                        $user->email_verified_at = date('Y-m-d H:i:s');
                        $user->save();
                        
                        $user->notify(new UserWelcomeMailNotification($user));
                        return response()->json(['status'=>'success',"User Email address is verified now."]);
                    }
                    return response()->json(['status'=>'fail',"User not available into system."]);
                }
                return response()->json(['status'=>'fail',"Something went wrong.."]);
        } catch (Exception $e) {
            return response()->json(['status'=>'fail',"Something went wrong.."]);            
        }
    }
       
}
