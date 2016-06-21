<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Validator;

use App\CepDeveloperConfigurations;

class DeveloperConfigurationController extends Controller {

	public $configs;
	public $permit;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(\Illuminate\Http\Request $request)
	{
		//
		$this->middleware('auth');
		$this->permit=$request->attributes->get('permit');
		$this->configs=$request->attributes->get('configs');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$devConfig = Request::all();
		$validate = Validator::make($devConfig,[
								'dconf_product_id' => 'required',
								'dconf_name' => 'required|max:256',
								'dconf_value' => 'required',
		]);
		if($validate->fails()){
				return redirect()->back()->withErrors($validate->errors());
		}
		CepDeveloperConfigurations::create($devConfig);
		return redirect()->back();
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
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

	/**
	* Remove the specified resource from inbox to storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function deleteDevConfig($id)
	{
		//
		CepDeveloperConfigurations::where('dconf_id',$id)->delete();
		return redirect()->back();
	}

	/**
	 * Bulk Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function bulkUpdate()
	{
		//
		$devConfigUpdate = Request::all();
		//print_r ($devConfigUpdate);
		foreach($devConfigUpdate['dconf_id'] as $key=>$dcu){
			$updateValue = array('dconf_name'=>$devConfigUpdate['dconf_name'][$key],
													 'dconf_value'=>$devConfigUpdate['dconf_value'][$key],
													 'dconf_status'=>$devConfigUpdate['dconf_status'][$key]);
			CepDeveloperConfigurations::where('dconf_id',$dcu)->update($updateValue);
		}
		return redirect()->back();
	}
}
