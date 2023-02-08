<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Notif extends Controller{

    private function kirimEmail($email,$limit,$total){
        $mail = new PHPMailer(true);
        try {
           $mail->SMTPDebug = 0;									
           $mail->isSMTP();											
           $mail->Host	 = 'mail.warungtehusi.com';					
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

    public function tampil()
    {
        $users = $this->model('User_model')->tampilUserLimit();
        foreach($users as $user){
            $this->kirimEmail($user['email'],$user['limitPengeluaran'],$user['total_pengeluaran']);
            $user['limit'] = 0;
            $u = $this->model('User_model');
            $u->setEmail($user['email']);
            $u->setLastNotif(date('Y-m-d H:i:s'));
            $u->updateLastNotif();
            echo "Berhasil mengirim email ke ".$user['email']."<br>";
        }
    }
}