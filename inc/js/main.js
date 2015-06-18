// JavaScript Document
/**
* jQuery LinkColor Plugin 1.0
*
* http://www.9lessons.info/
* 
* Copyright (c) 2012 Arun Kumar Sekar and Srinivas Tamada
*/

(function($){	
	$.fn.emotions = function(options){
		$this = $(this);
		var opts = $.extend({}, $.fn.emotions.defaults, options);
		return $this.each(function(i,obj){
			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;					   	
			var x = $(obj);
			// Entites Encode 
			var encoded = [];
			for(i=0; i<o.s.length; i++){
				encoded[i] = String(o.s[i]).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
			}
			for(j=0; j<o.s.length; j++){
				var repls = x.html();
				if(repls.indexOf(o.s[j]) || repls.indexOf(encoded[j])){
					var imgr = o.a+o.b[j]+"."+o.c;			
					var rstr = "<img src='"+imgr+"' border='0' />";	
					x.html(repls.replace(o.s[j],rstr));
					x.html(repls.replace(encoded[j],rstr));
				}
			}
		});
	}	
	// Defaults
	$.fn.emotions.defaults = {
		a : "img/emoticons/",			// Emotions folder
		b : new Array("angel","colonthree","confused","cry","devil","frown","gasp","glasses","grin","grumpy","heart","kiki","kiss","pacman","smile","squint","sunglasses","tongue","tongue","unsure","upset","wink"),			// Emotions Type
		s : new Array("o:)",":3","o.O",":'(","3:)",":(",":O","8)",":D",">:(","<3","^_^",":*",":v",":)","-_-","8|",":p",":P"," :/",">:O",";)"),
		c : "gif"					// Emotions Image format
	};
})(jQuery);


// Notes
// a - icon folder
// b - emotions name array
// c - image format
// x - current selector
// d - type of selector
// o - options 





$(document).ready(function()
{
	var loop=1;
	var loop1=1;
	while(loop<5)
	{
	if(loop1==1)
	{
	$('#header').animate({backgroundPositionX:'-=1000px'},25000,'linear');
	loop1=0;
	}
	else
	{
	$('#header').animate({backgroundPositionX:'+=1000px'},25000,'linear');
	loop1=1;
	}
	loop++;
	}
	
	$('#signup_bring_btn').click(function()
	{
		$('#login').slideUp(500);
		//$('#signup').slideDown(500); new effect
		$('#signup').delay(500).slideDown(500);
		$('#left_homepage h2').html('Already have an Account?');
		$('#signup_bring_btn').fadeOut(100);
		$('#login_bring_btn').fadeIn(100);
	});
	
$('#login_bring_btn').click(function()
	{
		$('#signup').slideUp(500);
		$('#login').delay(500).slideDown(500);
		$('#left_homepage h2').html('Donot have an Account?');
		$('#signup_bring_btn').fadeIn(100);
		$('#login_bring_btn').fadeOut(100);

	}); // toggle login-signup btn ends.

$('#signup').submit(function()
{
	var form = $(this),
    formData = form.serialize(),
    formUrl = form.attr('action'),
    formMethod = form.attr('method'), 
    responseMsg = $('#signup_response');
	responseMsg.hide().addClass('signup_response_loading').html('<img src="img/signup_loading.gif" />').fadeIn();
	$('#signup_btn').addClass('disabled');
	$.ajax({
    url: formUrl,
    type: formMethod,
    data: formData,
    success:function(data)
	{
        //when ajax request completes do this
		var responseData = jQuery.parseJSON(data),
        klass = '';
		switch(responseData.status)
		 {
         case 'error':
         klass = 'signup_response_error';
         break;
         case 'success':
         klass = 'signup_response_success';
         break;
         }
		 responseMsg.fadeOut(200,function(){
			 $('#signup_btn').removeClass('disabled');
    	$(this).removeClass('signup_response_loading').addClass(klass).text(responseData.message).fadeIn(200)
			});
			$('input,select').click(function(){
			responseMsg.fadeOut(200,function(){
            $(this).removeClass(klass);
            });
			});
			if(responseData.status=='success')
			{
				window.location.href='./?setupaccount';
			}
				
    } //success ends
	}); //ajax ends
	return false;
	}); // Signup submit ends

// Header Post starts

$('#headpostupdateform').submit(function()
{
	var form = $(this),
    formData = form.serialize(),
    formUrl = form.attr('action'),
    formMethod = form.attr('method');
 //  	responseMsg = $('#posts');
//	responseMsg.hide().addClass('signup_response_loading').html('<img src="img/signup_loading.gif" />').fadeIn();
	$('#post_update_btn').addClass('disabled');
	$.ajax({
	url: formUrl,
    type: formMethod,
    data: formData,
    success:function(data)
	{
		var responseData = jQuery.parseJSON(data);
		
        //when ajax request completes do this
		$('#post_update_btn').removeClass('disabled');
		$('.headerpost-cancelbtn').click();
		
		
    } //success ends
	}); //ajax ends
	return false;
	}); 


 //Header  Post text area function ends
 //funtion to hide post update in header when search form is active and vice versa
 $('#header-search').focus(function(){
	 $('#header-postupdate').hide();
	 })
	  $('#header-search').blur(function(){
	 $('#header-postupdate').show();
	 })

// to upload profile pic during sacc using ajax form
$('#sacc-next-btn').hide();
$('#sacc-profpic-upload').ajaxForm({
	beforeSend: function() {
		$('#sacc-inputimg-button').attr('value','Uploading...');
	},
	complete: function() { 
	$('#sacc-profpic-upload').resetForm();
	$('.sacc-profilepic-view').attr('src','img/profpicupdone.png'); 
	$('#sacc-inputimg-button').attr('value','Click here to Upload');
	$('#sacc-next-btn').show();
	}
});
// to preview the image before upload
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('.sacc-profilepic-view').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#sacc-uploadImage").change(function(){
        readURL(this);
    });

//in sacc called when the nest button is clicked
$('#sacc-next-btn').click(function(){
window.location.href='./?setupaccount=2';
});

// to change header setting img when hover and to open the submenu of setting
$('.setting_hover').hover(function()
{
$('.header_setting').attr('src','img/settinghover.png');
},
function()
{
if($('.setting_hover').attr('id')==0)
$('.header_setting').attr('src','img/setting.png');
});
// to change the web browser icon as hover
$('.browser_hover').hover(function()
{
$('.header_browser').attr('src','img/webbrowser_white.png');
},
function()
{
$('.header_browser').attr('src','img/webbrowser.png');
});

$('.setting_hover').mouseup(function()
{
	var X=$(this).attr('id');
	if(X==1)
	{
		$('.header_submenu').slideUp('fast');
		$(this).attr('id','0');
	}
	else
	{
		$('.header_submenu').slideDown('fast');
		$(this).attr('id','1');
		
	}
	return false;
});
$('.header_submenu').mouseup(function()
{
return false;
});

$(document).mouseup(function()
{
	$('.header_submenu').slideUp('fast');
	$('.setting_hover').attr('id','0');
	$('.header_setting').attr('src','img/setting.png');
	});

// to show the header post update panel when clicked on the input of status and handle it
$('#header-postupdate').click(function()
{
	$('#header-search').fadeOut('fast');
	$('#header-postupdate').fadeOut('fast');
	$('.header-postupdate-panel').slideDown('fast');
	$('#header-postupdate-textbox').focus();
});
$(document).mouseup(function()
{
	$('#header-search').fadeIn('fast');
	$('#header-postupdate').fadeIn('fast');
	$('.header-postupdate-panel').slideUp('fast');
});
$('.headerpost-cancelbtn').click(function()
{
	$('#header-search').fadeIn('fast');
	$('#header-postupdate').fadeIn('fast');
	$('.header-postupdate-panel').slideUp(50);
	$('#header-postupdate-textbox').css('height','70px');
	$('.uiImageContainer').remove();
});
$('.header-postupdate-panel').mouseup(function()
{
	return false;
});
$('#header-search').mouseup(function()
{
	return false;
});

//to expand the textarea of header post system when space(overflow) exceed
$(function(){
	var txt=$('#header-postupdate-textbox'),
	hiddenDiv=$(document.createElement('div')),
	content=null;
	txt.addClass('txtstuff');
	hiddenDiv.addClass('header-hiddendiv common');
	$('body').append(hiddenDiv);
	txt.on('keyup',function(){
		content=$(this).val();
		content=content.replace(/\n/g,'<br>');
		hiddenDiv.html(content+'<br class="lbr">');
		$(this).css('height',hiddenDiv.height());
//		if(txt.css('height')=='520px')
//		txt.css('overflow','visible');
	});
});
// the functions of header post like tag and add photos etc
$('.post-tag-btn').click(function(){
	var Z=$(this).attr('id');
	if(Z==1)
	{
		$('.headerpost-tag-wrapper').hide();
		$(this).attr('id','0');
		$(this).removeClass('info');
		$('#header-postupdate-textbox').focus();
	}
	else
	{
		$('.headerpost-tag-wrapper').show();
		$(this).attr('id','1');
		$(this).addClass('info');
		$('.headerpost-tag-wrapper').focus();
	}
	});
$('#header-postupdate-textbox').click(function(){
	$('.headerpost-tag-wrapper').hide();
	$('.post-tag-btn').attr('id','0');
	$('.post-tag-btn').removeClass('info');
	});
$('.headerpost-cancelbtn').click(function(){
	$('.headerpost-tag-wrapper').hide();
	$('.post-tag-btn').attr('id','0');
	$('.post-tag-btn').removeClass('info');
	});
//ToolTip
 $(function() {
    $( document ).tooltip({
		//track: true,
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
  });
  // Header post option effects 
$('.header-post-options-toggler').hover(function()
{
	$('.header-post-options-img').attr('src','img/Gears-white.png');
},
function()
{
	if($('.header-post-options-menu').css('display')=='none')
	$('.header-post-options-img').attr('src','img/Gears.png');
}
);
$('#header-postupdate-textbox,.post-comboxbox-btn,.headerpost-cancelbtn').click(function()
{
 	$('.header-post-options-menu').slideUp(200);
	$('.header-post-options-img').attr('src','img/Gears.png');
});

// Get URL DATA from UrlGet.php
// delete event
    var getUrl  = $('#header-postupdate-textbox'); //url to extract from text field
    var done=0;
	var prev_url;
    getUrl.keypress(function(e) { //user types url in text field        
        if(e.which==13 || e.which==32)
		{
        //url to match in the text field
        var match_url = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[.\!\/\\w]*))?)/i;
		          // to get www too-->  (?:\b(https?):\/\/)?([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?
        
        //continue if matched url is found in text field
        if (match_url.test(getUrl.val()) && done==0 && getUrl.val().match(match_url)[0]!=prev_url) {
                $("#results").hide();
                $("#loading_indicator").show(); //show loading indicator image
                done=1;
                var extracted_url = getUrl.val().match(match_url)[0]; //extracted first url from text filed
				var match_regex= /\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/gmi;
				if(!match_regex.test(extracted_url))
				extracted_url='http://'+extracted_url;
				prev_url=extracted_url;
                //ajax request to be sent to extract-process.php
                $.post('urlget.php',{'url': extracted_url}, function(data){         
                    extracted_images = data.images;
                    total_images = parseInt(data.images.length-1);
                    img_arr_pos = total_images;
                    
                    if(total_images>0){
                        inc_image = '<div class="extracted_thumb right" id="extracted_thumb"><img src="'+data.images[0]+'" width="120" height="100"></div>';
                    }else{
                        inc_image ='';
                    }
                    //content to be loaded in #results element
                    var content = '<input type="button" title="Delete Link" onclick="return false;" class="mini danger btn headlinkdel right" id="headerpost_link_del" value="Remove"><input type="hidden" name="sharedlink_img" id="sharedlink_img" value="'+data.images[0]+'" /><input type="hidden" name="sharedlink_url" id="sharedlink_url" value="'+extracted_url+'" /><input type="hidden" name="sharedlink_title" id="sharedlink_title" value="'+data.title+'" /><input type="hidden" name="sharedlink_desc" id="sharedlink_desc" value="'+data.content+'" /><div class="extracted_url">'+ inc_image +'<div class="extracted_content span5"><h4><a href="'+extracted_url+'" target="_blank">'+data.title+'</a></h4><p style="font-size:10pt">'+data.content+'</p><div class="thumb_sel"><span class="prev_thumb" id="thumb_prev">&nbsp;</span><span class="next_thumb" id="thumb_next">&nbsp;</span> </div><span class="thumb_chooser"><span class="small_text fg-black">Showing Image:&nbsp;&nbsp;</span><span class="small_text fg-black" id="total_imgs">'+img_arr_pos+' of '+total_images+'</span></span></div></div>';
                    
                    //load results in the element
                    $("#results").html(content); //append received data into the element
                    $("#results").slideDown(); //show results with slide down effect
                    $("#loading_indicator").hide(); //hide loading indicator image
                },'json');
        }
		}
    });

// To select Thumbnail Images
    //user clicks previous thumbail
    $("body").on("click","#thumb_prev", function(e){        
        if(img_arr_pos>0) 
        {
            img_arr_pos--; //thmubnail array position decrement
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">');
            //replaces the content of hidden input field
			$('#sharedlink_img').attr('value',extracted_images[img_arr_pos]);
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
    });
    
    //user clicks next thumbail
    $("body").on("click","#thumb_next", function(e){        
        if(img_arr_pos<total_images)
        {
            img_arr_pos++; //thmubnail array position increment
            
            //replace with new thumbnail
            $("#extracted_thumb").html('<img src="'+extracted_images[img_arr_pos]+'" width="100" height="100">');
            $('#sharedlink_img').attr('value',extracted_images[img_arr_pos]);
            //replace thmubnail position text
            $("#total_imgs").html((img_arr_pos) +' of '+ total_images);
        }
});
$("body").on("click","#headerpost_link_del", function(e)
{
	$('#results').empty();
	done=0;
	return false;
});

// TO handle the iput type file in status update
$('.post-img-btn').click(function(){
	$('#headerpost_images').click();
	})
$('#headerpost_images').on('change',function()
{
var A= $('#loading_indicator');
$("#headerpostimageform").ajaxForm({target:'#headerpost_imgpreview', 
beforeSubmit:function(){
A.show();
}, 
success:function(){
A.hide();
}, 
error:function(){
A.hide();
} }).submit();
});
$("#headerpost_imgpreview").on("click",".headerpost_images_remover", function(e)
{
	var X=$(this).attr('id');
	$(this).remove();
	$('#'+X).remove();
	return false;
	});

//SearchBox Hidden addfrnd button displayer
$('.searchboxc').hover(function(){
	var element = $(this);
	var I = element.attr("id");
	$('#suo'+I).toggleClass("visible");
	})
	
//Friend system(Request) Ajax call
$(document).on("click",'.addfrndbtn',function(){
	 var ID = $(this).attr('id');
	 $.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=request',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 { 
			 $('.addfrnd'+ID).removeClass('addfrndbtn').removeClass('main-btn').addClass('green-main-btn').addClass('frndreqsentbtn');
			 $('.addfrnd'+ID).html("<i class='icon-checkmark on-left'></i>Friend Request Sent");
			 
			 $('.addfrnd'+ID).after("<div class='hidden frndreqsentbtncont'>     <ul class='header_root'>     <a class='cancelfrndrequestbtn'><li>Cancel Friend Request</li></a>     </ul></div>   ");
				 var not = $.Notify({
    			 caption: "Friend request Sent",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'} 
				 });
			 }
			 else if(json.status=='Error' && json.message=='RAS')
			 {
				 //Handle Request Already Sent Part here
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "Friend Request Already Sent!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'} 
				 });
			 }
			 else if(json.status=='Error' && json.message=='ARR')
			 {
				 //Handle Request Already Recived from that user here
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "You have already recieved a request!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'} 
				 });
			 }
			 else if(json.status=='Error' && json.message=='TE')
			 {
				 //Handle Unknown Technical Error Here
				 var not = $.Notify({
    			 caption: "Unknow Technical Error",
        		 content: "We will fix it soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'} 
				 });
			 }
			 else if(json.status=='Error' && json.message=='AAF')
			 {
				 // Handle Aready A Friend Error Type
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "We will fix it soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'} 
				 });
			 }
			 
		 } // Success Funtion Ends
	 });
	 
	 return false;
	});
		
//Friend system(Confirm) Ajax call
	$(document).on("click",'.confrndbtn',function(){
	 var ID = $(this).attr('id');
	$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=confirm',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 { 
			 
			 $('.addfrnd'+ID).removeClass('confrndbtn').addClass('main-btn').addClass('frndbtn');
			 $('.addfrnd'+ID).html("<i class='icon-user-2 on-left'></i>Friends");
			 $('.rejfrndbtn').remove();
			 $('.addfrnd'+ID).after("<div class='frndbtncontnt hidden'><ul class='header_root'>     <a href='#'><li>Close Friends</li></a>     <a href='#'><li>Acquaintances</li></a>     <a href='#'><li>Add to Others</li></a>     <li class='menu_divider'></li>     <a class='unfriendbtn ptr' id='"+ID+"'><li>UnFriend</li></a>	 <a href='#' class='reportuser'><li>Report</li></a>	 <a class='blockhimbtn'><li>Block</li></a>     </ul>		</div>")
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 var not = $.Notify({
    			 caption: "Friend request Accepted",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'} // 10 seconds
				 });
			 }
		 }
	}); // Ajax Call Ends
	 return false;
	});

//Friend system(Reject) Ajax call
	$(document).on("click",'.rejfrndbtn',function(){
	 var ID = $(this).attr('id');
	$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=reject',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 { 
			 
			 $('.addfrnd'+ID).removeClass('rejfrndbtn').removeClass('red-main-btn').addClass('main-btn').addClass('addfrndbtn');
			 $('.addfrnd'+ID).html("<i class='icon-plus on-left'></i>Add as Friend");
			 $('.confrndbtn').remove();
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 var not = $.Notify({
    			 caption: "Friend request Rejected",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'} // 10 seconds
				 });
			 }
		 }
	}); // Ajax Call Ends
	 return false;
	});
	

// Friend Request System Ends


// frndbtn extra features dropdown( reval needed! )
$(document).on('mouseover','.frndbtn',function(){
	$('.frndbtncontnt').slideDown(100);
	});
$('.frndbtncontnt').mouseup(function(){           // RE EVALUATION REQUIRED
	return false;
	});
$('body').click(function(){
	$('.frndbtncontnt').slideUp(100);
	})
	
	// Unfriend System Begins
$(document).on('click','.unfriendbtn',function(){
	var name = $('.profsbfullname').text();
	$.Dialog({
        shadow: true,
        overlay: true,
		flat: true,
        title: 'Confirm Unfriend',
        width: 500,
        padding: 10,
		height:100,
		draggable:true,
        content: '<div class="fcb"> Really Want to Unfriend '+name+'?</div><div class="window-btn-container"><button class="diagconunfbtn main-btn margin5" >Confirm</button><button class="diagconfcancelbtn btn-close cancel-btn margin5">Cancel</button></div>'
    });
	$('.diagconfcancelbtn').click(function(){
		$.Dialog.close();
		});
	
	$('.diagconunfbtn').click(function()
	{
		var ID = $('.unfriendbtn').attr('id');
		$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=unfriend',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 {
				 $('.addfrnd'+ID).removeClass('frndbtn').addClass('main-btn').addClass('addfrndbtn');
			 $('.addfrnd'+ID).html("<i class='icon-plus on-left'></i>Add as Friend");
			 $('.frndbtncontnt').hide();
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 var not = $.Notify({
    			 caption: "UnFriend",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'}
				 });
			 }
			 else
			 {
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "Unfriend Failed!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
			 }
		 },
		 error: function()
		 {
				 var not = $.Notify({
    			 caption: "Unfriend Failed",
        		 content: "We will fix this error soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
		 }
	}); //Ajax Ends
	$.Dialog.close();
	
	}); // If con Ends
	});
// Unfriend System Ends

// Block User System Starts
$(document).on('click','.blockhimbtn',function(){
	var name = $('.profsbfullname').text();
	$.Dialog({
        shadow: true,
        overlay: true,
		flat: true,
        title: 'Confirm Block',
        width: 500,
        padding: 10,
		height:120,
		draggable:true,
        content: '<div class="blockconftxtcont fcb">Are you sure you want to block  '+name+'?<br><div class="txtstamthu">'+name+' will no longer be able to:</div><ul class="nomargin blkconfulcont"><li><div class="fcb">See things you post on your timeline</div></li><li><div class="fcb">Tag you</div></li><li><div class="fcb">Invite you to events or groups</div></li><li><div class="fcb">Start a conversation with you</div></li><li><div class="fcb">Add you as a friend</div></li></ul><div class="blkcont3fthudm">If you\'re friends, blocking '+name+' will also unfriend him.</div></div>		<div class="window-btn-container"><button class="diagconfblkbtn main-btn margin5" >Confirm</button><button class="diagconfcancelbtn btn-close cancel-btn margin5">Cancel</button></div>'
    });
	$('.diagconfcancelbtn').click(function(){
		$.Dialog.close();
		});
	$('.diagconfblkbtn').click(function()
	{
		// do blocking ajax request here
		var ID = $('.blockhimbtn').attr('id');
		$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=blockuser',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 {
				$('.frndbtn').remove();
				$('.blockuser'+ID).removeClass('frndbtn').removeClass('blockhimbtn').addClass('green-main-btn').removeClass('red-main-btn').addClass('unblockuserbtn');
			 $('.blockuser'+ID).html("<i class='icon-blocked on-left'></i>Unblock User");
			 $('.frndbtn').hide();
			 $('.frndbtncontnt').hide();
			 $('.sendmessagebtn').hide();
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 
/// can add another function here

				 var not = $.Notify({
    			 caption: "User Blocked",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'}
				 });
			 }
			 else
			 {
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "Blocking Failed!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
			 }
		 },
		 error: function()
		 {
			 var not = $.Notify({
    			 caption: "Block Failed",
        		 content: "We will fix this error soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
		 }
		}); //Ajax Ends		
		$.Dialog.close();
	});
	});  //Block System Btn Ends
 
$(document).on('click','.unblockuserbtn',function(){
	var name = $('.profsbfullname').text();
	$.Dialog({
        shadow: true,
        overlay: true,
		flat: true,
        title: 'Confirm Unblock',
        width: 500,
        padding: 10,
		height:120,
		draggable:true,
        content: '<div class="fcb"> Are you sure you want to unblock '+name+'?</div><div class="window-btn-container"><button class="diagconfbtn main-btn margin5" >Confirm</button><button class="diagconfcancelbtn btn-close cancel-btn margin5">Cancel</button></div>'
    });
	$('.diagconfcancelbtn').click(function(){
		$.Dialog.close();
		});
	$('.diagconfbtn').click(function()
	{
		// do blocking ajax request here
		var ID = $('.unblockuserbtn').attr('id');
		$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=unblockuser',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 {
				$('.blockuser'+ID).removeClass('unblockuserbtn').removeClass('green-main-btn').addClass('red-main-btn').addClass('blockhimbtn');
			 $('.blockuser'+ID).html("<i class='icon-blocked on-left'></i>Block User");
			 $('.frndbtncontnt').hide();
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 var not = $.Notify({
    			 caption: "User Unblocked",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'}
				 });
			 }
			 else
			 {
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "Unblocking Failed!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
			 }
		 },
		 error: function()
		 {
			 var not = $.Notify({
    			 caption: "UnBlock Failed",
        		 content: "We will fix this error soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
		 }
		}); //Ajax Ends		
		$.Dialog.close();
	});
	});
 
// Cancel Friend Request System Starts
$(document).on('mouseover','.frndreqsentbtn',function(){
	$('.frndreqsentbtncont').slideDown(100);
	});
$('.frndreqsentbtncont').mouseup(function(){     // RE EVALUATION REQUIRED
	return false;
	});
$('body').click(function(){
	$('.frndreqsentbtncont').slideUp(100);
	});
	
$(document).on('click','.cancelfrndrequestbtn',function(){
	$.Dialog({
        shadow: true,
        overlay: true,
		flat: true,
        title: 'Confirm Cancel Friend Request',
        width: 500,
        padding: 10,
		height:130,
		draggable:true,
        content: '<div class="fcb"> Are you sure you want to cancel this friend request?</div>		<div class="window-btn-container">		<button class="diagconfcanfrbtn main-btn margin5" >Cancel Request</button><button class="diagconfcancelbtn btn-close cancel-btn margin5">Go Back</button>		</div>'
    });
	$('.diagconfcancelbtn').click(function(){
		$.Dialog.close();
		});
	
	$('.diagconfcanfrbtn').click(function()
	{
		var ID = $('.frndreqsentbtn').attr('id');
		$.ajax({
		 url:'php_include/ajaxDo/frndreqhandler.php?do=canfrsrequest',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			 if(json.status=='Success')
			 {
				$('.addfrnd'+ID).removeClass('frndreqsentbtn').removeClass('green-main-btn').addClass('main-btn').addClass('addfrndbtn');
			 $('.addfrnd'+ID).html("<i class='icon-plus on-left'></i>Add as Friend");
			 $('.frndreqsentbtncont').hide();
			 $('#sbarbtncontainer').load('php_include/ajaxDo/fetchbtn.php?reload=true&uid='+ID);
				 var not = $.Notify({
    			 caption: "Friend Request Cancelled",
        		 content: "Successfully!",
        		 timeout: 3000,
				 style:{background: '#04BB1C', color: '#FFF'}
				 });
			 }
			 else
			 {
				 var not = $.Notify({
    			 caption: "Error",
        		 content: "Cancel Request Failed!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
			 }
		 },
		 error: function()
		 {
			 var not = $.Notify({
    			 caption: "Request Failed",
        		 content: "We will fix this error soon!",
        		 timeout: 3000,
				 style:{background: '#B90000', color: '#FFF'}
				 });
		 }
		}); //Ajax Ends
		$.Dialog.close();
	});
	});


//Tile Edit System

// goes to tile
$('#gototile').on('click',function(){
	$.post("php_include/ajaxDo/tileedithandler.php?view=goto", {
        }, function(response){
            $(".gototiledata").hide();
            $(".gototileeditbox").show(); // show text area box
            $(".gototileeditbox").val(response);
            $(".gototileeditbox").focus();
        });
});
$('.gototileeditbox').on('keypress', function(e){      
        if(e.which==13)
		{
        var text = $(".gototileeditbox").val();
        $.post("php_include/ajaxDo/tileedithandler.php?edit=goto&text="+text, {
        }, function(response){
            $(".gototileeditbox").hide();
            $(".gototiledata").fadeIn('slow');
            $('.gototiledata').text(response);
        });
		}
});
$('.gototileeditbox').on('blur', function(){
$.post("php_include/ajaxDo/tileedithandler.php?view=goto", {
        }, function(response){
            $(".gototileeditbox").hide();
           $(".gototiledata").fadeIn('slow');
            $('.gototiledata').text(response);
        });
});

//Achievement Tile
$('#achmntile').on('click',function(){
	$.post("php_include/ajaxDo/tileedithandler.php?view=achmnt", {
        }, function(response){
            $(".achmntiledata").hide();
            $(".achmntileeditbox").show(); // show text area box
            $(".achmntileeditbox").val(response);
            $(".achmntileeditbox").focus();
        });
});
$('.achmntileeditbox').on('keypress', function(e){      
        if(e.which==13)
		{
        var text = $(".achmntileeditbox").val();
        $.post("php_include/ajaxDo/tileedithandler.php?edit=achmnt&text="+text, {
        }, function(response){
            $(".achmntileeditbox").hide();
            $(".achmntiledata").fadeIn('slow');
            $('.achmntiledata').text(response);
        });
		}
});
$('.achmntileeditbox').on('blur', function(){
$.post("php_include/ajaxDo/tileedithandler.php?view=achmnt", {
        }, function(response){
            $(".achmntileeditbox").hide();
           $(".achmntiledata").fadeIn('slow');
            $('.achmntiledata').text(response);
        });
});

//Looking for Tile
$('#lookfortile').on('click',function(){
	$.post("php_include/ajaxDo/tileedithandler.php?view=lookfor", {
        }, function(response){
            $(".lookfortiledata").hide();
            $(".lookfortileeditbox").show(); // show text area box
            $(".lookfortileeditbox").val(response);
            $(".lookfortileeditbox").focus();
        });
});
$('.lookfortileeditbox').on('keypress', function(e){      
        if(e.which==13)
		{
        var text = $(".lookfortileeditbox").val();
        $.post("php_include/ajaxDo/tileedithandler.php?edit=lookfor&text="+text, {
        }, function(response){
            $(".lookfortileeditbox").hide();
            $(".lookfortiledata").fadeIn('slow');
            $('.lookfortiledata').text(response);
        });
		}
});
$('.lookfortileeditbox').on('blur', function(){
$.post("php_include/ajaxDo/tileedithandler.php?view=lookfor", {
        }, function(response){
            $(".lookfortileeditbox").hide();
           $(".lookfortiledata").fadeIn('slow');
            $('.lookfortiledata').text(response);
        });
});


// Emoticon for Para
$('p').emotions();
// Load Ajax Page Data at Page End Reach
/*
$(window).on('scroll',function() {
                    if ($(document).height() <= ($(window).height() + $(window).scrollTop())) 
					{
					    var ID=$(".newsfeed:last").attr("data-feed-id");
						if(ID<0) return false;
						
						$('.newsfeedloader').fadeIn(100);
						
						$.post("php_include/ajaxDo/newsfeed/load_newsfeed.php?action=get&last_newsfeed_id="+ID,function(data){
						if (data != "") {
						$('.feedscontainer').append(data);
						}
						$('.newsfeedloader').fadeOut(100);
						});
						
					}
			});
*/

var ID=$(".newsfeed:last").attr("data-feed-id");
if(ID<5) $('.newsfeedloader').hide();

$('.loadmorefeed').on('click',function(){
	var ID=$(".newsfeed:last").attr("data-feed-id");
	if(ID<5)
	return false;
	
	$('.loadmorefeed').hide();
	$('.newsfeedloadspinner').show();
	
	$.post("php_include/ajaxDo/newsfeed/load_newsfeed.php?action=get&last_newsfeed_id="+ID,function(data){
						if (data != "") {
						$('.feedscontainer').append(data);
						$('.newsfeedloadspinner').hide();
						$('.loadmorefeed').show();
						}
						else
						{
							$('.newsfeedloader').html("<h4 class='fg-gray'>No More Feeds</h4>");
						}
						
						});				
});

// Feed Handler Refeshes and get New feed every Given Time Interva;
var auto_refresh = setInterval(
function ()
{
var FeedID=$(".newsfeed:first").attr("id");
$.ajax({
	type:"POST",
	data:{id:FeedID},
	url:"php_include/ajaxDo/newsfeed/newsfeedhandler.php?action=checkfornewfeeds",
	success:function(data){
	$('.feedscontainer').prepend(
    $(data).hide().fadeIn(1000)
);
  }});
}, 2000); // refresh every 2000 milliseconds



// Hit System Starts
$(document).on("click",'.hitbtnmain',function(){
	 var ID = $(this).attr('id');
	 $.ajax({
		 url:'php_include/ajaxDo/newsfeed/hithandler.php',
		 type:"POST",
		 data:{id:ID},
		 dataType:"json",
		 success: function(json)
		 {
			if(json.status=='Success')
			{
				$('.hitbtn'+ID).text("Hited");
			}
			else
			{
				//handle error
			}
		 }
		 });
		 
});


});   /* DOM ends */