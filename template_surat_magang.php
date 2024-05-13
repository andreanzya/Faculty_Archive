<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        mysqli_query($conn,"INSERT INTO surat_keluar (no_surat, jenis_surat, nama, nim, noHP, email, jurusan) SELECT ID, jenis_surat, nama, nim, noHP, email, jurusan FROM surat_magang WHERE ID='$id'")or die(mysql_error());

        $query = mysqli_query($conn,"SELECT * from surat_magang where ID = $id") or die (mysqli_error($con));
        
        while($surat=mysqli_fetch_array($query)){
            $num =  $surat['ID'];
            $jenis = $surat['jenis_surat'];
            $nama = $surat['nama'];
            $nim =  $surat['nim'];
            $nohp = $surat['noHP'];
            $jurusan =  $surat['jurusan'];
            $pengurus =  $surat['pengurus_jabatan'];
            $nopengurus = $surat['nohppengurus'];
            $perusahaan = $surat['perusahaan'];
            $alamat =  $surat['alamat_tujuan'];
        
            require 'vendor\autoload.php';
            
            if($jurusan = 'Teknik Informatika'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_magang_IF.docx');
            }elseif($jurusan = 'Sistem Informasi'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_magang_SI.docx');
            }
            $templateProcessor->setValues([
                'tanggal' => date('d-M-Y'),
                'perusahaan' => $perusahaan,
                'alamatTujuan' => $alamat,
                'nim' => $nim,
                'nama' => $nama,
                'nohp' => $nohp,
            ]);
            
            $pathToSave = 'output/magang/'.$num.'_surat_magang_'.$nama.'.docx';
            $templateProcessor->saveAs($pathToSave);
        }
        mysqli_query($conn,"DELETE FROM surat_magang WHERE ID='$num'")or die(mysql_error());
        mysqli_query($conn,"DELETE FROM surat_masuk WHERE no_surat='$num' and jenis_surat='Magang'")or die(mysql_error());
        include_once 'kirim_surat_magang.php';
    }
    
?>