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
});

function linker(obby, nextDatebox) {
	var setDate = obby.date;

	//setDate.adj(2, 1); // Add One Day

	// Format the date for min/max attribute
	minDateString = this.callFormat('%Y-%m-%d', setDate);

	// Set min date and a default on "next" datebox
	// We set the min to not allow dates before a day after checkin to be picked.
	// We set the default to make sure the view is appropriate.

	// In this case, should you want to "suggest" a one week stay, add 6 more days to
	// setDate, *after* pulling the minimum date ISO string.
	$('#' + nextDatebox).val("");
	$('#' + nextDatebox).datebox({
		minDate      : minDateString,
		calHighToday : false,
		defaultValue : setDate
	});

	// Open "next" datebox
	$('#' + nextDatebox).datebox('open');
}

function linkerNoOpen(obby, nextDatebox) {
	var setDate = obby.date;

	//setDate.adj(2, 1); // Add One Day

	// Format the date for min/max attribute
	minDateString = this.callFormat('%Y-%m-%d', setDate);

	// Set min date and a default on "next" datebox
	// We set the min to not allow dates before a day after checkin to be picked.
	// We set the default to make sure the view is appropriate.

	// In this case, should you want to "suggest" a one week stay, add 6 more days to
	// setDate, *after* pulling the minimum date ISO string.
	$('#' + nextDatebox).val("");
	$('#' + nextDatebox).datebox({
		minDate      : minDateString,
		calHighToday : false,
		defaultValue : setDate
	});
}

function linkerGuessDate(obby, nextDatebox) {
	var setDate = obby.date;

	//setDate.adj(2, 1); // Add One Day

	firstPay = obby.date.copy(); // Copy Due Date
	firstPay.adj(2,7); // Add 7 days.

	highDates = [];
	if ( firstPay.get(2) < 16 ) { 
		firstPay.setD(2,15);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,30);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,15).adj(1,1);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,30);
		highDates.push( firstPay.iso() );
	}
	else if ( firstPay.get(2) < 31 ) {
		firstPay.setD(2,30);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,15).adj(1,1);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,30);
		highDates.push( firstPay.iso() );
		firstPay.setD(2,15).adj(1,1);
		highDates.push( firstPay.iso() );
	}

	// Format the date for min/max attribute
	minDateString = this.callFormat('%Y-%m-%d', setDate);

	// Set min date and a default on "next" datebox
	// We set the min to not allow dates before a day after checkin to be picked.
	// We set the default to make sure the view is appropriate.

	// In this case, should you want to "suggest" a one week stay, add 6 more days to
	// setDate, *after* pulling the minimum date ISO string.
	$('#' + nextDatebox).val("");
	$('#' + nextDatebox).datebox({
		minDate      : minDateString,
		calHighToday : false,
		defaultValue : setDate,
		highDates    : highDates
	});

	// Open "next" datebox
	$('#' + nextDatebox).datebox('open');
}