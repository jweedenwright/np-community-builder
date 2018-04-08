// Global Vars
var domain = document.getElementById("npcb-env").value;
var protocol = document.getElementById("npcb-protocol").value + ":";
var service_url = protocol + "//" + domain + "/app/services.php?service=";
var signin_url = protocol + "//" + domain + "/app/signin.php";
var signout_url = protocol + "//" + domain + "/app/signout.php";
var quick_signin = $("#quick-sign-in-name");

//////////////////////
// AUTOPOPULATE DATES
//////////////////////
window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>');
var today = new Date();
$('#myDate').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2));

// Handline invalid input
function handleInvalid(msg) {
	var error_divs = document.querySelectorAll(".danger");
	for (var i = 0; i < error_divs.length; i++) {
		error_divs[i].innerHTML = "<p class='alert'>" + msg + "</p>";
	}
	return false;
}

// Clear all error messages
function clearErrorMsgs() {
	var error_divs = document.querySelectorAll(".danger");
	for (var i = 0; i < error_divs.length; i++) {
		error_divs[i].innerHTML = "";
	}
}

// for auto populating fields
function botamatic() {
	$("input[name='firstname']").val("Rusty");
	$("input[name='lastname']").val("Von Shackleford");
	$("input[name='email']").val("backwoods007@shackleford.edu");
	document.getElementById('location').value = 3;
	document.getElementById('task').value = 2;	
	$(".release-handler").each(function () {
		$(this).prop("checked", true);
	});
}

// Get URL parameters
function getParameterByName(name, url) {
	if (!url) {
		url = window.location.href;
	}
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	results = regex.exec(url);
	if (!results) {
		return null;
	}
	if (!results[2]) {
		return '';
	}
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// Set input group addon values
// Check off that req field is now valid
function flipInputGroupIcon(querySelector, status) {
	var field_inputs = document.querySelectorAll(querySelector);
	for (var i = 0; i < field_inputs.length; i++) {
		// input-group-addon has field-* and the child <i> has the glyphicon
		if (status === "ok") {
			$(field_inputs[i]).addClass("field-ok").removeClass("field-error");
			$(field_inputs[i]).children().addClass("glyphicon-ok").removeClass("glyphicon-asterisk");
		} else {
			$(field_inputs[i]).addClass("field-error").removeClass("field-ok");
			$(field_inputs[i]).children().addClass("glyphicon-asterisk").removeClass("glyphicon-ok");			
		}
	}
}