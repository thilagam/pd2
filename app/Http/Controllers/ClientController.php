<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Support\Collection;
/* Models */
use App\User;
use App\CepUserPlus;
use App\CepGroups;
use App\CepCountry;
use App\CepItems;
use App\CepProducts;
use App\CepProductUsers;
use App\CepDeveloperConfigurations;
/* Facads */
use DB;
use Validator;
use Auth;
use Input;
use Request;

/* Services & Libs */
use App\Services\UploadsManager;
use App\Libraries\EMailer;
use App\Libraries\ActivityMainLib;


class ClientController extends Controller
{

	public $permit;
	public $configs;
    protected $manager;
    protected $emailActivity;
    protected $customactivity;

	 /**
     * Instantiate a new UserController instance.
     */
    public function __construct(\Illuminate\Http\Request $request)
    {

    	$this->permit=$request->attributes->get('permit');
    	$this->configs=$request->attributes->get('configs');
        $this->middleware('auth');

        $this->manager=new UploadsManager;
        $this->emailActivity = new EMailer;
        $this->customactivity = new ActivityMainLib;

    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		/* Get Clients to list them  */
		if(!$this->permit->module_client_view)
						return redirect('accessDenied');

		$clients = DB::table('cep_product_users')
                    ->select('id',
                             'up_company_name as company ',
                             'users.created_at as create_date',
                              DB::raw('count(DISTINCT puser_product_id) as products')
                            )
                    ->leftjoin('users', 'puser_user_id', '=', 'id')
                    ->leftjoin('cep_user_plus', 'up_user_id', '=', 'puser_user_id')
                    ->leftjoin('cep_groups', 'cep_groups.group_id', '=', 'users.group_id')
                    //->where('puser_group_id', '=', 243212)
                    ->where('group_code', '=', 'CL')
                    ->where('users.status', '=', 1)

                    ->orderBy('up_company_name', 'asc')
                    ->groupBy('puser_user_id')
                    ->get();
		return view('client.list',compact('clients'));
		// echo "<pre>"; print_r($clients);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	//echo "<pre>"; print_r($this->permit);
		/* Check if access is allowed */
		// if(!$this->permit->create_client)
		// {
		// 	return redirect('accessDenied');
		// }
		/* Get country Data */
		//echo "HI";exit;
		$countries=CepCountry::select('country_name', 'country_id')
			->where('country_status', 1)
		    ->orderBy('country_name', 'desc')
           	->get()->toArray();
        $countryData=array(0=>'');
        foreach ($countries as $key => $value) {
        	$countryData[$value['country_id']]=$value['country_name'];
        }

        /*
         * Create Counts array with key => value pair bindings and range is 0 to
         * config value from DB for mx_sub_account that can be set
         */
        $counts=array_combine(range(0,$this->configs->max_sub_accounts), range(0,$this->configs->max_sub_accounts));

        /* Get Bo Users to Select incharge  */
        $bousers=User::with('userPlus')
						->where('group_id','=','243211')
						->get()
						->toArray();
		$bouserData=array('0'=>'');
		foreach ($bousers as $key => $value) {
			$bouserData[$value['id']]=($value['user_plus']['up_first_name']!='') ? ucfirst($value['user_plus']['up_first_name'])." ".ucfirst($value['user_plus']['up_last_name']): $value['name'] ;
		}

        //echo "<pre>"; print_r($bouserData);exit;
		return view('client.create',compact('countryData','counts','bouserData'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	//echo "STORE";
		//exit;
		$input = Input::all();
		//echo "<pre>"; print_r($input);
		$users = Request::only('name','email','password','password_confirmation','status','user_max_sub_accounts');
        $original_password = $users['password'];

		$validate = Validator::make($users,[
                    'name' => 'required|max:45|unique:users',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'sometimes|min:6|same:password_confirmation',
                    'password_confirmation' => 'sometimes|same:password|min:6'
        ]);

        if($validate->fails())
        {
                return redirect()->back()->withErrors($validate->errors());
        }
        /* Validate User Plus data */
        $userPlusReq = Request::only('first_name','last_name','company_name','city','country','about_company','user_max_sub_accounts');

        $validateUplus = Validator::make($userPlusReq,[
                    'first_name' => 'max:45',
                    'last_name' => 'max:45',
                    'company_name' => 'max:100',
                    'city' => 'max:45',

        ]);

        if($validateUplus->fails())
        {
                return redirect()->back()->withErrors($validateUplus->errors());
        }

        /* Create Entry in User Table */

        $users['group_id'] = 243212;
       	$users['password'] = bcrypt($users['password']);
       	$users['user_max_subaccounts'] = $users['user_max_sub_accounts'];
       	$users['user_created_by']=Auth::id();

        $newUser = User::create($users);


        /* Create uer plus table entry */
        $userPlus=array(
            'up_user_id'=>$newUser->id,
            'up_first_name'=>$userPlusReq['first_name'],
            'up_last_name'=>$userPlusReq['last_name'],
            'up_company_name'=>$userPlusReq['company_name'],
            'up_city'=>$userPlusReq['city'],
            'up_about_company'=>$userPlusReq['about_company']
            );


        CepUserPlus::create($userPlus);


        /* Activity Email Alerts */

        $variable = '{ "EM_FLNAME": "'.$users['name'].'","EM_USERNAME": "'.$users['email'].'", "EM_PASSSWORD": "'.$original_password.'", "EM_URL": "'.$this->configs->edit_place_site_url.'" }';

        $option = array(
                        'em_type'=>1,
                        'em_from'=>$this->configs->email_no_reply_user_id,
                        'em_to'=>$newUser->id,
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->client_creation_email_template_subject,
                        'eticket_template_id' => $this->configs->client_creation_email_template_id,
                        'em_ticket_id' => 0,
                        );
        $this->emailActivity->sendMessage($option);

        //print_r($act_options); exit;



        /* Close Activity Email Alerts */



        /* Create Product Section Starts Here  */
        /* Product Table Entry */
        $product=$input['product_name'];
        $productIncharge=$input['boincharge'];
        foreach ($product as $key => $value)
        {

        	$productArray=array(
        		'prod_name'=>$value,
        		'prod_created_by'=>Auth::id()
        		);
        	if($value!='')
        	{
        		$prod=CepProducts::create($productArray);
                /* Activity Custom */
                $client_name = $userPlusReq['first_name']." ".$userPlusReq['last_name'];
                $variable_act = '{ "AC_CL_FLNAME": "'.$client_name .'","AC_NAME": "'.Auth::user()->name.'","AC_CL_PRODUCT": "'.$prod->prod_name.'" }';

                $act_options = array(
                            'act_template_id' => $this->configs->client_creation_activity_template_id,
                            'act_by' => Auth::id(),
                            'act_product_id' => $prod->prod_id,
                            'act_variables' => $variable_act
                           );
                $this->customactivity->postActivity($act_options);

                /* Close Activity Custom */

                /* Create Uploads Folder Entry */
                $this->manager->createDirectory($this->configs->uploads_products_path.$prod->prod_id);
                chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$prod->prod_id, 0777);
        		/* Add Product Users for the Product */
        		if($prod)
        		{
        			/* Add Client */
        			$productClient=array(
        					'puser_product_id'=>$prod->prod_id,
        					'puser_user_id'=>$newUser->id,
        					'puser_group_id'=>243212
        					);
        			CepProductUsers::create($productClient);


        			/* Add Incharge */
        			if($productIncharge[$key]!='')
        			{
	        			$productInchargeData=array(
	        					'puser_product_id'=>$prod->prod_id,
	        					'puser_user_id'=>$productIncharge[$key],
	        					'puser_group_id'=>243211,
	        					'puser_incharge'=>1
	        					);
	        			CepProductUsers::create($productInchargeData);
        			}
        		}
                /* Add Developer Configs */
                $devConfArray=array(
                                array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_type','dconf_value'=>'','dconf_status'=>1),
                                array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_controller','dconf_value'=>'','dconf_status'=>1),
                                array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_library','dconf_value'=>'','dconf_status'=>1)
                                );
                $devConfigs=CepDeveloperConfigurations::insert($devConfArrayst);
        	}

                /* Activity Email Alerts */

                $variable = '{ "EM_PRODUCT":"'.$value.'" }';

                $option = array(
                        'em_type'=>1,
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$productIncharge[$key],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->client_creation_email_template_subject_for_bo,
                        'eticket_template_id' => $this->configs->client_creation_email_template_id_for_bo,
                        'em_ticket_id' => 0,
                        );
                $this->emailActivity->sendMessage($option);

                /* Close Activity Email Alerts */

        }


       	return redirect('client');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		/* Get Bo Users to Select incharge  */
        $client=User::with('userPlus','productUser')
						->where('id','=',$id)
						->first()->toArray();
		$client=(object) $client;
        // /echo "<pre>"; print_r($client);exit;
        $country=CepCountry::where('country_id','=',$client->user_plus['up_country_code'])->get()->toArray();
       //echo "<pre>"; print_r($country);exit;
		$products=array();
		foreach ($client->product_user as $key => $value) {
            if($value['puser_status']==1){
    			$products[$value['puser_product_id']]=CepProducts::with('users')
    					    	->where('prod_id','=',$value['puser_product_id'])
    					    	->first()->toArray();
                $products[$value['puser_product_id']]['item'] =  CepItems::where('item_product_id','=',$value['puser_product_id'])
                                ->where('item_status',1)->get()->toArray();
            }
		}



		//echo "<pre>"; print_r($products);exit;
		return view('client.profile',compact('client','products','country'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		/* Get Bo Users to Select incharge  */
        $client=User::with('userPlus','productUser')
						->where('id','=',$id)
						->first()->toArray();
		$client=(object) $client;
		/* Get all products of the client */
		$products=array();
		$incharges=array();
		foreach ($client->product_user as $key => $value) {
			$products[]=CepProducts::with('users')
					    	->where('prod_id','=',$value['puser_product_id'])
					    	->first()->toArray();
			/* Get Incharge for the product if set */
			$incharges[$key]='';
			foreach ($products[$key]['users'] as $pk => $pv) {
				if($pv['puser_incharge']==1){
					$incharges[$key]=$pv['puser_user_id'];
				}
			}
		}
		//echo "<pre>"; print_r($client);echo "<pre>"; print_r($products);exit;

		/* Get Country data for select */
		$countries=CepCountry::select('country_name', 'country_id')
			->where('country_status', 1)
		    ->orderBy('country_name', 'desc')
           	->get()->toArray();
        $countryData=array(0=>'');
        foreach ($countries as $key => $value) {
        	$countryData[$value['country_id']]=$value['country_name'];
        }

        /* Get Bo Users to Select incharge  */
        $bousers=User::with('userPlus')
						->where('group_id','=','243211')
						->get()
						->toArray();
		$bouserData=array('0'=>'');
       // echo "<pre>"; print_r($bousers);
		foreach ($bousers as $key => $value) {
			$bouserData[$value['id']]=($value['user_plus']['up_first_name']!='') ? ucfirst($value['user_plus']['up_first_name'])." ".ucfirst($value['user_plus']['up_last_name']): $value['name'] ;
		}
		/*
         * Create Counts array with key => value pair bindings and range is 0 to
         * config value from DB for mx_sub_account that can be set
         */
        $counts=array_combine(range(0,$this->configs->max_sub_accounts), range(0,$this->configs->max_sub_accounts));


		return view('client.edit',compact('client','products','countryData','bouserData','counts','incharges'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		// /echo "<pre>"; print_r($input);
        //$users=User::where('id',$id)->first();

		/* Validate  User Table details first */
		$newusers = Request::only('name','email','password','password_confirmation','user_max_subaccounts');
       // echo "<pre>"; print_r($newusers);
		$validate = Validator::make($newusers,[
                    'name' => 'required|max:45|unique:users'. ($id ? ",name,$id" : ''),
                    'email' => 'required|email|max:255|unique:users'. ($id ? ",email,$id" : ''),
                    'password' => 'sometimes|min:6|same:password_confirmation',
                    'password_confirmation' => 'sometimes|same:password|min:6',
                    'user_max_subaccounts'=>'sometimes'
        ]);
        //echo "<pre>"; print_r($validate->errors());

        if($validate->fails())
        {
                return redirect()->back()->withErrors($validate->errors());
        }
        /* Validate User Plus data */
        $userPlus = Request::only('first_name','last_name','company_name','city','country','about_company');

        $validateUplus = Validator::make($userPlus,[
                    'first_name' => 'max:45',
                    'last_name' => 'max:45',
                    'company_name' => 'max:100',
                    'designation' => 'max:45',
                    'city' => 'max:45'
        ]);

        if($validateUplus->fails())
        {
                return redirect()->back()->withErrors($validateUplus->errors());
        }
        //exit;
        /* User Table Information Modify and Update */
        if($newusers['password']=='')
        {
        	unset($newusers['password']);
        	unset($newusers['password_confirmation']);
        }
        //$users=(object) $users;
        $user=User::where('id',$id)->first();

        $user->name=$newusers['name'];
        $user->email=$newusers['email'];
        $user->user_max_subaccounts=$newusers['user_max_subaccounts'];
		if(isset($newusers['password']))
        {
        	$user->password = bcrypt($newusers['password']);
        }
        //echo "<pre>USER : "; print_r($user);
        /* SAVE USER INFO */
	  	$user->save();

	  	/* Update UserPlus details modify & Update */
	  	$uPlus=CepUserPlus::where('up_user_id',$id)->first();
		//echo "<pre>"; print_r($uPlus);
		$uPlus = CepUserPlus::where('up_user_id', '=', $id)->first();
  		$uPlus->up_first_name=$userPlus['first_name'];
  		$uPlus->up_last_name=$userPlus['last_name'];


  		$uPlus->up_company_name=$userPlus['company_name'];
  		//$uPlus->up_designation=$userPlus['designation'];
  		$uPlus->up_city=$userPlus['city'];
  		$uPlus->up_country_code=$userPlus['country'];
  		$uPlus->up_about_company=$userPlus['about_company'];
  		//echo "<pre>UPLUS : "; print_r($uPlus);

        /* SAVE UPLUS INFO */
  		$uPlus->save();

  		/* Update Product information  */
        $product=$input['product_name'];
        $productIncharge=$input['boincharge'];
        $productIds=$input['pid'];
        // echo "<pre>"; print_r($productIds);
        // echo "<pre>"; print_r($productIncharge);
        // echo "<pre>"; print_r($product);exit;
        foreach ($product as $key => $value)
        {
            if($productIds[$key]=='')
            {

                $productArray=array(
                'prod_name'=>$value,
                'prod_created_by'=>Auth::id()
                );
                if($value!='')
                {
                    $prod=CepProducts::create($productArray);
                    /* Activity Custom */

                    $client_name = $userPlus['first_name']." ".$userPlus['last_name'];
                    $variable_act = '{ "AC_CL_FLNAME": "'.$client_name .'","AC_NAME": "'.Auth::user()->name.'","AC_CL_PRODUCT": "'.$prod->prod_name.'" }';

                    $act_options = array(
                            'act_template_id' => $this->configs->client_creation_activity_template_id,
                            'act_by' => Auth::id(),
                            'act_product_id' => $prod->prod_id,
                            'act_variables' => $variable_act
                           );

                    $this->customactivity->postActivity($act_options);
                    /* Close Activity Custom */
                    /* Create Uploads Folder Entry */
                    $this->manager->createDirectory($this->configs->uploads_products_path.$prod->prod_id);
                    chmod(public_path().$this->configs->uploads_path."/".$this->configs->uploads_products_path.$prod->prod_id, 0777);
                    /* Add Product Users for the new Product */
                    if($prod)
                    {
                        /* Add Client */
                        $productClient=array(
                                'puser_product_id'=>$prod->prod_id,
                                'puser_user_id'=>$id,
                                'puser_group_id'=>243212
                                );
                        CepProductUsers::create($productClient);
                        /* Add Incharge */
                        if($productIncharge[$key]!='')
                        {
                            $productInchargeData=array(
                                    'puser_product_id'=>$prod->prod_id,
                                    'puser_user_id'=>$productIncharge[$key],
                                    'puser_group_id'=>243211,
                                    'puser_incharge'=>1
                                    );
                            CepProductUsers::create($productInchargeData);
                        }

                        /* Add Developer Configs */
                        $devConfArray=array(
                                        array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_type','dconf_value'=>'','dconf_status'=>1),
                                        array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_controller','dconf_value'=>'','dconf_status'=>1),
                                        array('dconf_id'=>'','dconf_product_id'=>$prod->prod_id,'dconf_name'=>'pdc_client_library','dconf_value'=>'','dconf_status'=>1)
                                        );
                        $devConfigs=CepDeveloperConfigurations::insert($devConfArray);
                    }
                }


                /* Activity Email Alerts */

                $variable = '{ "EM_PRODUCT":"'.$value.'" }';

                $option = array(
                        'em_type'=>1,
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$productIncharge[$key],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->client_creation_email_template_subject_for_bo,
                        'eticket_template_id' => $this->configs->client_creation_email_template_id_for_bo,
                        'em_ticket_id' => 0,
                        );
                $this->emailActivity->sendMessage($option);

                /* Close Activity Email Alerts */

            }
            else
            {
                $prodInfo = CepProducts::where('prod_id',$productIds[$key])->first();
                /* Activity Custom */

                $client_name = $userPlus['first_name']." ".$userPlus['last_name'];
                $variable_act = '{ "AC_CL_FLNAME": "'.$client_name .'","AC_NAME": "'.Auth::user()->name.'","AC_CL_PRODUCT": "'.$prodInfo->prod_name.'" }';

                $act_options = array(
                            'act_template_id' => $this->configs->client_update_activity_template_id,
                            'act_by' => Auth::id(),
                            'act_product_id' => $prodInfo->prod_id,
                            'act_variables' => $variable_act
                           );

                $this->customactivity->postActivity($act_options);
                /* Close Activity Custom */
            
                /* Update name if value not changed */
                if($prodInfo->prod_name!=$value)
                {
                    $prodInfo->prod_name=$value;
                    /* SAVE PRODUCT INFO */
                    $prodInfo->save();
                }
                /* Update Bo Incharge if not Changed */
                $bouserInfo= CepProductUsers::where('puser_product_id','=',$productIds[$key])->where('puser_incharge','=',1)->first();
                //echo "<pre>BOUSER INFO : "; print_r($bouserInfo);
                if($bouserInfo->puser_user_id!=$productIncharge[$key])
                {
                    $bouserInfo->puser_user_id=$productIncharge[$key];
                    /* SAVE BOUSER INFO */
                    $bouserInfo->save();

                }

                /* Activity Email Alerts */

                $variable = '{ "EM_PRODUCT":"'.$value.'" }';

                $option = array(
                        'em_type'=>1,
                        'em_from'=> $this->configs->email_no_reply_user_id,
                        'em_to'=>$productIncharge[$key],
                        'em_variables'=>$variable,
                        'em_subject' => $this->configs->client_update_email_template_subject_for_bo,
                        'eticket_template_id' => $this->configs->client_update_email_template_id_for_bo,
                        'em_ticket_id' => 0,
                        );
                $this->emailActivity->sendMessage($option);

                /* Close Activity Email Alerts */

            }
        }

	  	//exit;
        return redirect('client/'.$id);
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
?>
