$(document).ready(function() {
	$(".glyphicon-remove").click(function() {
		var id = $(this).attr("data-id");
		if(id != 0) {
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
		}
	});
});