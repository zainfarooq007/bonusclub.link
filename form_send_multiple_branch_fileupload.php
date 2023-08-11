<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="STEPS | Multipurpose Working Wizard with Branches">
    <meta name="author" content="Ansonika">
    <title>STEPS | Multipurpose Working Wizard with Branches</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

	<!-- GOOGLE WEB FONT -->
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

	<!-- BASE CSS -->
	<link href="css/style.css" rel="stylesheet">

	<!-- YOUR CUSTOM CSS -->
	<link href="css/custom.css" rel="stylesheet">
    
	<script type="text/javascript">
    function delayedRedirect(){
        window.location = "index.html"
    }
    </script>

</head>
<body style="background:#f8f8f8 url(img/pattern.svg) repeat;" onLoad="setTimeout('delayedRedirect()', 5000)">
<?php
						$mail = $_POST['email'];

						$to = "test@domain.com";	/* YOUR EMAIL HERE */
						$subject = "Quotation from STEPS";
						$headers = "From: Quotation from STEPS <noreply@yourdomain.com>";
						$message = "DETAILS\n";
						$message .= "\nWhat Type of Project do you need: " . $_POST['branch_1_group_1'] . "\n";
			
						if (isset($_POST['branch_1_answers']) && $_POST['branch_1_answers'] != "")
							{
							$message.= "\nWhat Type of Seo Optimization do you need:\n";
							foreach($_POST['branch_1_answers'] as $value)
								{
								$message.= "- " . trim(stripslashes($value)) . "\n";
								};
							}
	
						if (isset($_POST['branch_2_group_1']) && $_POST['branch_2_group_1'] != "")
							{
							$message.= "\nWhat Type of Web Development do you need: ". $_POST['branch_2_group_1'] . "\n\n";
							
							if (isset($_POST['branch_2_1_answers']) && $_POST['branch_2_1_answers'] != "")
								{
								foreach($_POST['branch_2_1_answers'] as $value)
									{
									$message.= "- " . trim(stripslashes($value)) . "\n";
									};
								$message .= "\nHome pages: " . $_POST['home_page'] . "\n";
								$message .= "\nInner pages: " . $_POST['inner_pages'] . "\n";
								$message .= "\nNotes: " . $_POST['html_development_notes'] . "\n";
								}
							
							if (isset($_POST['branch_2_2_answers']) && $_POST['branch_2_2_answers'] != "")
								{
								foreach($_POST['branch_2_2_answers'] as $value)
									{
									$message.= "- " . trim(stripslashes($value)) . "\n";
									};
								$message .= "\nNotes: " . $_POST['cms_development_notes'] . "\n";
								}
							
							if (isset($_POST['branch_2_3_answers']) && $_POST['branch_2_3_answers'] != "")
								{
								foreach($_POST['branch_2_3_answers'] as $value)
									{
									$message.= "- " . trim(stripslashes($value)) . "\n";
									};
									$message .= "\nNotes: " . $_POST['frontend_development_notes'] . "\n";
								}
							
							}

						if (isset($_POST['branch_3_answers']) && $_POST['branch_3_answers'] != "")
							{
							$message.= "\nWhat Type of Design do you need:\n";
							foreach($_POST['branch_3_answers'] as $value)
								{
								$message.= "- " . trim(stripslashes($value)) . "\n";
								};
							}
	
						$message .= "\nWhat is your Budget: " . $_POST['budget_slider']. "$". "\n";
						$message .= "\nPERSONAL DETAILS" ;
						$message .= "\nName and Lastname: " . $_POST['first_last_name'];
						$message .= "\nEmail: " . $_POST['email'];
						$message .= "\nTelephone " . $_POST['telephone'];
						$message .= "\nCountry: " . $_POST['country'];


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
						while (file_exists( 'upload_files/'.$FinalFilename )) // The folder where the files will be stored; set the permission folder to  0755. 
					   		$FinalFilename = $FileCounter++.'_'.$OriginalFilename; 

							if(in_array($file_ext,$expensions)=== false){
								$errors[]="Extension not allowed, please choose a jpg, jpeg, .png, .pdf, .doc, .docx file.";
							}
							// Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
							if($file_size > 153600){
								$errors[]='File size must be max 150Kb';
							}
							if(empty($errors)==true){
								move_uploaded_file($file_tmp,"upload_files/".$FinalFilename);
								$message .= "\nFile uploaded: http://www.yourdomain.com/upload_files/".$FinalFilename; // Write here the path of your upload_files folder
							}else{
								$message .= "\nFile name: no files uploaded";
								}
							};
						/* end FILE UPLOAD */


						$message .= "\nTerms and conditions accepted: " . $_POST['terms'] . "\n";
												
						//Receive Variable
						$sentOk = mail($to,$subject,$message,$headers);
						
						//Confirmation page
						$user = "$mail";
						$usersubject = "Thank You";
						$userheaders = "From: info@steps.com\n";
						/*$usermessage = "Thank you for your time. Your quotation request is successfully submitted.\n"; WITH OUT SUMMARY*/
						//Confirmation page WITH  SUMMARY
						$usermessage = "Thank you for your time. Your quotation request is successfully submitted. We will reply shortly.\n\nBELOW A SUMMARY\n\n$message"; 
						mail($user,$usersubject,$usermessage,$userheaders);
	
?>
<!-- END SEND MAIL SCRIPT -->   
<div id="success">
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
</div>
</body>
</html>