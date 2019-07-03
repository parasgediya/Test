<?php

namespace TestApp\Http\Controllers\admin;

use TestApp\Amenities;
use TestApp\Club;
use TestApp\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TestApp\Http\Controllers\Controller;


class ClubController extends Controller
{

    public function clubs()
    {
        $data['page_title'] = "Club";
        $data['page_description'] = "";
        $data['user'] = User::where('role','club')->get()->pluck('full_name', 'id')->all();
        return view('admin.club', $data);
    }
    
    public function DisplayData(Request $request) {
        
            $all = $request->all();
            $start = isset($all['start']) ? $all['start'] : 0;
            $length = isset($all['length']) ? $all['length'] : 10;
            $orderdir = isset($all['order'][0]['dir']) ? $all['order'][0]['dir'] : 0;
            $ordercol = isset($all['order'][0]['dir']) ? $all['order'][0]['column'] : 0;
            $searchchar = isset($all['search']['value']) ? $all['search']['value'] : '';

            $Category_query = Club::select('clubs.*','users.firstname','users.lastname')
                                    ->leftjoin('users', 'users.id', '=', 'clubs.user_id');

              if($searchchar != '') {
                 $Category_query->where('name', 'like', '%'.$searchchar.'%');
              }
        
              if ($ordercol == 1) {
              $Category_query->orderBy('name',$orderdir);
              }
              else{
              $Category_query->orderBy('id',$orderdir);
              }    

            $total = $Category_query->count();
            $Category_query->skip($start)->take($length);
            $data['data'] =$Category_query->get();
            $data['recordsTotal'] = $total;
            $data['recordsFiltered'] = $total;
            return json_encode($data);
    }

    public function postClub(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|max:30',
            'user_id' => 'required|not_in:0'
        ]);
        $club = new Club;
        if (!empty($r->hidden_id)) {
            $update = Club::find($r->hidden_id);
            $update->name = $r->name;
            $update->user_id = $r->user_id;
            $save = $update->save();
        } else {
            $club->name = $r->name;
            $club->user_id = $r->user_id;
            $save = $club->save();
        }
        if ($save) {
            echo json_encode(['status' => true, 'msg' => 'Club successfully save.', 'type' => 'success']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Something went wrong!', 'type' => 'warning']);
        }
    }
    
     public function getformdata(Request $request){
         
         $sr= Club::where('id',$request['id'])->first();

          if(!empty($sr)){
            $data['data']=$sr; 
            $data['flag']=1; 
          }  
          else{
            $data['flag']=0; 
          }
        echo json_encode($data);   
   
     }
     
    public function getClub()
    {
        return DB::table('clubs')->select('id','name')->get();
    }

    public function delClub(Request $r)
    {
        $query= "Delete clubs, teams, groups, players 
                from clubs 
                LEFT JOIN teams ON teams.user_id=clubs.user_id
                LEFT JOIN groups ON groups.user_id=clubs.user_id
                LEFT JOIN players ON players.user_id=clubs.user_id 
                where clubs.id= ?";
        return DB::delete($query,[$r->id]);
    }
}
