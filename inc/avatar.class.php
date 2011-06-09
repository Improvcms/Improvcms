<?php
/*
* Created by Azareal
* Copyright (c) 2011 - Azareal, DDI & ImprovCMS
* inc/class_avatar.php
*/
class avatar_handler
{
	public $width = 50;
	public $height = 50;
	public $size = 20000;
	protected $log = array();
	protected $debug = false;
	private $logincre = 0;
	function __construct($width = 50,$height = 50)
	{
		$this->log('Executing Constructor');
		// Get the needed information and validate it!
		$this->log('Validating Width');
		$this->width = intval($width);
		$this->log('Validating Height');
		$this->height = intval($height);
		$this->log('Constructor Execution Complete');
	}
	function upload($filename, $overwrite = false, $size = null)
	{
		$this->log('Commencing upload');
		if($_FILES['file']['type']!='image/gif' && $_FILES['file']['type']!='image/jpeg' && $_FILES['file']['type']!='image/pjpeg' && $_FILES['file']['type']!='image/gif')
		{
			$this->log('Invalid image type');
			return false;
		}
		$this->log('Checking maximum size');
		if($size==null || intval($size)==0)
		{
			$size = $this->size;
			$this->log('No new size value found. Loading class size value');
		}
		else
		{
			$this->log('Validating size data');
			$size = intval($size);
			$this->size = $size;
			$this->log('Assigning new size value to class');
		}
		$this->log('Checking image size');
		if(!($_FILES['file']['size'] < $size))
		{
			$this->log('Image size exceeds maximum size');
			return false;
		}
		if($_FILES['file']['error']>0)
		{
			$this->log("An issue has occured with error code '{$_FILES['file']['error']}'");
			return false;
		}
		$this->log('Checking if file exists');
		if(strpos($filename,".jpg")!===false && strpos($filename,".png")!===false && strpos($filename,".gif")!===false 
		&& strpos($filename,".jpeg")!===false)
		{
			$filename = "{$filename}.{$this->type}";
		}
		if(file_exists($filename))
		{
			if($overwrite)
			{
				$this->log('The file already exists however, overwrite is enabled');
				unlink($filename) or $this->log('Failed to delete previous file').$return = true;
				if($return) return false;
				$this->log('The previous file has been deleted');
				move_uploaded_file($_FILES['file']['tmp_name'],$filename) or $this->log('Failed to move uploaded file').$return = true;
				if($return) return false;
				$this->log('Succeeded in moving file to destination');
			}
			else
			{
				$this->log('The file already exists and overwrite is disabled. Aborting');
				return false;
			}
		}
		else
		{
			$this->log('File does not already exist');
			move_uploaded_file($_FILES['file']['tmp_name'],$filename) or $this->log('Failed to move uploaded file').$return = true;
			if($return) return false;
			$this->log('Succeeded in moving file to destination');
		}
		$this->log('Passing file data to calling script');
		$return = $_FILES['file'];
		$return['loc'] = $filename;
		$this->log('Upload complete');
		return $return;
	}
	/**
	* Datalogging function
	*
	* $string - string
	*
	**/
	function log($string)
	{
		$this->logincre++;
		$this->log[$this->logincre] = "#{$this->logincre} - {$string}\n";
	}
	/**
	* Debug system switch
	*
	* $bool - booleon
	*
	**/
	function debug($bool = true)
	{
		if($bool==false && $this->debug==true)
		{
			$this->debug = false;
		}
		elseif(($bool==true && $this->debug==true) || ($bool==false && $this->debug==false))
		{
			return;
		}
		elseif($bool==true && $this->debug==false)
		{
			$log = $this->log;
			foreach($log as $key => $entry)
			{
				echo nl2br($entry);
				unset($this->log[$key]);
			}
		}
		return null;
	}
}
?>