<?php namespace App\Http\Controllers\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/* Models */		
use App\CepProducts;
use App\CepProductUsers;
use App\CepProductFtp;
use App\CepProductConfigurations;
use App\CepProductMailingList;
use App\CepItems;
use App\CepUploads;

/* FACADES */		
use DB;
use Validator;
use Auth;
use Input;  
//use Request;
use Crypt;
use Config;
use FTP;
use Log;
use File;
use Storage;



/* Services */		
use App\Services\UploadsManager;

/* Libraries */		
use App\Libraries\FileManager; 
use App\Libraries\ActivityMainLib;
use App\Libraries\CheckAccessLib;
use App\Libraries\ProductHelper;
use App\Libraries\ClientLahalle;
use App\Libraries\ExcelLib;


class LahalleController extends Controller 
{

	public $permissions;
	public $configs;
	public $dictionary;

	private $manager;
    private $activityObject;
    private $checkaccess;
    private $productHelper;
    private $ClientLahalle;
	/**
     * Instantiate a new UserController instance.
     */
    public function __construct(\Illuminate\Http\Request $request)
    {	
    	$this->middleware('auth');
    	
    	$this->permit=$request->attributes->get('permit');
    	$this->configs=$request->attributes->get('configs');
    	$this->dictionary=$request->attributes->get('dictionary');

    
    	$this->activityObject = new ActivityMainLib;
    	$this->checkaccess = new CheckAccessLib;
    	$this->productHelper = new ProductHelper;

    	$this->ClientLahalle = new ClientLahalle;
    	
    }

	/**
	 * Function shoeGen
	 *
	 * @param
	 * @return
	 */		
	public function shoeGen($file)
	{	
		$globalParentsData;
		$globalParentsDataFile; 
		$globalParentsXlsFile;
		//echo $file;
		$excel = new ExcelLib;
		$FileManager= new FileManager;
		$productHelper=new ProductHelper;
      	/* Get File And Read data */		
      	$uploadInfo=$FileManager->getUploadInfo($file);
      	
      	$file =public_path()."/uploads/".$uploadInfo['upload_url'];
      	//echo $file;
      	$datas=$excel->readExcel($file);
      	//echo "<pre>"; print_r($datas);exit;
      	/* Get Old Written References */		
		$written=$this->ClientLahalle->globalUniqueShoeGenRefs();

		$globalParentsData=$written[0];
        $globalParentsDataFile=$written[1];
        $globalParentsXlsFile=$written[2];
        
        /* Get FTP info */		
        $ftp=$this->productHelper->getProductFtpInfo($uploadInfo['upload_product_id'],true);

        /* Check New References in Old for doublons and images */	
        $alphaRange=array_combine(range('1','26'),range('A','Z'));		
        $dblnArr = array() ;
        $sheetcount = 1;
        $doubref=15;

       // $pattern = public_path()."/uploads/".$ftp['ftp_path'].'/*/052014-*.*';
        //echo $pattern;
        //$arraySource = glob($pattern,GLOB_BRACE);
       // echo "<pre>"; print_r($arraySource);exit;

      // 	echo "<pre>"; print_r($datas);exit;
       	$datas=array($datas);
       	$newData=array();
        foreach ($datas as $xlsArr)
        {
            $key = 0 ;
            //echo "<pre>"; print_r($xlsArr);exit;
            foreach ( $xlsArr as $col ) 
            {	
            	$xls=0;
            	$ref=1;
				//if($key==$xls)
				//$datas[$sheetcount-1][$key]['A'] = "Url" ;
				//
				// processing rows - excluding header
                if($key>$xls)
                {	

                	$arraySource=array();
                    $col_ref = trim($col[$ref]);
                    $doub_ref=trim($col[$doubref]);
                    $pattern = public_path()."/uploads/".$ftp['ftp_path'].'/*/'.$col_ref.'*.*';
                   //$pattern = $ftp['ftp_path'].'/*/'.$col_ref.'_*.*';
                    //echo $pattern;
                    $arraySource = glob($pattern,GLOB_BRACE);
                    sort($arraySource);
                   	// if($col_ref==7163000103){
                    // 	echo $pattern;
                    //  	echo "<pre>"; print_r($arraySource);exit;
                    //  }
                    //echo $col_ref;exit;
                    if(count($arraySource)>0)
                    {
                        $path = pathinfo($arraySource[0]) ;
                        
                        if(!in_array($doub_ref, $globalParentsData))
                        {
                            $datas[$sheetcount-1][$key+1][0] = $ftp['ftp_path'] ."/". $col_ref ;
                            if(!in_array($doub_ref, $globalParentsData)){
                            	 $newData[]=$datas[$sheetcount-1][$key+1];
                            }
                            $globalParentsData[]=$doub_ref;
                            //echo "<pre>"; print_r($globalParentsData);
                            $globalParentsXlsFile[$doub_ref]=$doub_ref;//$key+1;
                            
                            
                           
                        }
                        elseif(in_array($doub_ref, $globalParentsData))
                        {
							$doubfile=($globalParentsXlsFile[$doub_ref])? basename($globalParentsXlsFile[$doub_ref]): 'filename_error' ;
                            $datas[$sheetcount-1][$key+1][0] = 'Doublon-'.$doubfile ;
                            $datas[$sheetcount-1][$key+1][2] = 'DOUBLON';
                        }
				    }
                    else
                    {
                        $datas[$sheetcount-1][$key+1][0] = 'NA';
                        $pdct_id = '';
                    }
            	}
            	$key++;
           	}
            $sheetcount++;
        }
        
        /* Get Writer config info  */		
      	$writerConf=$this->productHelper->checkwriterAvailable($uploadInfo['upload_product_id'],true);
      	
      	/* Update new data in Database and Write writer file at writer path */	
      	/* Get Write Path */		
      	$WriterInfo=$productHelper->checkwriterAvailable($uploadInfo['upload_product_id'],true);
      	
      	$fileName1 = uniqid() ."_".date('y-m-d')."_la-halle_shoe.xlsx" ;
    	$filePath1 = public_path()."/uploads/".$WriterInfo['pconf_path'] ;
    	

      	$excel->writeExcel($datas[0],$filePath1. $fileName1);	
      	/* Download entry Prepaarations and Entry*/
      	$productInfo=$productHelper->checkProductExists($WriterInfo['pconf_product_id']);
      	
      	$dwdoptions=array(
      				'name'=>basename($fileName1),
      				'type'=>'writer',
      				'client'=>$productInfo->client_id,
      				'product'=>$WriterInfo['pconf_product_id'],
      				'item'=>$WriterInfo['pconf_item_id'],
      				'path'=>$filePath1,
      				'description'=>'Writer file generated'
      			);
      	
      	$FileManager->downloadInitiated($dwdoptions);		

      	
      	/* Update new references to DB */		
  	    $options=array(
            'lahalleShoeImagePath'=>public_path()."/uploads/".$ftp['ftp_path'],
            'lahalleShoeUrl'=>url('product/'.$uploadInfo['upload_product_id'].'/ftp/')
            );
      	$status=$this->ClientLahalle->updateNewShoeGenRefs($newData,$filePath1.$fileName1,$options);
      	if($status['flag']){
      		return redirect("product/writer/".$WriterInfo['pconf_product_id'])->with('success', 'Writer file Generated Successfully ');
      	}else{
      		return redirect("product/writer/".$WriterInfo['pconf_product_id'])->with('customError', 'Writer file Generation failed');
      	}
	}

	/**
	 * Function shoeGen
	 *
	 * @param
	 * @return
	 */		
	public function clothGen($file)
	{
		
	}
}