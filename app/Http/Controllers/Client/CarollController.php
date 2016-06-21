<?php namespace App\Http\Controllers\Client;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

/* Models */		
use App\CepProducts;
use App\CepProductUsers;
use App\CepProductFtp;
use App\CepProductConfigurations;
use App\CepProductMailingList;
use App\CepItems;
use App\CepUploads;

/* FACADES */		
use DB;
use Validator;
use Auth;
use Input;  
//use Request;
use Crypt;
use Config;
use FTP;
use Log;
use File;
use Storage;



/* Services */		
use App\Services\UploadsManager;

/* Libraries */		
use App\Libraries\FileManager; 
use App\Libraries\ActivityMainLib;
use App\Libraries\CheckAccessLib;
use App\Libraries\ProductHelper;
use App\Libraries\ClientCaroll;
use App\Libraries\ExcelLib;


class LahalleController extends Controller 
{


}