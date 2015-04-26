<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return response([
        'result' => 'DevStatus'
      ]);
});

$app->get('/{name}', function($name) use ($app) {

  $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
  $context  = stream_context_create($options);
  $url = "https://api.github.com/users/" . urlencode($name);
  $result = json_decode(file_get_contents($url, true, $context));
  $name = $result->name;
  $public_repos = $result->public_repos;
  $status = "";

  if($public_repos <= 10){
     $status = "Rookie";
  }
  if( $public_repos > 10 && $public_repos <= 25){
     $status = "Intermediate";
  }
  if( $public_repos > 25){
     $status = "Ninja";
  }

  $finalStatus = $name . " is a " . $status . " Open Source Evangelist";

  return response([
      'Developer Status' => $finalStatus
    ]);
});
