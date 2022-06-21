<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\publishing;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class caledarController extends Controller
{

    function getCalendar(){

        $user_id = Crypt::decrypt(session()->get('access_ID'));

        $calendar = DB::table('publishing')
                    ->join('posts', 'publishing.post_id', '=', 'posts.post_id')
                    ->join('accounts', 'publishing.account_id', '=', 'accounts.account_id')
                    ->select('publishing.*', 'posts.title', 'posts.image', 'accounts.username' , 'accounts.platform')
                    ->get();

      
        foreach($calendar as $c){
            $c->publish_id = Crypt::encrypt($c->publish_id);
            $c->post_id = Crypt::encrypt($c->post_id);
            $c->account_id = Crypt::encrypt($c->account_id); 
        }

        return $calendar;

    
    
    }

    function postCalendar(Request $req){

        $user_id = Crypt::decrypt(session()->get('access_ID'));

        $post_id = $req['data'][0][0]['post'];
        $timing = $req['data'][0][0]['timing'];

        for($i = 0 ; $i < count($req['data'][0][0]['account']) ; $i++){
            $account_id = $req['data'][0][0]['account'][$i][0];
            $record = new publishing();
            $record->post_id = Crypt::decrypt($post_id);
            $record->timing = $timing;
            $record->account_id = Crypt::decrypt($account_id);
            $record->is_published = 0;
            $record->user_id = $user_id;
            $record->save();
        }
        
    }


    function deleteCalendar(Request $req){

        $ID = Crypt::decrypt($req['id']);
        publishing::where('publish_id', '=', $ID)->delete();
    
    }



}
