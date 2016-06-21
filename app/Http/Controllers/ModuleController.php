<?php namespace App\Http\Controllers;

use App\CepModules;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Validator;

class ModuleController extends Controller {

	public $configs;
	public $permit;

        /*
        |--------------------------------------------------------------------------
        | Module
        |--------------------------------------------------------------------------
        |
        | CRUD Module
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
		if(!$this->permit->crud_modules)
            return redirect('accessDenied');
		$modules = CepModules::all();
		return view('modules.index', compact('modules'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_modules_create)
            return redirect('accessDenied');
		return view('modules.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$module = Request::all();
                $validate = Validator::make($module,[
                            'mod_name' => 'required|max:45',
                            'mod_url' => 'required|unique:cep_modules|max:100',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepModules::create($module);
		return redirect('modules');

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
		if(!$this->permit->crud_modules_read)
            return redirect('accessDenied');
		    $module=CepModules::where('mod_id', $id)->first();
        return count($module) ? view('modules.show',compact('module')) : abort(404);
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
		if(!$this->permit->crud_modules_edit)
            return redirect('accessDenied');
		    $module=CepModules::where('mod_id',$id)->first();
        return count($module) ? view('modules.edit', compact('module')) : abort(404);
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
		$moduleUpdate=Request::only('mod_name','mod_url');
		$module=CepModules::where('mod_id',$id)->first();
		$validate = Validator::make($moduleUpdate,[
                            'mod_name' => 'required|max:45',
                            'mod_url' => 'required|unique:cep_modules,mod_url,'.$id.',mod_id|max:100',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		$affectedRows = CepModules::where('mod_id', '=', $id)->update($moduleUpdate);
		return redirect('modules');
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
		if(!$this->permit->crud_modules_delete)
            return redirect('accessDenied');
		CepModules::where('mod_id', $id)->delete();
		return redirect('modules');
	}

}
