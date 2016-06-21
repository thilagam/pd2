<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CepUploads;
use App\CepUploadLogs;

class UploadLogsController extends Controller {

	public $configs;
	public $permit;
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
		//echo ($this->permit->crud_upload_logs); exit;
		if(!$this->permit->crud_upload_logs)
						return redirect('accessDenied');
		$uploads = CepUploads::all();
		return view("uploads.index",compact('uploads'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return redirect('upload-logs');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
				return redirect('upload-logs');
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
		if(!$this->permit->crud_upload_logs_view)
						return redirect('accessDenied');
		$upload = CepUploads::with('uploadlogs','userby','verifyby')->where("upload_id",$id)->first();
		$comparedArray = array();
		if(isset($upload->uploadlogs->uplog_logs))
			$comparedArray = json_decode($upload->uploadlogs->uplog_logs, true);
			//print_r ($upload); exit;
		return count($upload) ? view("uploads.show",compact('upload','comparedArray')) : abort(404);
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
				return redirect('upload-logs');
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
				return redirect('upload-logs');
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
				return redirect('upload-logs');
	}

}
