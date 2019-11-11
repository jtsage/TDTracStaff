$(document).ready(function() {
	$(".bootcheck").each(function() {
		$(this).bootstrapSwitch();
	});

	$('input[type="text"]').each(function() {
		$(this).after($('<div class="help-block with-errors"></div>'));
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip({
			container: 'body'
		});
	});
	
	$('[role="alert"].error').addClass('alert alert-warning');

	function do_rep() {
		var cur_pass = $('#password').val(),
			cur_user = $('#username').val(),
			cur_text = $('#welcomeEmail').val();

		cur_text = cur_text.replace(/Username:.+\n/m, "Username: " + cur_user + "\n");
		cur_text = cur_text.replace(/Password:.+\n/m, "Password: " + cur_pass + "\n");
		$('#welcomeEmail').val(cur_text);
	}
	
	$('#password').on('change', do_rep);
	$('#username').on('change', do_rep);

	$(".loadingClick").on('click', function() {
		$(".loading").each(function() {
			$(this).removeClass("loading");
		});
		$(".btn").each(function() {
			$(this).addClass("disabled");
		})
	});

	$(".clickOpenAct").on('click', function() {
		var jobID    = $(this).data("job"),
			methName = $(this).data("change"),
			jobName  = $(this).data("name"),

			ajaxUrl  = location.protocol + "//" + location.host + "/jobs/changeStatus/" + jobID + "/" + methName,
			message  = "Are you sure you wish to change the " + methName + " status of " + jobName + "?";

			this.blur();

			cont = confirm(message);

			if ( cont ) {
				$.ajax({
					url     : ajaxUrl,
					success : function(data) {
						if ( data.success === true ) {
							insertDiv = $(
								'<div class="alert alert-success alert-dismissible fade show" role="alert">' +
								data.responseString +
								'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
								'</div>');
							
							$("." + data.pillID ).closest(".col-md-9").prepend(insertDiv);
							$("." + data.pillID ).removeClass("badge-success badge-primary");
							$("." + data.pillID ).addClass("badge-" + data.pillClass);
							$("." + data.pillID ).text(data.pillText);

							$(".alert").delay(4000).slideUp(200, function() {
								$(this).alert('close');
							});
						} else {
							alert(data.responseString);
						}
					}
				});
			}	  
		return false;
	})
});

function linker(obby, nextDatebox) {
	var setDate = obby.date;

	minDateString = this.callFormat('%Y-%m-%d', setDate);

	$('#' + nextDatebox).val("");
	$('#' + nextDatebox).datebox({
		minDate      : minDateString,
		calHighToday : false,
		defaultValue : setDate
	});

	$('#' + nextDatebox).datebox('open');
}

function linkerNoOpen(obby, nextDatebox) {
	var setDate = obby.date;

	minDateString = this.callFormat('%Y-%m-%d', setDate);

	$('#' + nextDatebox).val("");
	$('#' + nextDatebox).datebox({
		minDate      : minDateString,
		calHighToday : false,
		defaultValue : setDate
	});
}


