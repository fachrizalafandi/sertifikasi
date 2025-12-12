<?
	$arr_mod = array("","6208e24c9eb59f8c2c9e828c13547447","error","master","skema-sertifikasi","profil");

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
	    	
	    }
    }
?>