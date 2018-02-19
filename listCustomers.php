<?php 
include("isJson.php");
include("greatCircleDistance.php");

$intercomLatitude = "53.339428"; 
$intercomLongitude = "-6.257664";
$errorMessage = "";
$listToInvite = array();

$contents = @file_get_contents("customers.json");

if($contents === FALSE){
	$errorMessage = "Sorry, no such file exists";
}else{
	if(isJson($contents)){
		$recordsArray  = json_decode(trim($contents), true);
		foreach($recordsArray as $record){
			if(greatCircleDistance($intercomLatitude, $intercomLongitude, $record["latitude"], $record["longitude"]) < 100000){//100 kms in metres
					$listToInvite[$record["user_id"]] = $record["name"];
			}			
		}

		if(count($listToInvite) > 0){
			ksort($listToInvite);// sort by key 		
			include("viewListCustomers.phtml");	
		}
		else
		{
			$errorMessage = "No customers found";
		}

	}
	else
	{
		switch (json_last_error()) {
	        case JSON_ERROR_DEPTH:
	            $errorMessage = 'JSON Error: Maximum stack depth exceeded';
	        break;
	        case JSON_ERROR_STATE_MISMATCH:
	            $errorMessage = 'JSON Error: Underflow or the modes mismatch';
	        break;
	        case JSON_ERROR_CTRL_CHAR:
	            $errorMessage = 'JSON Error: Unexpected control character found';
	        break;
	        case JSON_ERROR_SYNTAX:
	            $errorMessage = 'JSON Error: Syntax error, malformed JSON';
	        break;
	        case JSON_ERROR_UTF8:
	            $errorMessage = 'JSON Error: Malformed UTF-8 characters, possibly incorrectly encoded';
	        break;
	        default:
	            $errorMessage = 'JSON Error: Unknown error';
	        break;
    	}
	}	
}

if($errorMessage != ""){
	include("viewListError.phtml");	
}
?> 