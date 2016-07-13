<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use Validator;
use App\CepBreadcrumbs;
use App\CepModules;
use App\CepKeywords;

class BreadcrumbController extends Controller {

	public $configs;
	public $permit;
	public $breadcrumbs;
	public $modules_array;
	public $modules;
	public $validate;
	public $breadcrumbUpdate;
	/*
	|--------------------------------------------------------------------------
	| Breadcrumb
	|--------------------------------------------------------------------------
	|
	| Define all Breadcrumb Setting here
	|
	*/

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
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(!$this->permit->crud_breadcrumbs)
            return redirect('accessDenied');
		$this->breadcrumbs = CepBreadcrumbs::with('modules')->get();
		//return view('breadcrumbs.index',compact('breadcrumbs'));
		return view('breadcrumbs.index')->with(array('breadcrumbs'=>$this->breadcrumbs));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_breadcrumbs_create)
            return redirect('accessDenied');
		/*$modules_array = CepModules::where('mod_status',1)->get();
		$modules = array();
		$modules[""] = "Select";
		foreach($modules_array as $mod)
			$modules[$mod->mod_id] = $mod->mod_name;
		return view('breadcrumbs.create',compact('modules'));*/
		$this->modules_array = CepModules::where('mod_status',1)->lists('mod_name','mod_id');
		return view('breadcrumbs.create')->with(array('modules'=>$this->modules_array));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$this->breadcrumbs = Request::all();
		$this->breadcrumbs['breadcrumb_url'] = preg_replace('/\d+/','DD',$this->breadcrumbs['breadcrumb_url']);
                $this->validate = Validator::make($this->breadcrumbs,[
                            'breadcrumb_module_id' => 'required',
			    			'breadcrumb_page_title' => 'required',
			    			'breadcrumb_name' => 'required',
			    			'breadcrumb_description' => 'required',
                            'breadcrumb_url' => 'required|unique:cep_breadcrumbs',
                 ]);
		 if($this->validate->fails()){
			return redirect()->back()->withErrors($this->validate->errors());
                 }
		//exit;
		CepBreadcrumbs::create($this->breadcrumbs);

		/* Start Create Keywords */
		//CepKeywords::create(array('kw_name'=>$breadcrumbs['breadcrumb_page_title'],'kw_module_id'=>$breadcrumbs['breadcrumb_module_id']));
		//CepKeywords::create(array('kw_name'=>$breadcrumbs['breadcrumb_name'],'kw_module_id'=>$breadcrumbs['breadcrumb_module_id']));
		//CepKeywords::create(array('kw_name'=>$breadcrumbs['breadcrumb_description'],'kw_module_id'=>$breadcrumbs['breadcrumb_module_id']));
		/* Close Create Keywords */

		return redirect('breadcrumbs');
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
		if(!$this->permit->crud_breadcrumbs_read)
            return redirect('accessDenied');
			$this->breadcrumb = CepBreadcrumbs::where('breadcrumb_id',$id)->first();
      $this->modules = CepModules::where('mod_status',1)->get();
      //return count($breadcrumb) ? view('breadcrumbs.show',compact('breadcrumb','modules')) : abort(404);
      return count($this->breadcrumb) ? view('breadcrumbs.show')->with(array('breadcrumb'=>$this->breadcrumb,'modules'=>$this->modules)) : abort(404);
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
		if(!$this->permit->crud_breadcrumbs_edit)
            return redirect('accessDenied');
        $this->breadcrumb = CepBreadcrumbs::where('breadcrumb_id',$id)->first();
        /*$modules_array = CepModules::where('mod_status',1)->get();
        $modules_l[""] = "Select";
        foreach($modules_array as $mod)
            $modules_l[$mod->mod_id] = $mod->mod_name;
        //		print_r ($modules_l);
        return count($breadcrumb) ? view('breadcrumbs.edit',compact('breadcrumb','modules_l')) : abort(404);*/
        $this->modules_array = CepModules::where('mod_status',1)->lists('mod_name','mod_id');
        return count($this->breadcrumb) ? view('breadcrumbs.edit')->with(array('breadcrumb'=>$this->breadcrumb,'modules_l'=>$this->modules_array)) : abort(404);

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
                $this->breadcrumbUpdate=Request::only('breadcrumb_module_id','breadcrumb_name','breadcrumb_name','breadcrumb_description','breadcrumb_page_title','breadcrumb_url');
		$this->breadcrumb = CepBreadcrumbs::where('breadcrumb_id', $id)->first();
                $this->validate = Validator::make($this->breadcrumbUpdate,[
                            'breadcrumb_module_id' => 'required',
			    'breadcrumb_name' => 'required',
			    'breadcrumb_description' => 'required',
			    'breadcrumb_page_title' => 'required',
                            'breadcrumb_url' => 'required|unique:cep_breadcrumbs,breadcrumb_url,'.$id.',breadcrumb_id',
                 ]);
                if($this->validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
	        $affectedRows = CepBreadcrumbs::where('breadcrumb_id', '=', $id)->update($this->breadcrumbUpdate);
	        return redirect('breadcrumbs');
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
		if(!$this->permit->crud_breadcrumbs_delete)
            return redirect('accessDenied');
		CepBreadcrumbs::where('breadcrumb_id', $id)->delete();
	        return redirect('breadcrumbs');
	}

}
