#!/usr/bin/php
<?php 
 	require './includes/init.php';
 	
 	function add($editor, $element) {
 		global $editors_write, $child_editors;
 		
 		if(in_array($editor, $editors_write) || in_array($editor, $child_editors)) {
 			send_add_query($editor, $element);
 		}
 		else {
 			if($editor == "class") {
 				die("\nclass editor has to be enabled manually from includes/init.php\n\n");
 			}
 			else {
 				die("\nSpecified editor doesn't exists\n\n");
 			}
 		}
 	}
 	
 	if($argv[1] == "-h" || $argv[1] == "--help") {
 		echo "\n";
 		echo "Add a new QueueMetrics configuration from parameters or from file.\n";
 		echo "\n";
 		echo "Usage\n";
 		echo "\n";
 		echo "./queuemetrics-config-delete.php [editor name] [base64 encoded json object]\n";
 		echo "or\n";
 		echo "./queuemetrics-config-delete.php < input-file\n";
 		echo "\n";
 		echo "Every line of input-file should be composed as [editor name]<tab>[base64 encoded json object], e.g:\n";
 		echo "\n";
 		echo "agent	ewogICJhbGlhc2VzIiA6IC6ICAogICJjaGl...\n";
 		echo "queue	iLAogICJjaGlewogICJhbGlhc26IC6ICCJa...\n";
 		echo "\n";
 		echo "-h or --help: will show this message\n";
 		die();
 	}
 	
 	if(isset($argv[1]) && isset($argv[2])) {
 		add($argv[1], base64_decode($argv[2]));
 	}
 	
 	while($f = fgets(STDIN)) {
 		$data = explode("\t", $f);
 		
 		if(isset($data[0]) && isset($data[1])) {
 			add($data[0], base64_decode($data[1]));
 		}
 	}
?>