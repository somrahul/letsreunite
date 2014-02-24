<?php 
require './JS/facebook.php';

$config = array();
$config['appId'] = '518463338239542';
$config['secret'] = '60fee75e9b1d2e01dc6838baea832079';

$facebook = new Facebook($config);


$params = array(
  'scope' => 'read_stream, friends_likes,user_hometown,user_location,user_photos,friends_hometown,friends_location,friends_photos,create_event',
  'redirect_uri' => 'http://127.0.0.1/694/interface/loading.php'
);

$loginUrl = $facebook->getLoginUrl($params);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
 <meta name='author' content="Guanyi Fu Somesh Rahul Weqin" />
 <meta name="description" content="This is the website of 694 Course Project" />
<link rel="stylesheet" href="guanyif.css" type="text/css" />
<script src="JS/jquery.js" type="text/javascript"></script>  
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwtZQxsV6ks2nsaNHdUsUFFDrbGIBKa8A&sensor=false">
    </script>
<title>Let's Reunite</title>
</head>

<body>


<div id="loginmap" style="top:0px">


</div>


<div class="loginbox">

<div class="logincontent">
<div class="logintitle">
<img src="img/logo-big.png" />
</div>

<div class="logintext">
<h2 style="font-size:14px;">
Find your friend's home town and invite for any home-town based event, or you can discover more relationship with your friends in our application

</h2>

</div>


<a href="<?php echo $loginUrl; ?>">
<div class="loginbutton">
<div style="float:left; border-right:3px solid #9BB0D3; padding-right:10px; padding-top:10px; padding-bottom:10px; padding-left:10px;">
<img src="img/fb-icon.png" />
</div>

<h2 style="float:left; margin-top:11px; padding-right:10px; padding-left:10px;">Login with your facebook account</h2>

</div></a>


<div class="logintext" style="margin-top:20px; color:#999999">
<h1 style="font-size:11px">
Produced by Guanyi Fu, Weiqin Xie,Somesh Rahul<br />
More Feature will come soon

</h1>

</div>




</div>

</div>









</body>
</html>


<script>


$(function() {

    function abso() {

        $('#loginmap').css({
            position: 'absolute',
            width: $(window).width(),
            height: $(window).height()
        });
		
		
		$('.loginbox').css({
            left: $(window).width()/2-300,
            top: $(window).height()/2-135
        });
		

    }

    $(window).resize(function() {
        abso();         
    });

    abso();

});


 function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(42.290056,-83.731484), 
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("loginmap"),
            mapOptions);
			var myLatlng = new google.maps.LatLng(42.290056,-83.731484);
		


marker.setMap(map);
      }
      google.maps.event.addDomListener(window, 'load', initialize);




</script>
