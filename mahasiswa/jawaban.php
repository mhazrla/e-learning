<?php
include "/config/koneksi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-LEARNING</title>
	  <link rel="icon" type="image/png" id="favicon"
          href="../img/logosttikomiulagi.png"/>
</head>

<body>
 <center>
  <?php
		$nim=$_SESSION['username'];
		$hasil=mysql_query("select p.username, mhs.nim,mhs.namamhs, mhs.kd_kelas 
from tbl_pengguna p, tbl_mahasiswa mhs where p.username=mhs.nim AND p.username='$nim'");

		$row =mysql_fetch_array($hasil);
		
			$nim=$row["nim"];
			$nama =$row["namamhs"];
			$kelas = $row["kd_kelas"];
		?>
      <div role="main" class="container products list">        
        <div class="row">         
		 <div class="span12" style="width:100%;border:1px solid black;text-align:left;height:30px;margin-bottom:20px;border:1px solid #abb4c2;
  box-shadow: 1px 1px 2px rgba(0,0,0,.3);padding-top:10px;padding-left:10px;">Selamat Datang <?php echo $nama;?></div>
          <div class="span8" style="height:400px;border:1px solid black;border:1px solid #abb4c2;
  box-shadow: 1px 1px 2px rgba(0,0,0,.3);">
			<div style="float:left;border:0px solid black;margin-left:20px;">

        <h3>Hasil Jawaban <?php echo $nama;?></h3>
        
	   <?php 
       if(isset($_POST['submit'])){
			$pilihan=$_POST["pilihan"];
			$idsoal=$_POST["id"];
			$jumlahpg=$_POST['jumlahpg'];
			$idsoalujian=$_POST['idsoalujian'];
			$idjawaban=$_POST['idjawaban'];
			$kdmk=$_POST['kdmk'];
			$kdkelas=$_POST['kdkelas'];
			
			$nim=$_SESSION['username'];
			// $benar=$_POST['benar'];
			// $salah=$_POST['salah'];
			// $kosong=$_POST['kosong'];
			// $point=$_POST['point'];
			$tanggal=date("Y-m-d");
			// $tipe = $_SESSION['tipe'];
			
			
			
			
			
			
			$score=0;
			$benar=0;
			$salah=0;
			$kosong=0;
			
			for ($i=0;$i<$jumlahpg;$i++){
				//id nomor soal
				
				$nomor=$idsoal[$i];
				
				
				
				
				//jika user tidak memilih jawaban
				if (empty($pilihan[$nomor])){
					$kosong++;
				}
				else{
					//jawaban dari user
					$jawaban=$pilihan[$nomor];
					
					
					//cocokan jawaban user dengan jawaban di database
					$query=mysql_query("select * from tbl_banksoalpg where id_soal='$nomor' and kunci_jwb='$jawaban'");
					
					$cek=mysql_num_rows($query);
					
					if($cek){
						//jika jawaban cocok (benar)
						$benar++;
						
					}
					else{
						//jika salah
						$salah++;
						
					}				
					
					
				} 
				$varnilai = 100;
				$score = $benar*$varnilai;
				$scoreakhir=$score/$jumlahpg;
				
				
			}
			
			
			$querytambah=mysql_query("INSERT INTO tbl_nilai values('$idjawaban','$idsoalujian','$kdmk','$kdkelas','$nim','$scoreakhir')");
			
			
			
						
		
		}
		?><center>
		<table width="100%" border="0">
		<tr>
		<td>
		<?php 
		if ($scoreakhir > 50)
		{
		echo "<h3><center>SELAMAT ANDA MENDAPATKAN NILAI " . $scoreakhir."</h3>";
		}
		elseif ($scoreakhir <= 50){
		echo "<h3><center>MAAF ANDA  HANYA MENDAPATKAN NILAI " .$scoreakhir."</h3>";
		}
		?>
		<a href="?hal=home">Back</a>
		</td>
		</tr>
		</table>    
        </form> 
</div>

		


          </div>
		  
		  <div class="span3" style="float:right; border:0px solid black;margin-top:11px;">

  <div class="col-md-8"></div>
  <div class="col-md-4">
  	<ul class="nav nav nav-pills nav-stacked">
	<li class="active">PENCARIAN</li>
 <li>
	<table style='width:100%;'><tr><td><form name='formcari' method='POST' action='?hal=search' style="margin-top:10px;width:100%;"/><input type='input-text' name='title' type='text' placeholder='Pencarian'/>
					<input type='submit' name='input' value='Cari' style="color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #363636;
  *background-color: #222222;
  background-image: -moz-linear-gradient(top, #444444, #222222);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444444), to(#222222));
  background-image: -webkit-linear-gradient(top, #444444, #222222);
  background-image: -o-linear-gradient(top, #444444, #222222);
  background-image: linear-gradient(to bottom, #444444, #222222);
  background-repeat: repeat-x;
  border-color: #222222 #222222 #000000;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444', endColorstr='#ff222222', GradientType=0);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);width:18%;
  text-align:left;"/></td></tr></table>
  </li>
  
	</ul>
  </div>
</div>
		    <div class="span3" style="float:right; border:0px solid black;margin-top:11px;">

  <div class="col-md-8"></div>
  <div class="col-md-4">
  	<ul class="nav nav nav-pills nav-stacked">
	<li class="active">AKTIFITAS MAHASISWA</li>
 <li align="left">
 Kelas :
<?php
$kelasMHS = mysql_query("SELECT kd_kelas FROM tbl_mahasiswa where nim='$_SESSION[username]'");

$row =mysql_fetch_array($kelasMHS)
?>
&nbsp; <?php echo $row['kd_kelas'];?> 

  </li>
  
 
  <?php
$waliDSN = mysql_query("SELECT K.nid, D.namadsn FROM tbl_mahasiswa M, tbl_dosen D, tbl_kelas K where M.kd_kelas=K.kd_kelas AND K.nid=D.nid AND M.nim='$_SESSION[username]'");
?>
   <li align="left">
   Wali Dosen : 
	<?php 
$rowdata =mysql_fetch_array($waliDSN)
?>
&nbsp; <?php echo $rowdata['namadsn'];?> 

  </li>

  
  <li align="left">
 Kotak Materi :
<?php
$jawabTGS = mysql_query("SELECT COUNT(M.kd_materi) AS fileMTR 
FROM tbl_materi M, tbl_mahasiswa K 
where M.kd_kelas=K.kd_kelas AND K.nim='$_SESSION[username]'");
?> 
	<?php 
while ($rowdata =mysql_fetch_array($jawabTGS)){
?>
&nbsp; <?php echo $rowdata['fileMTR'];?>  Materi
<?php 
} 
?>
  </li>
  
	</ul>
  </div>
</div>
		   
        </div>
      </div>
</body>
</html>