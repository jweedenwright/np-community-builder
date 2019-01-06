//////////////////////////////////////////
// REPORTING
//////////////////////////////////////////

window.addEventListener("load",function() {
	// Chart logic
	var location_ctx = document.getElementById("location-chart");
	var task_ctx = document.getElementById("task-chart");
	if (location_ctx && task_ctx) {
		// Run the Chart code, there are charts on the page
		var location_chart_metrics = document.getElementsByClassName("location-chart-metric");
		var task_chart_metrics = document.getElementsByClassName("task-chart-metric");
		var backgroundColor = ["#3498db","#2ecc71","#8e44ad","#f1c40f","#34495e","#f39c12","#e67e22","#e74c3c","#16a085"];
		var options = { legend: { display: true, position: "right" } };

		// Location Chart Data
		var location_chart_dataset = [];
		var location_chart_labels = [];
		for (var i = 0; i < location_chart_metrics.length; i++) {
			location_chart_metric = location_chart_metrics[i];
			location_chart_dataset.push(location_chart_metric.value);
			location_chart_labels.push(location_chart_metric.name);
		}
		var location_chart_data = {
			datasets: [{
				data: location_chart_dataset,
				backgroundColor: backgroundColor
			}],
			labels: location_chart_labels
		};
		var location_chart = new Chart(location_ctx,{
			type: 'pie',
			data: location_chart_data,
			options: options
		});

		// Task Chart Data
		var task_chart_dataset = [];
		var task_chart_labels = [];
		for (var i = 0; i < task_chart_metrics.length; i++) {
			task_chart_metric = task_chart_metrics[i];
			task_chart_dataset.push(task_chart_metric.value);
			task_chart_labels.push(task_chart_metric.name);
		}
		var task_chart_data = {
			datasets: [{
				data: task_chart_dataset,
				backgroundColor: backgroundColor
			}],
			labels: task_chart_labels
		};
		var task_chart = new Chart(task_ctx,{
			type: 'pie',
			data: task_chart_data,
			options: options
		});
	
		// Setup Pagination
		setupPagination(".paginate-row",".pagination",1,10)
	
		// Setup CSV data - Volunteers
		var rows = document.querySelectorAll("#report-table tr");
		for (var i = 0; i < rows.length; i++) {
			var row = rows[i];
			var data_items = row.querySelectorAll("td");
			var row_values = "";
			for (var j = 0; j < data_items.length; j++) {
				var data_item = data_items[j];
				if (j !== 0) {
					row_values += ",";
				}
				// Trim values
				row_values += '"' + jQuery.trim(data_item.innerText) + '"';
			}
			table_data += row_values + "\n";
		}
		
		// Setup CSV data - Feedback
		var rows = document.querySelectorAll("#feedback-table tr");
		for (var i = 0; i < rows.length; i++) {
			var row = rows[i];
			var data_items = row.querySelectorAll("td");
			var row_values = "";
			for (var j = 0; j < data_items.length; j++) {
				var data_item = data_items[j];
				if (j !== 0) {
					row_values += ",";
				}
				// Trim values
				row_values += '"' + jQuery.trim(data_item.innerText) + '"';
			}
			feedback_table_data += row_values + "\n";
		}
	}
});

// CSV Download - Volunteer
var table_data = "Total Hours," +
					"Visit Count," +
					"First Visit," +
					"Last Visit," +
					"Name," +
					"Email";

// CSV Download - Feedback
var feedback_table_data = "Check In," +
							"Email," +
							"Feedback";

// Resets the dashboard
function resetDashboard() {
	document.getElementsByName("task")[0].options[0].selected = "selected";
	document.getElementsByName("location")[0].options[0].selected = "selected";
	document.getElementsByName("endtime")[0].value="";
	document.getElementsByName("starttime")[0].value="";
}

// Get the CSV Data
function getCsv() {
	if (isSafari) {
		var link = document.createElement("a");
		link.id = "csvDwnLink";
		document.body.appendChild(link);
		window.URL = window.URL || window.webkitURL;
		var csv = "\ufeff" + table_data,
			csvData = 'data:attachment/csv;charset=utf-8,' + encodeURIComponent(csv),
			filename = 'dashboard-report.csv';
		$("#csvDwnLink").attr({'download': filename, 'href': csvData});
		$('#csvDwnLink')[0].click();
		document.body.removeChild(link);	
	} else {
		var csvData = new Blob([table_data], {type: 'text/csv;charset=utf-8;'});
		var exportFilename = "dashboard-report.csv";
		// IE11 & Edge
		if (navigator.msSaveBlob) {
			navigator.msSaveBlob(csvData, exportFilename);
		} else {
			// In FF link must be added to DOM to be clicked
			var link = document.createElement('a');
			link.href = window.URL.createObjectURL(csvData);
			link.setAttribute('download', exportFilename);
			document.body.appendChild(link);    
			link.click();
			document.body.removeChild(link);    
		}
	}
}

// Get the CSV Data
function getFeedbackCsv() {
	if (isSafari) {
		var link = document.createElement("a");
		link.id = "feedCsvDwnLink";
		document.body.appendChild(link);
		window.URL = window.URL || window.webkitURL;
		var csv = "\ufeff" + feedback_table_data,
			csvData = 'data:attachment/csv;charset=utf-8,' + encodeURIComponent(csv),
			filename = 'feedback-report.csv';
		$("#feedCsvDwnLink").attr({'download': filename, 'href': csvData});
		$('#feedCsvDwnLink')[0].click();
		document.body.removeChild(link);	
	} else {
		var csvData = new Blob([feedback_table_data], {type: 'text/csv;charset=utf-8;'});
		var exportFilename = "feedback-report.csv";
		// IE11 & Edge
		if (navigator.msSaveBlob) {
			navigator.msSaveBlob(csvData, exportFilename);
		} else {
			// In FF link must be added to DOM to be clicked
			var link = document.createElement('a');
			link.href = window.URL.createObjectURL(csvData);
			link.setAttribute('download', exportFilename);
			document.body.appendChild(link);    
			link.click();
			document.body.removeChild(link);    
		}
	}
}

// Signout all users
function signout() {
	if (window.confirm("Are you sure you want to sign everyone out? 2 hours will be logged for each volunteer.")) {
		window.location.href = "/pages/autosignout.php";
	} else {
		return false;
	}
}