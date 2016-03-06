$(function() {
	console.info("Init application");

	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
		}
	});

	$(".form-delete").on("submit", function(e) {
		console.debug("Trying to submit form");

		if (confirm("Do you really want to delete this item?")) {
			console.debug("Continuing form submission");
		} else {
			console.debug("Abort form submit");

			e.preventDefault();
			return false;
		}
	});
});
