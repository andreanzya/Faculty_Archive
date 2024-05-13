<?php

require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        $query = mysqli_query($conn,"SELECT * from surat_keluar where no_surat = $id and jenis_surat = 'Riset Penelitian'") or die (mysqli_error($con));
        while($surat=mysqli_fetch_assoc($query)){

            $num =  $surat['no_surat'];
            $jenis = $surat['jenis_surat'];
            $nama =  $surat['nama'];
            $nim =  $surat['nim'];
            $email =  $surat['email'];

            $mail = new PHPMailer();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'tedyandreanz@gmail.com';
            $mail->Password = 'knulaytcrlhwykke';   

            $mail->From     = "tedyandreanz@gmail.com";
            $mail->FromName = "Tedy Andreansyah";
            $mail->addReplyTo("tedyandreanz@gmail.com", "Tedy Andreansyah");
            $mail->addAddress("$email", "$nama");
            $mail->Subject  = "Pengajuan Permohonan Surat Keperluan Akademik";
            $mail->Body     = "Berikut dilampirkan surat yang saudara/saudari sudah ajukan melalui website permohonan surat. Terima kasih dan semoga sukses.";

            $attachment = 'output/riset_penelitian/'.$num.'_surat_penelitian_'.$nama.'.docx';
            $mail->AddAttachment($attachment);
            }

            if($mail->send()) {

                echo '
				<script type = "text/javascript">
					alert("Email berhasil dikirim.");
					window.location = "arsip_riset.php";
				</script>
                ';
                exit;
            } 
            else {
                echo'
                <script type = "text/javascript">
					alert("Error: " . $mail->ErrorInfo;);
					window.location = "arsip_riset.php";
				</script>
                ';
            }
        }
?>