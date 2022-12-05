<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Level;

use Illuminate\Http\Request;

class CUser extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level = Level::all()->pluck('nama_level', 'id_level');
        return view('user.index', compact('level'));
    }

    public function data()
    {
        $user = user::select('users.*', 'nama_level')
                      ->leftJoin('level', 'level.id_level', 'users.level')  
                      ->orderBy('id')->get();
        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                    <div class="btn-group">
                        <button onclick="edit(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-edit"></i></button>
                        // <button onclick="hapus(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </div>
                ';
            })
            ->rawColumns(['aksi', ''])
            ->make(true);
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
        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        if($request->has('password') && $request->password != ""){
            $user->password = $request->password;
        } 
        $user->password = bcrypt($request->password);
        $user->level = $request->id_level;
        $user->foto = '';
        $user->save();
        return response()->json('Data berhasil di simpan !', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::find($id)->update($request->all());
        return response()->json('Data berhasil di update !', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id)->delete();
        return response(null, 204);
    }
}
