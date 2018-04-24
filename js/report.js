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
	
		// Setup CSV data
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
	}
});

// CSV Download
var table_data = "data:text/csv;charset=utf-8," +
					"Total Hours," +
					"Visit Count," +
					"First Visit," +
					"Last Visit," +
					"Name," +
					"Email";

// Resets the dashboard
function resetDashboard() {
	document.getElementsByName("task")[0].options[0].selected = "selected";
	document.getElementsByName("location")[0].options[0].selected = "selected";
	document.getElementsByName("endtime")[0].value="";
	document.getElementsByName("starttime")[0].value="";
}

// Get the CSV Data
function getCsv() {
	var encodedUri = encodeURI(table_data);
	window.open(encodedUri);
}