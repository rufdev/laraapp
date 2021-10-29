<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        //$this->authorize('isAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isSupport')) {
            return Role::orderBy('id')->paginate(5);
        }else{
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'code' => 'required|string|max:191|unique:roles',
        ]);
        return Role::create([
            'name' => $request['name'],
            'code' => $request['code'],
            'description' => $request['description']
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'code' => 'required|string|max:191|unique:roles,code,'.$role->id,
        ]);


        $role->update($request->all());

        return ['message' => 'Updated the role info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $role = Role::findOrFail($id);
        $role->delete();
        return ['message'=>'Role Deleted'];
    }

    public function search(){

        if ($search = \Request::get('q')) {
            $roles = Role::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('code','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $roles = Role::latest()->paginate(5);
        }

        return $roles;

    }
    public function count(){
        return Role::count();
    }
}
