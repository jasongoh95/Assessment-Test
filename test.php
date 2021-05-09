<?php 
$sUrl = "http://localhost/management-system/webservice/API.php";
$ch = curl_init($sUrl);

$sEncodeData = "W2K4GdRcmSfWbvfUmSDrBAttajOVNJYdyqJJt6ZfDR6QU4%2Bofr1f7o%2FPR3RTp3tllU8cheVcwcBQbm67Bf6fHuTcxQSr7ZnMvCvPyT8cUw0sLJfOTEJ%2F5tMr15luvcYAyyfsiXBTewSf6IWWqIJREA%3D%3D"; 
$sData = "data=$sEncodeData";  
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-GB; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
curl_setopt($ch, CURLOPT_POSTFIELDS,  $sData);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $sUrl);
$result = curl_exec($ch);

curl_close($ch);

$result = json_decode($result);	
print_r($result);
?>