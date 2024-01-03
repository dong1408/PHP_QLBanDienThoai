<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Create an instance; passing `true` enables exceptions

function send_mail($receiver_email, $receiver_fullname, $title, $content){
    global $email_config;
    $mail = new PHPMailer(true);
    try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 0;  
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $email_config['smtp_host'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $email_config['smtp_user'];                     //SMTP username
    $mail->Password   = $email_config['smtp_pass'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $email_config['smtp_port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = $email_config['charset'];
    
    //Recipients
    $mail->setFrom($email_config['smtp_user'], $email_config['smtp_fullname']);
    $mail->addAddress($receiver_email, $receiver_fullname);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo($email_config['smtp_user'], $email_config['smtp_fullname']);
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments : Đính kèm file
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $title;
    $mail->Body    = $content;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    } catch (Exception $e) {
        echo "Email không được gửi, chi tiết lỗi: {$mail->ErrorInfo}";
    }
}
