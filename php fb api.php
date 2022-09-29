<?php
include 'config.php';
require_once __DIR__ . '/vendor/Facebook/autoload.php'; 

// msgtype = 1 means just message text and link, no image
// msgtype = 2 means just message text, image and link
if(isset($_GET['mtype'])){
  $msgtype=$_GET["mtype"];
} else{
  $msgtype=1;
}

//$db_handle = mysqli_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
//$records = mysqli_select_db($db_handle, $database) or die("Could not select database");
//$sqlquery = "select * from tweetmsg order by rand() limit 1";
//$sqlresult = mysqli_query($db_handle, $sqlquery) or die(mysql_error($db_handle));
//while ($row = mysqli_fetch_assoc($sqlresult)) {
  //  $articletext = $row['message'];
   // $articleimage = $row['image'];
//}

echo '  point 1  ';
$fb = new \Facebook\Facebook([
  'app_id' => $appid,
  'app_secret' => $appsecret,
  'default_graph_version' => $graphversion
]);
echo '  point 2  ';

try {
  $response = $fb->get('/me', $useraccesstoken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  echo 'USER: Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  echo 'USER: Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

// Check User 
$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();
$msgtype = 2;
if ($msgtype == 1) {
  echo '  point 1a  ';
  $linkData = [
    'link' => 'ENTER URL HERE',
    'message' => $articletext
   ];
   $pageAccessToken = $pageaccesstoken;
   
   echo '  point 1b  ';
   try {
    $response = $fb->post('/me/feed', $linkData, $pageAccessToken);
//    $response = $fb->post('/me/feed', $linkData, $pageAccessToken);
   } catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'PAGE: Graph returned an error: '.$e->getMessage();
    exit;
   } catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'PAGE: Facebook SDK returned an error: '.$e->getMessage();
    exit;
   }
   echo '  point 1c  ';
   $graphNode = $response->getGraphNode();
   echo '  Posted with id: ' . $graphNode['id'];
   echo '  point 1d  ';
} else if ($msgtype == 2) {
  echo '  point 2a  ';
  //$imgurl = '/images';
  //$imgurl = $imgsourceurl;
  //$imgurl = '';
  echo '  point 2aa  ';
  $data = [
    'message' => 'IMAGE...',
    'source' => $fb->fileToUpload('frontage.jpg'),
//    'source' => $fb->fileToUpload($imgurl . '/' . $articleimage)
  ];
  
  echo '  point 2b  ';
  try {
    // Returns a `Facebook\Response` object
    $post_url = '/me/feed';
    echo 'point 2bb';
    $response = $facebook->post('/me/feed', $data, $pageAccessToken);
  //  $response = $fb->post('/me/feed', $data, $pageAccessToken);
    echo 'point 2bb check!';
  } catch(Facebook\Exception\ResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exception\SDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  echo 'point 2c';
  
  $graphNode = $response->getGraphNode();
  echo 'Photo ID: ' . $graphNode['id'];
  echo 'point 2d';
}
echo 'END OF CODE';