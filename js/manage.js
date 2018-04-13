function editPeriod(vol_period_sel) {
	var vol_period_id = $(vol_period_sel).data("id"),
		vol_period_sigin = $(vol_period_sel).data("signin"),
		vol_period_signout = $(vol_period_sel).data("signout"),
		vol_period_act = $(vol_period_sel).data("activity"),
		vol_period_loc = $(vol_period_sel).data("location"),
		vol_period_org = $(vol_period_sel).data("org");

	$("#vol-period-id").attr("value", vol_period_id);
	$("#signin-datetime-picker").attr("value", vol_period_sigin);
	$("#signout-datetime-picker").attr("value", vol_period_signout);
	$("#organization").attr("value", vol_period_org);
	$("#task").val(vol_period_act);
	$("#location").val(vol_period_loc);
}