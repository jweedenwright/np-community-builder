//////////////////////////////////////////
// REPORTING
//////////////////////////////////////////

window.addEventListener("load",function() {
	// Chart logic
	var location_chart_metrics = document.getElementsByClassName("location-chart-metric");
	var task_chart_metrics = document.getElementsByClassName("task-chart-metric");
	var location_ctx = document.getElementById("location-chart");
	var task_ctx = document.getElementById("task-chart");
	var backgroundColor = ["#3498db","#2ecc71","#8e44ad","#f1c40f","#34495e","#f39c12","#e67e22","#e74c3c","#16a085"];
	var options = { legend: { display: true, position: "right" } };

	// Location Chart Data
	var location_chart_dataset = [];
	var location_chart_labels = [];
	for (var i = 0; i < location_chart_metrics.length; i++) {
		location_chart_metric = location_chart_metrics[i];
		location_chart_dataset.push(location_chart_metric.value);
		// location_chart_dataset.push({value: location_chart_metric.value, color:backgroundColor[i], label: location_chart_metric.name, labelColor : 'white', labelFontSize : '16'});
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

	setupPagination(".paginate-row",".pagination",1,10)
});

if (false) {
	window.addEventListener("load",function() {

		// Pagination
		setupPagination("#report-table tbody tr",".pagination",1,10)

		//////////////////////////////////////////
		// Pull together CSV Download variable
		//////////////////////////////////////////
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
				row_values += '"' + jQuery.trim(data_item.innerHTML) + '"';
			}
			table_data += row_values + "\n";
		}

		// Enable the Download Button
		$("#download-csv").removeClass("disabled");
	
		//////////////////////////////////////////
		// Charts
		//////////////////////////////////////////
	
		// Labels - dataset.label
		var location_labels = [],
			program_labels = [];
	
		// Values
		var program_stats = document.getElementsByClassName("program-stat"),
			location_stats = document.getElementsByClassName("location-stat"),
			total_times = document.getElementById("total-times").value,
			total_vols = document.getElementById("total-vols").value,
			total_hours = document.getElementById("total-hours").value,
			vols_color ="rgba(109, 53, 68, 0.7)",
			hours_color = "rgba(242, 155, 25, 0.7)",
			times_color = "rgba(92, 166, 17, 0.7)";
	
		// Set main stats
		document.getElementById("total-vols-display").querySelectorAll("span")[0].textContent = total_vols;
		document.getElementById("total-hours-display").querySelectorAll("span")[0].textContent = total_hours;
		document.getElementById("total-times-display").querySelectorAll("span")[0].textContent = total_times;
	
		// Go through all Program stats and get labels/values
		var program_vols_data = { 
				label:"Total Unique Volunteers",
				backgroundColor: vols_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] },
			program_hours_data = { 
				label:"Total Hours",
				backgroundColor: hours_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] },
			program_times_vol_data = { 
				label:"Total Volunteer Periods",
				backgroundColor: times_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] };
		
		// Setup Program stats
		var current_label = false;
		for (var i = 0; i < program_stats.length; i++) {
			var program_stat = program_stats[i];
			var label = program_stat.dataset.label;
			// first time through, set label or current label is different than label, we need to add it to the labels list
			if (current_label === false || current_label !== label) {
				current_label = label;
				program_labels.push(label);
			}
			// Check IDs for times, hours or vols - assign values
			if (program_stat.id.indexOf("vols") != -1) {
				program_vols_data.data.push(program_stat.value);
			} else if (program_stat.id.indexOf("times") != -1) {
				program_times_vol_data.data.push(program_stat.value);
			} else if (program_stat.id.indexOf("hours") != -1) {
				program_hours_data.data.push(program_stat.value);
			}
		}

		// Create Program Chart
		var prog_ctx = document.getElementById("hour-num-program-chart");
		var program_chart = new Chart(prog_ctx, {
			type: 'bar',
			data: {
				labels: program_labels,
				datasets: [program_vols_data, program_hours_data, program_times_vol_data]
			}
		});
	
		// Go through all Location stats and get labels/values
		var location_vols_data = { 
				label:"Total Unique Volunteers",
				backgroundColor: vols_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] },
			location_hours_data = { 
				label:"Total Hours",
				backgroundColor: hours_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] },
			location_times_vol_data = { 
				label:"Total Volunteer Periods",
				backgroundColor: times_color,
				borderColor: "rgba(222,222,222,.4)",
				data:[] };
		
		// Setup Location stats
		var current_label = "";
		for (var i = 0; i < location_stats.length; i++) {
			var location_stat = location_stats[i];
			var label = location_stat.dataset.label;
			// first time through, set label or current label is different than label, we need to add it to the labels list
			if (current_label === false || current_label !== label) {
				current_label = label;
				location_labels.push(label);
			}
			// Check IDs for times, hours or vols - assign values
			if (location_stat.id.indexOf("vols") != -1) {
				location_vols_data.data.push(location_stat.value);
			} else if (location_stat.id.indexOf("times") != -1) {
				location_times_vol_data.data.push(location_stat.value);
			} else if (location_stat.id.indexOf("hours") != -1) {
				location_hours_data.data.push(location_stat.value);
			}
		}

		// Create Location Chart
		var loc_ctx = document.getElementById("hour-num-location-chart");
		var location_chart = new Chart(loc_ctx, {
			type: 'bar',
			data: {
				labels: location_labels,
				datasets: [location_vols_data, location_hours_data, location_times_vol_data]
			}
		});
	});

	// CSV Download
	var table_data = "data:text/csv;charset=utf-8," +
						"Email," +
						"Name," +
						"Hours," +
						"Volunteer Count," +
						"Skills," +
						"Emergency Phone," +
						"Interests," +
						"Found Out," +
						"Include in Email," +
						"Latest Volunteer Day," +
						"First Volunteer Day";

	// Get the CSV Data
	function get_csv() {
		var encodedUri = encodeURI(table_data);
		window.open(encodedUri);
	}
}