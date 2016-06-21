<?php namespace App\Http\Controllers;

use App\CepKeywords;
use App\CepModules;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Validator;

class KeywordController extends Controller {

	public $configs;
	public $permit;
        /*
        |--------------------------------------------------------------------------
        | Keyword
        |--------------------------------------------------------------------------
        |
        | CRUD Keyword
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
		if(!$this->permit->crud_keywords)
            return redirect('accessDenied');
		$keywords=CepKeywords::with('module')->get();
		return view('keywords.index', compact('keywords'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->crud_keywords_create)
            return redirect('accessDenied');

		$modules = CepModules::all();
		$modules_array = array();
		foreach($modules as $module){
                    $modules_array[$module->mod_id] = $module->mod_name;
		}
		return view('keywords.create', compact('modules_array'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$keywords=Request::all();
                $validate = Validator::make($keywords,[
                            'kw_name' => 'required|unique:cep_keywords|max:100',
                            'kw_module_id' => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }
		CepKeywords::create($keywords);
		return redirect('keywords');
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
		if(!$this->permit->crud_keywords_read)
            return redirect('accessDenied');
		$keyword = CepKeywords::where('kw_id',$id)->first();

        $modules = CepModules::all();
		$modules_array = array();
		foreach($modules as $module){
            $modules_array[$module->mod_id] = $module->mod_name;
		}
		return count($keyword) ? view('keywords.show',compact('keyword','modules_array')) : abort(404);
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
		if(!$this->permit->crud_keywords_edit)
            return redirect('accessDenied');
		$keyword = CepKeywords::where('kw_id',$id)->first();

		$modules = CepModules::all();
		$modules_array = array();
		foreach($modules as $module){
            $modules_array[$module->mod_id] = $module->mod_name;
		}
		return count($keyword) ? view('keywords.edit',compact('keyword','modules_array')) : abort(404);
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
		$keywordUpdate = Request::only('kw_name','kw_module_id','kw_status');
		$keyword = CepKeywords::where('kw_id',$id)->first();
                $validate = Validator::make($keywordUpdate,[
                            'kw_name' => 'required|unique:cep_keywords,kw_name,'.$id.',kw_id|max:100',
                            'kw_module_id' => 'required',
                 ]);
                if($validate->fails()){
                        return redirect()->back()->withErrors($validate->errors());
                }

		$affectedRows = CepKeywords::where('kw_id', '=', $id)->update($keywordUpdate);
		return redirect('keywords');
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
		if(!$this->permit->crud_keywords_delete)
            return redirect('accessDenied');
		CepKeywords::where('kw_id',$id)->delete();
		return redirect('keywords');
	}

}
