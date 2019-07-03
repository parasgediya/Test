<?php

namespace TestApp\Http\Controllers\admin;

use Illuminate\Http\Request;
use TestApp\Http\Controllers\Controller;
use TestApp\User;

class ImpersonateController extends Controller
{
    public function index($id)
    {
        $user= User::where('id',$id)->first();
        if($user){
            session()->put('impersonate',$user->id);
            return redirect('admin');
        }
    }

    public function destroy()
    {
        session()->forget('impersonate');
        return redirect('admin/users');
    }
}
