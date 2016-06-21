<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CepGroups;
use App\CepPermissions;
use App\CepGroupPermissions;

use Request;
use Validator;

class GroupController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Group
    |--------------------------------------------------------------------------
    |
    | CRUD Group
    |
    */

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
		$groups = CepGroups::all();
		return view("groups/index",compact('groups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view("groups/create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$group = Request::all();
                $validate = Validator::make($group,[
                            'group_name' => 'required|max:45',
                            'group_code' => 'required|unique:cep_groups|max:5',
                 ]);

                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		$groupId = CepGroups::create($group)->id;
                $permissions = CepPermissions::all();

                foreach($permissions as $permission){
                    $group_permission = array();
                    $group_permission['gp_perm_id'] = $permission->perm_id;
                    $group_permission['gp_group_id'] = $groupId;
                    $group_permission['gp_permission'] = 0;
                    $group_permission['gp_status'] = 1;
                    CepGroupPermissions::create($group_permission); // Bulk creation of group permissions on each Permission Created
                }
		return redirect("groups");
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
		$group = CepGroups::where('group_id',$id)->first();
		return count($group) ? view("groups/show", compact('group')) : abort(404);
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
		$group = CepGroups::where('group_id',$id)->first();
		return count($group) ? view("groups/edit", compact('group')) : abort(404);
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
		$groupUpdate = Request::only('group_name','group_code','group_description');
                $validate = Validator::make($groupUpdate,[
                            'group_name' => 'required|max:45',
                            'group_code' => 'required|unique:cep_groups,group_code,'.$id.',group_id|max:5',
                 ]);

                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		$group = CepGroups::where('group_id',$id)->first();
		$affectedRows = CepGroups::where('group_id','=',$id)->update($groupUpdate);
		return redirect("groups");
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
		CepGroups::where('group_id',$id)->delete();
		return redirect("groups");
	}


}
