<?php
	if(isset($_SESSION['email_errors'])) {
	$errors = array();
	$errors = $_SESSION['email_errors'];

	$html = '';
	$html = $html . '<div id="email_errors">' . "\n";
	$html = $html . '<ul>' . "\n";
	foreach($errors as $error) {
	$html = $html . '<li>' . $error . '</li>';
	}
	$html = $html . '</ul>' . "\n";
	$html = $html . '</div>' . "\n";
	
	$_SESSION['email_errors'] = false;
	unset($_SESSION['email_errors']);
	
	echo $html;
	}
?>