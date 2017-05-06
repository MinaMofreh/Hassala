<?php 
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
if(isset($_POST['str'])){
	$val   = new validator();
	$str   = $_POST['str'];
	$vars  = explode(":", $str);

	$var1  = $vars[0]; // username
	$var2  = $vars[1]; // cf_handle
	$email = $vars[2]; // email
  $name  = $vars[3]; // name
	$verificationCode = $val->GenrateVerificationCode($var1,$var2);
  	function send_email($email,$verificationCode, $name){
    $mail = new PHPMailer; // create new object
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'hassalafcih@gmail.com';                 // SMTP username
    $mail->Password = '20150156';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;   

    $mail->setFrom('from@example.com', 'Hsala');
    $mail->addAddress($email, 'Joe User');     // Add a recipient
    $mail->addReplyTo('hassalafcih@gmail.com', 'Admin');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');                                 
  
    
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Welcome, Dr/'.$name;
    $mail->Body    = 'Welcome to <b>Hsala</b> course management community<br> 
                      <b>Verification code:</b>: '. $verificationCode .' <br>
                     / /sitelink ';
    
    if(!$mail->send()) {
    return True;
} else {
    return False;
}
   }
   send_email($email,$verificationCode,$name);
   echo $verificationCode;
}
?>