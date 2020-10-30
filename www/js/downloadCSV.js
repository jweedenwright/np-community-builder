function downloadCSV(elementId){
    let table = document.getElementById(elementId); 
    let rows = table.rows; 
    let resultArray = []; 
    let rowArray = []; 
    let cellValue; 

    for (let i = 0; i < rows.length; i++ ){
        for (let j = 0; j < rows[i].cells.length; j++){
            cellValue = rows[i].cells[j].textContent
            rowArray.push(cellValue);
        }
        resultArray.push(rowArray);
        rowArray = [] // set it back to initial value. 
    }

    let csvContent = "data:text/csv;charset=utf-8,";

    resultArray.forEach(function(rowArray) {
        let row = rowArray.join(",");
        csvContent += row + "\r\n";
    });

	var encodedUri = encodeURI(csvContent);
	var link = document.createElement("a");
	link.setAttribute("href", encodedUri);
	link.setAttribute("download", "data.csv");
	document.body.appendChild(link); // Required for FF
	link.click(); // This will download the data file named "my_data.csv".
	
}