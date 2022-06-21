<?php

namespace App\Http\Controllers;
use App\Models\account;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class accountController extends Controller
{

    public function getAccounts(Request $req){

        $user_id = Crypt::decrypt(session()->get('access_ID'));
        $accounts = DB::table('accounts')->where('user_id', $user_id)->get();

        // encrypt post_id for security
        foreach($accounts as $a){
            $a->account_id = Crypt::encrypt($a->account_id);
        }
        return $accounts;

    }

    public function addAccount(Request $req){

        $req->validate([
            'username' => 'required',
            'password' => 'required',
            'platform' => 'required|in:Instagram,Facebook,twitter',  
        ]);

        $account = new account();
        $account->username = $req['username'];
        $account->password = Crypt::encrypt($req['password']);
        $account->platform = $req['platform'];
        $account->user_id = Crypt::decrypt(session()->get('access_ID'));
        if($account->save()){
            return 'Added succussfully';
        }

    }

    public function updateAccount(Request $req){

        $req->validate([
            'username' => 'required',
            'platform' => 'required|in:Instagram,Facebook,twitter',
        ]);

        $account_id = Crypt::decrypt($req['id']);
        $account = account::find($account_id);

        $account->username = $req['username'];
        $account->platform = $req['platform'];
        $account->user_id = Crypt::decrypt(session()->get('access_ID'));

        if(empty($req->password)){
            if($account->save()){
                return "updated succuessfully";
            }  
        }else{
            $enctypedPassword = Crypt::encrypt($req['password']);
            $account->password = $enctypedPassword;
            if($account->save()){
                return "updated succuessfully";
            }  
        }


    }

    public function deleteAccount(Request $req){
        $id = Crypt::decrypt($req['id']);
        if(DB::table('accounts')->where('account_id',  $id)->where('user_id', '=', Crypt::decrypt(session()->get('access_ID')))->delete()){
            return 'Deleted successfully';
        }
        else{
            return 'unsuccessfull request';
        }
    }



}
