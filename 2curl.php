<html>
<head>
  <link href="style.css" type="text/css" rel="stylesheet"/>
<title>ARAMA MOTORU</title>
</head>
<body>
<center>
<form action="2curl.php" method="post"> 



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
   
   
   
   
   
 $ad=$_POST["arama"];
  strtolower("$ad");
$urrl=$_POST["url"];

 $url = iconv('ISO-8859-9','UTF-8',$urrl); 

 $kelimeler = explode(",", $ad);
 $urls = explode(",", $url);
$kelimesa= count($kelimeler);
$urlsa= count($urls);

$gercekceo=array();

for ( $j=0 ; $j<$kelimesa ; $j++ ){
	
	$kelime[$j]=$kelimeler[$j];
	
}


for ( $i=0 ; $i<$urlsa ; $i++ ){
	$deger=array();
$ceo=array();
$ceo[$i]=1;



for ( $j=0 ; $j<$kelimesa ; $j++ ){
	$verii = urlbaglan($urls[$i]);
	$veri=strtolower($verii);
$deger[$j]= substr_count($verii,$kelime[$j]);
	
	
}
for ( $t=0 ; $t<$kelimesa ; $t++ ){
	if($deger[$t]==0){
		$ceo[$i]=$ceo[$i]*($deger[$t]+1);
		
	}
	else{
		$ceo[$i]=$ceo[$i]*$deger[$t];
	}
}


	
	

$birles = implode(",", $kelime);
	 $birlestir = implode(",", $deger);
	 
	$gercekceo[$i]="$ceo[$i] puanli $urls[$i] baglantisinin  sirasiyla kelime ve puanlari: $birles -- $birlestir ";
	

	
}


rsort($gercekceo);
$ke= count($gercekceo);
for ( $j=0 ; $j<$ke ; $j++ ){

	echo $gercekceo[$j];
	echo('<br>');
}







?>

 
 
