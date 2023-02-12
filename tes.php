<?php 
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function kirimEmail($email,$limit,$total){
    $mail = new PHPMailer(true);
    try {
       $mail->SMTPDebug = 1;									
       $mail->isSMTP();											
       $mail->Host	 = 'novara.id.domainesia.com';					
       $mail->SMTPAuth = true;							
       $mail->Username = 'noreply@warungtehusi.com';				
       $mail->Password = 'eAGTGqQzpXrM';						
       $mail->SMTPSecure = 'tsl';							
       $mail->Port	 = 25;

       $mail->setFrom('noreply@warungtehusi.com', 'DosaKu');
       $mail->addAddress($email);
       
       $mail->isHTML(true);								
       $mail->Subject = 'Peringatan Limit Pengeluaran';
       $mail->Body = 'Limit pengeluaran kamu sudah melebihi batas yang telah ditentukan.<br>
                    <b>Limit Pengeluaran : </b> Rp. '.number_format($limit,0,',','.').',-<br>
                    <b>Total Pengeluaran : </b> Rp. '.number_format($total,0,',','.').',-';
       $mail->send();
       return true;
    } catch (Exception $e) {
       return false;
    }
}
if(kirimEmail('rendijulianto37@gmail.com',1000000,2000000)){
    echo 'berhasil';
}else{
    echo 'gagal';
}