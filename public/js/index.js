$(document).ready(function() {
    $('.alert').fadeOut(4000);

    $("li").click(function() {
    	var dataId = $(this).attr("data-id");
    	console.log("data-id = " + dataId);
    	$('#calendar').fullCalendar('removeEvents');
    	$('#calendar').fullCalendar('addEventSource', '/index/get-reservation?courtId=' + dataId);
    	$('#calendar').fullCalendar('rerenderEvents');
    	courtId = dataId;
    });
    courtId = $("li.court.active").attr("data-id");
    $('#calendar').fullCalendar('removeEvents');
    $('#calendar').fullCalendar('addEventSource', '/index/get-reservation?courtId=' + courtId);
    $('#calendar').fullCalendar('rerenderEvents');
});