<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        mysqli_query($conn,"INSERT INTO surat_keluar (no_surat, jenis_surat, nama, nim, noHP, email, jurusan) SELECT ID, jenis_surat, nama, nim, noHP, email, jurusan FROM surat_skam WHERE ID='$id'")or die(mysql_error());

        $query = mysqli_query($conn,"SELECT * from surat_skam where ID = $id") or die (mysqli_error($con));
        
        while($surat=mysqli_fetch_array($query)){
            $num =  $surat['ID'];
            $jenis = $surat['jenis_surat'];
            $nama = $surat['nama'];
            $nim =  $surat['nim'];
            $nohp = $surat['noHP'];
            $jurusan =  $surat['jurusan'];
            $alamat =  $surat['alamat_tinggal'];
        
            require 'vendor\autoload.php';
            
            if($jurusan = 'Teknik Informatika'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_SKAM_IF.docx');
            }elseif($jurusan = 'Sistem Informasi'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_SKAM_SI.docx');
            }
            $templateProcessor->setValues([
                'num' => $num,
                'tanggal' => date('d-M-Y'),
                'nim' => $nim,
                'nama' => $nama,
            ]);
            
            $pathToSave = 'output/keterangan_aktif/'.$num.'_surat_SKAM_'.$nama.'.docx';
            $templateProcessor->saveAs($pathToSave);

        }
        mysqli_query($conn,"DELETE FROM surat_skam WHERE ID='$num'")or die(mysql_error());
        mysqli_query($conn,"DELETE FROM surat_masuk WHERE no_surat='$num' and jenis_surat='SKAM'")or die(mysql_error());
        
        include 'kirim_surat_SKAM.php';

    }
    
?>