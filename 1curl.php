
<html>
<head>
  <link href="style.css" type="text/css" rel="stylesheet"/>
<title>ARAMA MOTORU</title>
</head>
<body>
<center>
<form action="1curl.php" method="post"> 



	 <img src="resim1.png"  vspace="80" hspace="200" align = "center" height="300" width="500"><br/>

    <input type="text" name="arama"   placeholder="KELIME"></br></br>
 <input type="text" name="url"   placeholder="URL"></br></br>
 <input type="submit" name="submit" value='Ara' />

</center>



</form>
</body>
</html>




<?php
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'; 
 function urlbaglan($url) {  
      if(@function_exists('curl_init')) {  
           $cookie = tempnam ("/tmp", "CURLCOOKIE");  
           $ch = curl_init();  
           curl_setopt($ch, CURLOPT_URL, $url);  
           curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; CrawlBot/1.0.0)');  
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
           curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);  
           curl_setopt($ch, CURLOPT_HEADER, true);  
           curl_setopt($ch, CURLOPT_CONNECTTIMEOUT     , 5);  
           curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
           curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  
           curl_setopt($ch, CURLOPT_ENCODING, "");  
           curl_setopt($ch, CURLOPT_AUTOREFERER, true);  
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  # required for https urls  
           curl_setopt($ch, CURLOPT_MAXREDIRS, 15);                 
           $site = curl_exec($ch);  
		   curl_close($ch);  
           } else {  
           global $site;  
           $site = file_get_contents($url);  
      }  
      return $site;  
 }

 
 $adt=$_POST["arama"];
  strtolower("$adt");
  $ad=" ".$adt;
 $urrl=$_POST["url"];
$ad=strtolower($ad);

 $url = iconv('ISO-8859-9','UTF-8',$urrl); 
 

/*
 $veri = file_get_contents($url);


*/


$urr=urlbaglan($url);
 $ur=strtolower($urr);

 $adet=substr_count($ur, $ad);
echo $ad ," kelimesi ",$adet," kere bulundu";


?>