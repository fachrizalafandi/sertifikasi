<?
	$arr_mod = array("","6208e24c9eb59f8c2c9e828c13547447","error","master","skema-sertifikasi","profil","registrasi","apl-01","apl-02");

    if (!in_array($mod, $arr_mod)) 
    {
        header("location: ".$_SESSION["domain"]."/error");
    }
    else
    {
    	$arr_sub = array("","user-akses","tuk","asessor","skema","klaster","unit-kompetensi","elemen-kuk");
    	
    	if (!in_array($sub, $arr_sub)) 
	    {
	        header("location: ".$_SESSION["domain"]."/error");
	    }
	    else
	    {
	    	// ===== CEK KHUSUS ASESSI =====
			// Validasi ini digunakan untuk memastikan asessi telah melengkapi data profilnya

			if ( isset($_SESSION['hak_akses']) && $_SESSION['hak_akses'] == 'asessi' && isset($_SESSION['sha'])) {
				// modul yang butuh profil lengkap
				$restricted_mod = ['apl-01', 'apl-02'];

				if (in_array($mod, $restricted_mod)) {
					$q = mysqli_query($conn, "
						SELECT
							nama,
							no_ktp,
							tempat_lahir,
							tgl_lahir,
							jenis_kelamin,
							alamat,
							no_hp,
							kualifikasi_pendidikan,
							nama_institusi,
							jabatan,
							alamat_kantor
						FROM sr_registrasi
						WHERE sha = '".$_SESSION['sha']."'
					");

					$profil = mysqli_fetch_assoc($q);

					$profil_lengkap = true;

					foreach ($profil as $field) {
						if (trim($field) == '') {
							$profil_lengkap = false;
							break;
						}
					}

					// Jika profil tidak lengkap, arahkan ke halaman profil
					if (!$profil_lengkap) {
						$_SESSION['profil_warning'] = true; // set session flag untuk menampilkan peringatan (berguna di mod-profil.php)
						header("location: ".$_SESSION['domain']."/profil");
						exit;
					}
				}
			}
	    }
    }
?>