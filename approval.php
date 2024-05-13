<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        $query = mysqli_query($conn,"SELECT * from surat_masuk where ID = $id") or die (mysqli_error($con));
        
        while($surat=mysqli_fetch_array($query)){
            $num =  $surat['ID'];
            $jenis = $surat['surat'];

            switch($jenis){
                case 'Magang' :
                    include "template_surat_magang.php";
                    break;
                case 'Riset Penelitian' :
                    include "template_surat_riset.php";
                    break;
                case 'SKAM' :
                    include "template_SKAM.php";
                    break;
                case 'MSIB' :
                    include "template_MSIB.php";
                    break;
            }
            include "kirimj_surat.php";
            exit;
            
            exit;
        }
    }
?>
