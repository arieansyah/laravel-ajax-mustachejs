<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function listData()
    {
        $admin = User::orderBy('created_at', 'asc')->where('level', '=', '2')->get();
        $no = 0;
        $data = array();
        foreach($admin as $list){
          $no ++;
          $row = array();
          $row[] = $no;
          $row[] = $list->name;
          $row[] = $list->email;

          $row[] = "<div class='btn-group'>
                  <a onclick='editData(".$list->id.")' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a></div>
                  <a onclick='deleteData(".$list->id.")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></div>";
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $jml = User::where('email', $request['email'])
          ->count();

      if($jml < 1){
          $admin = new User;
          $admin->name        = $request['name'];
          $admin->email       = $request['email'];
          $admin->password    = bcrypt($request['password']);
          $admin->level       = 2;
          $admin->save();
          echo json_encode(array('msg'=>'success'));
      }else{
          echo json_encode(array('msg'=>'error'));
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        echo json_encode($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = User::find($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->password    = bcrypt($request['password']);
        $update->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = User::find($id);
        $hapus->delete();
    }
}
