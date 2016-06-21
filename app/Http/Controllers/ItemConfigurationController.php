<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Validator;
use App\CepItemConfigurations;

class ItemConfigurationController extends Controller {

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
		$itemConfig = Request::all();
		$validate = Validator::make($itemConfig,[
								'iconf_product_id' => 'required',
								'iconf_item_id' => 'required',
								'iconf_name' => 'required|max:256',
								'iconf_value' => 'required',
		]);
		if($validate->fails()){
				return redirect()->back()->withErrors($validate->errors());
		}
		CepItemConfigurations::create($itemConfig);
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
		//
	}

	/**
	* Remove the specified resource from inbox to storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function deleteItemConfig($id)
	{
		//
		CepItemConfigurations::where('iconf_id',$id)->delete();
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
		$itemConfigUpdate = Request::all();
		//echo "<pre>"; print_r ($itemConfigUpdate); exit;
		foreach($itemConfigUpdate['iconf_id'] as $key=>$icu){
			$updateValue = array(
													'iconf_item_id'=>$itemConfigUpdate['iconf_item_id'][$key],
													'iconf_name'=>$itemConfigUpdate['iconf_name'][$key],
													'iconf_value'=>$itemConfigUpdate['iconf_value'][$key],
													'iconf_status'=>$itemConfigUpdate['iconf_status'][$key]
													);
			CepItemConfigurations::where('iconf_id',$icu)->update($updateValue);
		}
		return redirect()->back();
	}

}
