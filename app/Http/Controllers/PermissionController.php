<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CepPermissions;
use App\CepGroups;
use App\CepGroupPermissions;
use App\User;
use App\CepUserPermissions;

//use Illuminate\Http\Request;
use Request;
use Validator;
use Illuminate\Support\Facades\Input;

class PermissionController extends Controller {

	/*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        |
        | CRUD Permission
        |
        */

	public $permit;
	public $configs;

        /**
         * Create a new controller instance.
         *
         * @return void
         */

        public function __construct(\Illuminate\Http\Request $request)
        {
         	$this->permit=$request->attributes->get('permit');
         	$this->configs=$request->attributes->get('configs');
                $this->middleware('auth');

        }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->crud_permissions)
            return redirect('accessDenied');
		$permissions = CepPermissions::all();
		return view('permissions/index', compact('permissions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_permissions_create)
            return redirect('accessDenied');
		return view('permissions/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$permission = Request::only('perm_description','perm_keyword');
                $validate = Validator::make($permission,[
                            'perm_keyword' => 'required|unique:cep_permissions',
                            'perm_description' => 'required',
                 ]);

                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		$permissionNew = CepPermissions::create($permission); // Create and Fetch Id for that row

                $groups = CepGroups::all();
                foreach($groups as $group){
                    $group_permission = array();
	            	$group_permission['gp_perm_id'] = $permissionNew->prem_id;
		    		$group_permission['gp_group_id'] = $group->group_id;
		    		$group_permission['gp_permission'] = 0;
		    		$group_permission['gp_status'] = 1;
                    CepGroupPermissions::create($group_permission);
				}

                return redirect('permissions');
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
		if(!$this->permit->crud_permissions_read)
            return redirect('accessDenied');
        $permission = CepPermissions::where('perm_id',$id)->first();
		return count($permission) ? view("permissions.show",compact('permission')) : abort(404);
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
		if(!$this->permit->crud_permissions_edit)
            return redirect('accessDenied');
		$permission = CepPermissions::where('perm_id',$id)->first();
		return count($permission) ? view("permissions.edit",compact('permission')) : abort(404);
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
   		$permissionUpdate = Request::only('perm_keyword','perm_description','perm_status');
		 $validate = Validator::make($permissionUpdate,[
                            'perm_keyword' => 'required|unique:cep_permissions,perm_keyword,'.$id.',perm_id',
                            'perm_description' => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		$effected_row = CepPermissions::where('perm_id','=',$id)->update($permissionUpdate);
 		return redirect('permissions');
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
		if(!$this->permit->crud_permissions_delete)
            return redirect('accessDenied');
        CepPermissions::where('perm_id',$id)->delete();
		return redirect('permissions');
	}

	public function viewAll(){
		if(!$this->permit->module_setting_group_permission)
			return redirect('accessDenied');

		$groups = CepGroups::all();
		$permissions = CepPermissions::all();
		$group_permissions = CepGroupPermissions::all();
		//echo "<pre>"; print_r($group_permissions);exit;
        return view("permissions.all_permissions",compact('groups','permissions','group_permissions'));
	}
	public function updatePermissionByGroup(){
		$data = Input::all();
		$data = explode("|",$data['perm']);
                //echo ($data['perm']);
                $updates = array("gp_permission"=>$data[2]);
//		print_r ($updates);
		$updated_row = CepGroupPermissions::where('gp_perm_id',$data[1])->where('gp_group_id',$data[0])->update($updates);
		print_r ($data[2]);
	}

	public function viewUserPermissions(){
                if(!$this->permit->module_setting_user_permission)
                        return redirect('accessDenied');

		$users = User::all();
                $users_array = array();
		$users_array[0]="Select";
		foreach($users as $user){
			$users_array[$user->id] = $user->name." ( ".$user->email." ) ";
		}
		//print_r ($users_array);
                $user_specific_id = 0;
		return view("permissions.user_permissions",compact('users_array','user_specific_id'));
	}
	public function updateUserPermissions($id){
                $users = User::all();
		$permissions = CepPermissions::all();
                $user_permissions = CepUserPermissions::where('uperm_user_id',$id)->first();
                $users_array = array();
                $users_array[0]="Select";

                foreach($users as $user){
                        $users_array[$user->id] = $user->name." ( ".$user->email." ) ";
                }

		$user_specific = User::where("id",$id)->select('group_id')->first();
		$user_specific_permissions =  CepGroupPermissions::where('gp_group_id',$user_specific->group_id)->select('gp_perm_id','gp_permission')->get();

		$enabled_permissions = isset($user_permissions->uperm_enabled) ? explode("|",$user_permissions->uperm_enabled) : array();
		$disabled_permissions = isset($user_permissions->uperm_disabled) ? explode("|",$user_permissions->uperm_disabled) : array();
		$final_permissions=array();
		$i=0;
		foreach($user_specific_permissions as $usp){
			$final_permissions[$i++] = $usp->gp_perm_id.$usp->gp_permission;
		}
//		 print_r ($final_permissions);
		$user_specific_id = $id;
                return view("permissions.user_permissions",compact('users_array','enabled_permissions','disabled_permissions','permissions','final_permissions','user_specific_id'));

	}
	public function updateUserPermissionsPost(){
                $data = Input::all();
		            $user_permissions = CepUserPermissions::where('uperm_user_id',$data['uid'])->first();

		if($data['f'] == 1){
			$uperm_enabled = $user_permissions->uperm_enabled.$data['permid']."|";
			$uperm_disabled = str_replace($data['permid']."|","",$user_permissions->uperm_disabled);
		}elseif($data['f']==0){
      $uperm_disabled = $user_permissions->uperm_disabled.$data['permid']."|";
      $uperm_enabled = str_replace($data['permid']."|","",$user_permissions->uperm_enabled);
		}
		$updated_row = CepUserPermissions::where('uperm_user_id',$data['uid'])->update(array('uperm_enabled'=>$uperm_enabled,'uperm_disabled'=>$uperm_disabled));
	}
}
