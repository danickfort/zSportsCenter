$(document).ready(function() {
	$(".glyphicon-remove").click(function() {

		var action = $(this).attr("action");
		var id = $(this).attr("data-id");

		console.log("action = " + action);
		console.log("id = " + id);

		if (action == "removeSport") {

			$.ajax({
				url: "/index/removeSport",
				type: "GET",
				dataType: "JSON",
				data: {
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
					var result = confirm(message);
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
					var result = confirm(message);
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
				}
			});

		} else if(action == "removeUser")
		{

			$.ajax(
			{
				url: "/index/remove-user",
				type: "POST",
				dataType: "JSON",
				data:
				{
					id: id,
					code:"removeUser"
				},
				success: function(json)
				{
					var message = 'Deleting user:\n';
					message += '----------------\n';
					var result = confirm(message);
					if(result)
					{
						$.ajax(
						{
							url: "/index/remove-user",
							type: "POST",
							dataType: "JSON",
							data:
							{
								code: "confirm",
								id: json.idUser
							},
							success: function(json)
							{
								$('.userEntry#' + id).hide();
							}
						});
					}
				}
					
			});
		}
	});
});