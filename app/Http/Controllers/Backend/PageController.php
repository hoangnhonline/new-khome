<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Book;
use App\Models\Chapter;

use Helper, File, Session, Auth, Hash, URL, Image;

class PageController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   
    public function index(Request $request)
    {   
        
        $arrSearch['book_id'] = $book_id = isset($request->book_id) ? $request->book_id : -1;
        $arrSearch['chapter_id'] = $chapter_id = isset($request->chapter_id) ? $request->chapter_id : -1;
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $query = Page::where('page.status', $status);
        
        $query->where('page.chapter_id', $chapter_id);  
        if($chapter_id > 0){
            $chapterDetail = Chapter::find($chapter_id);
        }
        $folder_id = -1;              
        if($book_id > 0){
            $bookDetail = Book::find($book_id);
            $folder_id = $bookDetail->folder_id;
            $bookList = Book::where('folder_id', $folder_id)->get();
            $chapterList = Chapter::where('book_id', $book_id)->get();   
        }else{
            $bookList = $chapterList = (object) [];
            $arrSearch['folder_id'] = $folder_id = isset($request->folder_id) ? $request->folder_id : $folder_id;            
        }

        
        if($folder_id){
            $bookList = Book::where('folder_id', $folder_id)->get();
        }        
        $query->orderBy('page.display_order', 'asc')->orderBy('page.id', 'desc');
        $items = $query->paginate(100);        
        return view('backend.page.index', compact( 'items', 'arrSearch', 'bookList', 'bookDetail', 'book_id', 'folder_id', 'chapter_id', 'chapterList', 'chapterDetail'));
    }
   
   
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {   
        $chapter_id = $request->chapter_id ? $request->chapter_id : null;
        $chapterDetail = Chapter::find($chapter_id);
        return view('backend.page.create', compact('chapter_id', 'chapterDetail'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all(); 
       
        $dataArr['display_order'] = Helper::getNextOrder('page',['folder_id' => $dataArr['folder_id'], 'book_id' => $dataArr['book_id'], 'chapter_id' => $dataArr['chapter_id']]);
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;              

        $rs = Page::create($dataArr);

        Session::flash('message', trans('text.success'));

        return redirect()->route('page.create', ['chapter_id' => $dataArr['chapter_id']]);
    }   

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    { 
        $detail = Page::find($id); 
        $chapter_id = $detail->chapter_id;
        $chapterDetail = Chapter::find($chapter_id);

        return view('backend.page.edit', compact( 'detail', 'chapterDetail', 'chapter_id'));
    }
   
    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
         
        $dataArr['updated_user'] = Auth::user()->id;        
        
        $model = Page::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', trans('text.success'));

        return redirect()->route('page.index', ['book_id' => $dataArr['book_id'], 'folder_id' => $dataArr['folder_id'], 'chapter_id' => $dataArr['chapter_id']]);
        
    }
   

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Page::find($id);        
        $model->delete();
        // redirect
        Session::flash('message', trans('text.success'));
        
        return redirect(URL::previous());
        
    }
}
