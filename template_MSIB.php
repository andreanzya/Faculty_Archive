<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);



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
            
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_MSIB.docx');
            
            $templateProcessor->setValues([
                'num' => $num,
                'nama' => $nama,
                'nik' => $nik,
                'nim' => $nim,
                'jurusan' => $jurusan,
                'semester' => $smt,
                'ipk' => $ipk,
                'sks' => $sks,
                'tanggal' => date('d-M-Y'),
            ]);
            
            $pathToSave = 'output/MSIB/'.$num.'_surat_MSIB_'.$nama.'.docx';
            $templateProcessor->saveAs($pathToSave);

        }
        include_once 'template_SPTJM.php';
        include_once 'kirim_surat_MSIB.php';
    }
    
?>