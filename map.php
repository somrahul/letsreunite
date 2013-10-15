<?php 
require './JS/facebook.php';

$config = array();
$config['appId'] = '518463338239542';
$config['secret'] = '60fee75e9b1d2e01dc6838baea832079';


$facebook = new Facebook($config);

$user = $facebook->getUser();

$user_home=array();

$params = array( 'next' => 'http://127.0.0.1/694/interface/' );

$logouturl=$facebook->getLogoutUrl($params);



if ($user) {
  try {
	
	 $user_profile = $facebook->api('/me');
	
	if(array_key_exists("hometown",$user_profile))
	{$user_home=$facebook->api("/".$user_profile['hometown']['id'], "GET");}
	
	if (array_key_exists("location",$user_profile))
	{$user_location=$facebook->api("/".$user_profile['location']['id'], "GET");}
	
	$user_friend=$facebook->api("/me/friends?fields=hometown,name,location&limit=10", "GET");
	$access_token = $facebook->getAccessToken();
	
	
	
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}


$friend_home_array=array();






foreach($user_friend['data'] as $eachfriend)
{
if(array_key_exists("hometown",$eachfriend))
{

$hometowndata=$facebook->api("/".$eachfriend['hometown']['id'], "GET");

$singlelist=array();

$checkcount=0;


foreach($friend_home_array as $hometowncheck)
{
if($hometowncheck[3]==$eachfriend['hometown']['id'])
{
array_push($friend_home_array[$checkcount][0],$eachfriend['id']);

array_push($friend_home_array[$checkcount][4],$eachfriend['name']);

break;
}

else
{$checkcount++;}

}

if($checkcount==count($friend_home_array))
{
$userid=array($eachfriend['id']);

$username=array($eachfriend['name']);

$singlelist=array($userid,$hometowndata['location']['latitude'],$hometowndata['location']['longitude'],$eachfriend['hometown']['id'],$username);

array_push($friend_home_array,$singlelist);


}


}


}



$friend_location_array=array();


foreach($user_friend['data'] as $eachfriend2)
{
if(array_key_exists("location",$eachfriend2))
{

$locationdata=$facebook->api("/".$eachfriend2['location']['id'], "GET");

$singlelist2=array();

$checkcount2=0;


foreach($friend_location_array as $locationcheck)
{
if($locationcheck[3]==$eachfriend2['location']['id'])
{
array_push($friend_location_array[$checkcount2][0],$eachfriend2['id']);

array_push($friend_location_array[$checkcount2][4],$eachfriend2['name']);



break;
}

else
{$checkcount2++;}

}

if($checkcount2==count($friend_location_array))
{
$userid2=array($eachfriend2['id']);

$username2=array($eachfriend2['name']);

$singlelist2=array($userid2,$locationdata['location']['latitude'],$locationdata['location']['longitude'],$eachfriend2['location']['id'],$username2);

array_push($friend_location_array,$singlelist2);


}


}


}












?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
 <meta name='author' content="Guanyi Fu" />
 <meta name="description" content="The web site and portfolio of Guanyi Fu" />
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

<script src="JS/guanyif.js" type="text/javascript"></script>




</script>
	

<title>UC-Design</title>
</head>

<body>




<div class="header" style="">
<img src="img/map-logo.png" class="headerlogo" />

<input class="searchbarbox" placeholder="Input Where you want to find ?" style="width:400px"/> 

<a href="<? echo $logouturl; ?>"><div class="logoutbutton"><h1>Logout</h1></div></a>

<div class="loginname"><h2><?php echo $user_profile['name'] ?></h2></div>

<img src=<?php echo "https://graph.facebook.com/".$user_profile['id']."/picture" ?>  class="loginpic"/>


</div>



<div id="loginmap" >


</div>






<div class="sidebarmenu" >
<div class="sidebaroption" style="background:#BDBFC1; color:#FFFFFF; margin-left:10px;" id="currentlocationtab" ><h1>Current Location</h1></div>


<div class="sidebaroption" style="margin-left:10px" id="hometowntab"><h1>Hometown</h1></div>


<div class="sidebarlist" style="margin-top:10px"><h2>Event Name</h2></div>

<div class="sidebarlist"><input type="text" class="sidebarinputbox" placeholder="Input Event Name" id="eventname"/></div>

<div class="sidebarlist" style="margin-top:10px"><h2>Event Description</h2></div>

<div class="sidebarlist"><textarea class="sidebarinputbox"  style="height:40px" placeholder="Input Event Description" id="eventdecsription"></textarea></div>

<div class="sidebarlist" style="margin-top:10px"><h2>Starting Time</h2></div>
<div class="sidebarlist"><input type="text" class="sidebarinputbox" placeholder="2013-10-16" id="datepicker1"  style="width:100px; background-image:url('img/calendar-back.png'); background-repeat:no-repeat;
background-position:80px 3px;" />


<select class="sidebarselect" style="width:110px; background: url('img/drop-down.png') no-repeat 85px #FFFFFF; margin-left:10px; padding-top:4px; padding-bottom:4px;">
<option>NULL</option>
<option>6:00:00</option>
<option>7:00:00</option>
<option>8:00:00</option>
<option>9:00:00</option>
<option>10:00:00</option>
<option>11:00:00</option>
<option>12:00:00</option>
<option>13:00:00</option>
<option>14:00:00</option>
<option>15:00:00</option>
<option>16:00:00</option>
<option>17:00:00</option>
<option>18:00:00</option>
<option>19:00:00</option>
<option>20:00:00</option>
<option>21:00:00</option>
<option>22:00:00</option>
<option>23:00:00</option>
</select>
</div>




<div class="sidebarlist" style="margin-top:10px"><h2>Ending Time</h2></div>
<div class="sidebarlist"><input type="text" class="sidebarinputbox" placeholder="2013-10-16" id="datepicker2"  style="width:100px; background-image:url('img/calendar-back.png'); background-repeat:no-repeat;
background-position:80px 3px;" />

<select class="sidebarselect" style="width:110px; background: url('img/drop-down.png') no-repeat 85px #FFFFFF; margin-left:10px; padding-top:4px; padding-bottom:4px;">
<option>NULL</option>
<option>6:00:00</option>
<option>7:00:00</option>
<option>8:00:00</option>
<option>9:00:00</option>
<option>10:00:00</option>
<option>11:00:00</option>
<option>12:00:00</option>
<option>13:00:00</option>
<option>14:00:00</option>
<option>15:00:00</option>
<option>16:00:00</option>
<option>17:00:00</option>
<option>18:00:00</option>
<option>19:00:00</option>
<option>20:00:00</option>
<option>21:00:00</option>
<option>22:00:00</option>
<option>23:00:00</option>
</select>
</div>

<div class="sidebarlist" style="margin-top:10px"><h2>Privact Setting</h2></div>
<div class="sidebarlist">
<select class="sidebarselect" id="eventprivacy">
<option>OPEN</option>
<option>SECRET</option>
<option>FRIENDS</option>
<option>CLOSED</option>
</select>
</div>

<div class="sidebarlist" style="margin-top:10px"><h2>Event Radius</h2></div>



<div class="sidebarlist">
<select class="sidebarselect" id="eventrandius" style="width:150px; background: url('img/drop-down.png') no-repeat 125px #FFFFFF;">
<option>ALL</option>
<option>Set Sepcific Value</option>
</select>
</div>

<div id="sidebarslider" style="display:none"></div>

<div class="sidebarlist" id="radiuslegend" style="display:none"><h1>Radius:<span id="radiusdistance" style="font-weight:bold">5</span> Miles</h1></div>








<div class="sidebarlist" style="margin-top:10px"><h2>Participants</h2></div>
<div class="sidebarlist" style="margin-top:-10px" id="participantcontainer">

</div>


<div class="sidebarlist">
<div class="logoutbutton" style="float:left; font-size:12px; margin-bottom:10px;" id="createeventbutton"><h1>Create Event</h1></div>
</div>








</div>


<div class="sidebartrigger"><img src="img/side-bar.png" style="margin-top:10px" /></div>




<div class="eventconfirmationbox">
<div class="eventconfirmationcontent">
<div class="eventlist">
<img src="img/confrimation.png" style="float:left" />
<h2 style="float:left; margin-left:10px; color:#7490BA; font-size:15px; margin-top:2px;">Event has been Created</h2>
</div>


<div class="eventlist">
<h2 style="float:left; font-size:13px;">Event Name</h2>
<h1 style="float:left; font-size:13px; margin-left:10px; margin-top:-1px;" id="confirmationeventname">Family Renuite</h1>
</div>

<div class="eventlist">
<h2 style="float:left; font-size:13px;">Event Description</h2>
<h1 style="float:left; font-size:13px; margin-left:10px; margin-top:-1px;" id="confirmationeventdescription">Description</h1>
</div>


<div class="eventlist">
<h2 style="float:left; font-size:13px;">Starting Time</h2>
<h1 style="float:left; font-size:13px; margin-left:10px; margin-top:-1px;" id="confirmationstarttime">2013/5/2</h1>
</div>

<div class="eventlist">
<h2 style="float:left; font-size:13px;">Ending Time</h2>
<h1 style="float:left; font-size:13px; margin-left:10px; margin-top:-1px;" id="confirmationendtime">2013/5/2</h1>
</div>

<div class="eventlist">
<h2 style="float:left; font-size:13px;">Privacy</h2>
<h1 style="float:left; font-size:13px; margin-left:10px; margin-top:-1px;" id="confirmationprivacy">OPEN</h1>
</div>

<div class="eventlist">
<h2 style="float:left; font-size:13px;">Participants</h2>
</div>


<div class="confirmationpartcipantcontainer">


</div>


<div class="eventlist" style="width:380px">
<div class="logoutbutton" style=" font-size:12px; margin-top:-2px;" onclick="$('.eventconfirmationbox').animate({marginTop:-500})"><h1>Done</h1></div>
</div>



</div>
</div>





<div class="operationhintbox"><h1><span style="font-weight:bold">Click</span>  the map to set where you want to do filter</div>



</body>
</html>







<script>

window.markerlatitude='nodata';

window.markerlongtitdue='nodata';


$(function() {
    function abso() {
        $('#loginmap').css({
            position: 'absolute',
			
            width: $(window).width()-245,
            height: $(window).height()-50,
			
			marginLeft:"245px"

        });
		
		
		
		
		$(".sidebarmenu").css({
            height:$(window).height()-50
        });
		
		
		$('.eventconfirmationbox').css({
            left: $(window).width()/2-200
        });
		

    }

    $(window).resize(function() {
        abso();         
    });

    abso();

});



$(document).ready(function(){

      map = new GMaps({
        el: '#loginmap',
        lat: <?php echo $user_location['location']['latitude']?>,
        lng: <?php echo $user_location['location']['longitude'] ?>,
		zoom:5
      });


var checkselfcount=0;






<?php
$js_array = json_encode($friend_location_array);
echo "var originallocations = ". $js_array . ";\n";

?>






for (i = 0; i < originallocations.length; i++) { 

if(originallocations[i][3]==<? echo $user_profile['location']['id'] ?>)
{

map.drawOverlay({
        lat: <?php echo $user_location['location']['latitude']?>,
        lng: <?php echo $user_location['location']['longitude'] ?>,
        layer: 'overlayLayer',
        content: '<div class="self_overlay"><img src="https://graph.facebook.com/'+<?php echo $user_profile['id'] ?>+'/picture" ><div class="self_overlay_arrow above"></div></div><div class="friendmorenum"><h1>'+originallocations[i][0].length+' More</h1></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });
	  
checkselfcount=-1;	  

}





else{

checkselfcount++;

if(originallocations[i][0].length==1)
{
map.drawOverlay({
        lat: originallocations[i][1],
        lng: originallocations[i][2],
        layer: 'overlayLayer',
        content: '<div class="overlay"><img src="https://graph.facebook.com/'+originallocations[i][0][0]+'/picture" ><div class="overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });




}


else{


imagepath='<img src="https://graph.facebook.com/'+originallocations[i][0][0]+'/picture">';


var friendnum=originallocations[i][0].length-1;




map.drawOverlay({
        lat: originallocations[i][1],
        lng: originallocations[i][2],
        layer: 'overlayLayer',
        content: '<div class="overlay">'+imagepath+'<div class="overlay_arrow above"></div></div><div class="friendmorenum"><h1>'+friendnum+' More</h1></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });
	  	 


}

}


}

if(checkselfcount==originallocations.length){

map.drawOverlay({
        lat: <?php echo $user_location['location']['latitude']?>,
        lng: <?php echo $user_location['location']['longitude'] ?>,
        layer: 'overlayLayer',
        content: '<div class="self_overlay"><img src="https://graph.facebook.com/'+<?php echo $user_profile['id'] ?>+'/picture" ><div class="self_overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });}





GMaps.on('click', map.map, function(event) {

     
	
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
	
	window.markerlatitude= event.latLng.lat();
	
	window.markerlongtitdue=event.latLng.lng();
	
	
	maprefresh(originallocations,lat,lng,'all',0);
	
	

});











});









</script>







<script>
$(document).ready(function(){



<?php
$js_array = json_encode($friend_home_array);
echo "var locations = ". $js_array . ";\n";


$location_data = json_encode($friend_location_array);
echo "var newdata= ". $location_data . ";\n";

?>


for (i = 0; i < locations.length; i++) { 
for(a=0;a<locations[i][0].length; a++){
var insertedhtml='';

insertedhtml='<div class="partcipantslist" uid='+locations[i][0][a]+'><img src="https://graph.facebook.com/'+locations[i][0][a]+'/picture" class="partcipantpic" /><h1 class="partcipantname">'+locations[i][4][a]+'</h1><img src="img/delete.png" class="participantdelete" onclick="$(this).parent().remove()" /></div>';


$('#participantcontainer').append(insertedhtml);

}
}







   




$('#eventrandius').change(function() {

   
  
  
  if($(this).val()=='ALL')
  {

  if($("#hometowntab").css('background-color')=='rgb(189, 191, 193)')
  {
  if(window.markerlatitude=='nodata'&&window.markerlongtitdue=='nodata')
  {
  
   maprefresh(locations,<?php echo $user_home['location']['latitude']?>,<?php echo $user_home['location']['longitude']?>,'all',1);
  
  listrefresh(locations);}
  
  else{
  
  
    maprefresh(locations,window.markerlatitude,window.markerlongtitdue,'all',1);
  
  listrefresh(locations);
  
  }
  
  
 
  
  }
  
  
  else{
  
  
  
  if(window.markerlatitude=='nodata'&&window.markerlongtitdue=='nodata')
 {
 
  maprefresh(newdata,<?php echo $user_location['location']['latitude']?>,<?php echo $user_location['location']['longitude']?>,'all',0);

  listrefresh(newdata);}
  
   else{

   maprefresh(newdata,window.markerlatitude,window.markerlongtitdue,'all',0);
  
  listrefresh(newdata);
  
  }
  
  
  
  
  }


   $("#sidebarslider").fadeOut();
  
  $("#radiuslegend").fadeOut();
  
  $("#radiusdistance").html(5);
  
  
  
  }
  
  
  
  else{
  
  if($("#hometowntab").css('background-color')=='rgb(189, 191, 193)')
  {
  
  
  $( "#sidebarslider" ).slider({
			range: "min",
			value: 5,
			min: 5,
			max: 1000,
			step: 50,
			slide: function( event, ui ) {
			
			var num=ui.value;
			
			var newlocations=[];
			
			if(window.markerlatitude=='nodata'&&window.markerlongtitdue=='nodata')
			{
			newlocations=calculatedistance(locations,<?php echo $user_home['location']['latitude']?>,<?php echo $user_home['location']['longitude']?>,num);
  
            
  maprefresh(newlocations,<?php echo $user_home['location']['latitude']?>,<?php echo $user_home['location']['longitude']?>,num,1);
  
  
  listrefresh(newlocations);
  
  $("#radiusdistance").html(num);}
  
  else{
  
  
  newlocations=calculatedistance(locations,window.markerlatitude,window.markerlongtitdue,num);
            
  maprefresh(newlocations,window.markerlatitude,window.markerlongtitdue,num,1);
  
  
  listrefresh(newlocations);
  
  $("#radiusdistance").html(num);   }
  
  
  
  }
		});

 }
 
 
 
 
 else{
 
 $( "#sidebarslider" ).slider({
			range: "min",
			value: 5,
			min: 5,
			max: 1000,
			step: 50,
			slide: function( event, ui ) {
			
			
			var num=ui.value;
			
			var newlocations2=[];
			
			if(window.markerlatitude=='nodata'&&window.markerlongtitdue=='nodata')
			{		
			newlocations2=calculatedistance(newdata,<?php echo $user_location['location']['latitude']?>,<?php echo $user_location['location']['longitude']?>,num);
  
  
  maprefresh(newlocations2,<?php echo $user_location['location']['latitude']?>,<?php echo $user_location['location']['longitude']?>,num,0);
  
  
  listrefresh(newlocations2);
  
  
  $("#radiusdistance").html(num);
  }
  
  
  else
  {newlocations2=calculatedistance(newdata,window.markerlatitude,window.markerlongtitdue,num);
  
  
  maprefresh(newlocations2,window.markerlatitude,window.markerlongtitdue,num,0);
  
  
  listrefresh(newlocations2);
  
  
  $("#radiusdistance").html(num); }
  
  
  
  }
		});
 
 
 } 
 
  
  $("#sidebarslider").fadeIn();
  
  $("#radiuslegend").fadeIn();
  
  
  }
  

  
});








});


function calculatedistance(data,a,b,distance)
{ var resultdata=[];

var checkdistance=distance*distance/3000;

if(distance=='all')
{resultdata=data}


else{

for (i = 0; i < data.length; i++)
{
var checkdis=0;
checkdis=(a-data[i][1])*(a-data[i][1])+(b-data[i][2])*(b-data[i][2]);



if(checkdis<checkdistance)
{resultdata.push(data[i]);}

} }

return resultdata;

}





function maprefresh(data,a,b,distance,homecheck)
{
var latitude=a;
var longitude=b;

var showselfid;

var checkselfcount=0;



var zoomval=0;



if(distance<200)
{zoomval=8;}

else if(distance<400&&distance>=200)
{zoomval=7;}

else if(distance<600&&distance>=400)
{zoomval=6;}

else if(distance<800&&distance>=600)
{zoomval=5;}


else if(distance>=800)
{zoomval=5;}

else
{zoomval=5;}




map = new GMaps({
        el: '#loginmap',
        lat: a,
        lng: b,
		zoom:zoomval
      });


for (i = 0; i < data.length; i++) { 


if((Math.abs(data[i][1]-latitude)<0.2)&&(Math.abs(data[i][2]-longitude)<0.2))
{

map.drawOverlay({
        lat: a,
        lng: b,
        layer: 'overlayLayer',
        content: '<div class="self_overlay"><img src="https://graph.facebook.com/'+<?php echo $user_profile['id'] ?>+'/picture" ><div class="self_overlay_arrow above"></div></div><div class="friendmorenum"><h1>'+data[i][0].length+' More</h1></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });
	  
checkselfcount=-1;	  

}

else{

checkselfcount++;

if(data[i][0].length==1)
{
map.drawOverlay({
        lat: data[i][1],
        lng: data[i][2],
        layer: 'overlayLayer',
        content: '<div class="overlay"><img src="https://graph.facebook.com/'+data[i]
[0][0]+'/picture" ><div class="overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });

}


else{

imagepath='<img src="https://graph.facebook.com/'+data[i][0][0]+'/picture">';


var friendnum=data[i][0].length-1;




map.drawOverlay({
        lat: data[i][1],
        lng: data[i][2],
        layer: 'overlayLayer',
        content: '<div class="overlay">'+imagepath+'<div class="overlay_arrow above"></div></div><div class="friendmorenum"><h1>'+friendnum+' More</h1></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });


}


}


}




if(checkselfcount==data.length){

map.drawOverlay({
        lat: a,
        lng: b,
        layer: 'overlayLayer',
        content: '<div class="self_overlay"><img src="https://graph.facebook.com/'+<?php echo $user_profile['id'] ?>+'/picture" ><div class="self_overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center',
		
		
      });}










if(distance!='all'){
map.drawCircle({
  lat: latitude,
  lng: longitude,
  radius: distance*1500, 
  strokeColor: '#C2D9F9',
  strokeOpacity: 1,
  strokeWeight: 3,
  fillColor: '#C2D9F9',
  fillOpacity: 0.3
});

}


GMaps.on('click', map.map, function(event) {

 
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
	
	window.markerlatitude= event.latLng.lat();
	
	window.markerlongtitdue=event.latLng.lng();
	
	
	if(homecheck==1)
	{
	
	<?php
$js_arraynew = json_encode($friend_home_array);
echo "var refreshdata = ". $js_arraynew . ";\n";

?>

	
	var newdata=calculatedistance(refreshdata,lat,lng,distance);
	
	listrefresh(newdata);
	
	
	maprefresh(newdata,lat,lng,distance,homecheck);
	
	
	
	}
	


else
{
<?php
$js_arraynew = json_encode($friend_location_array);
echo "var refreshdata2= ". $js_arraynew . ";\n";

?>
	
	var newdata2=calculatedistance(refreshdata2,lat,lng,distance);
	
	listrefresh(newdata2);
	
	
	maprefresh(newdata2,lat,lng,distance,homecheck);

}	
	
	
	

});




}



















function listrefresh(data)
{
$('#participantcontainer').children().remove();

for (i = 0; i < data.length; i++) { 
for(a=0;a<data[i][0].length; a++){
var insertedhtml='';

insertedhtml='<div class="partcipantslist" uid='+data[i][0][a]+' ><img src="https://graph.facebook.com/'+data[i][0][a]+'/picture" class="partcipantpic" /><h1 class="partcipantname">'+data[i][4][a]+'</h1><img src="img/delete.png" class="participantdelete"  onclick="$(this).parent().remove()" /></div>';


$('#participantcontainer').append(insertedhtml);

}

}


}






</script>


<script>
$(document).ready(function(){

$("#createeventbutton").click(function(){

var inventidlist='';

var confirmationlist=[];


for(i=0;i<$("#participantcontainer").children().length;i++)
{
inventidlist=inventidlist+$("#participantcontainer").children().eq(i).attr('uid')+',';
confirmationlist.push($("#participantcontainer").children().eq(i).attr('uid'));

}

inventidlist=inventidlist.substring(0,inventidlist.length-1);



var starttime=$("#datepicker1").val();


var endtime=$("#datepicker2").val();





 $.ajax({
        type: 'get',
        url: 'create_event.php',
        data: {eventname:$('#eventname').val(),eventdescription:$('#eventdecsription').val(),starttime:starttime,endtime:endtime,privacy:$('#eventprivacy').val(),inventlist:inventidlist},      
        success: function() {
		
		showconfirmation($('#eventname').val(),$('#eventdecsription').val(),starttime,endtime,$('#eventprivacy').val(),confirmationlist);
		
		
		 
		 $("#eventname").val('');

        $("#datepicker1").val('');

         $("#datepicker2").val('');

          $('#eventdecsription').val('');

           $('#eventprivacy').val('OPEN');



		
                    
        }
    });








});







});



function showconfirmation(eventname,eventdescription,starttime,endtime,privacy,participantlist)
{

$('.eventconfirmationbox').animate({marginTop: $(window).height()/2-125});


$("#confirmationeventname").html(eventname);


$("#confirmationeventdescription").html(eventdescription);

$("#confirmationstarttime").html(starttime);

$("#confirmationendtime").html(endtime);


$("#confirmationprivacy").html(privacy);


$('.confirmationpartcipantcontainer').children().remove();


for(i=0;i<participantlist.length;i++)
{
var inserthtml='';
inserthtml='<img src="https://graph.facebook.com/'+participantlist[i]+'/picture" class="confirmationpic" />';


$('.confirmationpartcipantcontainer').append(inserthtml);





}




}


</script>



<script>

$(document).ready(function(){

$("#currentlocationtab").click(function(){


$(this).css({'background':'#BDBFC1','color':'#FFFFFF'});
$("#hometowntab").css({'background':'#F1F3F8','color':'#333333'});


<?php
$location_data = json_encode($friend_location_array);
echo "var data= ". $location_data . ";\n";

?>

  
maprefresh(data,<?php echo $user_location['location']['latitude']?>,<?php echo $user_location['location']['longitude']?>,'all',0);


listrefresh(data);


$('#eventrandius').val('ALL');

$("#sidebarslider").fadeOut();
  
  $("#radiuslegend").fadeOut();
  
  
  window.markerlatitude='nodata';

window.markerlongtitdue='nodata';


});



$("#hometowntab").click(function(){


$("#currentlocationtab").css({'background':'#F1F3F8','color':'#333333'});
$(this).css({'background':'#BDBFC1','color':'#FFFFFF'});

<?php
$location_data = json_encode($friend_home_array);
echo "var data= ". $location_data . ";\n";

?>


maprefresh(data,<?php echo $user_home['location']['latitude']?>,<?php echo $user_home['location']['longitude']?>,'all',1);

listrefresh(data);

$('#eventrandius').val('ALL');

$("#sidebarslider").fadeOut();
  
  $("#radiuslegend").fadeOut();
  
  window.markerlatitude='nodata';

window.markerlongtitdue='nodata';


});





$(".searchbarbox").keypress(function(e){ 

var key = e.which;	
 
if(key==13)
	{
		
		
	GMaps.geocode({
  address: $(".searchbarbox").val(),
  callback: function(results, status) {
    if (status == 'OK') {
      var latlng = results[0].geometry.location;
      map.setCenter(latlng.lat(), latlng.lng());
      map.addMarker({
        lat: latlng.lat(),
        lng: latlng.lng()
      });
    }
  }
});	
		

$(".searchbarbox").val('');


 }

});



});


</script>