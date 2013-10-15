$(document).ready(function(){
						   
				$(".sidebartrigger").click(function(){
				
				if($(".sidebarmenu").css('marginLeft')=='0px')
				{
				$(".sidebarmenu").animate({marginLeft:"-246px"});
				
				$(this).animate({marginLeft:"0px"});
				
				$('#loginmap').animate({width: $(window).width(),marginLeft:"0px"});
				
				}
				
				
				else
				{$(".sidebarmenu").animate({marginLeft:"0px"});
				
			     $('#loginmap').animate({width: $(window).width()-245,marginLeft:"245px"});  
				   
				   $(this).animate({marginLeft:"245px"});
				
				
				}
				
				
				
				
				
				
				});
				
				
$( "#datepicker1" ).datepicker();	
$( "#datepicker1" ).datepicker( "option", "dateFormat", 'yy-mm-dd');
    

 $( "#datepicker2" ).datepicker();
 $( "#datepicker2" ).datepicker( "option", "dateFormat", 'yy-mm-dd');
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
						   
						   
						   });