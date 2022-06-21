<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\post;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{

    
    public function getPosts(Request $req){
        $user_id = Crypt::decrypt(session()->get('access_ID'));
        $posts = DB::table('posts')->where('user_id', $user_id)->get();

        // encrypt post_id for security
        foreach($posts as $p){
            $p->post_id = Crypt::encrypt($p->post_id);
        }
        return $posts;

    }
    
   public function addPost(Request $req){
        
        $req->validate([
            'title' => 'required',
            'text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',  
        ]);

        $imageName = time().'.'.$req->file('image')->guessExtension();

        $post = new post();
        $post->title = $req->title;
        $post->text = $req->text;
        $post->image = $imageName;
        $post->user_id = Crypt::decrypt(session()->get('access_ID'));
        if($post->save()){
            $req->image->move('images', $imageName); 
            return 'submitted successfully';
        }
    
    }
    

    public function updatePost(Request $req){

        $req->validate([
            'title' => 'required',
            'text' => 'required',
        ]);

        $post_id = Crypt::decrypt($req['id']);
        $post = post::find($post_id);

        if(empty($req->file('image'))){
            $post->title = $req->title;
            $post->text = $req->text;
            $post->user_id = Crypt::decrypt(session()->get('access_ID'));
            if($post->save()){
                return "updated succuessfully";
            }
            
        }
        else{
            $imageName = time().'.'.$req->file('image')->guessExtension();
            $post->image = $imageName;
            $post->title = $req->title;
            $post->text = $req->text;
            $post->user_id = Crypt::decrypt(session()->get('access_ID'));
            if($post->save()){
                $req->image->move('images', $imageName); 
                return "updated succuessfully";
            }

        }


        
    }



    public function deletePost(Request $req){
        $id = $req['id'];      
        if(DB::table('posts')->where('post_id',  Crypt::decrypt($id))->where('user_id', '=', Crypt::decrypt(session()->get('access_ID')))->delete()){
            return 'Deleted successfully';
        }
        else{
            return 'unsuccessfull request';
        }
    }



}

