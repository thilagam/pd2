<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


//use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Support\Collection;

use App\User;
use App\CepUserPlus;
use App\CepGroups;
use App\CepCountry;
use App\CepUserPermissions;

use Request;
use Validator;
use Auth;
use Input;
use DateTime;

use App\Libraries\ActivityMainLib;
use App\Libraries\CheckAccessLib;
use App\Libraries\EMailer;


class UserController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Config
    |--------------------------------------------------------------------------
    |
    | Define all Config Setting here
    |
    */

	public $permit;
	public $configs;
	protected $activityObject;
	protected $accesscheck;
	protected $emailActivity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
            $this->permit=$request->attributes->get('permit');
         	$this->configs=$request->attributes->get('configs');
            $this->middleware('auth');
            $this->activityObject = new ActivityMainLib;
            $this->accesscheck = new CheckAccessLib;
            $this->emailActivity = new EMailer;

    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
                if(!$this->permit->module_user_view)
                        return redirect('accessDenied');

	    $id = Auth::id();
	    $user_logged_in = User::with('groups')->find($id);
	    if(strcmp($user_logged_in->groups->group_code,"SA") == 0 || strcmp($user_logged_in->groups->group_code,"DEV") == 0)
		    $groups = CepGroups::where('group_status',1)->get();
	    else
            $groups = CepGroups::where('group_status',1)->whereIn('group_code',['CL','CM'])->get();

        if(strcmp($user_logged_in->groups->group_code,"SA") == 0 || strcmp($user_logged_in->groups->group_code,"DEV") == 0)
    	    $users = User::with('groups','userPlus')->where('status',1)->get();
	    else
            $users = User::with('groups','userPlus')->where('status',1)->where('id',$id)->orWhere('user_parent_id',$id)->get();

		//echo "<pre>"; print_r($users);exit;
		return view('users.index',compact('groups','users','user_logged_in'));
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(!$this->permit->module_user_create)
                        return redirect('accessDenied');

                $id = Auth::id();
                $user_logged_in = User::with('groups')->find($id);
		$user_logged_in_max_account = User::where('user_parent_id',$id)->count();
                if(strcmp($user_logged_in->groups->group_code,"SA") == 0 || strcmp($user_logged_in->groups->group_code,"DEV") == 0)
                    $groups_array = CepGroups::where('group_status',1)->whereNotIn('group_code',['CL','CM'])->get();
                else
                    $groups_array = CepGroups::where('group_status',1)->whereIn('group_code',['CM'])->get();//not include client and client manager group
                $groups = array();
		$groups['']="Select";
		foreach ($groups_array as $gp){
			$groups[$gp->group_id]=$gp->group_name.":".$gp->group_code;
		}
		return view('users.create',compact('groups','user_logged_in_max_account','user_logged_in'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $newusers = Request::only('name','email','password','password_confirmation','group_id');
   		$validate = Validator::make($newusers,[
                    'name' => 'required|max:45',
                    'email' => 'required|email|unique:users|max:255',
                    'group_id' => 'required',
	    			'password' => 'required|confirmed|min:6',
         ]);

        if($validate->fails()){
                return redirect()->back()->withErrors($validate->errors());
        }

       	/* Modify Id and Password */
        $original_password = $newusers['password'];
       	$newusers['password'] = bcrypt($newusers['password']);
       	$newusers['user_created_by']=Auth::id();

        $id = Auth::id();
        $user_logged_in = User::with('groups')->find($id);
	if(strcmp($user_logged_in->groups->group_code,"CL") == 0)
		$newusers['user_parent_id'] = $id;

        $newUser = User::create($newusers);

        /* Create uer plus table entry */
       	$userPlus=array('up_user_id'=>$newUser->id);

       	CepUserPlus::create($userPlus);
        //dd(DB::getQueryLog());exit;
        CepUserPermissions::create(array('uperm_user_id'=>$newUser->id));

        /* Activity Email Alerts */

        $variable = '{ "EM_FLNAME": "'.$newusers['name'].'","EM_USERNAME": "'.$newusers['email'].'", "EM_PASSSWORD": "'.$original_password.'", "EM_URL": "'.$this->configs->edit_place_site_url.'" }';

        $option = array(
        				'em_type'=>1,
        				'em_from'=>$this->configs->email_no_reply_user_id,
        				'em_to'=>$newUser->id,
        				'em_variables'=>$variable,
        				'em_subject' => $this->configs->user_creation_email_template_subject,
        				'eticket_template_id' => $this->configs->user_creation_email_template_id,
        				'em_ticket_id' => 0,
        				);
        $this->emailActivity->sendMessage($option);

        /* Close Activity Email Alerts */

        return redirect('users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(!$this->permit->module_user_show)
                return redirect('accessDenied');
		User::where('id',$id)->update(array('status'=>0));
		return redirect('users');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(!$this->permit->module_user_edit)
            return redirect('accessDenied');

                $idi = Auth::id();
                $user_logged_in = User::with('groups')->find($idi);
                $user_logged_in_max_account = User::where('user_parent_id',$idi)->count();
                if(strcmp($user_logged_in->groups->group_code,"SA") == 0 || strcmp($user_logged_in->groups->group_code,"DEV") == 0)
                    $groups_array = CepGroups::where('group_status',1)->whereNotIn('group_code',['CL','CM'])->get();
                else
                    $groups_array = CepGroups::where('group_status',1)->whereIn('group_code',['CM'])->get();//not include client and client manager group
                $groups = array();
                $groups['']="Select";
                foreach ($groups_array as $gp){
                        $groups[$gp->group_id]=$gp->group_name.":".$gp->group_code;
                }

		$user = User::where('id',$id)->select('id','name','group_id','email')->first();
		return view("users.edit",compact('user','groups'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = Request::only('name','email','group_id');
		$validate = Validator::make($user,[
                	    'name' => 'required|max:45',
              	   	    'email' => 'required|email|unique:users,id,'.$id.',id|max:255',
                    	    'group_id' => 'required',
         	]);
	        if($validate->fails()){
                	return redirect()->back()->withErrors($validate->errors());
        	}

		$userUpdate = User::where('id',$id)->update($user);
		return redirect('users');
	}


	public function destroy($id)
	{
		//
	}

	/**
	 * Function profile
	 *
	 * @param
	 * @return
	 */
	public function profile($id)
	{

        if(!$this->permit->module_user_profile_view)
                return redirect('accessDenied');

		$userData=User::where('id',$id)->get();
		//echo "<pre>"; print_r($userData);exit;
		$userPlusData=CepUserPlus::where('up_user_id',$id)->first();

		if($userData->isEmpty()){
			return redirect('users');
		}
		//echo "<pre>"; print_r($userPlusData);exit;


        $activity = $this->activityObject->getActivity($id,0);

		return view('users.profile',compact('userData','userPlusData','activity'));
	}

	/**
	 * Function editProfile
	 * Function show edit form for current user
	 * @param
	 * @return
	 */
	public function editProfile()
	{

        if(!$this->permit->module_user_profile_edit)
                return redirect('accessDenied');

		$userData=Auth::user();
		$userPlusData=CepUserPlus::where('up_user_id',$userData->id)->first();

		$countries=CepCountry::select('country_name', 'country_id')
			->where('country_status', 1)
		    ->orderBy('country_name', 'desc')
           	->get()->toArray();
        $countryData=array(0=>'');
        foreach ($countries as $key => $value) {
        	$countryData[$value['country_id']]=$value['country_name'];
        }

        if(!empty($userPlusData['up_dob'])){
  			$now = DateTime::createFromFormat('Y-m-d',trim($userPlusData['up_dob']));
  			$userPlusData['up_dob'] = $now->format('D, d F Y');
  	    }

		//echo "<pre>"; print_r($countryData);exit;
		//echo "<pre>"; print_r($userPlusData);exit;

		return view('users.editProfile',compact('userData','userPlusData','countryData'));
	}

	/**
	 * Function doEdit
	 *
	 * @param
	 * @return
	 */
	public function doEdit($id)
	{
		//$input = Input::all();
		//echo "<pre>"; print_r($input);
		/* Validate  User Table details first */
		$users = Request::only('name','email','password','password_confirmation');
		$validate = Validator::make($users,[
                    'name' => 'required|max:45|unique:users'. ($id ? ",id,$id" : ''),
                    'email' => 'required|email|max:255|unique:users'. ($id ? ",id,$id" : ''),
                    'password' => 'sometimes|min:6|same:password_confirmation',
                    'password_confirmation' => 'sometimes|same:password|min:6'
        ]);

        if($validate->fails())
        {
                return redirect()->back()->withErrors($validate->errors());
        }
        /* Validate User Plus data */
        $userPlus = Request::only('first_name','last_name','gender','dob','user_about_you','company_name','designation','city','country','about_company','image');

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

        /* User Table Information Modify and Update */
        if($users['password']=='')
        {
        	unset($users['password']);
        	unset($users['password_confirmation']);
        }
        //$users=(object) $users;
        $user=User::where('id',$id)->first();

        $user->name=$users['name'];
        $user->email=$users['email'];
		if(isset($users['password']))
        {
        	$users->password = bcrypt($users->password);
        }
	  	$user->save();

	  	/* Update UserPlus details modify & Update */
	  	$uPlus=CepUserPlus::where('up_user_id',$id)->first();

	  	//var_dump($uPlus);
	  	if($uPlus===NULL)
	  	{
	  		/* Create uer plus table entry */
	  		//echo $id;
        	$createUserPlus=array('up_user_id'=>$id);
        	//echo "<pre>"; print_r($createUserPlus);
        	$uPlus=CepUserPlus::create($createUserPlus);
	  	}
	  	//exit;
	  	$uPlus = CepUserPlus::where('up_user_id',$id)->first();
		//echo "<pre>"; print_r($uPlus);
		$uPlus = CepUserPlus::where('up_user_id', '=', $id)->first();
  		$uPlus->up_first_name=$userPlus['first_name'];
  		$uPlus->up_last_name=$userPlus['last_name'];
  		$uPlus->up_gender=$userPlus['gender'];
  		//echo $userPlus['dob'];exit;
  		$now = DateTime::createFromFormat('D, d F Y',trim($userPlus['dob']));
  		//$now = date_create_from_format('D, d F Y', trim($userPlus['dob']));
  		//echo $userPlus['dob'];exit;
  		$uPlus->up_dob=$now->format('Y-m-d');
  		$uPlus->up_about_user=$userPlus['user_about_you'];
  		$uPlus->up_company_name=$userPlus['company_name'];
  		$uPlus->up_designation=$userPlus['designation'];
  		$uPlus->up_city=$userPlus['city'];
  		if($userPlus['image']!=''){
  			$uPlus->up_profile_image=$userPlus['image'];
  		}
  		//$uPlus->up_country_code=$userPlus['country'];
  		$uPlus->up_about_company=$userPlus['about_company'];
  		//$uPlus = User::where('username', '=', $username)->first();
  		$uPlus->save();

	  	// / CepUserPlus::where('up_user_id',$id)->update($uPlus);
	  	/* Update New Data to Userplus table */
	  	//$uPlus = CepUserPlus::where('up_user_id',$id)->get();
        //echo "<pre>"; print_r($uPlus);
        return redirect('profile/'.$id);

	}

	/**
	 * Function accessDenied
	 *
	 * @param
	 * @return
	 */
	public function accessDenied()
	{
		return view('errors.accessDenied');
	}

}
?>
