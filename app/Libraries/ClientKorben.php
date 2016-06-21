<?php namespace App\Libraries;

use Auth;
use request;
use Carbon\Carbon;
use File;
use DB;

use App\CepUploads; 
use App\CepDownloads;
use App\CepDownloadLogs;
use App\ClientModels\CepClLahalleShoeGen;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Services\UploadsManager;


/**
* Lahalle class used for Processing lahale client logic
*
*/
class ClientKorben
{
  /**
	 * Function referenceFileUploads
	 * insert new references to the DB no duplicate
	 * @param array $data
   * @param array $options
	 * @return
	 */
	public function referenceFileUploads($data,$options,$col=0)
	{
      //$options['model'] = '\CepClientKorbenCchRefs';
			$model = "\App\ClientModels".$options['model'];
			$fields = with(new $model)->getFillable();
			$dataNew = array();
			unset($data[0]);
		  foreach($data as $key=>$dt){
			 		$dataNew[] = array(
													 $fields[0]=>$dt[$col],
													 $fields[1]=>json_encode($dt),
													 $fields[2]=>$options['upload_id']
													);
			 }
			return ($model::insertIgnore($dataNew) ? true : false);
  }

	/**
	 * Function writerFileUploads
	 * insert new references to the DB no duplicate
	 * @param array $data, $option, $col(reference column), $url(sheet column 1 or 2 mostly)
   * @param array $options
	 * @return
	 */
	public function writerFileUploads($data,$options,$col=0,$url=2)
	{
      //$options['model'] = '\CepClientKorbenCchRefs';
			$model = "\App\ClientModels".$options['model'];
			$fields = with(new $model)->getFillable();
			//print_r ($fields); exit;
			$dataNew = array();
			unset($data[0]);
		  foreach($data as $key=>$dt){
			 		$dataNew[] = array(
													 $fields[0]=>$dt[$col],
													 $fields[1]=>$dt[$url],
													 $fields[2]=>0,
													 $fields[3]=>json_encode($dt),
													 $fields[4]=>$options['upload_id']
													);
			 }
			return ($model::insertIgnore($dataNew) ? true : false);
  }

	/**
	 * @Sheel-Script
	 * Function ftpImageCheck -> Type
	 * check image on ftp and return url or None
	 * @param $product_id
   * @param $reference_id
	 * @return
	 */
	public function ftpImageCheck($product_id,$reference_id)
	{
		$cmd = "find ".public_path()."/uploads/products/".$product_id."/ftp/ -iname ".$reference_id."\* | wc -l";
		return shell_exec($cmd);
	}
}
