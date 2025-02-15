<?php
if(isset($_POST['contactUsEmail'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "mahendrabhamu08@gmail.com";
    $email_subject = "Contact Us- Enquiry";
    
    
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    
     // validation expected data exists
    if(!isset($_POST['contactUsName']) ||
        !isset($_POST['contactUsGmail']) ||
        !isset($_POST['contactUsMobile']) ||
        !isset($_POST['contactUsMessage'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
    
    
    
    $first_name = $_POST['contactUsName']; // required
    $email_from = $_POST['contactUsGmail']; // required
    $telephone = $_POST['contactUsMobile']; // not required
    $comments = $_POST['contactUsMessage']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    
    
     
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
 

  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
    
  
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

 

 
alert("Thank you for contacting us. We will be in touch with you very soon.");
 

 
}
?>   
