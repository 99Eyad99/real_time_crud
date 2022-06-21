<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;




class userController extends Controller
{
    public function login(request $req){


        $msg = [   'ID.required'=> 'ID is can not be empty',
                    'password.required'=> 'password is can not be empty',
                    'password.min'=> 'password lenght must be 8 or more',
                ];
        
        $validator =   Validator::make($req->all(),[
                'ID' => 'required',
                'password' => 'required|min:8',
            ],
            $msg
        )->validate();

        $result = DB::table('users')->where('user_id', '=', $req['ID'])->get();
        $array = (array) $result;
        // password == Eyad@1234
        $encPassword = md5($req['password']);

        echo $encPassword;
        echo '-----------------------------------------------------';
        echo $result[0]->password;

        if(count($result)!=0){
            if($encPassword  == $result[0]->password){
                session(['access_ID' => Crypt::encrypt($result[0]->user_id)]);    
                return redirect('app');
            }else{
                $msg = 'You have entered wrong information';
                return view('login')->with(['msg' => $msg]);
            }
        }
        else{
            $msg = 'You have entered wrong information';
            return view('login')->with(['msg' => $msg]);
        }

    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }

    public function UserUpdate(Request $request){
        //$user = User::whereId($request->session)->update($request->all());
        $user_id = Crypt::decrypt($request['session']);
        if(DB::table('users')->where('user_id', '=', $user_id)->get()){
            $query = DB::table('users')->where('user_id','=',$user_id)
            ->update(array('username' => $request['username'] , 'email' => $request['email']));
            if($query){
                return 'profile has updated successfully';   
            }
        }
      
    }


}
