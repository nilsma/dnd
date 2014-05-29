<?php
session_start();
	
  $email = $_POST['email'];
  $message = $_POST['message'];
  $username = $_POST['user_name'];
  $topic = $_POST['topic'];
  
  $body ="username: {$_POST['user_name']}\n\ntopic: {$_POST['topic']}\n\nmessage: {$_POST['message']}";
  
if(isset($username) && !empty($username) && isset($email) && !empty($email) && isset($message) && strlen($message) >= 4) {
	mail( "reneewb@hotmail.com", "Feedback From D&D site", $body, "From: {$_POST['email']}");
	header( "Location: http://dikult205.h.uib.no/groups/G5/dnd/html/application/views/thankyou.html" );
} else {
	$errors = array();
	if(empty($username)) {
		$errors[] = 'the username field is empty';
	}
	
	if(empty($email)) {
		$errors[] = 'the e-mail field is empty';
	}
	
	if(strlen($message) <= 4) {
		$errors[] = 'the message field is empty';
	}
	
	$_SESSION['email_errors'] = $errors;
	header( "Location: http://dikult205.h.uib.no/groups/G5/dnd/html/application/views/about.php");
}
?>