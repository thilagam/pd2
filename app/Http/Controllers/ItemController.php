<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use App\CepItems;
use Validator;
use App\CepProductConfigurations;
use DateTime;
use Auth;

/* Services */
use App\Services\UploadsManager;

/* Libraries */
use App\Libraries\FileManager; 

class ItemController extends Controller {

	public $configs; 
	private $manager;
  
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
    	$this->configs=$request->attributes->get('configs');
    	
    	$this->manager=new UploadsManager;
    	
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		 $id = Request::all(); 
		 $item_product_id = $id['pid'];
		 return view("product.items_create",compact('item_product_id'))->render();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$dt = new DateTime();
		
		$items = Request::only('item_product_id','item_name','item_info','item_url');

		$item_prod_conf = explode("_",$items['item_name']);
		$items['item_created_by'] = Auth::id();
		$items['item_create_date'] = $dt->format('Y-m-d H:i:s');
		$validate = Validator::make($items,[
                'item_product_id' => 'required',
 			    'item_name' => 'required',
			    'item_info' => 'required',
			    'item_url'	=> 'required',
                 ]);		
	    if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
	    }
		
        $items_config = Request::only('ref_file','pconf_path','pconf_reference_id'); 
        $items_config_i = Request::only('pconf_path','pconf_reference_id');

		if($items_config['ref_file']){
            $items_config_i['pconf_product_id'] = $items['item_product_id'];
            $items_config_i['pconf_type'] = $item_prod_conf[1];
            $items_config_i['pconf_created_by'] = Auth::id();
            $items_config_i['pconf_create_date'] = $dt->format('Y-m-d H:i:s');

			$validate = Validator::make($items_config_i,[
                        'pconf_product_id' => 'required',
                        'pconf_path' => 'required',
		                //'pconf_reference_id' => 'required',
                 ]);
	        if($validate->fails()){
	    	        return redirect()->back()->withErrors($validate->errors());
	    	}
		}
		$newItem = CepItems::Create($items);
        if($items_config['ref_file'])
        {
			$items_config_i['pconf_item_id'] = $newItem->item_id;
			CepProductConfigurations::Create($items_config_i);
		}
	    /* Create FTP folder in product folder */
	    $id=$items['item_product_id'];
	    $item=explode('_', $items['item_name']);
		$this->manager->createDirectory($this->configs->uploads_products_path.$id."/".$item[1]);
        chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$id."/".$item[1], 0777);
   
		return redirect()->back();			

	}

	/**
	 * Update status for specified resource.
	 *
	 * @param  int  $id (item_id + pconf_id)
	 * @return Response
	 */
	public function show($id)
	{
		//
		$id = explode("-",trim($id));
		CepItems::where('item_id',$id[0])->update(array('item_status'=>0));
		if(isset($id[1]))
			CepProductConfigurations::where('pconf_id',$id[1])->update(array('pconf_status'=>0));

		return redirect()->back();
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
		$item = CepItems::leftjoin('cep_product_configurations','item_id','=','pconf_item_id')
				 ->where('item_id',$id)
				 ->first();
		$ref_file = isset($item->pconf_id) ? 1 : 0; 
		return view("product.items_edit",compact('item','ref_file'))->render();	
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
                $items = Request::only('item_product_id','item_name','item_info','item_url');
                $item_prod_conf = explode("_",$items['item_name']);

                $items['item_updated_by'] = Auth::id();
                $validate = Validator::make($items,[
                            'item_product_id' => 'required',
                            'item_name' => 'required',
                            'item_info' => 'required',
                            'item_url'  => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
             
                $items_config = Request::only('ref_file','pconf_path','pconf_reference_id');
                $items_config_i = Request::only('pconf_path','pconf_reference_id','pconf_id');

			if($items_config['ref_file']){
                        $items_config_i['pconf_product_id'] = $items['item_product_id'];
                        $items_config_i['pconf_type'] = $item_prod_conf[1];
			if(empty($items_config_i['pconf_id'])){
				            $dt = new DateTime();
                        	$items_config_i['pconf_created_by'] = Auth::id();
                        	$items_config_i['pconf_create_date'] = $dt->format('Y-m-d H:i:s');
			}else{
                                $items_config_i['pconf_updated_by'] = Auth::id();
			}

                        $validate = Validator::make($items_config_i,[
                            'pconf_product_id' => 'required',
                            'pconf_path' => 'required',
                            //'pconf_reference_id' => 'required',
                         ]);
                        if($validate->fails()){
                                return redirect()->back()->withErrors($validate->errors());
                        }
                }

			//echo "<pre>"; print_r ($items_config_i); exit;

		$newItem = CepItems::where('item_id',$id)->update($items);
                if($items_config['ref_file']){
                        $items_config_i['pconf_item_id'] = $id;
                        if(empty($items_config_i['pconf_id']))
				CepProductConfigurations::Create($items_config_i);
			else
                                CepProductConfigurations::where('pconf_id',$items_config_i['pconf_id'])->update($items_config_i);
		
                }

                return redirect()->back();

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
