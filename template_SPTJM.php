<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        mysqli_query($conn,"INSERT INTO surat_keluar (no_surat, jenis_surat, nama, nim, noHP, email, jurusan) SELECT ID, jenis_surat, nama, nim, noHP, email, jurusan FROM surat_msib WHERE ID='$id'")or die(mysql_error());

        $query = mysqli_query($conn,"SELECT * from surat_msib where ID = $id") or die (mysqli_error($con));
        
        while($surat=mysqli_fetch_array($query)){
            $num =  $surat['ID'];
            $jenis = $surat['jenis_surat'];
            $nama = $surat['nama'];
            $nim =  $surat['nim'];
            $nohp = $surat['noHP'];
            $email = $surat['email'];
            $jurusan =  $surat['jurusan'];
            $nik = $surat['nik'];
            $smt = $surat['smt'];
            $ipk = $surat['ipk'];
            $sks = $surat['sks'];
            $ortu = $surat['nama_ortu'];
        
            require 'vendor\autoload.php';
            
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_SPTJM.docx');
            $templateProcessor->setValues([
                'nama' => $nama,
                'jurusan' => $jurusan,
                'nim' => $nim,
                'nik' => $nik,
                'nohp' => $nohp,
                'email' => $email,
                'ortu' => $ortu,
            ]);
            
            $pathToSave = 'output/SPTJM/'.$num.'_surat_SPTJM_'.$nama.'.docx';
            $templateProcessor->saveAs($pathToSave);

        }
        mysqli_query($conn,"DELETE FROM surat_msib WHERE ID='$num'")or die(mysql_error());
        mysqli_query($conn,"DELETE FROM surat_masuk WHERE no_surat='$num' and jenis_surat='MSIB'")or die(mysql_error());
        

    }
    
?>