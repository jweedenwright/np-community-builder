// Update the Volunteer Period Modal
function editPeriod(vol_period_sel) {
	var vol_period_id = $(vol_period_sel).data("id"),
		vol_period_signin = $(vol_period_sel).data("signin"),
		vol_period_signout = $(vol_period_sel).data("signout"),
		vol_period_act = $(vol_period_sel).data("activity"),
		vol_period_loc = $(vol_period_sel).data("location"),
		vol_period_org = $(vol_period_sel).data("org");

	$("#vol-period-id").attr("value", vol_period_id);
	$("#signin-datetime-picker").val(vol_period_signin);
	$("#signout-datetime-picker").val(vol_period_signout);
	$("#organization").attr("value", vol_period_org);
	$("#task").val(vol_period_act);
	$("#location").val(vol_period_loc);
}

// Search volunteers
var vol_search_rows = document.getElementsByClassName("search-row");
function filterVolunteers(search_field) {
	// Start the search
	for (var i = 0; i < vol_search_rows.length; i++) {
		vol_search_row = vol_search_rows[i];
		var found = vol_search_row.dataset.search.toLowerCase().indexOf(search_field.value.toLowerCase());
		if (found === -1) {
			vol_search_row.classList.add("hidden");
		} else if (found !== -1) {
			vol_search_row.classList.remove("hidden");
		}
	}
}