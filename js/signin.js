// Check email service call for returning volunteer
function checkEmail() {
	clearErrorMsgs();
	var element = document.getElementById('quick-sign-in-name'); 
	if (element.value !== undefined && element.value !== null && element.value !== "") {
		var service = "check_email";
		var callback = "checkEmailCallback";
		var url_params = "email=" + element.value;
		loadServiceData(element, service, callback, url_params);
	} else {
		handleInvalid("Please enter your email address.");
	}
}

// Callback - moved into this JS file to help with understanding of the code
function checkEmailCallback(element, results) {
	if (results.data !== undefined && results.data !== null && results.data.length > 0) {
		// Populate fields and hide everything unnecessary
		$("#returning-volunteer-not-found").addClass("hidden");
		$("#returning-volunteer-found").removeClass("hidden");

		var person = results.data[0]; 
		var first_name = person.firstName;
		var last_name = person.lastName;
		// Check and collapse liability boxes (previously logged in)
		document.getElementById("general-liability-check").checked = true;
		document.getElementById("photo-release-check").checked = true;
		document.getElementById("health-release-check-collapse").classList.add("in");
		
		// Set first and last name (previously logged in)
		document.getElementById("first-name").value = first_name;
		document.getElementById("last-name").value = last_name;
		// Hide Fields
		document.getElementsByClassName("first-name")[0].style.display = "none";
		document.getElementsByClassName("last-name")[0].style.display = "none";
		document.getElementById("photo-release-check-panel").style.display = "none";
		document.getElementById("general-liability-check-panel").style.display = "none";
		document.getElementById("sign-in-opts-accordion").style.display = "none";

		// Change field-error/glyphicon-remove to field-ok/glyphicon-ok
		flipInputGroupIcon(".email .input-group-addon, .last-name .input-group-addon, .first-name .input-group-addon", "ok");
	// Failure
	} else {
		
		// Uncheck boxes
		document.getElementById("general-liability-check").checked = false;
		document.getElementById("health-release-check").checked = false;
		document.getElementById("photo-release-check").checked = false;

		// Show fields
		document.getElementsByClassName("first-name")[0].style.display = "table";
		document.getElementById("first-name").value = "";
		document.getElementsByClassName("last-name")[0].style.display = "table";
		document.getElementById("last-name").value = "";
		document.getElementById("photo-release-check-panel").style.display = "block";
		document.getElementById("general-liability-check-panel").style.display = "block";
		document.getElementById("sign-in-opts-accordion").style.display = "block";
		
		// Change field-ok/glyphicon-ok to field-error/glyphicon-remove
		flipInputGroupIcon(".last-name .input-group-addon, .first-name .input-group-addon", "error");
		$("#returning-volunteer-not-found").removeClass("hidden");
		$("#returning-volunteer-found").addClass("hidden");
	}
}

// Sign in Volunteer
function signIn() {

	// Clear old errors
	clearErrorMsgs();
	
	// Validate Fields
	var valid_form = true;
	
	// required validations
	valid_form = document.getElementsByName("general-liability-check")[0].checked;
	if(!valid_form) { return handleInvalid("Please be sure to accept the general liability form."); }
	valid_form = document.getElementsByName("health-release-check")[0].checked;
	if(!valid_form) { return handleInvalid("Please be sure to accept the health release form."); }
	valid_form = document.getElementsByName("photo-release-check")[0].checked;
	if(!valid_form) { return handleInvalid("Please be sure to accept the photo release form."); }
	valid_form = document.getElementsByName("firstname")[0].value !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide your first name."); }
	valid_form = document.getElementsByName("lastname")[0].value !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide your last name."); }
	
	// Complex validations
	var email = document.getElementsByName("email")[0];
	valid_form = email.value !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide your email."); }
	valid_form = (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/).test(email.value);
	if(!valid_form) { return handleInvalid("Please be sure your email is in the correct format."); }

	// Date: 02/07/2017 6:48 PM
	var datetime = document.getElementsByName("signintime")[0];
	valid_form = datetime.value !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide your sign in date."); }

	var location_item = document.getElementsByName("location")[0];
	valid_form = (/^[0-9]*$/).test(location_item.options[location_item.selectedIndex].value);
	if(!valid_form) { return handleInvalid("Please be sure to select a location."); }
	var task_item = document.getElementsByName("task")[0];
	valid_form = (/^[0-9]*$/).test(task_item.options[task_item.selectedIndex].value);
	if(!valid_form) { return handleInvalid("Please be sure to select a program."); }
	
	// Check non-req field validation
	var emer_phone = document.getElementsByName("emergency-phone-number")[0].value;
	if (emer_phone !== "") {
		valid_form = (/[0-9]{3}-[0-9]{3}-[0-9]{4}/).test(emer_phone);
		if(!valid_form) { return handleInvalid("Please be sure your emergency contact info is in the xxx-xxx-xxxx format."); }
	}

	if (valid_form) {
		// AJAX Post to PHP
		$.ajax({
			type: "POST",
			url: signin_url,
			data: $("#sign-in-form").serialize(), // serializes the form's elements.
			success: function(data) {
				if (data.indexOf("ERROR") !== -1) {
					$(".danger").html(data);
				} else {
					// Redirect to thank you
					location.href = 'thank-you.php';
				}
			}
		});
	}
	return false;
}

function bulkImport() {
	// Used by the Bulk Import page to sign in many people at once
	// Scroll to top
	jQuery('html,body').animate({scrollTop:0},200);
	
	// Clear old errors
	clearErrorMsgs();
	
	// Validate Fields
	var valid_form = true;
	
	// required validations
	// Date: 02/07/2017 6:48 PM
	var datetime = document.getElementsByName("signintime")[0].value;
	valid_form = datetime !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide your sign in date."); }

	// Affiliation
	var affiliation = document.getElementsByName("organization")[0].value;
	valid_form = affiliation !== "";
	if(!valid_form) { return handleInvalid("Please be sure to provide an organization or affiliation name."); }

	// Task
	var task_item = document.getElementsByName("task")[0];
	var task_id = task_item.options[task_item.selectedIndex].value;
	valid_form = (/^[0-9]*$/).test(task_id);
	if(!valid_form) { return handleInvalid("Please be sure to select a program."); }

	// Location
	var location_item = document.getElementsByName("location")[0];
	var location_id = location_item.options[location_item.selectedIndex].value;
	valid_form = (/^[0-9]*$/).test(location_id);
	if(!valid_form) { return handleInvalid("Please be sure to select a location."); }

	// Loop through all first / last / email / checkbox combos
	if (valid_form) {
		var attendees = document.getElementsByClassName("attendee");
		if (attendees.length > 0) {
			// Need to verify ALL attendees before saving any to keep some saving some before an error occurs
			// - EX: 20 attendees sign in, the first 10 pass and are saved, the 11th has an issue...we now have 10 saved and 10 not in the DB
			// - This check makes sure that all data is valid BEFORE saving attendees
			var all_valid_attendees = true;
			for (var i = 0; i < attendees.length; i++) {
				valid_attendee = true;
				var attendee = attendees[i];
				current_attendee = i + 1;
						
				// Validation
				valid_attendee = attendee.querySelectorAll("[name=firstName]")[0].value !== "";
				if(!valid_attendee) { return handleInvalid("Please be sure to provide first names for all volunteers. Issue found on volunteer " + current_attendee + "."); }
				valid_attendee = attendee.querySelectorAll("[name=lastName]")[0].value !== "";
				if(!valid_attendee) { return handleInvalid("Please be sure to provide last names for all volunteers. Issue found on volunteer " + current_attendee + "."); }
	
				// Complex validations
				var email = attendee.querySelectorAll("[name=email]")[0];
				valid_attendee = email.value !== "";
				if(!valid_attendee) { return handleInvalid("Please be sure to provide email addresses for all volunteers. Issue found on volunteer " + current_attendee + "."); }
				valid_attendee = (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/).test(email.value);
				if(!valid_attendee) { return handleInvalid("Please be sure all emails are in the correct format. Issue found on volunteer " + current_attendee + "."); }

				if (!valid_attendee) {
					all_valid_attendees = false;
					break;
				}
			}
			
			// If all valid - start to process one at a time
			// - Need to setup form data in the following format to pass to the existing signin.php page:
			// "first-time=0&email=jeremiah.weedenwright%40gmail.com&firstname=Jeremiah&lastname=Weeden-Wright
			//		&location=2&task=3&signintime=04%2F12%2F2018+1%3A30+PM
			//		&general-liability-check=1&agree=no&health-release-check=1&agree=no&photo-release-check=1&agree=no
			//		&include-email-dist=0&community-service=0&affiliation=&emergency-phone-number=&skills=&find-out-about-us="
			if(all_valid_attendees) {
				for (var i = 0; i < attendees.length; i++) {
					// Look over each Login
					var attendee = attendees[i];
					var vol_data = "first-time=0"
								+ "&email=" + attendee.querySelectorAll("[name=email]")[0].value
								+ "&firstname=" + attendee.querySelectorAll("[name=firstName]")[0].value
								+ "&lastname=" + attendee.querySelectorAll("[name=lastName]")[0].value
								+ "&location=" + location_id
								+ "&task=" + task_id
								+ "&signintime=" + datetime
								+ "&general-liability-check=1&health-release-check=1&photo-release-check=1&include-email-dist=0&community-service=0"
								+ "&affiliation=" + affiliation
								+ "&emergency-phone-number=&skills=&find-out-about-us=";

					// AJAX Post to PHP - need to try ALL attendees before failing/succeeding
					var attendees_returned = 0; // compare to attendees.length
					var issues = "";
					$.ajax({
						type: "POST",
						url: signin_url,
						data: vol_data, // serializes the form's elements.
						success: function(data) {
							// Increment the number of attendees to return
							attendees_returned++;
							// Check for an error
							if (data.indexOf("ERROR") !== -1) {
								issues = issues + data;
							}
							// Check if this was the last attendee to return
							if (attendees_returned === attendees.length) {
								if (issues !== "") {
									$(".danger").html(issues);		
								} else {
									// Redirect to thank you
									location.href = 'thank-you.php';
								}
							}							
						}
					});
				}	
			}
		} else {
			// There were no attendees on the form!
			return handleInvalid("Please be sure to add attendees!");
		}
	}
	return false;
}

function setPreferences() {
	// Get location and store in local storage
	if (typeof(Storage) !== "undefined") {
		var location_value = document.getElementById("location").value;
		if (location_value !== "") {
			localStorage.setItem("location", location_value);
		}
		document.getElementById("prefs-set").innerHTML = "<p>Preferences Set!</p>";
	} else {
		document.getElementById("prefs-failed").innerHTML = "<p>Sorry! This browser doesn't support local storage or setting of preferences!</p>";	
	}
}

function checkPreferences() {
	// Check for preferences
	if (typeof(Storage) !== "undefined") {
		var location_value = localStorage.location;
		if (location_value !== undefined && location_value !== "") {
			var element = document.getElementById('location');
			if(element !== null && element !== undefined) {
				element.value = location_value;
				// Check off that req field is now valid
				flipInputGroupIcon(".location .input-group-addon", "ok");
			}
		}
	}
}