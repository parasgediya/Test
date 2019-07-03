<?php

namespace TestApp\Http\Controllers\admin;

use TestApp\Http\Controllers\Controller;
use TestApp\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getProfile()
    {
        $id = Auth::user()->id;
        $data['page_title'] = "User";
        $data['page_description'] = "Profile";
        $data['user'] = \TestApp\User::where('id', $id)->first();
        return view('admin.profile', $data);
    }



    public function saveUser(Request $request)
    {
        $id = Auth::user()->id;
        $this->validate($request, [
            'firstname' => 'required|regex:/(^[A-Za-z ]+$)+/|max:30',
            'lastname' => 'required|regex:/(^[A-Za-z ]+$)+/|max:30',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'confirmed',
        ]);
            
        if(!empty($id))
        $User = User::find($id);

        $input = $request->all();
        
        // $img= Auth::user();
        // $img->addMedia($request->image)->toMediaCollection();
        
        
        if($photo = $request->file('image'))
        {
          $root = base_path().'/public/images/profile';
          $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            $image_path = 'images/profile/'.$name;
            $photo->move($root,$name);
            $input['image'] = $image_path;
        }
              
        if (empty($request['password'])) {
            unset($input['password']);
        }

        $input['ip'] = $request->ip();
        $input['updated_at'] = Carbon::now();
        $User->update($input);
        \Session::flash('Success', 'User updated successfully!');
        return redirect('admin\profile');
    }

    public function add()
    {
        $id= request()->segment(4);
        $data['page_title'] = "Add Users";
        $data['page_description'] = "";
        $data['user'] = \TestApp\User::where('id', $id)->first();

        $data['role'] = ['admin'=>'Super Admin','club'=>'Club Admin'];
        return view('admin.users.add', $data);
    }

    public function postUser(Request $request)
    {
        $id = !empty($request->uid)?$request->uid:'';
        $this->validate($request, [
            'firstname' => 'required|max:30',
            'lastname' => 'required|max:30',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'password' => 'required',
            'role' => 'required|not_in:0'
        ]);
            
        if(!empty($id))
        $User = User::find($id);

        $input = $request->all();
       
        // $img= Auth::user();
        // $img->addMedia($request->image)->toMediaCollection();
        if($photo = $request->file('image'))
        {
          $root = base_path().'/public/images/profile';
          $name = str_random(20).".".$photo->getClientOriginalExtension();
            if (!file_exists($root)) {
                mkdir($root, 0777, true);
            }
            $image_path = 'images/profile/'.$name;
            $photo->move($root,$name);
            $input['image'] = $image_path;
        }
              
        if (empty($request['password'])) {
            unset($input['password']);
        }

        $input['ip'] = $request->ip();
        if(!empty($id)){
            $input['updated_at'] = Carbon::now();
            $User->update($input);
            \Session::flash('Success', 'User updated successfully!');
        }else{
            $save = User::create($input);
            if($save){
                $data['name']= $request->firstname.' '.$request->lastname;
                $data['email'] = $request->email;
                $data['password']= $request->password;
                $data['from'] = Auth::user()->email;
                $data['subject'] = "TestApp - Account Details";
                Mail::send('template.email', $data, function ($message) use ($data) {
                    $message->from('test@app.com', 'Test App');
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                });
            }
            \Session::flash('Success', 'User successfully save!');
        }
        return redirect('admin\users');
    }

    public function users()
    {
        $data['page_title'] = "Users";
        $data['page_description'] = "";
        return view('admin.users.list', $data);
    }

    public function getUsers(Request $r)
    {
        $all = $r->all();
        $start = isset($all['start']) ? $all['start'] : 0;
        $length = isset($all['length']) ? $all['length'] : 10;
        $orderdir = isset($all['order'][0]['dir']) ? $all['order'][0]['dir'] : 0;
        $ordercol = isset($all['order'][0]['dir']) ? $all['order'][0]['column'] : 0;
        $searchchar = isset($all['search']['value']) ? $all['search']['value'] : '';

        $Users_query = User::select('*');

        if ($searchchar != '') {
            $Booking_query->where('name', 'like', '%' . $searchchar . '%');
        }

        if ($ordercol == 1) {
            $Users_query->orderBy('name', $orderdir);
        } else {
            $Users_query->orderBy('id', $orderdir);
        }

        $total = $Users_query->count();
        $Users_query->skip($start)->take($length);
        $data['data'] = $Users_query->get();
        $data['recordsTotal'] = $total;
        $data['recordsFiltered'] = $total;
        return json_encode($data);
    }
    
    public function updateRole(Request $r){
        $user = User::find($r->id);
        $user->role = $r->role;
        $save = $user->save();
        if ($save) {
            echo json_encode(['status' => true, 'msg' => 'User role successfully update.', 'type' => 'Success']);
        } else {
            echo json_encode(['status' => false, 'msg' => 'Something went wrong!', 'type' => 'Warning']);
        }
    }

    public function deleteUser(Request $r)
    {
        return User::where('id', $r->id)->delete();
    }
}