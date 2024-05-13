<?php

 require_once("include/connection.php");

 if(isset($_GET['file_id'])){
    $id = mysqli_real_escape_string($conn,$_GET['file_id']);
    
    mysqli_query($conn,"INSERT INTO surat_ditolak (no_surat, jenis_surat, nama, nim, noHP, email, jurusan) SELECT ID, jenis_surat, nama, nim, noHP, email, jurusan FROM surat_magang WHERE ID='$id'")or die(mysql_error());

    mysqli_query($conn,"DELETE FROM surat_magang WHERE ID='$id'")or die(mysql_error());
    echo '
    <script type = "text/javascript">
        alert("Surat berhasil ditolak.");
        window.location = "arsip_magang.php";
    </script>
    ';
 }
?>