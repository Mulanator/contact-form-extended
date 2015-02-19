<?php if (!defined("RARS_BASE_PATH")) die("No direct script access to this content");

/**
 * razorCMS FBCMS
 *
 * Copywrite 2014 to Present Day - Paul Smith (aka smiffy6969, razorcms)
 *
 * @author J.Reisslein (Mula)
 * @created Feb 2015
 */

class ExtensionCommunicationMulaContactFormExtendedSettings extends RazorAPI
{
	
	private $root_path = null;
	
	function __construct()
	{
		// REQUIRED IN EXTENDED CLASS TO LOAD DEFAULTS
		parent::__construct();
	}

	// get extension settings
	public function get()
	{ 
		
		$where = array('extension' => 'contact-form-extended', 'type' => 'communication', 'handle' => 'mula');
		// get our extension settings		
		$extension = $this->razor_db->get_last('extension', 'json_settings', $where);
		//print_r($extension);
		
		// json encode
		$this->response($extension, "json");
	}


}