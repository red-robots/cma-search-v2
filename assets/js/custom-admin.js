jQuery(document).ready(function ($) {

	// $(window).off('beforeunload');

	// $("body.toplevel_page_acf-options form#post").on("submit",function(e){
	// 	e.preventDefault();
	// 	var adminURL = wpAdminURL + 'admin.php?page=acf-options';
	// 	var successURL = adminURL + '&message=1';
	// 	var data = $(this).serializeArray();
	// 	$.post(adminURL, data, function(response){
 //            if(response) {
 //            	window.location.href = successURL;
 //            	//window.history.pushState( null, document.title, successURL );
 //            }
 //        });
 //        return false;

	// });


	/* THIS IS TO FIX THE ISSUE OF BEING REDIRECTED TO 404 AFTER SAVING THE OPTIONS CUSTOM FIELDS */
	/* Request Information URL field */
	var schemes = ['http','https'];
	if( $("input#acf-field_5dc248358e034").length > 0 ) {
		var url_dummy_field = '<input type="text" id="request-info-url" value="">';
		$(url_dummy_field).insertBefore('input#acf-field_5dc248358e034');
		var currentVAL = $("input#acf-field_5dc248358e034").val();
		var cv = currentVAL.replace(/\s/g,'');
		var completeURL = '';
		if( $("input#acf-field_5e7f01711e379").length > 0 ) {
			var schemeVal = $("input#acf-field_5e7f01711e379").val();
			if(cv) {
				if( schemeVal && ($.inArray(schemeVal, schemes) !== -1) ) {
					completeURL = schemeVal + "://" + currentVAL.trim();
				} else {
					completeURL = currentVAL.trim();
				}
				$("input#request-info-url").val(completeURL);
			}
		}

	}
	

	$(document).on("keyup keypress blur focusout","input#request-info-url",function(){
		var str = $(this).val();
		var valstr = str.replace(/\s/g,'');
		if(valstr) {
			var link  = valstr.toLowerCase();
			var parse = link.split(":");
			var link_scheme = parse[0];
			if($.inArray(link_scheme, schemes) !== -1) {
				/* URL SCHEME FIELD */
				var removestr = link_scheme + '://';
				var cleanedURL = str.replace(removestr,"");
				if( $("input#acf-field_5dc248358e034").length > 0 ) {
					$("input#acf-field_5dc248358e034").val(cleanedURL);
				}
				if( $("input#acf-field_5e7f01711e379").length > 0 ) {
					$("input#acf-field_5e7f01711e379").val(link_scheme); 
				}
			} else {
				if( $("input#acf-field_5dc248358e034").length > 0 ) {
					$("input#acf-field_5dc248358e034").val(str);
				}
				if( $("input#acf-field_5e7f01711e379").length > 0 ) {
					$("input#acf-field_5e7f01711e379").val(""); 
				}
			}
		} else {
			if( $("input#acf-field_5dc248358e034").length > 0 ) {
				$("input#acf-field_5dc248358e034").val("");
			}
			if( $("input#acf-field_5e7f01711e379").length > 0 ) {
				$("input#acf-field_5e7f01711e379").val("");
			}
		}
	});
	


	/* SEND EMAIL TO TEAM */
	$(document).on("keyup blur","#emailteamform .form-control",function(){
		var val = $(this).val().replace(/\s/g,'');
		if(val) {
			$(this).removeClass("error");
		}
	});

	$("#emailteamform").on("submit",function(e){
		e.preventDefault();
		var form = $(this);
		var formdata = $(this).serialize();
		var errors = [];
		form.find('.form-control.required').each(function(){
			var inputName = $(this).attr("name");
			var val = $(this).val().replace(/\s/g,'');
			if(val=='') {
				errors.push(inputName);
				$(this).addClass("error");
			} else {
				$(this).removeClass("error");
			}
		});

		if( $(errors).length > 0 ) {
			var errorMessage = '<div class="alert alert-danger">Fill-in the required field(s).</div>';
			$("#response").html(errorMessage);
		} else {
			var captchaVal = $("#captchagen").attr("data-source");
			$.ajax({
				type: "POST",
				url : myAjax.ajaxurl,
				data: formdata + '&captchashown='+captchaVal,
				dataType: "json",
				beforeSend:function(){
					$("#waiting").addClass('show');
					$("#response").html("");
					$(".form-control").removeClass("error");
				},
				success: function(obj) {
					var success = obj.success;
					var errorType = obj.error;
					var message = obj.message;

					if(success) {
						form.find('.form-control.required').each(function(){
							$(this).val("");
							$(this).removeClass("error");
						});
						form[0].reset();
						$("#response").html(message);
						$("#response").focus();
						$(".teamform").remove();
						//$(".captcha-field").load(currentURL+'?contact=yes'+ " .captchaInner",function(){ });
					} else {
						$("#response").html(message);
						if(errorType=='captcha') {
							$("input#strcaptcha").addClass("error").select();
						}
					}
				},
				complete:function(){
					setTimeout(function(){
						$("#waiting").removeClass('show');
					},500);
				},
				error: function (xhr, desc, err) {
					// console.log(xhr);
					// console.log(desc);
					// console.log(err);
	            },
	        });
		}
	});

});
