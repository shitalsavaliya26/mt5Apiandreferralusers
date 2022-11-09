<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateNewsAPIRequest;
use App\Http\Requests\API\UpdateNewsAPIRequest;
use App\Models\News;
use App\Models\Rank;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Response;

/**
 * Class NewsController
 * @package App\Http\Controllers\API
 */
class NewsController extends AppBaseController
{
    /** @var  NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        $this->middleware('auth:admin');
        $this->newsRepository = $newsRepo;
    }

    /**
     * Display a listing of the News.
     * GET|HEAD /news
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $news = News::paginate(8);

        return view('admin.admin_news', compact('news'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin_create_news');
    }


    /**
     * Store a newly created News in storage.
     * POST /news
     *
     * @param CreateNewsAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateNewsAPIRequest $request)
    {
        $input = $request->all();

        $image = $request->file('image');
        $input['image'] = $image->getClientOriginalName();
        $news = $this->newsRepository->create($input);

        $image->storeAs('news_images', $image->getClientOriginalName());

        return redirect('avanya-vip-portal/news')->with('message', 'News created successfully.');
    }

    /**
     * Upload ckeditor News Image.
     * GET|HEAD /news/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */    
    public function uploadNewsImage(Request $request)
    {
	if($request->hasFile('upload')) {
            
            $image = $request->file('upload');
            $filename = time().'-'.$image->getClientOriginalName();
            
            $image->storeAs('news_ckeditor_images', $filename);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('news_ckeditor_images/'.$filename); 
            $msg = 'Image successfully uploaded'; 
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            @header('Content-type: text/html; charset=utf-8'); 
            echo $re;
        }
    }
    
    /**
     * Display the specified News.
     * GET|HEAD /news/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var News $news */
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        return view('admin.show_news', compact('news'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var Rank $news */
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        return view('admin.admin_edit_news', compact('news'));
    }

    /**
     * Update the specified News in storage.
     * PUT/PATCH /news/{id}
     *
     * @param int $id
     * @param UpdateNewsAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UpdateNewsAPIRequest $request)
    {
        $input = $request->all();

        /** @var News $news */
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'mimes:jpeg,jpg,png,gif'
            ]);
            $usersImage = public_path("uploads/news_images/{$news->image}"); // get previous image from folder
            if (File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
            }

            $image = $request->file('image');

            $input['image'] = $image->getClientOriginalName();

            $news = $this->newsRepository->update($input, $id);

            $image->storeAs('news_images', $image->getClientOriginalName());
        }

        $this->newsRepository->update($input, $id);

        return redirect('avanya-vip-portal/news')->with('message', 'News updated successfully.');
    }

    /**
     * Remove the specified News from storage.
     * DELETE /news/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var News $news */
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            return $this->sendError('News not found');
        }

        $news->delete();

        return back()->with('message', 'News successfully deleted.');
    }
}
