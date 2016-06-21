<?php namespace App\Http\Controllers\Fprwd;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CepDownloads;
use DB;

class WriterController extends Controller {

	public function writer($id){

		$writerFileList = CepDownloads::where('download_product_id',$id)
						->where('download_type','=','writer')
						->select(DB::raw("date_format(download_date,'%d %M %Y') as dt,download_name,download_description,download_url,download_id"))
						->get();
		return view("product.writer",compact('writerFileList'));
	}

}
