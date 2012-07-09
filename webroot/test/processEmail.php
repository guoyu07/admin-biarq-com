<?php $HTTP_POST_VARS[]; ?><?php

//create short variable names
$name=$_POST['name'];
$email=$_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$name=trim($name);
$email=trim($email);
$subject=StripSlashes($subject);
$message=StripSlashes($message);
//modify the next line with your own email address
$toaddress='jonylucas@aeiou.pt';


function validate_email($email) {

  // Function to validate an e-mail address by both checking the
  // format of the address, and then testing it by holding an
  // authorisation conversation with the addresses SMTP server
  //
  // inputs - $email = the email address itself
  // 
  // returns - function has a return value of
  //           0 = success
  //           1 = failed, invalid address
  //           2 = system failure
  //
  // Written by Trib after reading, combining, enhancing and modifying
  // the efforts of too many other people to give a credit list. However
  // Jay Greenspan deserves a mention for his exhaustive work on address
  // parsing (see the link in the rutorial at 
  // http://www.trib-design.com/gurututs/validatemail.php
  // and also so does an unknown person who wrote the SMTP MX record
  // query program which got me to thinking about the problem from the 
  // SMTP perspective.
  //
  // You can also find the associated e-mail contact form at
  // <this address - later>
  //
  // Permission is hereby given to use, distribute and modify this code
  // without restriction or condition. However if you are a decent person
  // you might consider putting a credit into your comments. If you do,
  // I'm K. Salt (a.k.a. Trib) at http://www.trib-design.com. Thanks and ...
  //
  // enjoy .....

  global $HTTP_HOST;

  // Check for a malformed address (roughly)
  if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) { 
    // it failed the simple format test, so return with an invalid address error
    return 1;
  }  
  // otherwise it passes the test so we can go off and do the 'real' validation
  //
  // first split #email up into parts
  list ( $Username, $Domain ) = split ("@",$email);

  // look for an MX record and get the mail host name
  if (checkdnsrr ( $Domain, "MX" ))  {  
    if (getmxrr ($Domain, $MXrec))  {  
      // save the MX hostname ready for Phase 3 testing
	$Mailserver = $MXrec[0];
    } else {
      // there is an MX record, but we failed to retrieve it
      return 2; // return system error NOT invalid address
    }
  } else {
    // in this case there isn't an MX record so assume that the domain
    // portion is also the name of the mail server itself (it can happen)
    // save it as the mailserver address ready for Phase 3 testing
    $Mailserver = $Domain;
  }

  // open a socket connection to the Mailserver
  if ($Connection = fsockopen($Mailserver, 25)) {

    // start the SMTP validation

    if (ereg("^220", $Rubbish = fgets($Connection, 1024))) {
      // it is an SMTP server so you can start talking to it

      // Tell it who you are and get the response (not needed later). 
      fputs ( $Connection, "HELO $HTTP_HOST\r\n" );  
      $Rubbish = fgets ( $Connection, 1024 );

      // Ask it to accept mail from your $email user - store the response (needed later)
      fputs ( $Connection, "MAIL FROM: <{$email}>\r\n" );  
      $Fromstring = fgets ( $Connection, 1024 ); 

      // Ask it to accept mail for your $email user - store the response (needed later)
      fputs ( $Connection, "RCPT TO: <{$email}>\r\n" );  
      $Tostring = fgets ( $Connection, 1024 );

      // Now tell it you're done with chatting
      fputs ( $Connection, "QUIT\r\n");  
      // and close the connection
       fclose($Connection);  

      // finally test the resonses did we get OK (type 250) messages?
      if (ereg("^250", $Fromstring) && ereg("^250", $Tostring)) {
        // YAHOOO .. we got a good one
        return 0; //  return successful validation
      } else {
        // the server refused the user
        return 1; // return invalid address
      }
    } else {
      // connected, to something but it failed to identfy itself as an SMTP server 
      // so assume its a bogus address
      return 1; // return invalid address error
    }
  } else {
    // it failed to connect 
    return 1; // return invalid address or system error - its your call
  }
}

$valid = validate_email($email);

switch ($valid) {

  case 0:
    mail($toaddress,$subject,$message,"From: $name <$email>");
     //clear the variables
     $name='';
     $email='';
     $subject='';
     $message='';
     echo 'response=passed';
     break;
  case 1:
     echo 'response=invalid';
     break;
  case 2:
     echo 'response=error';
     break;

}//end switch

?>