<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CepDownloads;
use App\CepDownloadLogs;

class DownloadLogsController extends Controller {


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
		if(!$this->permit->crud_download_logs)
						return redirect('accessDenied');
		$downloads = CepDownloads::all();
		return view("downloads.index",compact('downloads'));
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
		$download_log = CepDownloads::with('downloadlogs','userby','clientby','productname','itemname')
																	->where("download_id",$id)->first();

		$dlog = CepDownloadLogs::with('userby')->where("dlog_download_id",$id)->get();
		return count($download_log) ? view("downloads.show", compact('download_log','dlog')) : abort(404);
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
