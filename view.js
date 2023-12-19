function redirectTo(url) {
    window.location.href = url;
  }

  function downloadCSV() {
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Emp ID,First Name,Last Name,Middle Name,Address,Email,Phone,Work Status,Birthday\n";

    // Extract data from the displayed table
    var table = document.querySelector('.table');
    var rows = table.querySelectorAll('tbody tr');

    rows.forEach(function (row) {
        var columns = row.querySelectorAll('td:not(:last-child)'); // Exclude last column (Operations)
        var rowData = Array.from(columns).map(function (column) {
            return column.textContent;
        });
        csvContent += rowData.join(',') + '\n';
    });

    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "employee_data.csv");
    document.body.appendChild(link);

    link.click(); // This will trigger the download
}