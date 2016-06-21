<?php namespace App\Http\Controllers\Specification;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Validator;
use Carbon\Carbon;
use Auth;
use Input;

use App\CepProducts;
use App\CepModels\Specification\CepSpecificationProducts;
use App\CepModels\Specification\CepSpecificationMasters;
use App\Libraries\FileManager;

use App\CepLanguages;
use App\CepAttachmentFiles;

class ProductSpecification extends Controller {


        /**
         * Create a new controller instance.
         *
         * @return void
         */

	public function __construct(\Illuminate\Http\Request $request)
	{
             $this->middleware('auth');
             $this->permit=$request->attributes->get('permit');
    		 $this->configs=$request->attributes->get('configs');
             $this->attachment = new FileManager;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$productSpecs = CepSpecificationProducts::all();
		return view("product_specifications.index",compact('productSpecs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$ps_products = CepProducts::where("prod_status",1)->select('prod_id','prod_name')->get();
		$all_ps_products = array();
		$all_ps_products[""] = "Select";
		foreach($ps_products as $prod)
			$all_ps_products[$prod->prod_id] = $prod->prod_name;
		$alphaRange=array_combine(range('1','26'),range('A','Z'));

        $languages = CepLanguages::where('lang_status',1)->get();
		$languages_array = array();
		$languages_array[""] = "Select";
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		return view("product_specifications.create",compact('all_ps_products','alphaRange','languages_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$productSpecs = Request::all();

        $validate = Validator::make($productSpecs,[
        	                 'specprod_product_id' => 'required',
        	                 'specprod_item_id' => 'required',
        	                 'specprod_usage' => 'required',
        	                 'specprod_language_code' => 'required',
        	                 'specprod_technical_info' => 'required',
        	                 'specprod_reference_id' => 'required',
        	                 'specprod_description' => 'required',
 						     'specprod_url' => 'required|unique:cep_specification_products',
                 	]);

        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
        }

        if(Input::hasFile('files')){
            $files=Input::file('files');
            $productSpecs['specprod_attachment_id'] = $this->attachment->createAttachment(array('att_type'=>'product-specifications'));
            foreach($files as $key=>$fl){
                    //echo "<pre>"; print_r ($appointments['files'][$key]); //exit;
                    $this->attachment->uploadAttachmentFiles($fl,$productSpecs['specprod_attachment_id']);
            }
        }

		if(isset($productSpecs['universal_id']))
			$productSpecs['specprod_url'] = preg_replace('/\d+/','DD',$productSpecs['specprod_url']);

        $masterSpecs = array( 'spec_type' => 'product',
        					  'spec_created_date' => Carbon::now(),
        					  'spec_created_by' => Auth::id()
        					);

        $master = CepSpecificationMasters::create($masterSpecs);
		$productSpecs['specprod_spec_id'] = $master->spec_id;
        CepSpecificationProducts::create($productSpecs);

        return redirect('product-specifications');

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
		$ps_products = CepProducts::where("prod_status",1)->select('prod_id','prod_name')->get();
		$all_ps_products = array();
		$all_ps_products[""] = "Select";
		foreach($ps_products as $prod)
			$all_ps_products[$prod->prod_id] = $prod->prod_name;
		$alphaRange=array_combine(range('1','26'),range('A','Z'));
		$productSpecs = CepSpecificationProducts::where("specprod_id",$id)->first();

        $languages = CepLanguages::all();
		$languages_array = array();
		$languages_array[""] = "Select";
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		$prd_attachment = CepAttachmentFiles::where('attfiles_attachment_id',$productSpecs['specprod_attachment_id'])->get();
		return count($productSpecs) ? view("product_specifications.show",compact('all_ps_products','alphaRange','productSpecs','languages_array','prd_attachment')) : abort(404);
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
		$ps_products = CepProducts::where("prod_status",1)->select('prod_id','prod_name')->get();
		$all_ps_products = array();
		$all_ps_products[""] = "Select";
		foreach($ps_products as $prod)
			$all_ps_products[$prod->prod_id] = $prod->prod_name;
		$alphaRange=array_combine(range('1','26'),range('A','Z'));
		$productSpecs = CepSpecificationProducts::where("specprod_id",$id)->first();

        $languages = CepLanguages::all();
		$languages_array = array();
		$languages_array[""] = "Select";
		foreach ($languages as $language){
			$languages_array[$language->lang_code]=$language->lang_name;
		}

		$prd_attachment = CepAttachmentFiles::where('attfiles_attachment_id',$productSpecs['specprod_attachment_id'])->get();

		return count($productSpecs) ? view("product_specifications.edit",compact('all_ps_products','alphaRange','productSpecs','languages_array','prd_attachment')) : abort(404);
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

		$productSpecs = Request::only('specprod_product_id','specprod_item_id','specprod_usage','specprod_technical_info','specprod_reference_id','specprod_description','specprod_url','specprod_status','specprod_spec_id','specprod_language_code','specprod_attachment_id');
        $validate = Validator::make($productSpecs,[
        	                 'specprod_product_id' => 'required',
        	                 'specprod_item_id' => 'required',
        	                 'specprod_usage' => 'required',
        	                 'specprod_language_code' => 'required',
        	                 'specprod_technical_info' => 'required',
        	                 'specprod_reference_id' => 'required',
        	                 'specprod_description' => 'required',
 						     'specprod_url' => 'required|unique:cep_specification_products,specprod_url,'.$id.',specprod_id',
                 	]);

        if($validate->fails()){
			return redirect()->back()->withErrors($validate->errors());
        }

        if(Input::hasFile('files')){
            $files=Input::file('files');
            if($productSpecs['specprod_attachment_id'] == 0)
	            $productSpecs['specprod_attachment_id'] = $this->attachment->createAttachment(array('att_type'=>'product-specifications'));
            foreach($files as $key=>$fl){
                    //echo "<pre>"; print_r ($appointments['files'][$key]); //exit;
                    $this->attachment->uploadAttachmentFiles($fl,$productSpecs['specprod_attachment_id']);
            }
        }

        $masterSpecs = array(
        					  'spec_updated_by' => Auth::id()
        					);

        CepSpecificationMasters::where('spec_id', $productSpecs['specprod_spec_id'])->update($masterSpecs);
        CepSpecificationProducts::where('specprod_id', $id)->update($productSpecs);

        return redirect('product-specifications');
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
		if(!$this->permit->crud_general_specifications_delete)
            return redirect('accessDenied');

        	$ids = explode("-",$id);
			CepSpecificationProducts::where('specprod_id', $ids[0])->delete();
			CepSpecificationMasters::where('spec_id', $ids[1])->delete();
	        return redirect('product-specifications');
	}

}
