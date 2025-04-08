<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function TagPage(Request $request){
        $user_id = $request->header('id');
        $tags = Tag::where('user_id', $user_id)->get();
        return Inertia::render('TagPage',['tags'=>$tags]);
    }//end method

    public function TagSavePage(Request $request){
        $tag_id = $request->query('id');
        $user_id = $request->header('id');
        $tag = Tag::where('id', $tag_id)->where('user_id', $user_id)->first();
        return Inertia::render('TagSavePage',['tag'=>$tag]);
    }
    public function CreateTag(Request $request){
        $user_id = $request->header('id');

        Tag::create([
            'name' => $request->name,
            'user_id' => $user_id
        ]);
        $data = ['message'=>'Tag created successfully','status'=>true,'error'=>''];
        return redirect('/TagPage')->with($data);
    }//end method

    public function TagList(Request $request){
        $user_id = $request->header('id');
        $tags = Tag::where('user_id', $user_id)->get();
        return $tags;
    }//end method

    public function TagById(Request $request){
        $user_id = $request->header('id');
        $tag =Tag::where('id', $request->id)->where('user_id', $user_id)->first();
        return $tag;
    }//end method

    public function TagUpdate(Request $request){
        $user_id = $request->header('id');
        $id = $request->input('id');
        Tag::where('id', $id)->where('user_id', $user_id)->update([
            'name' => $request->input('name')
        ]);
        $data = ['message'=>'Tag Updaetd successfully','status'=>true,'error'=>''];
        return redirect('/TagPage')->with($data);
    }//end method

    public function TagDelete(Request $request,$id){
        $user_id = $request->header('id');
        Tag::where('user_id', $user_id)->where('id', $id)->delete();
        $data = ['message'=>'Tag Deleted successfully','status'=>true,'error'=>''];
        return redirect('/TagPage')->with($data);
    }//end method
}
