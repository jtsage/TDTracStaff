$(document).ready(function() {
	$('#sidebarCollapse').on('click', function () {
		$('#sidebar').toggleClass('active');
	});
	

	$('input[type="text"]').each(function() {
		$(this).after($('<div class="help-block with-errors"></div>'));
	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip({
			container: 'body'
		});
	});

	$('[role="alert"].error').addClass('alert alert-danger shadow-sm');

	$( ".deleteBtn" ).on( "click", function () {
		var thisEle = $(this).data();

		bootbox.confirm({ 
			message: thisEle.msg,
			centerVertical : true,
			callback: function(result) { 
				if ( result ) {
					window.location.href = location.protocol + "//" + location.host + "/" + thisEle.control + "/delete/" + thisEle.id;
				}
			}
		});
		return false;
	});

	
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
			jobName  = $(this).data("name");

			ajaxUrl  = location.protocol + "//" + location.host + "/jobs/changeStatus/" + jobID + "/" + methName,
			message  = "Are you sure you wish to change the " + methName + " status of " + jobName + "?";

			this.blur();

			bootbox.confirm({ 
				message: message,
				centerVertical : true,
				callback: function(result) { 
					if ( result ) {
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
									$("." + data.pillID ).removeClass("badge-success badge-danger");
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
				}
			});
		return false;
	});
	$("#markAllBut").on('click', function() {
		bootbox.confirm({ 
			message: "Are you sure you want to mark all visible (in this page) hours as paid? (This cannot be easily un-done)",
			centerVertical : true,
			callback: function(result) { 
				if ( result ) {
					$('#markAllForm').submit();
				}
			}
		});
		return false;
	});
	$(".clickMark").on('click', function() {
		var payID    = $(this).data("payroll"),
			message  = $(this).data("msg"),
			
			ajaxUrl  = location.protocol + "//" + location.host + "/payrolls/markPaid/" + payID + "/";

			this.blur();

			bootbox.confirm({ 
				message: message,
				centerVertical : true,
				callback: function(result) { 
					if ( result ) {
						$.ajax({
							url     : ajaxUrl,
							success : function(data) {
								if ( data.success === true ) {
									$("." + data.pillID ).hide();
									$("." + data.pillID ).parent().find(".deleteBtn").hide();
									$("." + data.pillID ).closest("tr").find(".hours-worked-col").removeClass("font-weight-bold");
									$("." + data.pillID ).closest("tr").find(".is-paid-col").removeClass("font-weight-bold").html("<span class=\"w-100 badge badge-success\">yes</span>");
								} else {
									alert(data.responseString);
								}
							}
						});
					}
				}
			});
		return false;
	});
	$(".emailNeedBtn").on('click', function() {
		var jobID    = $(this).data("jobid"),
			
			ajaxUrl  = location.protocol + "//" + location.host + "/jobs/email/" + jobID + "/";

			this.blur();

			bootbox.confirm({ 
				message: 'Are you sure you wish to e-mail all qualified employees about this job?  This process may take a minute, please be patient.',
				centerVertical : true,
				callback: function(result) { 
					if ( result ) {
						$(".loading").each(function() {
							$(this).removeClass("loading");
						});
						$(".btn").each(function() {
							$(this).addClass("disabled");
						})
						window.location.href = ajaxUrl;
					}
				}
			});
		return false;
	});
	$(".emailNotifyBtn").on('click', function() {
		var recID    = $(this).data("recid"),
			username = $(this).data("username"),
			
			ajaxUrl  = location.protocol + "//" + location.host + "/jobs/notify/" + recID + "/";

			this.blur();

			bootbox.confirm({ 
				message: 'Are you sure you wish to e-mail ' + username + ' that scheduling information for this job is complete?',
				centerVertical : true,
				callback: function(result) { 
					if ( result ) {
						$(".loading").each(function() {
							$(this).removeClass("loading");
						});
						$(".btn").each(function() {
							$(this).addClass("disabled");
						})
						window.location.href = ajaxUrl;
					}
				}
			});
		return false;
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



jQuery.fn.tableToCSV = function() {
	
	var clean_text = function(text){
		text = text.replace(/"/g, '\\"').replace(/'/g, "\\'").replace(/\t/g,"").replace(/\n/g,"");
		return '"'+text+'"';
	};
	
	$(this).each(function(){
			var table = $(this);
			var caption = $(this).find('caption').text();
			var title = [];
			var rows = [];

			$(this).find('tr').each(function(){
				var data = [];
				$(this).find('th').each(function(){
					var text = clean_text($(this).text());
					title.push(text);
				});
				$(this).find('td').each(function(){
					var text = clean_text($(this).text());
					data.push(text);
				});
				data = data.join(",");
				rows.push(data);
				});
			title = title.join(",");
			rows = rows.join("\n");

			var csv = title + rows;
			var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
			var download_link = document.createElement('a');
			download_link.href = uri;
			var ts = new Date().getTime();
			if(caption==""){
				download_link.download = ts+".csv";
			} else {
				download_link.download = caption+"-"+ts+".csv";
			}
			document.body.appendChild(download_link);
			download_link.click();
			document.body.removeChild(download_link);
	});
};

$(function(){
	$("#export").click(function(){
		$("#export_table").tableToCSV();
	});
});

window.chartColor = {
	"red"    : "#f1b8b8",
	"green"  : "#9ad98c",
	"yellow" : "#e9b77a",
	"blue"   : "#9eb4cb",
	"grey"   : "#dfe6e8",
	"ltblue" : "#c6e2fc",
	"purple" : "#b49ddf"
};
window.lottaColors = [
	"rgba(220,220,220,0.5)", "rgba(151,187,205,0.5)", "rgba(82,154,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,205,151,0.5)", "rgba(154,190,82,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,151,205,0.5)", "rgba(154,82,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(205,151,187,0.5)", "rgba(190,82,154,0.5)",
	"rgba(220,220,220,0.5)", "rgba(151,187,205,0.5)", "rgba(82,154,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,205,151,0.5)", "rgba(154,190,82,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,151,205,0.5)", "rgba(154,82,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(205,151,187,0.5)", "rgba(190,82,154,0.5)",
	"rgba(220,220,220,0.5)", "rgba(151,187,205,0.5)", "rgba(82,154,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,205,151,0.5)", "rgba(154,190,82,0.5)",
	"rgba(220,220,220,0.5)", "rgba(187,151,205,0.5)", "rgba(154,82,190,0.5)",
	"rgba(220,220,220,0.5)", "rgba(205,151,187,0.5)", "rgba(190,82,154,0.5)",
];




