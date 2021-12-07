<?php
//PHP OSINT by Professional#0001
/*
 *Query Parameters Start
 */
$Target = $_GET['target'];//Specify Target as query in URL to page like this File.php?target=username
$Client = $_GET['client'];//Specify Client if you are using in this format &client=discord
$CustomUrls = $_GET['urls'];//Specify Custom URLs in this format &urls=URL1,URL2,URL3 ETC...
/*
 *Query Parameters End
 */

function GetStatusResponseCode($url)//Fuction to get status response of cURL Request
{
/*
 *Request Config Start
 */
$ValidUserAgent = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36";//If site doesn't accept user agent update this with new user agent from something like Chrome or Firefox
/*
 *Request Config End
 */
$http = curl_init($url);//Initialize cURL
curl_setopt($http, CURLOPT_HEADER, true);         // we want headers
curl_setopt($http, CURLOPT_NOBODY, true);         // we don't need body
curl_setopt($http, CURLOPT_RETURNTRANSFER,1);     // We don't need transfer
curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);// We don't need SSL verify peer
curl_setopt($http, CURLOPT_HTTPHEADER, array($ValidUserAgent,));//Set Headers
curl_setopt($http, CURLOPT_TIMEOUT,3);//timeout after 3 seconds
curl_exec($http);//Execute cURL Request
$httpcode = curl_getinfo($http, CURLINFO_HTTP_CODE);//Get cURL response code
curl_close($http);//Close cURL Request
switch ($httpcode)
{
    case 404;//Any 404 errors
    case 302;//Any 302 errors
    $status = false;//set status to false
    break;
    case 200;//this is the response status we want 
    $status = true;//set status to true
    break;
    default;//if anything else
    print "error $httpcode";//print status code to add 
    $status = false;//set status to false
    break;
}
return $status;//return status to request
}
$url = array("https://pastebin.com/u/$Target","https://www.facebook.com/$Target/","https://twitter.com/$Target","https://$Target.newgrounds.com/");//this is the built in URLs we will be checking by default
if (strlen($CustomUrls)>0)//If the $CustomURLs parameter is larger than 0
{
    $TargURI = str_replace("<Target>",$Target,$CustomUrls);//Replaces <Target> inside of custom url with actual target.
    $URIs = explode(",", $TargURI);//Splits Custom URLs into array sepparating by commas
    foreach ($URIs as $Custom)//For Each Custom URL in Custom URLs
    {
        array_push($URIs);//Add Custom URL to $url Array
    }
}
foreach ($url as $Hit) {//Each URL as string
    if(GetStatusResponseCode($Hit) == true)//do request and if response code is 200 OK then print URL
{
    switch ($Client)
    {
        case "DiscordBot";//Check If $Client is set to discord
        print "~~$Hit\n\r~~";//Print using discord Markup
        break;
        case "API";
        print "$Hit\n\r";//Print using RAW format
        default;//if no client defined
        print "$Hit</br>";//Print in regular HTML Format
        break;
    }    
}
}
?>
