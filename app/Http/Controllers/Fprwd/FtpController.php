<?php namespace App\Http\Controllers\Fprwd;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Crypt;

class FtpController extends Controller {

	/**
	 * Function ftp
	 *
	 * @param
	 * @return
	 */		
    public function viewReference($id){
        $product_id = $id;
		$reference_listing = array();
		$folder_listing = array();
        $dir = public_path()."/uploads/products/".$id."/ftp/";
		if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
            		$folder_listing[] = $entry;
        		}
    		}
    		closedir($handle);
		}

		$data = Request::all();
		$folder_show = "";
		if(empty($data))
			$folder_show = $folder_listing[0];
		else
			$folder_show = $data['f'];

		$dir = public_path()."/uploads/products/".$id."/ftp/".$folder_show."/";
		if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
            		$part = explode("_",$entry);
            		if(!in_array($part[0],$reference_listing))	
            			$reference_listing[] = $part[0];
        		}
    		}
    		closedir($handle);
		}

		//echo "<pre>"; print_r($reference_listing); exit;
		return view("product.reference", compact('folder_listing','reference_listing','product_id','folder_show'));
	}


	/**
	 * Function ftp
	 *
	 * @param
	 * @return
	 */		

	public function viewReferenceImage($id){

		$product_id = "";
		$folder_show = "";
		$images_show = "";

//		try{
			$product_id = Crypt::decrypt($id);
			$data = Request::all();
			$folder_show = "";
			if(empty($data))
				return redirect('accessDenied');
			else{
				$folder_show = Crypt::decrypt($data['f']);
				$images_show = Crypt::decrypt($data['r']);
			}
//		}catch(DecryptException $e){ return redirect('accessDenied');  } 	

		$reference_listing = array();
		$dir = public_path()."/uploads/products/".$product_id."/ftp/".$folder_show."/";		//exit;
		
		try{
		 if ($handle = opendir($dir)) {
 		   while (false !== ($entry = readdir($handle))) {
        		if ($entry != "." && $entry != "..") {
					$part = explode("_",$entry);
					//echo $part[0]." ".$part[1]."<br />";
            		if(strcmp($part[0],$images_show) == 0){
            			$reference_listing1['ref_path'] = "/uploads/products/".$product_id."/ftp/".$folder_show."/".$entry;
            			$reference_listing1['ref_id'] = $entry;
            			$reference_listing[] = $reference_listing1;
            		}	
        		}
    		}
    		closedir($handle);
    	 }
    	}catch(Exception $e){ return redirect('accessDenied');  } 

		//print_r ($reference_listing); exit;
    	if(empty($reference_listing))
			return redirect('404'); // Stop hacking and stop entrying wrong data and redirect to 404 page.

			return view("product.reference_image",compact('product_id','reference_listing','images_show','product_id'));
	}

	/**
	 * Function ftp
	 *
	 * @param
	 * @return
	 */		
	public function ftpImageView($id)
	{	
			$product_id = $id;
			$data = Request::all();
			$folder_show = "";
			$images_show = "";
			if(empty($data))
				return redirect('accessDenied');
			else{
				echo $folder_show = $data['f'];
				echo $images_show = $data['r'];
			}
			//exit;
			return redirect('/product/ftp/'.Crypt::encrypt($product_id).'/images/?f='.Crypt::encrypt($folder_show).'&r='.Crypt::encrypt($images_show));
	}

}
