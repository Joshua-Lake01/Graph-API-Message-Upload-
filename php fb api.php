<?php
include 'config.php';
require_once __DIR__ . '/vendor/Facebook/autoload.php'; 

if(isset($_GET['mtype'])){
  $msgtype=$_GET["mtype"];
} else{
  $msgtype=1;
}



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

  echo '  point 2aa  ';
  $data = [
    'message' => 'IMAGE...',
    'source' => $fb->fileToUpload('IMAGE DIRECTORY HERE'),
  ];
  
  echo '  point 2b  ';
  try {
    $post_url = '/me/feed';
    echo 'point 2bb';
    $response = $facebook->post('/me/feed', $data, $pageAccessToken);
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