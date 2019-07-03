<?php

namespace TestApp\Http\Controllers\admin;

use Illuminate\Http\Request;
use TestApp\Http\Controllers\Controller;
use TestApp\Player;
use TestApp\Team;
use TestApp\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function players()
    {
        $data['page_title'] = "Players";
        $data['page_description'] = "";
        $data['team'] = Team::get()->pluck('name', 'id')->all();
        return view('admin.club.player', $data);
    }

    public function cmbGroup(Request $r)
    {
        $group = Group::where('team_id',$r->id)->get();
        echo json_encode($group);
    }
    
    public function DisplayData(Request $request) {
        $all = $request->all();
        $start = isset($all['start']) ? $all['start'] : 0;
        $length = isset($all['length']) ? $all['length'] : 10;
        $orderdir = isset($all['order'][0]['dir']) ? $all['order'][0]['dir'] : 0;
        $ordercol = isset($all['order'][0]['dir']) ? $all['order'][0]['column'] : 0;
        $searchchar = isset($all['search']['value']) ? $all['search']['value'] : '';

        $Category_query = Player::select('players.*','groups.name as group','teams.name as team')
                            ->leftjoin('groups','groups.id','=','players.group_id')    
                            ->leftjoin('teams','teams.id','=','players.team_id')    
                            ->where('players.user_id',Auth::user()->id);

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
            'team_id' => 'required|not_in:0',
            'group_id' => 'required|not_in:0'
        ]);
        $team = new Player;
        
        if($photo = $r->file('image'))
        {
          $root = base_path().'/public/images/profile';
          $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            $image_path = 'images/profile/'.$name;
            $photo->move($root,$name);
            $image = $image_path;
        }
        if (!empty($r->hidden_id)) {
            $update = Player::find($r->hidden_id);
            $update->name = $r->name;
            $update->team_id= $r->team_id;
            $update->group_id= $r->group_id;
            if(!empty($image)){
                $update->image=$image;
            }
            $update->user_id = Auth::user()->id;
            $save = $update->save();
        } else {
            $team->name = $r->name;
            $team->team_id= $r->team_id;
            $team->group_id= $r->group_id;
            if(!empty($image)){
                $team->image = $image;
            }
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
        
        $sr= Player::where('id',$request['id'])->first();

        if(!empty($sr)){
            $data['data']=$sr; 
            $data['flag']=1; 
        }  
        else{
            $data['flag']=0; 
        }
        echo json_encode($data);   
    }
     
    public function delPlayer(Request $r)
    {
        return Player::where('id', $r->cid)->delete();
    }
}
