<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Response;

/**
 * Class FAQController
 * @package App\Http\Controllers
 */
class FAQController extends AppBaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * return view my profile
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFaqs(Request $request)
    {
        $englishFaqs = FAQ::where('status', 0)->where('language', 'en')->get();
        $chineseFaqs = FAQ::where('status', 0)->where('language', 'ch')->get();

        return view('users.faq', compact('englishFaqs', 'chineseFaqs'));
    }
}
