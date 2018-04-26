// Update a Location Modal
function editLocation(loc_period_sel) {
	$("#loc-name").attr("value", $(loc_period_sel).data("name"));
	$("#loc-internal").attr("value", $(loc_period_sel).data("internal"));
	$("#loc-id").attr("value", $(loc_period_sel).data("id"));
}

// Update the Volunteer Period Modal
function editPeriod(vol_period_sel) {
	$("#vol-period-id").attr("value", $(vol_period_sel).data("id"));
	$("#signin-datetime-picker").val($(vol_period_sel).data("signin"));
	$("#signout-datetime-picker").val($(vol_period_sel).data("signout"));
	$("#organization").attr("value", $(vol_period_sel).data("org"));
	$("#task").val($(vol_period_sel).data("activity"));
	$("#location").val($(vol_period_sel).data("location"));
}

// Search volunteers
var search_rows = document.getElementsByClassName("search-row");
function filterItems(search_field) {
	// Start the search
	for (var i = 0; i < search_rows.length; i++) {
		search_row = search_rows[i];
		var found = search_row.dataset.search.toLowerCase().indexOf(search_field.value.toLowerCase());
		if (found === -1) {
			search_row.classList.add("hidden");
		} else if (found !== -1) {
			search_row.classList.remove("hidden");
		}
	}
}