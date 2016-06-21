<?php namespace App\Http\Controllers;

use App\CepConfigs;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Validator;

class ConfigController extends Controller {


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
		if(!$this->permit->crud_configs)
            return redirect('accessDenied');
		$configs = CepConfigs::all();
		return view("configs.index", compact("configs"));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_configs_create)
            return redirect('accessDenied');
		return view("configs.create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$config = Request::all();
		$validate = Validator::make($config,[
		    'conf_name' => 'required|unique:cep_configs|max:250',
                    'conf_value' => 'required',
                ]);
                if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
                }
		CepConfigs::create($config);
		return redirect("configs");
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
		if(!$this->permit->crud_configs_read)
            return redirect('accessDenied');
		$config = CepConfigs::where('conf_id',$id)->first();
		return count($config) ? view("configs.show", compact("config")) : abort(404);
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
		if(!$this->permit->crud_configs_edit)
            return redirect('accessDenied');
		$config = CepConfigs::where('conf_id',$id)->first();
		return count($config) ? view("configs.edit", compact("config")) : abort(404);
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
		$configUpdates = Request::only('conf_name','conf_value');
	        $validate = Validator::make($configUpdates,[
                    'conf_name' => 'required|unique:cep_configs,conf_name,'.$id.',conf_id|max:250',
                    'conf_value' => 'required',
                ]);
		if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepConfigs::where('conf_id',$id)->update($configUpdates);
		return redirect('configs');
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
		if(!$this->permit->crud_configs_delete)
            return redirect('accessDenied');
		CepConfigs::where('conf_id',$id)->delete();
		return redirect('configs');
	}

}
