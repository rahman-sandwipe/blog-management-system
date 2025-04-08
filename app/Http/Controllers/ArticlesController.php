<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Exception;
use Inertia\Inertia;

class ArticlesController extends Controller
{ 
    // articlesPage
    public function articlesPage(Request $request) {
        $user_id = $request->header('id');
        $articles = Post::where('user_id', $user_id)->get();
        return Inertia::render('ArticlesPage', [
            'articles' => $articles
        ]);
    }
    
    // articleSavePage
    public function articleSavePage(Request $request) {
        $user_id = $request->header('id');
        $article_id = $request->query('id');
        $article = Post::where('id',$article_id)->where('user_id',$user_id)->first();
        return Inertia::render('ArticleSavePage', [
            'article' => $article
        ]);
    }//end method
    
    // articleCreate
    public function articleCreate(Request $request) {
        $user_id = $request->header('id');

        $request->validate([
            'title'     => 'required',
            'content'   => 'required',
            'visibility'=> 'required|in:public,private',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = [
            'title'         => $request->title,
            'content'       => $request->content,
            'image'         => $request->image,
            'visibility'    => $request->visibility,
            'user_id'       => $user_id
        ];

        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $filePath = 'uploads/articles/'.$fileName;
            $image->move(public_path('uploads/articles'), $fileName);
            $data['image'] = $filePath;
        }

        Post::create($data);
        $status = ['message'=>'Article created successfully','status'=>true,'error'=>''];
        return redirect('/articles')->with($status);
    }

    // articleUpdate
    public function articleUpdate(Request $request) {
        $user_id = $request->header('id');

        $request->validate([
            'id'            => 'required|exists:posts,id',
            'title'         => 'required',
            'content'       => 'required',
            'visibility'    => 'required|in:public,private'
        ]);
        $article = Post::where('user_id', $user_id)->findOrFail($request->id);

        $article->title         = $request->title;
        $article->content       = $request->content;
        $article->visibility    = $request->visibility;

        if($request->hasFile('image')){
            if($article->image && file_exists(public_path($article->image))){
                unlink(public_path($article->image));
            }

            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);
            $image = $request->file('image');

            $fileName = time().'.'.$image->getClientOriginalExtension();
            $filePath = 'uploads/articles/'.$fileName;

            $image->move(public_path('uploads/articles'), $fileName);
            $article->image = $filePath;
        }

        $article->save();
        $data = ['message'=>'Article updated successfully','status'=>true,'error'=>''];
        return redirect('/articles')->with($data);
    }//end method

    // articleList
    public function articleList(Request $request){
        $user_id = $request->header('id');

        $articles = Post::where('user_id', $user_id)->get();
        return $articles;
    }//end method

    // articleById
    public function articleById(Request $request){
        $user_id = $request->header('id');

        $article = Post::where('user_id', $user_id)->where('id', $request->id)->first();
        return $article;
    }//end method

    

    // articleDelete
    public function articleDelete(Request $request,$id){
        try{
            // $user_id = $request->header('id');
            $article = Post::findOrFail($id);
            if($article->image && file_exists(public_path($article->image))){
                unlink(public_path($article->image));
            }

            $article->delete();
            $data = ['message'=>'article Deleted successfully','status'=>true,'error'=>''];
            return redirect()->back()->with($data);
        }catch(Exception $e){
            $data = ['message'=> 'Something went wrong','status'=>false,'error'=>$e->getMessage()];
            return redirect()->back()->with($data);
        }

    }//end method

}

