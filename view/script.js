$(document).ready(function(){
	$('.real_body').removeAttr('background');
	$('.real_body').removeAttr('style');
	$('.email-item').click(function(){
		var attr = $(this)[0].id;
		if($(this)[0].className.indexOf('email-item-selected') > 1){
			$(this).removeClass('email-item-selected');
			$('#content-'+attr).css('display','none');
			return;
		}
		var class_attr = $(this)[0].className;
		var unread = class_attr.indexOf("email-item-unread");
		if(unread > 1){
			$(this).removeClass('email-item-unread');
		}
		$('.email-item').removeClass('email-item-selected');
		$(this).addClass('email-item-selected');
		$('.email-content').css('display','none');
		$('#content-'+attr).css('display','block');
	})
	var i =0;
	$('#plus-to').click(function(){
		i++;
		var item = $(this)[0].previousElementSibling;
		var input = $('<input type="email" name="mail_to'+i+'" class="pure-input-1-2" placeholder="To '+i+'"/>');
		$(this).after(input);
	})
	$('#draftIt').click(function(){
		$('#form-send').attr('action', '../model/send_draft.php');
		$('#form-send').submit();
	})
	$('input[type="checkbox"] ').click(function(){
		if($('#choice1').prop("checked") == true){
			$('#input2').css('display','none');
			$('#input1').css('display','block');
		}else if($('#choice2').prop("checked") == false){
			$('#input1').css('display','none');
		}
		if($('#choice2').prop("checked") == true){
			$('#input1').css('display','none');
			$('#input2').css('display','block');
		}else if($('#choice1').prop("checked") == false){
			$('#input2').css('display','none');
		}
	});
	$('#input1').focus(function(){
		$('#hint1').css('display','block');
	});
	$('#input1').blur(function(){
		$('#hint1').css('display','none');
	})
	$('#input2').focus(function(){
		$('#hint2').css('display','block');
	});
	$('#input2').blur(function(){
		$('#hint2').css('display','none');
	})
	$('font').remove();

	$("#submit-timer").click(function(){
		if($('#choice1').prop("checked")==true){
			var choice = 1;
		}else if($('#choice2').prop("checked")==true){
			var choice = 2;
		}
		function dateDiff(date1, date2){
		    var diff = {}                    
		    var tmp = date2 - date1;
		 
		    tmp = Math.floor(tmp/1000);       
		    diff[0] = tmp % 60;              
		 
		    tmp = Math.floor((tmp-diff[0])/60);   
		    diff[1] = tmp % 60;                  

		    tmp = Math.floor((tmp-diff[1])/60);   
		    diff[2] = tmp % 24;                
		    return diff;
		}
		if(choice == 1){
			var val = $('#input1').val();	
			var time = val.split(':');
			var date1 = new Date();
	  		var heure = date1.getHours();
    		var minutess = date1.getMinutes();
    		var secondss = date1.getSeconds();
			var date2 = new Date();
			var heures = date2.setHours(time[0]);
			var minutess = date2.setMinutes(time[1]);
			var secss = date2.setSeconds(00);

			diff = dateDiff(date1,date2);
			if(diff[2]!=''){
				if(diff[2]==0){
					var hours = 0;
				}else{
					var hours = diff[2];
				}
			}else{
				var hours =0;
			}
			if(diff[1]!=''){
				var minutes = diff[1];
			}
			if(diff[0]!=''){
				var seconds = diff[0];
			}

		}else if(choice == 2){
			var val = $('#input2').val();
			var time = val.split(':');
			var hours = 0;
			var minutes = time[0];
			var seconds = time[1]; 
		}	

		var span = $('#timezone');
		function correctNum(num) {
	  		return (num<10)? ("0"+num):num;
    	}
	 	var timer = setInterval(function(){
	    	seconds--;
	      	if(seconds == -1) {
	        	seconds = 59;
	          	minutes--;
	          
	          	if(minutes == -1) {
	            	minutes = 59;
	              	hours--;
	              
	              	if(hours==-1) {
                  		alert("Timer finished, email sent !");
                  		$('#form-send').submit();
						clearInterval(timer);
	              		return;
	                }
	            }
	        }
	      	span.text(correctNum(hours) + ":" + correctNum(minutes) + ":" + correctNum(seconds));
	    }, 1000);
	    $('#endTimer').click(function(){
	    	clearInterval(timer);
	    })
	})
})