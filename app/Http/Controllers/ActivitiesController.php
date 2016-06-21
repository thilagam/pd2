<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use Illuminate\Http\Request;
use App\Libraries\ActivityMainLib;

class ActivitiesController extends Controller {
	
	public $activityObject;

	public function __construct(){
		$this->activityObject = new ActivityMainLib; 
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
		$activity = $this->activityObject->getActivity(Auth::id(),0);
		return view('activities.view-activities',compact('activity'));
		
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
		$value = explode("-",$id);
		$activity = $this->activityObject->getActivity(Auth::id(),$value[1],$value[0]);
		if(sizeof($activity) > 0)
			return view('snippets.addActivities',compact('activity'))->render();
		else
			return view('snippets.noMoreActivities',compact('activity'))->render();

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

}
