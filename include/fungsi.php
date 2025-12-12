<?
	function output($output)
	{
		$output=str_replace("<br>","",$output);
		$output=str_replace("<BR>","",$output);
		return $output;
	}

	function input($input)
	{
		$input=str_replace(chr(13),"<br>",trim($input));
		$input=str_replace("'","`",$input);
		$input=strip_tags($input, '<br><b><i><u><strong>');
		return $input;
	}

	function tgl_indo($tgl)
	{
		$tanggal = substr($tgl,8,2);
		$bulan = getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
	}

	function tgl_show($tgl)
	{
		if($tgl<>"")
		{
		$tanggal = substr($tgl,8,2);
		$bulan = substr($tgl,5,2);
		$tahun = substr($tgl,0,4);
		return $tanggal.'/'.$bulan.'/'.$tahun;	
		}	 
	}

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 

	function getBulan2($bln){
				switch ($bln){
					case 1: 
						return "Jan";
						break;
					case 2:
						return "Feb";
						break;
					case 3:
						return "Mar";
						break;
					case 4:
						return "Apr";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Jun";
						break;
					case 7:
						return "Jul";
						break;
					case 8:
						return "Ags";
						break;
					case 9:
						return "Sep";
						break;
					case 10:
						return "Okt";
						break;
					case 11:
						return "Nov";
						break;
					case 12:
						return "Des";
						break;
				}
			} 

	function getHari($tgl){
				switch ($tgl){
					case Sunday: 
						return "Minggu";
						break;
					case Monday:
						return "Senin";
						break;
					case Tuesday:
						return "Selasa";
						break;
					case Wednesday:
						return "Rabu";
						break;
					case Thursday:
						return "Kamis";
						break;
					case Friday:
						return "Jum'at";
						break;
					case Saturday:
						return "Sabtu";
						break;
				}
			} 

	function Terbilang($x)
	{
	  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	  if ($x < 12)
		return " " . $abil[$x];
	  elseif ($x < 20)
		return Terbilang($x - 10) . "belas";
	  elseif ($x < 100)
		return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
	  elseif ($x < 200)
		return " seratus" . Terbilang($x - 100);
	  elseif ($x < 1000)
		return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
	  elseif ($x < 2000)
		return " seribu" . Terbilang($x - 1000);
	  elseif ($x < 1000000)
		return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
	  elseif ($x < 1000000000)
		return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
	   elseif ($x < 1000000000000)
		return Terbilang($x / 1000000000) . " milyar" . Terbilang(fmod($x,1000000000));
	  elseif ($x < 1000000000000000)
		return Terbilang($x / 1000000000000) . " trilyun" . Terbilang(fmod($x,1000000000000));

	  /*
		manggil :
		 echo number_format($angka, 0) . "<br>";
        echo ucwords(Terbilang($angka));
	  */
	}

	function email($to,$nama,$password,$sha)
	{
		$subject="Notifikasi Pendaftaran LSP-IPI";
		$content="Salam hormat,<br>Dengan ini kami sampaikan, bahwa proses pendaftaran LSP-IPI telah berhasil, silahkan lakukan aktivasi dengan mengklik tautan <a href='https://sertifikasi.lsp-ipi.id/6208e24c9eb59f8c2c9e828c13547447' target='blank'>berikut</a>.
			<br><br>
			Akun login anda :
			<br>Username : ".$to."
			<br>Password : ".$password."
			<br>
				<br><br><br><br>
				<i>Email Ini Digenerate Otomatis dan Hanya Berupa Notifikasi</i>";
		
		require("conn_email.php");
		$mail->setFrom('notifikasi@lsp-ipi.id', 'Notifikasi LSP-IPI');
		$mail->addAddress($to);
		$mail->Subject = $subject;
		$mail->isHTML(true);
		$mailContent = $content;
		$mail->Body = $mailContent;
		if(!$mail->send())
		{
			echo 'Pesan tidak dapat dikirim.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		else
		{
			echo 'Pesan telah terkirim';
		}
	}
?>