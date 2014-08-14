<?php 
	require './config/config.php';
	
	/*
	 * Valid JSON Parent Editors (Read-Only Editors not included)
	 * 
	 * and Children Editors
	 * **********************************************************
	 * 
	 * There are two list since the order is different for read
	 * and write.
	 */

	$editors_write = array(	
				//  'class',	- uncomment only if strictly necessary
				'location',
				'agentGroup',
				'agent',	// depends on agentGroup and location
				'dnis',
				'ivr',
				'outcome',
				'pause',
				'qaForm',
				'queue',
				'report',
				'user',		// depends on class
				'exportJob',	// depends on report and queue
				'exportReport'
						
	);
	
	$editors_delete = array(
				'agent',	
				'location',	// delete agent before
				'agentGroup',	// delete agent before
				'dnis',
				'exportJob',
				'exportReport',
				'ivr',
				'outcome',
				'pause',
				'qaForm',
				'queue',	// delete exportJob before
				'report',	// delete exportJob before
				'user'
				//	,'class', - uncomment only if strictly necessary (delete user before)
	);
		
	$child_editors = array(	'qaItem',
				'reportScreen',
				'reportItem'
	);
	
	$childOf = array(	'qaForm'	=> 	'qaItem',
				'report'	=> 	'reportScreen',
				'reportScreen'	=> 	'reportItem'
	);
		
	
	/*
	 *  API Interaction Functions
	 */
	
	function send_get_query($editor, $element, $search, $parent) {
		global $config;
		
		$url = "http://".$config['host'].":".$config['port']."/".$config['webapp_name']."/".$editor."/".$element."/jsonEditorApi.do?q=".$search."&parent=".$parent;
		
		/*
		 * cURL 
		 */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
	function send_delete_query($editor, $element) {
		global $config;
		
		$url = "http://".$config['host'].":".$config['port']."/".$config['webapp_name']."/".$editor."/".$element."/jsonEditorApi.do";
		
		/*
		 * cURL 
		 */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
		
	function send_add_query($editor, $data) {
		global $config;
		
		$url = "http://".$config['host'].":".$config['port']."/".$config['webapp_name']."/".$editor."/-/jsonEditorApi.do";
		
		/*
		 * cURL
		*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_USERPWD, $config['username'].":".$config['password']);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(	'Content-Type: application/json',
								'Content-Length: ' . strlen($data))
							);
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
?>
