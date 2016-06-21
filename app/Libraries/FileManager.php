<?php namespace App\Libraries;

use Auth;
use request;
use Carbon\Carbon;
use File;

use App\CepUploads;
use App\CepDownloads;
use App\CepDownloadLogs;
use App\CepAttachments;
use App\CepAttachmentFiles;
use App\CepUploadLogs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Services\UploadsManager;

/**
* File Manager class used for upload and download of files
* Keeps track of files uploaded and downloaded in DB
*/
class FileManager
{
	protected $manager;
	public $user_id;

	public function __construct()
	{
		$manager=new UploadsManager;
		$this->manager = $manager;
		$this->user_id =Auth::id();
	}

	/**
	 * Function upload
	 *
	 * @param string $file
	 * @param array $options
	 * 		  $option =array (
	 *							'type'=> // File Type : xlsx , xls , jpg , PNG , DOC
	 *							'name'=> // new file name to be given
	 *							'description'=> // Short info not mandatory
	 *							'url'=> //upload location
	 *							'client'=> // Client Id
	 *							'product'=> // Product id
	 *							'item'=> //Item id if needed
	 *						 )
	 * @return
	 */
	public function upload($file,$options)
	{
		/* Upload file to the given path */

		$extension = $file->getClientOriginalExtension();
		$type=(isset($options['type']))?$options['type']:'';
		//echo $type;exit;
		$path = $options['url'].$options['name'].".".$extension;
		$content = File::get($file->getRealPath());

		//Storage::disk('local')->put($options['url'],  File::get($file));
		$result=$this->manager->saveFile($path, $content);
		/* Add entry in the Table  */
		$upFile=array(
					'upload_name'=>$options['name'].".".$extension,
					'upload_by'=>$this->user_id,
					'upload_date'=> Carbon::now(),
					'upload_type'=>(isset($options['type']))?$options['type']:'',
					'upload_original_name'=>$file->getClientOriginalName(),
					'upload_descriptions'=>(isset($options['description']))? $options['description']:'',
					'upload_client_id'=>(isset($options['client']))?$options['client']:'',
					'upload_product_id'=>(isset($options['product']))?$options['product']:'',
					'upload_item_id'=>(isset($options['item']))?$options['item']:'',
					'upload_url'=>$path,
					'upload_reference_column'=>$options['reference_column'],
					'upload_status'=>$options['status']
					);
 		//echo "<pre>"; print_r($upFile); exit;
		$uploaded=CepUploads::create($upFile);
		if(!is_null($uploaded))
			return $uploaded;
		else
			return false;

	}

	/**
	 * Function uploadEntry
	 *
	 * @param
	 * @return
	 */
	public function uploadEntry($options)
	{
		$file=$options['url'].$options['file'];
		$extension = $file->getClientOriginalExtension();
		$type=(isset($options['type']))?$options['type']:'';
		$path = $options['url'].$options['name'].".".$extension;
		/* Add entry in the Table  */
		$upFile=array(
					'upload_name'=>$options['name'].".".$extension,
					'upload_by'=>$this->user_id,
					'upload_date'=> Carbon::now(),
					'upload_type'=>(isset($options['type']))?$options['type']:'',
					'upload_original_name'=>$file->getClientOriginalName(),
					'upload_descriptions'=>(isset($options['description']))? $options['description']:'',
					'upload_client_id'=>(isset($options['client']))?$options['client']:'',
					'upload_product_id'=>(isset($options['product']))?$options['product']:'',
					'upload_item_id'=>(isset($options['item']))?$options['item']:'',
					'upload_url'=>$path,
					'upload_reference_column'=>$options['reference_column']
					);
 		//echo "<pre>"; print_r($upFile); exit;
		$uploaded=CepUploads::create($upFile);
		if(!is_null($uploaded))
			return $uploaded;
		else
			return false;
	}

	/**
	 * Function getUploadInfo
	 *
	 * @param
	 * @return
	 */
	public function getUploadInfo($id)
	{
		return ($id!='')?CepUploads::where('upload_id','=',$id)->first(): array();
	}


	/**
	 * Function list
	 *
	 * @param
	 * @return
	 */
	public function getlist($path,$options)
	{

	}

	/**
	 * Function delete
	 *
	 * @param
	 * @return
	 */
	public function delete($file,$options)
	{

	}

	/**
	 * Function simpleUplaod
	 *
	 * @param string $file
	 * @param array $options=array('url'=>..)
	 * @return
	 */
	public function simpleUplaod($file,$options)
	{
		/* Upload file to the given path */
		$extension = $file->getClientOriginalExtension();
		$path = $options['url'].$options['name'].".".$extension;
		$content = File::get($file->getRealPath());

		$result=$this->manager->saveFile($path, $content);
		return $path;
	}

	/**
     * Function downloadInitiated
     * When new writer file is created downloadInitiated is called
	 *
     * @param string $file
     * @param array $options
     *                $option =array (
     *                                'type'=> // File Type : XLSX , DOCX, ZIP
     *                                'name'=> // new file name to be given
     *                                'description'=> // Short info not mandatory
     *                                'url'=> //upload location
     *                                'client'=> // Client Id
     *                                'product'=> // Product id
     *                                'item'=> //Item id if needed
	 *				  'path'=> //File path
     *                                               )
     * @return
     */
	public function downloadInitiated($options)
	{
        $initiated_data =array(
                                'download_name'=>$options['name'],
                                'download_by'=> Auth::id(),
                                'download_type'=>$options['type'],
                                'download_descriptions'=>$options['description'],
                                'download_client_id'=>$options['client'],
                                'download_product_id'=>$options['product'],
                                'download_item_id'=>$options['item'],
                                'download_url'=>$options['path']
                     	  );

		return (CepDownloads::create($initiated_data)) ? true : false;
	}

	/**
     * Function downloadLogs
     * When new writer file is downloaded called
     *
     * @param string $file
     * @param array $options
     *                $option =array (
     *                                'dlog_download_id'=> // download id of generated file
     *                                'dlog_by'=> // downloaded by
     *                               )
     * @return
     */
    public function downloadLogs($options)
    {
            $download_data =array(
                                    'dlog_download_id'=> $options['dlog_download_id'],
                                    'dlog_by'=> Auth::id(),
                                 );
	 							return (CepDownloadLogs::create($download_data)) ? true : false;
    }


    /**
     * Function createAttachment
     *
     * @param $options array contain attachment parameters.
     * @return $attachment->att_id contain value of recently created attachment.
     */

	public function createAttachment($options)
	{
		$attachment_data = array(
								'att_type'=>$options['att_type']
							   );

		$attachment = CepAttachments::create($attachment_data);
		return $attachment->att_id;

	}

    /**
     * Function uploadAttachmentFiles
     *
     * @param $options array contain attachment parameters
     * @return true or false
     */

	public function uploadAttachmentFiles($file,$att_id)
	{
		$path = "attachements/".$att_id."/";
		File::makeDirectory($path, $mode = 0777, true, true);
		chmod($path, 0777);

		$name=uniqid();

		$extension = $file->getClientOriginalExtension();
		$path = $path.$name.".".$extension;
		$content = File::get($file->getRealPath());

		$result=$this->manager->saveFile($path, $content);

		$options = array(
							'attfiles_attachment_id' => $att_id,
							'attfiles_type' => $extension,
							'attfiles_original_name' => $file->getClientOriginalName(),
							'attfiles_name' => $name,
							'attfiles_path' => $path,
							'attfiles_created_by' => Auth::id()
						);

		return (CepAttachmentFiles::create($options)) ? true : false;

	}

	/**
	* Function uploadLogs
	* When new writer file is downloaded called
	*
	* @param string $file
	* @param array $options
	*                $option =array (
	*                  				'uplog_upload_id'=> upload id from cepupload table,
	*								'uplog_logs'=> upload id from cepupload log data,
	*								'uplog_check_upload'=> check upload status,
	*								'uplog_check_upload_status'=> error log status
	*                               )
	* @return
	*/
	public function uploadLogs($options)
	{
		$upload_data =array(
							'uplog_upload_id'=> $options['uplog_upload_id'],
							'uplog_logs'=> $options['uplog_logs'],
							'uplog_check_upload'=> $options['uplog_check_upload'],
							'uplog_check_status'=> $options['uplog_check_status']
					);
		return (CepUploadLogs::create($upload_data)) ? true : false;
	}

}
?>
