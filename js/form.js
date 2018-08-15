(function ($){
	"use strict";

	var notices = $('<div id="form-notices"/>');
	$("body").append(notices);

	// Get form
	$(document).ready(function(){
		$(".form-processor").submit( submitForm );
	})
	

	function submitForm(event){
		event.preventDefault();

		var form = $(this);
		var url = form.attr("action");
		var data = new FormData(form[0]);					
		
		notify({type: "loading"}); 	// Display loading message

		form.find(":submit").attr("disabled","disabled"); // Disable form submission

		$.ajax({
			url: url,
			type: "POST",
			data: data,
			dataType: "json",
			processData: false,
			contentType: false,
			success: function(response){
				notify(response);
				form.find(".form-output").html(response.msg).attr("msg-status", response.status);
				form.find(":submit").removeAttr("disabled");  // Enable form submission
			}
		})
		
	}

	function notify(message){
		
		//Get type of message
		var msg = message.msg;
		var type = message.type || message.status ? "success" : "failure";
		
		//Create Message based on type
		switch( type ){

			case "loading":
				if( notices.find(".loading").length > 0) return;
				msg = msg || "Loading...";

			case "success":
			case "failure":
				unload();
			default:
				if(!msg) return;

				var notice = $('<div class="form-notice"/>')
				notice.addClass(type);

				if(type == "loading"){
					notice.append("<i class='ion-spin ion-load-c'> </i> " + msg);
				}
				else{
					notice.append("<span class='form-notice-close'>&times;</span>" + msg);
					notice.find(".form-notice-close").click(function(e){$(this).parents(".form-notice").remove();});
					setTimeout(function(){ notice.remove()}, 5000);
				}
				notices.append(notice);
		}
	}

	function unload(){
		$("#form-notices .loading").remove();
	}

})(jQuery)