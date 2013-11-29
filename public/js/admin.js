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

							}
						});
					}
				}
			});
		}
	});
});