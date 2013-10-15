<?php 
require './JS/facebook.php';

$config = array();
$config['appId'] = '518463338239542';
$config['secret'] = '60fee75e9b1d2e01dc6838baea832079';


$facebook = new Facebook($config);




if($_GET['eventname'])
{
$eventname=$_GET['eventname'];

}

if($_GET['eventdescription'])
{
$eventdecsription=$_GET['eventdescription'];
}


if($_GET['starttime'])
{$starttime=$_GET['starttime'];}


if($_GET['endtime'])
{$endtime=$_GET['endtime'];}


if($_GET['privacy'])

{$privacy=$_GET['privacy'];}


$eventdata=array();
$eventdata= array(
   'name' => $eventname,
   'description'=>$eventdecsription,
   'start_time' => $starttime,
   'end_time'=>$endtime,
   'privacy_type'=>$privacy
   );




$response = $facebook->api('/me/events','post', $eventdata);




if($_GET['inventlist'])
{


$invite = $facebook->api($response['id']."/invited?users=".$_GET['inventlist'],'post', $eventdata);

}








?>




