<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Repositories\NewsRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class NewsController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->middleware(['auth', 'verified']);
        $this->newsRepository = $newsRepo;
    }

    /**
     * Display a listing of the Post.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $items = $request->items ?? 9;

        $query = News::query();

	   $selectedYear = $month = $language ='';
       
        $query = $query->where('language', app()->getLocale());

        if (!empty($request->year)) {
            $year = $request->year;
            $query = $query->whereYear('created_at', $year);
        }

        if (!empty($request->month)) {
            $month = $request->month;
            $query = $query->whereMonth('created_at', $month);
        }

        $news = $query->where('status',0)->paginate($items)->appends($request->except('_token'));

        return view('news.all_news', compact('news','month','selectedYear','language'))
            ->withItems($items);
    }

    /**
     * Display the specified Post.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNews($id)
    {
        $news = $this->newsRepository->find($id);

        return view('news.show', compact('news'));
    }
}
