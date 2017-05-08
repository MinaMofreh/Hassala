<?php

if (isset($_POST['str'])) {
    include_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
    $val = new validator();
    $str = $_POST['str'];
    $email = $str;
    $verificationCode = $val->GenrateVerificationCode("forget" . $email, "pass" . $email);

    function send_email($email, $verificationCode) {
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

        $mail->Subject = 'Welcome, Doctor';
        $mail->Body = 'Welcome to <b>Hsala</b> course management community<br> 
                      it is seems that you are trying to reset your password<br>
                      Here is the code :) <br>
                      <b>Verification code:</b>: ' . $verificationCode . ' <br>
                     / /sitelink ';

        if (!$mail->send()) {
            return True;
        } else {
            return False;
        }
    }

    send_email($email, $verificationCode, $name);
    echo $verificationCode;
}
?>