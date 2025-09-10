<?php
$name= $_POST['fname'];
$lastname= $_POST['lname'];
$phone= $_POST['phone'];
$emailHelp= $_POST['email'];
$comments=$_POST['msg'];

if(isset($name) && isset($lastname) && isset($phone) && isset($emailHelp))
{
    global $to_email,$vpb_message_body,$headers;
    $to_email="salem@centralemeuble.com,bahrisalem5@gmail.com";

    // موضوع قصير وواضح
    $subject = "New Contact Form Submission from ".$name." ".$lastname;

    // جسم الرسالة
    $vpb_message_body = nl2br("Dear Admin,\n
    The user whose detail is shown below has sent this message from ".$_SERVER['HTTP_HOST']." dated ".date('d-m-Y').".\n
    
    Name: ".$name."\n
    Last Name: ".$lastname."\n
    Phone Number: ".$phone."\n
    Email Address: ".$emailHelp."\n
    Message: ".$comments."\n
    User Ip: ".getHostByName(getHostName())."\n
    Thank You!\n\n");

    // إعدادات الـ Headers
    $headers  = "From: $name <$emailHelp>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Message-ID: <".time().rand(1,1000)."@".$_SERVER['SERVER_NAME'].">\r\n"; 

    // صح: subject منفصل عن body
    if(@mail($to_email, $subject, $vpb_message_body, $headers))
    {
        $status='Success';
        $output="Congrats ".$name.", your email message has been sent successfully! We will get back to you as soon as possible. Thanks.";
    } 
    else 
    {
        $status='error';
        $output="Sorry, your email could not be sent at the moment. Please try again or contact this website admin to report this error message if the problem persist. Thanks.";
    }   
}
else
{
    $status='error';
    $output="please fill required fields";
}

echo json_encode(array('status'=> $status, 'msg'=>$output));
?>
