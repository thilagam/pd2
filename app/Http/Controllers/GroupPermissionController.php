<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;

use App\CepGroupPermissions;
use App\CepGroups;
use App\CepPermissions;
use Validator;

class GroupPermissionController extends Controller {

	public $configs;
	public $permit;
	/*
	|--------------------------------------------------------------------------
	| Config
	|--------------------------------------------------------------------------
	|
	| Define all Config Setting here
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(\Illuminate\Http\Request $request)
	{
		$this->middleware('auth');
		$this->permit=$request->attributes->get('permit');
    	$this->configs=$request->attributes->get('configs');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->crud_group_permissions)
            return redirect('accessDenied');
		$group_permissions = CepGroupPermissions::with('permission','group')->get();
		return view('group_permissions.index',compact('group_permissions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(!$this->permit->crud_group_permissions_create)
            return redirect('accessDenied');

        $groups_array = CepGroups::all();
        $permissions_array = CepPermissions::all();
		$groups = array();
		$permissions = array();

		foreach($groups_array as $group)
			$groups[$group->group_id] = $group->group_name;
                foreach($permissions_array as $permission)
					$permissions[$permission->perm_id] = $permission->perm_keyword;

        return view('group_permissions.create', compact('groups','permissions'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $group_permission = Request::only('gp_perm_id','gp_group_id','gp_permission');
		$validate = Validator::make($group_permission,[
                    'gp_perm_id' => 'required',
	    			'gp_group_id' => 'required',
                    'gp_permission' => 'required',
        ]);
        if($validate->fails()){
                return redirect()->back()->withErrors($validate->errors());
        }
		CepGroupPermissions::create($group_permission);
                return redirect('group-permissions');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		if(!$this->permit->crud_group_permissions_read)
            return redirect('accessDenied');

		$group_permission = CepGroupPermissions::where('gp_id',$id)->first();
		$group_array = CepGroups::all();
		$permission_array = CepPermissions::all();
		$groups = array();
		$permissions = array();
		foreach($group_array as $group)
			$groups[$group->group_id] = $group->group_name;
		foreach($permission_array as $permission)
			$permissions[$permission->perm_id]= $permission->perm_keyword;

		return count($group_permission) ? view('group_permissions.show', compact('groups','permissions','group_permission')) : abort(404);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		if(!$this->permit->crud_group_permissions_edit)
            return redirect('accessDenied');
		$group_permission = CepGroupPermissions::where('gp_id',$id)->first();
                $group_array = CepGroups::all();
                $permission_array = CepPermissions::all();
                $groups = array();
                $permissions = array();
                foreach($group_array as $group)
                        $groups[$group->group_id] = $group->group_name;
                foreach($permission_array as $permission)
                        $permissions[$permission->perm_id]= $permission->perm_keyword;

        return count($group_permission) ? view('group_permissions.edit', compact('groups','permissions','group_permission')) : abort(404);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$group_permissionUpdate = Request::only('gp_perm_id','gp_group_id','gp_permission','gp_status');
                $validate = Validator::make($group_permissionUpdate,[
                            'gp_keyword' => 'required|max:100',
                            'gp_group_id' => 'required',
                            'gp_permission' => 'required',
                ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		$effected_row = CepGroupPermissions::where('gp_id',$id)->update($group_permissionUpdate);
                return redirect("group-permissions");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		if(!$this->permit->crud_group_permissions_delete)
            return redirect('accessDenied');
                CepGroupPermissions::where('gp_id',$id)->delete();
                return redirect('group-permissions');
	}

}
