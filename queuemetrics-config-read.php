#!/usr/bin/php
<?php 
 	require './includes/init.php';
 	 	
 	function read_all($current_editor, $element, $query, $parent, $child) {
 		global $childOf;
 		 	
 		if(empty($element)) {
 			$results = json_decode(send_get_query($current_editor, $element, $query, $parent), true);
 			
 			if(!empty($results)) {
		 		foreach($results as $result) {
		 			echo $current_editor ."\t". base64_encode(send_get_query($current_editor, $result['PK_ID'], $query, $parent)) ."\n";
		 			
		 			// Recursively read a possible child editor
		 			if($child && isset($childOf[$current_editor])) {
		 				read_all($childOf[$current_editor], $element, $query, $result['PK_ID'], $child);
		 			}
		 		}
 			}
 		}
 		else {
 			$result = send_get_query($current_editor, $element, $query, $parent);
 			
 			if(!empty($result))
 				echo $current_editor ."\t". base64_encode($result) ."\n";
 		}
 	}
 	
 	/*
 	 * Parameters Evaluation
 	 */
 	
 	$child 		= true;
 	$editor 	= "";
 	$element 	= "";
 	$query 		= "";
 	$parent 	= "";
 	
 	for($i = 1; isset($argv[$i]); $i++) {
 		if($argv[$i] == "-h" || $argv[$i] == "--help") {
 			echo "\n";
 			echo "Usage:\n";
			echo "\n";
 			echo "You will get the name of the kind of the element and its json value (encoded in base64 in order to have it on one line) separated by a tab; example:\n";
 			echo "With this tool you can read all or some configurations.\n";
 			echo "\n";
 			echo "agent	ewogICJhbGlhc2VzIiA6IC6ICAogICJjaGl...\n";
 			echo "queue	iLAogICJjaGlewogICJhbGlhc26IC6ICCJa...\n";
 			echo "\n";
 			echo "Without parameters it will scan ALL the configurations, so that you can create a configuration dump or back-up:\n";
 			echo "\n";
 			echo "./queuemetrics-config-read.php [parameters]\n";
 			echo "or\n"; 			
 			echo "./queuemetrics-config-read.php [parameters] > output-file\n";
 			echo "\n";
 			echo "Possible parameters are:\n";
 			echo "\n";
 			echo "-n or --no-child: prevents the script from looking for child elements (for hierarchical editors)\n";
 			echo "-e or --editor: filter by name of the editor\n";
 			echo "-l or --element: filter a specific element by its ID (better used with -e)\n";
 			echo "-q or --query: filter by searching in elements' fields; use double quotes for more than one word\n";
 			echo "-p or --parent: filter by parent element's ID (for hierarchical editors, better used with -e)\n";
 			echo "-h or --help: will show this message\n";
 			echo "\n";
 			die();
 		}
		else if($argv[$i] == "-n" || $argv[$i] == "--no-child") {
			$child = false;
		}
 		else if(isset($argv[$i + 1])) {
 			switch($argv[$i]) {
 				case "-e":
 				case "--editor":
 					$editor = $argv[$i + 1];
 					break;
 				case "-l":
 				case "--element":
 					$element = $argv[$i + 1];
 					break;
 				case "-q":
 				case "--query":
 					$query = $argv[$i + 1];
 					break;
 				case "-p":
 				case "--parent":
 					$parent = $argv[$i + 1];
 					break;
 				default:
 					die("\n\nInvalid parameters! Try --help\n");
 			}
 			
 			$i++;	// Skip one
 		}
 		else {
 			die("\n\nInvalid parameters! Try --help\n");
 		}
 	}
 	
 	if($editor == "") {
		foreach($editors_write as $editor) {
			read_all($editor, $element, $query, $parent, $child);
		}
 	}
 	else if(in_array($editor, $editors_write) || in_array($editor, $child_editors)) {
 		read_all($editor, $element, $query, $parent, $child);
 	}
 	else {
 		if($editor == "class") {
 			die("\n\nclass editor has to be enabled manually from includes/init.php\n");
 		}
 		else {
 			die("\n\nSpecified editor doesn't exists\n");
 		}
 	}

?>