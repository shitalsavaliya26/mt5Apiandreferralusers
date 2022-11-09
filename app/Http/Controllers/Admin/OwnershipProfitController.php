<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OwnershipImportFile;
use Exception;
use Illuminate\Http\Request;

class OwnershipProfitController extends Controller
{
    public function __construct(Request $request)
    {
        // parent::__construct();
        $this->path = storage_path('logs/user_logs/' . date("Y-m-d") . '.log');
        $this->limit = $request->limit ? $request->limit : 10;
    }

    public function index(Request $request)
    {
        $ownershipHistory = OwnershipImportFile::orderBy('id', 'desc')->paginate($this->limit);

        return view('admin.ownership.index', compact('ownershipHistory'));
    }

    public function importFile(Request $request)
    {
        set_time_limit(0);
        $request->validate([
            'importFile' => 'required|mimes:csv,xlsx,xls,htm,html',
        ]);

        try {

            if ($request->file('importFile')) {
                $original_name = $request->file('importFile')->getClientOriginalName();
                $original_extension = $request->file('importFile')->getClientOriginalExtension();
                $path = 'profit/ownership-import';
                $file_name = time() . '_file.' . $original_extension;
                $image = $request->importFile->storeAs('profit/ownership-import', $file_name);
                $rebate_file = new OwnershipImportFile();
                $rebate_file->file_name = $file_name;
                $rebate_file->original_name = $original_name;
                $rebate_file->path = $path;
                $rebate_file->save();

                // \Artisan::call('cron:call '.$route);
                // $this->extractData1($rebate_file->id);
                return redirect()->back()->with('message', 'File imported successfully.');
            }
            return redirect()->back()->with('error', 'Please select proper html files.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.......');
        }
        // return view('backend.pipe_rebates.import_data');
    }
}
