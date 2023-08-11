<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>STEPS | Multipurpose Working Wizard with Branches</title>

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="../css/custom.css" rel="stylesheet">
    
	<script type="text/javascript">
    function delayedRedirect(){
        window.location = "../index-3.html"
    }
    </script>

</head>
<body onLoad="setTimeout('delayedRedirect()', 8000)" style="background-color:#fff;">
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';

$mail = new PHPMailer(true);

try {

    //Recipients - main edits
    $mail->setFrom('info@steps.com', 'Message from STEPS');                    // Email Address and Name FROM
    $mail->addAddress('jhon@steps.com', 'Jhon Doe');                           // Email Address and Name TO - Name is optional
    $mail->addReplyTo('noreply@steps.com', 'Message from STEPS');              // Email Address and Name NOREPLY
    $mail->isHTML(true);                                                       
    $mail->Subject = 'Message from STEPS';                                     // Email Subject

    //The email body message
    $message = "<strong>Details</strong><br />";
    $message .= "What Type of Project do you need:<br />";
        foreach($_POST['answers_1'] as $value) 
        { 
        $message .=   "- " .  trim(stripslashes($value)) . "<br />"; 
        };
    $message .= "<br />Are you a Company or Private User: " . $_POST['answer_group_1'] . "<br />";
    $message .= "<br />Answers to the following questions:";
    $message .= "<br />If you already have an hosting plan, please define: " . $_POST['select_1'];
    $message .= "<br />If you need an hosting plan, please define which one: " . $_POST['select_2'];
    $message .= "<br />If you need a newsletter campaign, please define the provider you prefer: " . $_POST['select_3'];
    $message .= "<br /><br />What is your Budget: " . $_POST['budget_slider']. "$". "<br />";
    $message .= "<br /><strong>User Details</strong><br />";
    $message .= "Name and Lastname: " . $_POST['first_last_name'];
    $message .= "<br />Email: " . $_POST['email'];
    $message .= "<br />Telephone " . $_POST['telephone'];
    $message .= "<br />Country: " . $_POST['country'];
    $message .= "<br />Terms and conditions accepted: " . $_POST['terms'];

	$mail->Body = "" . $message . "";

    $mail->send();

    // Confirmation/autoreplay email send to who fill the form
    $mail->ClearAddresses();
    $mail->addAddress($_POST['email']); // Email address entered on form
    $mail->isHTML(true);
    $mail->Subject    = 'Confirmation'; // Custom subject
    $mail->Body = "" . $message . "";

    $mail->Send();

    echo '<div id="success">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h4><span>Request successfully sent!</span>Thank you for your time</h4>
            <small>You will be redirect back in 5 seconds.</small>
        </div>';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
	
?>
<!-- END SEND MAIL SCRIPT -->   

</body>
</html>