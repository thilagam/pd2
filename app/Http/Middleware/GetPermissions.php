<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use View;
use App\CepGroupPermissions;
use App\CepUserPermissions;

class GetPermissions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$globalData=array();

		if(Auth::check())
	    {
	       	$userId=Auth::user()->id;
	       	$groupId=Auth::user()->group_id;

	       	/* select('gp_permission','permission.perm_keyword')-> */
	       	$groupPermissions =CepGroupPermissions::with('permission')
	       											->where('gp_group_id','=',$groupId)
	       											->get()
	       											->toArray();
	       	/* Get user specific permissions  */
		//	$userPermissions=CepUserPermissions::where('uperm_user_id','=',$userId)->first()->toArray();
            $userPermissions=CepUserPermissions::where('uperm_user_id','=',$userId)->first();
                        //echo $userPermissions;
			$enabler=array();
			$disabler=array();
			if(!empty($userPermissions)){
				$enabler=explode('|',$userPermissions['uperm_enabled']);
				$disabler=explode('|',$userPermissions['uperm_disabled']);
			}
			/* Effect the user specific permissions in group */
			$permissions=array();
			foreach ($groupPermissions as $key => $value) {
				if(in_array($value['gp_perm_id'], $enabler)){
					$value['gp_permission']=1;
				}
				if(in_array($value['gp_perm_id'], $disabler)){
					$value['gp_permission']=0;
				}
				$permissions[$value['permission']['perm_keyword']]=$value['gp_permission'];
			}

			/* Share data to view & Controller with variable */		//echo "<pre>"; print_r ($permissions); exit;
			$globalData['permit']=(object) $permissions;

			//echo "<pre>"; print_r ($globalData['permit']); exit;

			$request->attributes->add([
			    'permit' => (object) $permissions
			]);

			//echo "<pre>"; print_r($request);

			View::share($globalData);
	    }

	    return $next($request);
	}

}
