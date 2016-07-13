<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CepActivityTypes;

//use Illuminate\Http\Request;
use Request;
use Validator;

class ActivityTypeController extends Controller {

	public $configs;
	public $permit;
	public $activity_type;
	public $validate;
	public $activityTypeUpdate;
	public $language;
	/*
	|--------------------------------------------------------------------------
	| Config
	|--------------------------------------------------------------------------
	|
	| Define all Activity Type Setting here
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
		if(!$this->permit->crud_activity_types)
            return redirect('accessDenied');
		$this->activity_type = CepActivityTypes::all();
		//return view('activities.index',compact('activity_type'));
		return view('activities.index')->with(array('activity_type'=>$this->activity_type));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_activity_types_create)
            return redirect('accessDenied');
        return view('activities.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$this->activity_type=Request::all();
                $this->validate = Validator::make($this->activity_type,[
                            'acttype_name' => 'required|unique:cep_activity_types',
 			    'acttype_description' => 'required',
			    'acttype_icon' => 'required',
                 ]);

                if($this->validate->fails()){
			return redirect()->back()->withErrors($this->validate->errors());
                }
  		CepActivityTypes::create($tis->activity_type);
		return redirect('activity-types');
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
		if(!$this->permit->crud_activity_types_read)
            return redirect('accessDenied');
        $this->activity_type = CepActivityTypes::find($id);
        return count($this->activity_type) ? view('activities.show')->with(array('activity_type'=>$this->activity_type)) : abort(404);
        //return count($activity_type) ? view('activities.show',compact('activity_type')) : abort(404);
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
		if(!$this->permit->crud_activity_types_edit)
            return redirect('accessDenied');

        $this->activity_type = CepActivityTypes::find($id);
        //return count($activity_type) ? view('activities.edit',compact('activity_type')) : abort(404);
        return count($this->activity_type) ? view('activities.edit')->with(array('activity_type'=>$this->activity_type)) : abort(404);
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
    	        $this->activityTypeUpdate=Request::only('acttype_name','acttype_description','acttype_icon','acttype_status');
				$this->language = CepActivityTypes::where('acttype_id', $id)->first();
                $this->validate = Validator::make($this->activityTypeUpdate,[
                            'acttype_name' => 'required|unique:cep_activity_types,acttype_id,'.$id.',acttype_id',
                            'acttype_description' => 'required',
                            'acttype_icon' => 'required',
                 ]);
                if($this->validate->fails()){
                        return redirect()->back()->withErrors($this->validate->errors());
                }
	        $affectedRows = CepActivityTypes::where('acttype_id', '=', $id)->update($this->activityTypeUpdate);
	        return redirect('activity-types');
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
		if(!$this->permit->crud_activity_types_delete)
            return redirect('accessDenied');
		CepActivityTypes::where('acttype_id', $id)->delete();
	        return redirect('activity-types');
	}

}
