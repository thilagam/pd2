<?php 

/**
	*
	* Function human_filesize
	* Return sizes readable by humans
	* The human_filesize() function returns a file size which is easier to read than just a count of bytes.
	* @param int $bytes
	* @param int $decimals
	* @return  string 
	*
	*/
	function human_filesize($bytes, $decimals = 2)
	{
	  $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
	  $factor = floor((strlen($bytes) - 1) / 3);

	  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) .
	      @$size[$factor];
	}

	/**
	*
	* Function is_image
	* Is the mime type an image
	* The is_image() function returns true if the mime type is an image.
	* @param string $mimetype
	* @return string 
	*
	*/

	function is_image($mimeType)
	{
	    return starts_with($mimeType, 'image/');
	}