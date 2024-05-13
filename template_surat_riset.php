<?php
    require_once("include/connection.php");

    if(isset($_GET['file_id'])){
        $id = mysqli_real_escape_string($conn, $_GET['file_id']);

        mysqli_query($conn,"INSERT INTO surat_keluar (no_surat, jenis_surat, nama, nim, noHP, email, jurusan) SELECT ID, jenis_surat, nama, nim, noHP, email, jurusan FROM surat_penelitian WHERE ID='$id'")or die(mysql_error());

        $query = mysqli_query($conn,"SELECT * from surat_penelitian where ID = $id") or die (mysqli_error($con));
        
        while($surat=mysqli_fetch_array($query)){
            $num =  $surat['ID'];
            $jenis = $surat['jenis_surat'];
            $nama = $surat['nama'];
            $nim =  $surat['nim'];
            $nohp = $surat['noHP'];
            $email = $surat['email'];
            $jurusan =  $surat['jurusan'];
            $pengurus = $surat['pengurus_jabatan'];
            $nopengurus = $surat['nohppengurus'];
            $perusahaan = $surat['instansi'];
            $alamat = $surat['alamat_tujuan'];
            $judul = $surat['judul'];
           
        
            require 'vendor\autoload.php';
            
            if($jurusan = 'Teknik Informatika'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_riset_IF.docx');
            }elseif($jurusan = 'Sistem Informasi'){
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('template\template_riset_SI.docx');
            }
            
            $templateProcessor->setValues([
                'num' => $num,
                'nama' => $nama,
                'nim' => $nim,
                'jurusan' => $jurusan,
                'nohp' => $nohp,
                'judul' => $judul,
                'pengurus' => $pengurus,
                'perusahaan' => $perusahaan,
                'alamatTujuan' => $alamat,
                'tanggal' => date('d-M-Y'),
            ]);
            
            $pathToSave = 'output/riset_penelitian/'.$num.'_surat_penelitian_'.$nama.'.docx';
            $templateProcessor->saveAs($pathToSave);

        }
        mysqli_query($conn,"DELETE FROM surat_penelitian WHERE ID='$num'")or die(mysql_error());
        mysqli_query($conn,"DELETE FROM surat_masuk WHERE no_surat='$num' and jenis_surat='Riset Penelitian'")or die(mysql_error());
        
        include 'kirim_surat_penelitian.php';
    }
    
?>