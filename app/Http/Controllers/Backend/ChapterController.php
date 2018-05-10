<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Book;

use Helper, File, Session, Auth, Hash, URL, Image;

class ChapterController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */    
    public function index(Request $request)
    {   
        
        $arrSearch['book_id'] = $book_id = isset($request->book_id) ? $request->book_id : -1;
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $query = Chapter::where('chapter.status', $status);
        
        $query->where('chapter.book_id', $book_id);  
        $folder_id = -1;              
        if($book_id > 0){
            $bookDetail = Book::find($book_id);
            $folder_id = $bookDetail->folder_id;
            $bookList = Book::where('folder_id', $folder_id)->get();   
        }else{
            $bookList = (object) [];
            $arrSearch['folder_id'] = $folder_id = isset($request->folder_id) ? $request->folder_id : $folder_id;
        }

        
        if($folder_id){
            $bookList = Book::where('folder_id', $folder_id)->get();   
        }        
        $query->orderBy('chapter.display_order', 'asc')->orderBy('chapter.id', 'desc');
        $items = $query->paginate(100);        
        return view('backend.chapter.index', compact( 'items', 'arrSearch', 'bookList', 'bookDetail', 'book_id', 'folder_id'));
    }
   
   
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {       
        $folder_id = $request->folder_id ? $request->folder_id : null;
        $book_id = $request->book_id ? $request->book_id : null;
        if($book_id > 0){
            $bookDetail = Book::find($book_id);
            $folder_id = $bookDetail->folder_id;
            $bookList = Book::where('folder_id', $folder_id)->get();   
        }else{
            $bookList = (object) [];
        }
        return view('backend.chapter.create', compact('book_id', 'folder_id', 'bookList'));
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
        
         $this->validate($request,[            
            'folder_id' => 'required',
            'book_id' => 'required',            
            'name' => 'required'
        ],
        [   
            'folder_id.required' => 'Please choose folder',
            'book_id.required' => 'Please choose book',            
            'name.required' => 'Please input name',
        ]);
           
        $dataArr['slug'] = str_slug($dataArr['name']);
        $dataArr['status'] = 1;
        $dataArr['display_order'] = Helper::getNextOrder('chapter',['folder_id' => $dataArr['folder_id'], 'book_id' => $dataArr['book_id']]);
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;              

        $rs = Chapter::create($dataArr);
        $product_id = $rs->id;

        Session::flash('message', trans('text.success'));

        return redirect()->route('chapter.index', ['folder_id' => $dataArr['folder_id'], 'book_id' => $dataArr['book_id']]);
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
        $detail = Chapter::find($id); 
         $bookDetail = Book::find($detail->book_id);
            $folder_id = $bookDetail->folder_id;
            $bookList = Book::where('folder_id', $folder_id)->get();   
        return view('backend.chapter.edit', compact( 'detail', 'bookDetail', 'folder_id', 'bookList'));
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
        
        $this->validate($request,[            
            'folder_id' => 'required',
            'book_id' => 'required',            
            'name' => 'required'
        ],
        [   
            'folder_id.required' => 'Please choose folder',
            'book_id.required' => 'Please choose book',            
            'name.required' => 'Please input name',
        ]);
        $dataArr['slug'] = str_slug($dataArr['name']);     
        $dataArr['updated_user'] = Auth::user()->id;        
        
        $model = Chapter::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', trans('text.success'));

        return redirect()->route('chapter.index', ['book_id' => $dataArr['book_id'], 'folder_id' => $dataArr['folder_id']]);
        
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
        $model = Chapter::find($id);        
        $model->delete();        
        // redirect
        Session::flash('message', trans('text.success'));
        
        return redirect(URL::previous());
        
    }
}
