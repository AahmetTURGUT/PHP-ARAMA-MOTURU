<html>
<head>
  <link href="style.css" type="text/css" rel="stylesheet"/>
<title>ARAMA MOTORU</title>
</head>
<body>
<center>
<form action="3curl.php" method="post"> 



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




require "simple_html_dom.php";


  $arananurll = $_POST["url"]; 
  $yazii =$_POST["arama"] ; 
  strtolower($yazii);
 $arananurl = iconv('ISO-8859-9','UTF-8',$arananurll); 


$yazi = explode(",", $yazii);
$aranan = explode(",", $arananurl);
 
$kelimesa= count($yazi);
$urlsa= count($aranan);


$dizii=array();

$tt=array();
for ( $j=0 ; $j<$urlsa ; $j++ ){
	
	

$html = str_get_html(urlbaglan($aranan[$j]));


$i=0; 

foreach($html->find('a') as $element)  
{
 $veri[$i++]=$element->href.'<br>'; 
      
}//burda i yi tutu
$tt[$j]=$i;

$i=0; 


			


while (!empty($veri[$i])) {
	$ara[$i] =strstr($veri[$i],$aranan[$j]);
	if(!empty($ara[$i])){ 
		$a=substr_count($ara[$i], '/') ;
		
		if($a<=5)
               { 
		   $dizii[$j][$i]=$ara[$i];
		   
               	                            }
            
            }
	   $i++;
	   
                  
}
	
	
}




$dizi=array();

for ($j=0; $j<$urlsa; $j++)
  {$t=0;
for ($i=0; $i<$tt[$j]; $i++)
  {
    if (!empty($dizii[$j][$i])){
		
		$dizi[$j][$t]=$dizii[$j][$i];
		$t++;
  } 
  }
  }





$adet=array();

for ( $i=0 ; $i<$kelimesa ; $i++ ){
	
	
for ( $y=0 ; $y<count($dizi) ; $y++ ){
	$adet[$i][$y]=0;
	
	for ( $j=0 ; $j<count($dizi[$y]); $j++){
		
		if(!empty($dizi[$y][$j])){ 
		
		
		$aranacak=$yazi[$i];
		
		
		$ara=substr_replace($dizi[$y][$j], '', -4);
	///////////////////////////////
	
		$veri = urlbaglan($ara);
		

		$adet[$i][$y]=$adet[$i][$y]+substr_count($veri,$aranacak);
		
		
		}
		
	}
	
	
}
	
			}
		
			$puan=array();
			$ceo=array();
				for ( $i=0 ; $i<count($adet[0]) ; $i++ ){
				$ceo[$i]=1;
				$puan[$i]=0;
					for ( $j=0 ; $j<count($adet) ; $j++ ){
						
						$a=$adet[$j][$i];
						
						if($puan[$i]==0){
							
							$puan[$i]= $puan[$i]+ $a;
						}
						else{
							$puan[$i]=" $puan[$i]+ $a";
						}
						if($a!=0){
							
							$ceo[$i]=$ceo[$i]*$a;
						}
						
					
					}
					
					
				}
				
$gercekceo=array();
					for ( $i=0 ; $i<count($ceo) ; $i++ ){
							 $birlestir = implode(",", $yazi);

						
						$gercekceo[$i]=$ceo[$i]. " puanli $aranan[$i] baglantisinin  sirasiyla kelime ve puanlari: $birlestir - $puan[$i] ";
	
					}

rsort($gercekceo);
$ke= count($gercekceo);
for ( $j=0 ; $j<$ke ; $j++ ){

	echo $gercekceo[$j];
	echo('<br>');
}
echo "AGAC YAPILARI::::";
echo('<br>');
print_r ($dizi);
?>