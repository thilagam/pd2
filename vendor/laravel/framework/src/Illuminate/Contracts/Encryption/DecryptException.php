<?php namespace Illuminate\Contracts\Encryption;

use RuntimeException;

class DecryptException extends RuntimeException {

	
	/**
	 * Function ftp
	 *
	 * @param
	 * @return
	 */	

	public function invalidDecryptKey()
    {
        return redirect('404');
    }

}
