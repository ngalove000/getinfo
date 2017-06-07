<?php
error_reporting(E_ALL & ~ E_NOTICE & ~ E_WARNING);

ini_set('memory_limit', '-1');
set_time_limit(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');

include 'libs/Curl/CaseInsensitiveArray.php';
include 'libs/Curl/Curl.php';
include 'libs/Curl/MultiCurl.php';

include 'libs/DiDom/Document.php';
include 'libs/DiDom/Query.php';
include 'libs/DiDom/Element.php';

use \Curl\Curl;
use \DiDom\Document;
use \DiDom\Query;
use \DiDom\Element;


?>
<form method="post">
  <textarea name="sites" cols="100" rows="10"></textarea>
  <br>
  <br>
  <button type="submit" name="button">OK</button>
</form>

<?php
if(isset($_POST['button']))
{
  $sites = $_POST['sites'];
  $sites = explode(',',$sites);
  // var_dump($sites);
  foreach ($sites as $key) {
$key = $key." email contact";
$url = "https://www.bing.com/search?q=".rawurlencode($key);
if(get_web_page($url,$content)){
  // echo $content;

  $dom = new Document();
  $dom->load($content);
  $result = $dom->find('li[class=b_algo]')[0];
  // echo $lists;

    // $title = $list->find('strong[class=text-info title_display]')[0]->text();
    // echo $title;
    // echo "</br></br>";
    $link = $result->find('a')[0]->getAttribute('href');
    // echo $link;
    // echo "</br></br>";
get_web_page($link,$content);
    $string = $content;
    $pattern = '/[a-z0-9_\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
    preg_match($pattern, $string, $matches);
    echo "URL: ".str_replace(" email contact",'',$key);

    echo "</br></br>";
    echo "Email: ".$matches[0];

    echo "</br></br>";
    echo "</br></br>";

  }
}
}



function get_web_page( $url, &$content )
{
	$ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13';
	$options = array(
		CURLOPT_USERAGENT 	   => $ua,
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        // CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 0,      // timeout on connect
        CURLOPT_TIMEOUT        => 0,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}


?>
