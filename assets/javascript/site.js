//
// Shared sitewide javascript code.
//
$(document).ready(function () {
	// Globel Datepicker
	$('.datepicker').datepicker();
	
	// Jquery UI Buttons
	$(".button").button();
	
	// Datatables.
	$('.data-table').dataTable({
		"bJQueryUI": true,
		"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
		"aaSorting": [[0,'desc']],
		"iDisplayLength": 50
	});
	
	// A generic way to confirm deletions.
	$('.confirm').live('click', function () {
		var c = confirm('Are you sure you want to delete this entry?');
		return c;
	});
});