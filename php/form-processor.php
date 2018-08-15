<?php

$config_fields = [
	"required" => "array",
	"allowed" => "array",
	"email_to" => "string",
	"email_from" => "string",
	"subject" => "string",
	"response" => "string",
];

// Check if configuration is set
if( !isset( $CONFIG ) ){
	trigger_error( "Form configuration is not set", E_USER_ERROR );
}

// Check that all required configuration fields are valid
foreach( $config_fields as $field => $type ){
	if( ! isset($CONFIG[$field]) || gettype($CONFIG[$field]) != $type ){
		trigger_error("Configuration field '$field' was not set", E_USER_ERROR );
	}

	// Check if all config email addresses specified are valid
	if( preg_match("/mail/", $field) ){
		if ( ! filter_var( $CONFIG[$field], FILTER_VALIDATE_EMAIL) ) {
			trigger_error("Configuration field '$field' is not a valid email",  E_USER_ERROR );
		}
	}

}

// TODO: Spam trap

// validation expected data exists
foreach( $CONFIG["required"] as $field){
	if( ! isset( $_POST[$field] ) || !$_POST[$field] ){
		respond( false, "Required field '$field' is absent" );
	}

	if( preg_match("/mail/", $field) ){
		if ( !filter_var( $_POST[$field], FILTER_VALIDATE_EMAIL) ) {
			respond( false, "'$field' is not a valid email" );
		}
	}
}

// Populate the contact message
// Sanitize all strings

$message = "Form details below.\n\n";

foreach( $CONFIG["allowed"] as $field ){
	$message .= "$field: " . clean_string( trim($_POSt[$field]) ) . "\n";
}
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
isset( $CONFIG["reply_field"]) ? ( 'Reply-To: '. $_POST[ $CONFIG["reply_field"] ] ."\r\n" ) : "".
'X-Mailer: PHP/' . phpversion();

@mail( $CONFIG["email_to"], $CONFIG["subject"], $message, $headers);

respond(true, $CONFIG["response"] );



function respond( $status, $msg ){
	$response = [
		"status" => $status,
		"msg" => $msg
	];
	echo( json_encode($response) );
	exit();
}

function clean_string($string) {
	$bad = array("content-type","bcc:","to:","cc:","href");
	return str_replace($bad,"", $string);
}