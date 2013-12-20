$(document).ready(function() {
    $('.message').fadeOut(4000);

    $("li").click(function() {
    	var dataId = $(this).attr("data-id");
    	console.log("data-id = " + dataId);
    	$('#calendar').fullCalendar('removeEvents');
    	$('#calendar').fullCalendar('addEventSource', '/index/get-reservation?courtId=' + dataId);
    	$('#calendar').fullCalendar('rerenderEvents');
    	courtId = dataId;

        changeCourtIdCalendar(courtId);
    });
    courtId = $("li.court.active").attr("data-id");
    $('#calendar').fullCalendar('removeEvents');
    $('#calendar').fullCalendar('addEventSource', '/index/get-reservation?courtId=' + courtId);
    $('#calendar').fullCalendar('rerenderEvents');

    $(".glyphicon-remove").click(function() {

        var action = $(this).attr("action");
        var id = $(this).attr("data-id");

        if (action == "removeVacation") {
            $.ajax({
                url: "/index/removeVacation",
                type: "GET",
                dataType: "JSON",
                data: {
                    code: "removeVacation",
                    id: id
                },
                success: function(json) {
                    bootbox.confirm("Are you sure ?", function(result) {
                        if (result) {
                            // confirmation
                            $.ajax({
                                url: "/index/removeVacation",
                                type: "GET",
                                dataType: "JSON",
                                data: {
                                    code: "confirm",
                                    id: json.idVacation
                                },
                                success: function(json) {
                                    bootbox.alert("Vacation Delete !");
                                }
                            });
                        }
                    });
                }
            });
        }
    });
});