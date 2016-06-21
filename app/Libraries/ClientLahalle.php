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
class ClientLahalle 
{
	

	/**
	 * Function updateNewGenRefs
	 * update new generated references to the DB
	 * @param array $data
	 * @param string $generatedFile
	 * @param array $options
	 * @return
	 */
	public function updateNewShoeGenRefs($data,$generatedFile,$options)
	{
		if(empty($data) || $generatedFile=='' || empty($options))
		{
			return false;
		}
		/* Get Generated file information to add in DB */
		$fileinfo=pathinfo($generatedFile);
		$filetime= date("Y-m-d H:i:s", filemtime($generatedFile));
		$filename=$fileinfo['filename'];

		$localRefArr=array();
		$localdoup=array();
		$insertArr=array();
		$gen_array=array();
		$status=array();
		//echo "<pre>"; print_r($data);
		foreach ($data as $key => $value)
		{

			if(!empty($value) && $key!=0)
			{	
				//echo $options['lahalleShoeImagePath'] . "/*/".$value[1] . "*{*.jpg,*.jpeg,*.JPG,*.JPEG}";exit;
				$image=glob($options['lahalleShoeImagePath'] ."/*/". $value[1] . "*{*.jpg,*.jpeg,*.JPG,*.JPEG}", GLOB_BRACE);//$this->glob_files(TRUFFAUT_IMAGE_PATH,$reference, 0 ,3);
				if(empty($image)){
					$reference=str_pad($value[1], 5, '0', STR_PAD_LEFT);
					$image = glob($options['lahalleShoeImagePath'] . "/[0]" . $reference . "{*.jpg,*.jpeg,*.JPG,*.JPEG}", GLOB_BRACE);
				}
				//echo "<pre>IMAGE : "; print_r($image);exit;
				$localRefArr[]=$value[16];
				$row['image']=count($image);
				$row['folder']=basename(dirname($image[0]));
				$row['url']= $options['lahalleShoeUrl'].'/view-pictures.php?r=' . $value[2] ;

				$row=array('data'=>$value,'image'=>$row['image'],'url'=>$row['url'],'folder'=>$row['folder']);
				//echo "<pre>"; print_r($row);exit;
				/* Gen array to insert in db */

				$gen_temp=array();
				$gen_temp[]='NULL';
				$gen_temp[]=$row['data'][15];
				$gen_temp[]=$row['data'][1];
				if(isset($row['data'][17]) && $row['data'][17]=='long')
				{
					$gen_temp[]=1;
				}
				else
				{
					$gen_temp[]=0;
				}

				//$gen_temp[]='NULL';
				$gen_temp[]=$row['url'];
				$gen_temp[]=$row['folder'];
				$gen_temp[]=$row['image'];
				$gen_temp[]= $filetime;
				$gen_temp[]='NULL';
				//Serialise writer data for future usage
				$gen_temp[]=serialize($row);
				$gen_temp[]=$fileinfo['basename'];
				$gen_temp[]=0;

				$gen_temp[]=$filetime;
				$gen_temp[]=1;
				//echo "<pre>"; print_r($gen_temp);exit;
				$gen_array[]=$gen_temp;
			}
		}

		//echo "<pre>"; print_r($gen_array);	exit;
		
		if(!empty($gen_array))
		{
			$sql='';
			$shard=0;
			$shardSize = 500;
			foreach($gen_array as $key => $value){
				if ($shard % $shardSize == 0) {
					if ($shard != 0) {
						//mysqy_query($sql);
						$sql=rtrim($sql,',');
						//echo "<br />".$sql."<br />";
						if(DB::insert($sql)){
							$status['success']="Records Inserted";
							$status['flag']=true;
						}else{
							$status['error']="records not Inserted";
							$status['flag']=false;
						}
					}
					$sql = "INSERT INTO `cep_cl_lahalle_shoe_gen`(`lahs_id` ,`lahs_nomod`,`lahs_reference`,`lahs_descriptif`  ,`lahs_file_url` ,`lahs_reference_folder` ,`lahs_ref_image_count` ,`lahs_create_date` ,`lahs_created_by` ,`lahs_data`,`lahs_export_filename` ,`lahs_export_status` ,`lahs_export_date` ,`lahs_status`) VALUES ";
				}
				//$newRef[]=$row[$ref];
				$sql.=" (NULL, '".$value[1]."', '".$value[2]."', '".$value[3]."', '".$value[4]."', '".$value[5]."', '".$value[6]."', '".$value[7]."', NULL,'".$value[9]."','".$value[10]."', '0' ,'".$value[12]."', '1'),";
				$shard++;
				//echo $sql;exit;
			}
			//Insert Last set of Batch
			$sql=rtrim($sql,',');
			if($sql!=''){
			$sql=rtrim($sql,',');
				if(DB::insert($sql)){
					$status['success']="Records Inserted";
					$status['flag']=true;
				}else{
					$status['error']="Records not Inserted";
					$status['flag']=false;
				}
			}

			//echo "<pre>"; print_r($status);exit;

			return $status;
		}

	}

	/**
	* Function globalUniqueGenRefs get
	* function used to get references from GEN REF table
	*
	* @package clientsEditPlace
	* @author Vinayak
	* @retuen array $rows
	*/
	function globalUniqueShoeGenRefs(){
		
		$global_parents_data=array();
		$global_parents_data_file=array();
		$global_parents_xls_file=array();
		$genData=CepClLahalleShoeGen::select('lahs_nomod','lahs_reference','lahs_reference_folder','lahs_export_filename')
									  ->where('lahs_status','=',1)->get();
		
		//echo "<pre>"; print_r($genData);
		foreach ($genData as $key => $value) {
			$global_parents_data[]=$value['lahs_nomod'];
			$global_parents_data_file[$value['lahs_nomod']]=$value['lahs_reference'];
			$global_parents_xls_file[$value['lahs_nomod']]=$value['lahs_export_filename'];
		}
			
		
		//$res=mysql_fetch_array($res);
		return array($global_parents_data,$global_parents_data_file,$global_parents_xls_file);
	}

}