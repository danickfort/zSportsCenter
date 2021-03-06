$(document).ready(function() {
	$(".glyphicon-remove").click(function() {

		var action = $(this).attr("action");
		var id = $(this).attr("data-id");

		console.log("action = " + action);
		console.log("id = " + id);

		if (action == "removeSport") {
			$('#sportsmanager.loading').show();
			$.ajax({
				url: "/index/removeSport",
				type: "GET",
				dataType: "JSON",
				data:
				{
					code: "removeSport",
					id: id
				},
				success: function(json) {
					var message = 'Deleting court:\n';
					message += '----------------\n';
					var size = json.courts.length;
					for (var i = 0; i < size; i++) {
						message += json.courts[i] + '\n';
					}
					bootbox.confirm("Are you sure ?", function(result) {
						if (result) {
							// confirmation
							$.ajax({
								url: "/index/removeSport",
								type: "GET",
								dataType: "JSON",
								data: {
									code: "confirm",
									id: json.idSport
								},
								success: function(json) {
									$('#sportsmanager.loading').hide();
									console.log(json.sportName);
									var li = $("a[href='#" + json.sportName + "']").parent();
									var div = $("#" +  json.sportName);

									var prevLi = li.prev();
									var prevDiv = div.prev();

									console.log("prevLi: " + prevLi);
									console.log("prevDiv: " + prevDiv);

									if ($.isEmptyObject(prevLi)) {
										console.log("prevLi");
										prevLi.addClass("active");
									} else {
										console.log("nextLi");
										li.next().addClass("active");
									}

									if ($.isEmptyObject(prevDiv)) {
										console.log("prevDiv");
										prevDiv.addClass("active");
									} else {
										console.log("nextDiv");
										div.next().addClass("active");
									}

									li.remove();
									div.remove();
								}
							});
}
else {
	$('#sportsmanager.loading').hide();
}
});
}
});

} else if (action == "removeCourt") {
	$.ajax({
		url: "/index/removeCourt",
		type: "GET",
		dataType: "JSON",
		data: {
			code: "removeCourt",
			id: id
		},
		success: function(json) {
			var message = 'Deleting reservations:\n';
			message += '----------------\n';
			var size = json.usersName.length;
			for (var i = 0; i < size; i++) {
				message += json.usersName[i] + '\n';
			}
			bootbox.confirm("Are you sure ?", function(result) {
				if (result) {
							// confirmation
							$.ajax({
								url: "/index/removeCourt",
								type: "GET",
								dataType: "JSON",
								data: {
									code: "confirm",
									id: json.idCourt
								},
								success: function(json) {
									console.log(json.nameCourt);
									var li = $("a[href='#" + json.nameCourt + "']").parent();
									var div = $("#" +  json.nameCourt);

									var prevLi = li.prev();
									var prevDiv = div.prev();

									console.log("prevLi: " + prevLi);
									console.log("prevDiv: " + prevDiv);

									if ($.isEmptyObject(prevLi)) {
										console.log("prevLi");
										prevLi.addClass("active");
									} else {
										console.log("nextLi");
										li.next().addClass("active");
									}

									if ($.isEmptyObject(prevDiv)) {
										console.log("prevDiv");
										prevDiv.addClass("active");
									} else {
										console.log("nextDiv");
										div.next().addClass("active");
									}

									li.remove();
									div.remove();
								}
							});
}
});
}
});

}
else if(action == "removeUser")
{
	$('#usersmanager.loading').show();
	$.ajax({
		url: "/index/remove-user",
		type: "POST",
		dataType: "JSON",
		data: {
			id: id,
			code:"removeUser"
		},
		success: function(json) {
			bootbox.confirm("Are you sure ?", function(result) {
				if(result) {
					$.ajax({
						url: "/index/remove-user",
						type: "POST",
						dataType: "JSON",
						data: {
							code: "confirm",
							id: json.idUser
						},
						success: function(json) {
							$('.userEntry#' + id).hide();
							$('#usersmanager.loading').hide();
						}
					});
				} else {
					$('#usersmanager.loading').hide();
				}
			});
		}
		
	});
}
});
});

$(document).ready(function() {
	var urlz = document.location.toString();
	if (urlz.match('#')) {
		var n = urlz.split('#')[1];
		if (n != sports) $('.nav-tabs a[href=#sports]').tab('show') ;
		$('.nav-tabs a[href=#'+n+']').tab('show') ;
	}});
