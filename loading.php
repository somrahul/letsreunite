<?php 
require './JS/facebook.php';

$config = array();
$config['appId'] = '518463338239542';
$config['secret'] = '60fee75e9b1d2e01dc6838baea832079';


$facebook = new Facebook($config);

$user = $facebook->getUser();


if ($user) {

    $user_profile = $facebook->api('/me');
	
	
}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
 <meta name='author' content="Somesh Rahul" />
 <meta name="description" content="Let us Reunite" />
<link rel="stylesheet" href="guanyif.css" type="text/css" />
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="JS/jquery.js" type="text/javascript"></script>  
<script src="JS/gmaps.js" type="text/javascript"></script>



<link rel="stylesheet" href="JS/jquery-ui-1.10.3/themes/base/jquery.ui.all.css"/>
<script src="JS/jQuery-UI/jquery.ui.core.js"></script>
<script src="JS/jQuery-UI/jquery.ui.widget.js"></script>
<script src="JS/jQuery-UI/jquery.ui.mouse.js"></script>
<script src="JS/jQuery-UI/jquery.ui.slider.js"></script>
<script src="JS/jQuery-UI/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="JS/jquery-ui-1.10.3/demos/demos.css" />




</script>
	

<title>UC-Design</title>
</head>

<body>


<div id="loading"><img src="img/logo-loading.png" style="margin-top:60px"/><br>
<h2 style="font-size:15px; margin-top:5px; margin-bottom:10px; color:#CCCCCC">Welcome, <span style="color:#FFFFFF"><?php echo $user_profile['name'] ?></span></h2>

<img src=<?php echo "https://graph.facebook.com/".$user_profile['id']."/picture?type=normal" ?>  class="loadingpic"/><br />



<img src="img/ajax-loader.gif" style="margin-top:5px; margin-bottom:20px"><h1 style="font-size:15px">We are trying very hard to load data from facebook, Please Wait for some time :)</h1>



</div>



</body>


</html>



<script>


$( window ).load(function(){
window.location.href='./map.php'

});


</script>
