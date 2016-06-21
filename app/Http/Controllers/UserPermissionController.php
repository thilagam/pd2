<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Validator;
use App\CepUserPermissions;
use App\CepPermissions;
use App\User;

class UserPermissionController extends Controller {

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
		if(!$this->permit->crud_user_permissions)
            return redirect('accessDenied');
        $user_permission=CepUserPermissions::with('user')->get();
		return view('user_permissions.index',compact('user_permission'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_user_permissions_create)
            return redirect('accessDenied');
                $users_array = User::all();
		$users = array();
		foreach($users_array as $user)
			$users[$user->id]= $user->name." : ".$user->email;
		$permissions_array = CepPermissions::all();
		$permissions= array();
		foreach($permissions_array as $permission)
			$permissions[$permission->perm_keyword] = $permission->perm_keyword;
		return view('user_permissions.create',compact('permissions','users'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//

                $user_permission = Request::all();
                $validate = Validator::make($user_permission,[
                            'uperm_user_id' => 'required',
                            'uperm_enabled' => 'required',
                            'uperm_disabled' => 'required',
                 ]);

                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
                $user_permission['uperm_enabled'] = implode(",",$user_permission['uperm_enabled']);
		$user_permission['uperm_disabled'] = implode(",",$user_permission['uperm_disabled']);
                CepUserPermissions::create($user_permission);
		return redirect("user-permissions");

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
		if(!$this->permit->crud_user_permissions_read)
            return redirect('accessDenied');

                $users_array = User::all();
                $users = array();
                foreach($users_array as $user)
                        $users[$user->id]= $user->name." : ".$user->email;
                $permissions_array = CepPermissions::all();
                $permissions= array();
                foreach($permissions_array as $permission)
                        $permissions[$permission->perm_keyword] = $permission->perm_keyword;
                $user_permission = CepUserPermissions::where("uperm_id",$id)->first();
//                $user_permission['uperm_enabled'] = explode(",",$user_permission['uperm_enabled']);
//                $user_permission['uperm_disabled'] = explode(",",$user_permission['uperm_disabled']);

    return count($user_permission) ? view('user_permissions.show',compact('permissions','users','user_permission')) : abort(404);

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
		if(!$this->permit->crud_user_permissions_edit)
            return redirect('accessDenied');

                $users_array = User::all();
                $users = array();
                foreach($users_array as $user)
                        $users[$user->id]= $user->name." : ".$user->email;
                $permissions_array = CepPermissions::all();
                $permissions= array();
                foreach($permissions_array as $permission)
                        $permissions[$permission->perm_keyword] = $permission->perm_keyword;
                $user_permission = CepUserPermissions::where("uperm_id",$id)->first();
//                $user_permission['uperm_enabled'] = explode(",",$user_permission['uperm_enabled']);
//                $user_permission['uperm_disabled'] = explode(",",$user_permission['uperm_disabled']);

    return count($user_permission) ? view('user_permissions.edit',compact('permissions','users','user_permission')) : abort(404);

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
                $user_permission = Request::only('uperm_enabled','uperm_disabled','uperm_user_id','uperm_status');
		$validate = Validator::make($user_permission,[
                            'uperm_enabled' => 'required',
                            'uperm_disabled' => 'required',
			    'uperm_user_id' => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
                $user_permission['uperm_enabled'] = implode(",",$user_permission['uperm_enabled']);
                $user_permission['uperm_disabled'] = implode(",",$user_permission['uperm_disabled']);
                CepUserPermissions::where('uperm_id',$id)->update($user_permission);
                return redirect("user-permissions");

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
		if(!$this->permit->crud_user_permissions_delete)
            return redirect('accessDenied');
		CepUserPermissions::where('uperm_id',$id)->delete();
                return redirect('user-permissions');
	}

}
