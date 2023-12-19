$(document).ready(function () {
    // Initialize datepicker
    $('#log_search').datepicker({
        format: 'dd- mm - yyyy', // Specify your desired date format
        autoclose: true
        });
    });

  // JavaScript function to handle CSV download
  function downloadCSV() {
    var table = document.querySelector('.table');
    var rows = Array.from(table.querySelectorAll('tr'));

    // Create a CSV string
    var csvContent = rows.map(function (row) {
      var columns = Array.from(row.querySelectorAll('td, th'));
      return columns.map(function (column) {
        return column.innerText;
      }).join(',');
    }).join('\n');

    // Create a Blob containing the CSV data
    var blob = new Blob([csvContent], { type: 'text/csv' });

    // Create a link element and trigger the download
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'login_report.csv';
    link.click();
  }

  function redirectTo(url) {
    window.location.href = url;
  }