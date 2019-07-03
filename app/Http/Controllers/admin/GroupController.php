<?php

namespace TestApp\Http\Controllers\admin;

use Illuminate\Http\Request;
use TestApp\Http\Controllers\Controller;
use TestApp\Group;
use TestApp\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function groups()
    {
        $data['page_title'] = "Groups";
        $data['page_description'] = "";
        $data['team'] = Team::get()->pluck('name', 'id')->all();
        return view('admin.club.group', $data);
    }
    
    public function DisplayData(Request $request) {
        
            $all = $request->all();
            $start = isset($all['start']) ? $all['start'] : 0;
            $length = isset($all['length']) ? $all['length'] : 10;
            $orderdir = isset($all['order'][0]['dir']) ? $all['order'][0]['dir'] : 0;
            $ordercol = isset($all['order'][0]['dir']) ? $all['order'][0]['column'] : 0;
            $searchchar = isset($all['search']['value']) ? $all['search']['value'] : '';

            $Category_query = Group::select('groups.*','teams.name as team')
                                ->leftjoin('teams','teams.id','=','groups.team_id')    
                                ->where('groups.user_id',Auth::user()->id);

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

    public function postData(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|max:30',
            'team_id' => 'required|not_in:0'
        ]);
        $team = new Group;
        if (!empty($r->hidden_id)) {
            $update = Group::find($r->hidden_id);
            $update->name = $r->name;
            $update->team_id= $r->team_id;
            $update->user_id = Auth::user()->id;
            $save = $update->save();
        } else {
            $team->name = $r->name;
            $team->team_id= $r->team_id;
            $team->user_id = Auth::user()->id;
            $save = $team->save();
        }
        if ($save) {
            echo json_encode(['status' => true, 'msg' => 'Group successfully save.', 'type' => 'success']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Something went wrong!', 'type' => 'warning']);
        }
    }
    
    public function getformdata(Request $request){
        
        $sr= Group::where('id',$request['id'])->first();

        if(!empty($sr)){
            $data['data']=$sr; 
            $data['flag']=1; 
        }  
        else{
            $data['flag']=0; 
        }
        echo json_encode($data);   
    }
     
    public function delGroup(Request $r)
    {
        $query= "Delete groups, players from groups LEFT JOIN players ON players.group_id=groups.id where groups.id= ?";
        return DB::delete($query,[$r->id]);
    }
}
