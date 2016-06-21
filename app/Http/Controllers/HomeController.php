<?php namespace App\Http\Controllers;


use Auth;
use App\User;
use App\CepProducts;
use App\CepItems;
use App\CepDownloads;
use App\CepUploads;

use DB;
use Cookie;

use App\Libraries\ProductHelper;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
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
		$this->productHelper = new ProductHelper;
		$this->configs=$request->attributes->get('configs');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$statDetails = array();

		$statDetails['user']['total'] = User::count();
		$statDetails['user']['active'] = User::where('status',1)->count();
		$statDetails['user']['inactive'] = $statDetails['user']['total'] - $statDetails['user']['active'];

		$statDetails['user']['bouser'] = User::leftjoin('cep_groups','users.group_id','=','cep_groups.group_id')->where('status',1)->where('group_code','BO')->count();
		$statDetails['user']['client'] = User::leftjoin('cep_groups','users.group_id','=','cep_groups.group_id')->where('status',1)->where('group_code','CL')->count();
		$statDetails['user']['product_admin'] = User::leftjoin('cep_groups','users.group_id','=','cep_groups.group_id')->where('status',1)->where('group_code','PA')->count();
		$statDetails['user']['client_manager'] = User::leftjoin('cep_groups','users.group_id','=','cep_groups.group_id')->where('status',1)->where('group_code','CM')->count();

		$statDetails['product']['total'] = CepProducts::count();
		$statDetails['product']['active'] = CepProducts::where('prod_status',1)->count();
		$statDetails['product']['inactive'] = $statDetails['product']['total'] - $statDetails['product']['active'];


		$statDetails['item']['total'] = CepItems::count();
		$statDetails['item']['active'] = CepItems::where('item_status',1)->count();
		$statDetails['item']['inactive'] = $statDetails['item']['total'] - $statDetails['item']['active'];

		$statDetails['item']['category'] = CepItems::select(DB::raw('item_name, count(*) as item_count'))
																							->where('item_status',1)
																							->groupBy('item_name')
																							->get()->toArray();

		$statDetails['crud']['total'] = DB::table('cep_crud')->count();
		$statDetails['crud']['data'] = DB::table('cep_crud')->orderBy('crud_name')->get();

		$statDetails['upload']['total'] = CepUploads::count();
		$statDetails['download']['total'] = CepDownloads::count();


		$id = Auth::id();
		$user = User::with('groups')->find($id);
		$view_name = "";
		switch(true){
			case (strcmp($user->groups->group_code,"SA") == 0):
				$view_name = "dashboards.home";
				break;
			case (strcmp($user->groups->group_code,"CL") == 0):
				$view_name = "dashboards.home_client";
				return redirect(url()."/client/".$id);
				break;
			case (strcmp($user->groups->group_code,'CM') == 0):
				$prdCount = $this->productHelper->getUserProductCount($id);
				return (count($prdCount) == 1) ? redirect(url()."/product/".$prdCount[0]['puser_product_id'])  : redirect(url()."/client/".$id);
				break;
			case (strcmp($user->groups->group_code,'BO') == 0 || strcmp($user->groups->group_code,'PA') == 0):
				$view_name = "dashboards.home_bouser";
				break;
			case (strcmp($user->groups->group_code,'DEV') == 0):
				$view_name = "dashboards.home_developer";
				break;
			default:
				$view_name = "dashboards.home";
				break;
		}
		return view($view_name,compact('statDetails'));
	}

	public function setLanguages($id){

		$update_row = DB::table('cep_user_plus')->where('up_user_id',Auth::id())->update(array('up_default_language'=>$id));
		Cookie::forget('DEFAULT_LANGUAGE_CODE_COOKIE');
		$cookies = Cookie::forever('DEFAULT_LANGUAGE_CODE_COOKIE',$id);
		//echo Cookie::get('default_language_code_cookie');
		return redirect()->back()->withCookie($cookies);

	}

}
