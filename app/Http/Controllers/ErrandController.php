<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Input;
use Response;
use View;
use App\User;
use App\CepUserPlus;
use Crypt;
use DB;
use File;
use Cookie;
use Config;
use FTP;
use Mail;
use Storage;

use App\Libraries\FileManager;
use App\Libraries\EMailer;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

use App\Services\UploadsManager;

use App\Libraries\ProductHelper;
use App\Libraries\ClientKorben;
use App\Libraries\ExcelLib;

use Request;


class ErrandController extends Controller {

	protected $manager;
	public $permit;
	public $configs;
	public $excelobj;
	// /public $FileManager;

	public function __construct(\Illuminate\Http\Request $request)
	{
		$this->manager = new UploadsManager;
		$this->permit=$request->attributes->get('permit');
    	$this->configs=$request->attributes->get('configs');
    	//$this->FileManager = new FileManager($manager);
	}

	/**
	 * Function newProductLine
	 *
	 * @param
	 * @return
	 */
	public function newProductLine($id)
	{
		//$input = Input::all();
		/* Get Bo Users to Select incharge  */
        $bousers=User::with('userPlus')
						->where('group_id','=','243211')
						->get();
		$bouserData=array('0'=>'');
		foreach ($bousers as $key => $value) {
			$bouserData[$value->id]=($value['user_plus']['up_first_name']!='') ? ucfirst($value['user_plus']['up_first_name'])." ".ucfirst($value['userPlus']['up_last_name']): $value['name'] ;
		}
		return view('snippets.addProductLine',compact('id','bouserData'))->render();

	}

	/**
	 * Function addMailingListHelper
	 *
	 * @param
	 * @return
	 */
	public function addMailingListHelper($id)
	{
		return view('snippets.addMailingList',compact('id'))->render();
	}

	/**
	 * Function userImageUpload
	 *
	 * @param
	 * @return
	 */
	public function userImageUpload()
	{
		$file=Input::file('file');
		$name="usr_".uniqid();
		$options =array (
	 				'name'=>$name,
					'url'=> 'images/',
				 );
		$FileManager=new FileManager();
		$upload=$FileManager->simpleUplaod($file,$options);
		echo $upload;
	}


	/**
	 * Function test
	 *
	 * @param
	 * @return
	 */
	public function test()
	{




		//return view("test/index");
		//$em = new EMailer;

		//echo $em->getTemplateCode(20);


		/*Config::set('ftp.connections.newftp', array(
           'host'   => 't052.x1.fr',
           'username' => 'morgan_ep',
           'password'   => 'n$2RLR',
           'passive'   => false,
		));

		//echo config;

		$listing = FTP::connection("newftp")->getDirListing();
		//print_r ($listing);

		$listing1 = FTP::connection("newftp")->getDirListingDetailed();
		echo "<pre>"; print_r ($listing1);

		foreach($listing1 as $key=>$l1)
		    echo $key; */

		/* QRY TO GET PRODUCT USERS  */
		// $id=1515082812194318;
		// $result=DB::table('cep_product_users1')
		// 	 ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'cep_product_users.puser_group_id')
		// 	 ->leftjoin('cep_user_plus', 'cep_user_plus.up_user_id', '=', 'cep_product_users.puser_user_id')
		// 	 ->leftjoin('cep_products', 'cep_products.prod_id', '=', 'cep_product_users.puser_product_id')
	 //    ->whereIn('puser_product_id', function($query) use ($id)
	 //    {
	 //        $query->select('puser_product_id')
	 //              ->from('cep_product_users')
	 //              ->whereRaw('cep_product_users.puser_user_id = '.$id)
	 //              ->groupBy('puser_product_id');
	 //    })
	 //    ->groupBy('puser_product_id')
	 //    ->get();
	 //    echo "<pre>"; print_r($result);
		// /$folder = $request->get($this->configs->uploads_path);
		// echo $this->configs->uploads_path;
		// $folder='test';
		// //$result = $this->manager->createDirectory($folder);
  //   	$data = $this->manager->folderInfo($this->configs->uploads_path."/test");
  //   	echo "<pre>"; print_r($data);

		//$cookie = Cookie::forever('DEFAULT_LANGUAGE', 'en');
		//echo public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path."lahalle5";
		//$this->manager->createDirectory($this->configs->uploads_products_path."lahalle5");
		//chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path."lahalle5", 0777);


		//$allUsers = User::paginate(5);

		//echo $allUsers;

		//return view('test',compact('data','allUsers'));

		//echo $value = Crypt::encrypt("products/454329/pdn/5677dcd6a6620.xls");
		//echo "\n";
		//echo Crypt::decrypt($value);
		//\App:: make ('Excel');


       /*$excel = new PHPExcel;
       $file =public_path()."/uploads/test/Compo_MC_AH15_20151013.xlsx";

       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
       foreach ($cell_collection as $cell) {
         $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
         $colNumber = PHPExcel_Cell::columnIndexFromString($column);
         $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
         $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
         $arr_data[$row][$column] = $data_value;
	 		}
     print_r ($arr_data);*/

		/*$excel_lib = new ExcelLib();
		$data = $excel_lib->readExcelUniqueValue(public_path()."/uploads/test/Compo_MC_AH15_20151013.xlsx");
		//echo "<pre>"; print_r ($data); exit;
		$client = new ClientKorben;

		$options['upload_id'] = 12345;
		$options['model'] = "CepClientKorbenCchRefs";
		echo $client->referenceFileUploads($data,$options);*/

	}

	/**
	 * Function testPost
	 *
	 * @param
	 * @return
	 */
	public function testPost()
	{
		echo "<pre>"; print_r($_POST);
		echo "<pre>"; print_r($_FILES);
		// $file=Input::file('file');
		// $name=uniqid();
		// $options =array (
	 // 				'name'=>$name,
		// 			'description'=> 'some info',
		// 			'url'=> 'test/',
		// 			'client'=> '',
		// 			'product'=> '',
		// 			'item'=> ''
		// 		 );
		// $FileManager=new FileManager();
		// $upload=$FileManager->upload($file,$options);
		// if($upload){
		// 	echo "SUCCESS";
		// }else{
		// 	echo "FAIL";
		// }
	}

	public function refImport($id)
	{
      $excel_lib = new ExcelLib();
			$folder_listing = array();
			$dir = public_path()."/uploads/products/".$id."/ref/old/"; //exit;
			if ($handle = opendir($dir)) {
					while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
									$folder_listing[] = $dir.$entry;
							}
					}
					closedir($handle);
			}

			echo "<div style='height:150px;overflow:scroll;'><pre>"; print_r ($folder_listing); echo "</div>";//exit;

			$input_f = 0;
			if(Request::all()){
				$input_f_a = Request::only('f','op');
				$op = $input_f_a['op'];
				$input_f = $input_f_a['f'];
				$data = array();
				//echo $folder_listing[$input_f]; exit;
        if($input_f < sizeof($folder_listing)){
				$data = $excel_lib->readExcelUniqueValue($folder_listing[$input_f],4);
				//echo "<pre>"; print_r ($data); exit;

				echo "<h2>Data of ".intval($input_f+2)." File</h2><p>".$folder_listing[$input_f]."</p><table border='1'><tr>";
				foreach($data as $k=>$dt){
					foreach($dt as $row){
							echo "<td>".$row."</td>";
				  }
					echo "</tr>";
					if($k==3)
						break;
				}
				echo "</table><br />";
			  }

        if($op == 'y'){
					$client = new ClientKorben;
					$options['upload_id'] = 12345;
					$options['model'] = "\korben\CepClientKorbenMorganUkGens";
					$client->referenceFileUploads($data,$options,4);
				}
				echo "Imported Data of ".intval($input_f+1)." files among ".count($folder_listing)."<br />";
				echo "<a href='?f=".intval($input_f+1)."&op=y'>next</a><br />";
				echo "<a href='?f=".intval($input_f+2)."&op=n'>skip</a>";

			}else{

        $data = $excel_lib->readExcelUniqueValue($folder_listing[0],4);
				echo "<h2>Data of 1st File</h2><p>".$folder_listing[0]."</p><table border='1'><tr>";
				foreach($data as $k=>$dt){
					foreach($dt as $row){
							echo "<td>".$row."</td>";
					}
					echo "</tr>";
					if($k==6)
						break;
				}
				echo "</table><br />";
				echo "<a href='?f=".intval(0)."&op=y'>Begin</a>";
			}
	}

	public function writerImport($id)
	{
			$excel_lib = new ExcelLib();
			$folder_listing = array();
			$dir = public_path()."/uploads/products/".$id."/writer/old/"; //exit;
			if ($handle = opendir($dir)) {
					while (false !== ($entry = readdir($handle))) {
							if ($entry != "." && $entry != "..") {
									$folder_listing[] = $dir.$entry;
							}
					}
					closedir($handle);
			}

			echo "<div style='height:150px;overflow:scroll;'><pre>"; print_r ($folder_listing); echo "</div>";//exit;

			$input_f = 0;
			if(Request::all()){
				$input_f_a = Request::only('f','op');
				$op = $input_f_a['op'];
				$input_f = $input_f_a['f'];
				$data = array();
				//echo $folder_listing[$input_f]; exit;
				if($input_f < sizeof($folder_listing)){
				$data = $excel_lib->readExcelUniqueValue($folder_listing[$input_f],0);
				//echo "<pre>"; print_r ($data); exit;

				echo "<h2>Data of ".intval($input_f+2)." File</h2><p>".$folder_listing[$input_f]."</p><table border='1'><tr>";
				foreach($data as $k=>$dt){
					foreach($dt as $row){
							echo "<td>".$row."</td>";
					}
					echo "</tr>";
					if($k==3)
						break;
				}
				echo "</table><br />";
				}

				if($op == 'y'){
					$client = new ClientKorben;
					$options['upload_id'] = 54321;
					$options['model'] = "\korben\CepClientKorbenMorganUkGens";
					$client->writerFileUploads($data,$options,0);
				}
				echo "Imported Data of ".intval($input_f+1)." files among ".count($folder_listing)."<br />";
				echo "<a href='?f=".intval($input_f+1)."&op=y'>next</a><br />";
				echo "<a href='?f=".intval($input_f+2)."&op=n'>skip</a>";

			}else{

				$data = $excel_lib->readExcelUniqueValue($folder_listing[0],0);
				echo "<h2>Data of 1st File</h2><p>".$folder_listing[0]."</p><table border='1'><tr>";
				foreach($data as $k=>$dt){
					foreach($dt as $row){
							echo "<td>".$row."</td>";
					}
					echo "</tr>";
					if($k==6)
						break;
				}
				echo "</table><br />";
				echo "<a href='?f=".intval(0)."&op=y'>Begin</a>";
			}
	}
}
