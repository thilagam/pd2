<?php namespace App\Libraries;

/**
* Check Access of users
*/

use App\CepProductUsers;
use App\CepGroups;
use App\CepAppointments;
use App\CepEmailMessages;
use Auth;

class CheckAccessLib
{
	public $user_id;
	
	public function __construct()
	{	
		$this->user_id = Auth::id();
	}

	/**
	 * Function productAccessCheck
	 * Only allow product view to SA|DEV and product related users.
	 *
	 * @param $prod_id product id
	 * @return true or false
	 */
	public function productAccessCheck($prod_id){
		    $group = CepGroups::where('group_id',Auth::user()->group_id)->first();
			$user_count = CepProductUsers::where('puser_user_id',$this->user_id)
							->where('puser_product_id',$prod_id)
							->count();
			
			return ($user_count > 0 || $group->group_code == 'SA' || $group->group_code == 'DEV') ? true : false;				
	}

	/**
	 * Function appointmentAccessCheck
	 * Only allow appointment view to SA|DEV and product related users.
	 *	
	 * @param $apo_id as appointment id
	 * @return true or false
	 */
	public function appointmentAccessCheck($apo_id){
		    $group = CepGroups::where('group_id',Auth::user()->group_id)->first();
			$user_count = CepAppointments::where('apo_client_id',$this->user_id)
							->orWhere('apo_ep_incharge_id',$this->user_id)
							->orWhere('apo_client_incharge_id',$this->user_id)
							->orWhere('apo_created_by',$this->user_id)
							->count();
			
			return ($user_count > 0 || $group->group_code == 'SA' || $group->group_code == 'DEV') ? true : false;				
	}

	/**
	 * Function messageAccessCheck
	 * Only allow message view access to sender and receiver not others.
	 * @param $messages_id as message id
	 * @return true or false
	 */
	public function messageAccessCheck($messages_id){
			$message_count = CepEmailMessages::where('em_id',$messages_id)
											 ->where(function ($query) {
                									$query->orwhere('em_to',$this->user_id)
                      									  ->orwhere('em_from',$this->user_id);
            										})
											 ->count();								 
			return ($message_count > 0) ? true : false;								 	
	}	
	
	/**
	 * Function profileAccessCheck
	 * Profile page is open only for login user
	 * @param $messages_id as message id
	 * @return true or false
	 */
	public function profileAccessCheck($user_id){
			return (Auth::id() == $user_id) ? true : false;
	}

}
?>
