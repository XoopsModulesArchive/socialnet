//configs lightbox
jQuery(document).ready(function() {
	$(function() {
	   $('a[@rel*=lightbox]').lightBox({
		overlayBgColor: '#000',
		overlayOpacity: 0.6,
		imageLoading: 'images/photo/lightbox-ico-loading.gif',
		imageBtnClose: 'images/photo/close.gif',
		imageBtnPrev: 'images/photo/prev.gif',
		imageBtnNext: 'images/photo/next.gif',
		containerResizeSpeed: 800,
		txtImage: 'Image',
		txtOf: 'of'
	   });
	});


});


//validation of album form
jQuery(document).ready(function() {
	$("form#form_picture").submit(function() {
		return xoopsFormValidate_form_picture();
	});
});
// validation of youtube videos
jQuery(document).ready(function() {
	$("form#form_videos").submit(function() {
								 
		if ($("form#form_videos input#codigo").val() == ""){
			window.alert("Please enter YouTube URL or code"); 
			$("form#form_videos input#codigo").focus(); 
			return false; 
		}
		else { 
			var str = $("form#form_videos input#codigo").val();
			var urlValue = str.replace(/http:\/\//gi,"http:%2F%2F")	
			$("form#form_videos input#codigo").val(urlValue);
		}
		return true;	
	});
});


// validation of audios
jQuery(document).ready(function() {
	$("form#form_audios").submit(function() {
								 
		if ($("form#form_audios input#sel_audio").val() == ""){
			window.alert("Please enter MP3 title"); 
			$("form#form_audios input#sel_audio").focus(); 
			return false; 
		}
		else { 
			return true;	
		}
	});
});


//validation of scraps
jQuery(document).ready(function() {
	$("form#formScrapNew").submit(function() {
		return xoopsFormValidate_formScrapNew();
	});
});


jQuery(document).ready(function() {
$("div.socialnet-scrap-details-form").hide();
});


jQuery(document).ready(function() {
	$("a.socialnet-scraps-replyscrap").click(function() {
		$(this).parents("div.socialnet-scrap-details").find('div.socialnet-scrap-details-form').slideToggle("slow");
		
	});
});

jQuery(document).ready(function() {
	$("input.resetscrap").click(function() {
		$(this).parents("div.socialnet-scrap-details-form").slideToggle("slow");
		
	});

});

// in album page show tips effect
jQuery(document).ready(function() {
	$("a#show_tips").click(function() {
		$("div#xtips").slideToggle("slow");
	});
});

jQuery(document).ready(function() {
	
		$("div#xtips").hide();
	
});
// in index.php 
jQuery(document).ready(function() {
	
		$("div#socialnet-suspension").hide();
	
});

jQuery(document).ready(function() {
	$("img#socialnet-suspensiontools").toggle(function() {
		$("div#socialnet-suspension").show();
	},function(){
  		$("div#socialnet-suspension").hide();
	});
});


jQuery(document).ready(function() {
$("div#socialnet-license").hide();
});

jQuery(document).ready(function() {

//    $("a#socialnet-license-link").click(function() {
    $("a#socialnet-license-link").mouseover(function() {

        $("div#socialnet-license").slideToggle("slow");
        
 });
});

//close all search results in contributions when the page loads for the first time
jQuery(document).ready(function() {
$("div.socialnet-profile-search-module-results").slideUp("fast");
});

//open the search results for one specific module and close the others. 
//If the button is clicked when the module results are open then it closes it

jQuery(document).ready(function() {

	$("a.socialnet-profile-search-module-title").click(function() {
	    $("div.socialnet-profile-search-module-results").slideUp("slow");
        if ( $(this).parents("div.socialnet-profile-search-module").find('div.socialnet-profile-search-module-results').is(':hidden') )
		    $(this).parents("div.socialnet-profile-search-module").find('div.socialnet-profile-search-module-results').slideDown("slow");
		
	});

});

jQuery(document).ready(function() {
	$("p.odd").mouseover(function() {
		$(this).addClass("present");
		
	});

});

jQuery(document).ready(function() {
	$("p.odd").mouseout(function() {
		$(this).removeClass("present");
		
	});

});

jQuery(document).ready(function() {
	$("p.even").mouseover(function() {
		$(this).addClass("present");
		
	});

});

jQuery(document).ready(function() {
	$("p.even").mouseout(function() {
		$(this).removeClass("present");
		
	});

});

jQuery(document).ready(function() {
	$("#text").click(function() {
		$(this).html("");
		
	});

});

jQuery(document).ready(function() {

var ifChecked = "0";
$("input#allbox").click(function() {

if(ifChecked == "0") {
$("input.socialnet-notification-checkbox").attr("checked","checked");
ifChecked = "1";
}
else {
$("input.socialnet-notification-checkbox").attr("checked","");
ifChecked = "0";
}
});	
});


function xoopsFormValidate_form_picture() { myform = window.document.form_picture; if ( myform.sel_photo.value == "" ) { window.alert("Please enter Select Photo"); myform.sel_photo.focus(); return false; }return true;
}


function xoopsFormValidate_formScrapNew() { 
myform = window.document.formScrapNew; 
if ( myform.text.value == "" ) { 
window.alert("Please enter text"); 
myform.text.focus(); 
return false; 
}
return true;
		}

function cleanScrapForm(id,defaultvalue) { 

	
var ele = xoopsGetElementById(id);
if (ele.value==defaultvalue){    
ele.value = "";
}
}

function goToUserPage(id) { 

var ele = xoopsGetElementById(id);
openWithSelfMain('index.php?uid='.ele.value);
}

function changeVisibility(id) { 

var elestyle = xoopsGetElementById(id);

    if (elestyle.style.visibility == "hidden") {
        elestyle.style.visibility = "visible";
                
    } else {
        elestyle.style.visibility = "hidden";
    }
   

}

function changeReplyVisibility(idform) { 

changeVisibility(idform);
}

function groupImgSwitch(img) { 

var elestyle = xoopsGetElementById(img).style;

        elestyle.display = "none";
  

}


