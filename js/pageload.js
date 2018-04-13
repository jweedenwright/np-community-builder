//////////////////////
// PAGE LOAD
//////////////////////
window.addEventListener("load",function() {

	// Check for hours passed in the URL
	var hours = getParameterByName('hours'); // "lorem"
	if (hours !== undefined && hours !== null && hours !== "") {
		$("#hours").html(hours);
		$("#hours-worked").show();
	}
	
	// Botomatic for testing
	//botamatic();
	
	// Setup datetime picker
	$(".datetime-picker").datetimepicker({
		"useCurrent": true,
		"stepping":5
	});
	console.log("You're a rich girl, and you've gone too far");
	
	// Check / Set preferences
	checkPreferences();

	//////////////////////
	// SERVICE CALLS
	//////////////////////
	var service_calls = $(".npcb-service");
	for (var i = 0; i < service_calls.length; i++) {
		var service_call = service_calls[i];
		if($(service_call).data("npcb-service")) {
			// Only run if data is populated
			var service = $(service_call).data("npcb-service");
			var callback = "";
			if ($(service_call).data("npcb-callback") !== "") {
				callback = $(service_call).data("npcb-callback");
			}		
			loadServiceData(service_call, service, callback, "");
		}
	}
	
	//////////////////////
	// ON EVENT HANDLERS
	//////////////////////

	// Set datetime picker time and flip the ok switch on that input
	$(".datetime-picker").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".signin-time .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".signin-time .input-group-addon", "error");
		}
	});
	$(".datetime-picker").focus().blur();
	$("#quick-sign-in-name").focus();

	// Setup on change for organization
	$("#organization").on("change",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".organization .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".organization .input-group-addon", "error");
		}
	});

	// Setup on change for task drop down
	$("#task").on("change",function() {
		if ($(this).find(":selected").val() !== "") {
			flipInputGroupIcon(".task .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".task .input-group-addon", "error");
		}
	});
	
	// Setup on change for location drop down
	$("#location").on("change",function() {
		if ($(this).find(":selected").val() !== "") {
			flipInputGroupIcon(".location .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".location .input-group-addon", "error");
		}
	});
	
	// Setup on change for email
	$("#quick-sign-in-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".email .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".email .input-group-addon", "error");
		}
	});
	
	// Setup on change for first and last name
	$("#first-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".first-name .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".first-name .input-group-addon", "error");
		}
	});
	
	// Setup on change for first and last name
	$("#last-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".last-name .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".last-name .input-group-addon", "error");
		}
	});
	
	// Expand / Collapse release forms sections
	$(".release-handler").on("click",function() {

		// Remove in on ALL to cover our bases
		$(".panel-collapse").each(function() {
			$(this).removeClass("in");
		});

		// Remove and add 'in' to expand/collapse
		var parents = $(this).parents(".panel-collapse");
		if (parents.length > 0) {
			// Remove the in, collapsing the panel
			var parent_item = parents[0];
			$(parent_item).removeClass("in");
			$(parent_item).siblings().find("a").addClass("collapsed");

			// Go up another level to find the next panel
			var panel_items = $(parent_item).parents(".panel");
			if (panel_items.length > 0) {
				// get next panel
				var panel_item = panel_items[0];
				var next_items = $(panel_item).next(".panel");
				if (next_items.length > 0) {
					// We have another panel, expand it
					var next_item = next_items[0];
					$($(next_item).children(".panel-heading")[0]).find("a").removeClass("collapsed");
					$($(next_item).children(".panel-collapse")[0]).addClass("in");
				}
			}
		}
	});
	
	// Scroll to top
	jQuery('html,body').animate({scrollTop:0},200);
	
	//////////////////////////////////
	// PAGE SPECIFIC LOGIC - Bulk Page
	$(".add-attendee").on("click", function() {
		var attendee_count = document.getElementsByClassName("attendee").length,
			attendee_wrapper = $("#bulk-import .attendee-wrap"),
			attendee_field_wrapper = $("<div id=\"attendee" + attendee_count + "\" class=\"row attendee\">"),
			attendee_email = $("<div class=\"form-group col-sm-3\"><label for=\"email\">Email</label><input type=\"text\" class=\"form-control\" id=\"quick-sign-in-name\" name=\"email\" autocomplete=\"on\" placeholder=\"Enter an email\"></div>"),
			attendee_first_name = $("<div class=\"form-group col-sm-3\"><label for=\"firstName\">First Name</label><input type=\"text\" class=\"form-control\" id=\"firstName\" name=\"firstName\" autocomplete=\"on\" placeholder=\"First Name\"></div>"),
			attendee_last_name = $("<div class=\"form-group col-sm-3\"><label for=\"lastName\">Last Name</label><input type=\"text\" class=\"form-control\" id=\"lastName\" name=\"lastName\" autocomplete=\"on\" placeholder=\"Last Name\"></div>"),
			attendee_first_time = $("<div class=\"form-group col-sm-2\"><div class=\"checkbox\"><label><input type=\"checkbox\" name=\"first-time\"> First Time</label></div></div>")
			attendee_removal = $("<div class=\"pull-left\"><button type=\"button\" class=\"remove btn btn-default active\"><i class='glyphicon glyphicon-minus' aria-hidden=\"true\"></i><span class=\"sr-only\">Remove a field</span></button></div>");

		attendee_field_wrapper.append(attendee_email);
		attendee_field_wrapper.append(attendee_first_name);
		attendee_field_wrapper.append(attendee_last_name);
		attendee_field_wrapper.append(attendee_first_time);
		attendee_field_wrapper.append(attendee_removal);
		attendee_wrapper.append(attendee_field_wrapper);

		$(".attendee-wrap .remove").on("click", function() {
			$(this).parents(".attendee").remove();
		});
	});
});