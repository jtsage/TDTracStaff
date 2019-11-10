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


