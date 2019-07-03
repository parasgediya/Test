<?php

namespace TestApp\Http\Controllers\admin;

use Illuminate\Http\Request;
use TestApp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(){
        
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "";
        return view('admin.dashboard',$data);
    }

    public function getCounter()
    {
        $data['user']= \TestApp\User::get()->count();
        $data['team']= \TestApp\Team::where('user_id',Auth::user()->id)->get()->count();
        $data['group']= \TestApp\Group::where('user_id',Auth::user()->id)->get()->count();
        $data['player']= \TestApp\Player::where('user_id',Auth::user()->id)->get()->count();
        return json_encode($data);
    }
}