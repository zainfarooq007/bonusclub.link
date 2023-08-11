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
        window.location = "../index.html"
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
    $message .= "What Type of Project do you need: " . $_POST['branch_1_group_1'] . "<br />";
            
    if (isset($_POST['branch_1_answers']) && $_POST['branch_1_answers'] != "")
        {
        $message.= "<br />What Type of Seo Optimization do you need:<br />";
            foreach($_POST['branch_1_answers'] as $value)
            {
            $message.= "-" . trim(stripslashes($value)) . "<br />";
            };
        }
    
    if (isset($_POST['branch_2_group_1']) && $_POST['branch_2_group_1'] != "")
        {
        $message.= "<br />What Type of Web Development do you need: ". $_POST['branch_2_group_1'] . "<br /><br />";
                            
    if (isset($_POST['branch_2_1_answers']) && $_POST['branch_2_1_answers'] != "")
        {
        foreach($_POST['branch_2_1_answers'] as $value)
        {
            $message.= "-" . trim(stripslashes($value)) . "\n";
        };
    
        $message .= "<br />Home pages: " . $_POST['home_page'] . "<br />";
        $message .= "<br />Inner pages: " . $_POST['inner_pages'] . "<br />";
        $message .= "<br />Notes: " . $_POST['html_development_notes'] . "<br />";
        }
                            
    if (isset($_POST['branch_2_2_answers']) && $_POST['branch_2_2_answers'] != "")
        {
        foreach($_POST['branch_2_2_answers'] as $value)
        {
            $message.= "-" . trim(stripslashes($value)) . "<br />";
        };
            $message .= "<br />Notes: " . $_POST['cms_development_notes'] . "<br />";
        }
                            
    if (isset($_POST['branch_2_3_answers']) && $_POST['branch_2_3_answers'] != "")
        {
        foreach($_POST['branch_2_3_answers'] as $value)
        {
            $message.= "-" . trim(stripslashes($value)) . "<br />";
            };
            $message .= "<br />Notes: " . $_POST['frontend_development_notes'] . "<br />";
            }                       
        }

    if (isset($_POST['branch_3_answers']) && $_POST['branch_3_answers'] != "")
        {
        $message.= "<br />What Type of Design do you need:<br />";
            foreach($_POST['branch_3_answers'] as $value)
                {
                    $message.= "-" . trim(stripslashes($value)) . "<br />";
                    };
                }
    
    $message .= "<br />What is your Budget: " . $_POST['budget_slider']. "$". "<br />";
    $message .= "<br /><strong>User Details</strong><br />" ;
    $message .= "Name and Lastname: " . $_POST['first_last_name'];
    $message .= "<br />Email: " . $_POST['email'];
    $message .= "<br />Telephone " . $_POST['telephone'];
    $message .= "<br />Country: " . $_POST['country'];

    /* FILE UPLOAD */
    if(isset($_FILES['fileupload'])){
        $errors= array();
        $file_name = $_FILES['fileupload']['name'];
        $file_size =$_FILES['fileupload']['size'];
        $file_tmp =$_FILES['fileupload']['tmp_name'];
        $file_type=$_FILES['fileupload']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['fileupload']['name'])));

        $expensions= array("jpeg","jpg","png","pdf","doc","docx");// Define with files are accepted
                              
        $OriginalFilename = $FinalFilename = preg_replace('`[^a-z0-9-_.]`i','',$_FILES['fileupload']['name']); 
        $FileCounter = 1; 
        while (file_exists( '../upload_files/'.$FinalFilename )) // The folder where the files will be stored; set the permission folder to  0755. 
        $FinalFilename = $FileCounter++.'_'.$OriginalFilename; 

            if(in_array($file_ext,$expensions)=== false){
            $errors[]="Extension not allowed, please choose a jpg, jpeg, .png, .pdf, .doc, .docx file.";
            }
            // Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
            if($file_size > 153600){
                $errors[]='File size must be max 150Kb';
            }
            if(empty($errors)==true){
                move_uploaded_file($file_tmp,"../upload_files/".$FinalFilename);
            $message .= "<br />File: http://www.yourdomain.com/upload_files/".$FinalFilename; // Write here the path of your upload_files folder
                }else{
                    $message .= "<br />File name: no files uploaded";
                }
            };
    /* end FILE UPLOAD */
    
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