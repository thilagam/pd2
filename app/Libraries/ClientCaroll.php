<?php namespace App\Libraries;

use Auth;
use request;
use Carbon\Carbon; 
use File;
use DB;

use App\CepUploads;
use App\CepDownloads;
use App\CepDownloadLogs;

use App\ClientModels\CepClientCarollGen;
use App\ClientModels\CepClientCarollPdn;
use App\ClientModels\CepClientCarollRef;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Services\UploadsManager;
/**
* Lahalle class used for Processing lahale client logic 
* 
*/
class ClientCaroll 
{
	/**
	 * Function updateNewGenRefs
	 * update new generated references to the DB
	 * @param array $data
	 * @param string $generatedFile
	 * @param array $options
	 * @return
	 */
	public function updateNewGenRefs($data,$generatedFile,$options)
	{

	}

	/**
	 * Function updateNewPdnRefs
	 * updates PDN references in DB 
	 *
	 * @param array $data 
	 * @param array $options 
	 * @return
	 */		
	public function updateNewPdnRefs($data,$options)
	{
		
	}

	/**
	 * Function updateNewRefRefs
	 *
	 * @param
	 * @return
	 */		
	public function updateNewRefRefs($data,$options)
	{
		
	}
}