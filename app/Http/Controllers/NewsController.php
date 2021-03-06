<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function AddNews(Request $request){
        if($validate = $this->validasi($request->all(),[
            'content' => 'required',
            'judul' => 'required'
        ]))
        return $validate;

        $news = News::create($request->toArray());
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $news->id . '_' . $file->getClientOriginalName();
            $path = $file->move(public_path('images/news'), $filename);
            $news->update(['image' => $filename]);
        }
        return $this->resSuccess($news);
    }

    public function deleteNews(Request $request){
        $cari = News::where('id', $request->id)->first();
        $cari->delete();
        return $this->resSuccess("Content Berita Dihapus");
    }

    public function AllNews(){
        return $this->resSuccess(News::all());
    }

    public function UpdatedNews(Request $request){
        if ($validate = $this->validasi($request->all(),[
            'id' => 'required',
        ]))
        return $validate;

        $news = News::where('id',$request->id)->first();
        if (!is_null($request->content)) $news->content = $request->content;
        if (!is_null($request->judul)) $news->judul = $request->judul;
        $news->update();
        return $this->resSuccess($news);
    }
}
