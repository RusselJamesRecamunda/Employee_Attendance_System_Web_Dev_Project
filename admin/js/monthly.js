$(document).ready(function () {
    // Initialize datepicker
    $('#monthly_atdnc').datepicker({
      format: 'mm - yyyy', // Specify your desired date format
      autoclose: true,
      startView: 'months', // Set the start view to show only months
      minViewMode: 'months' // Set the minimum view mode to show only months
    });
  });

  function redirectTo(url) {
    window.location.href = url;
  }

  function downloadCSV() {
      var csvContent = "data:text/csv;charset=utf-8,";
      csvContent += "Emp ID,Employee Name,AM In,AM Out,PM In,PM Out,Month Date,Work Status\n";

      // Extract data from the displayed table
      var table = document.querySelector('.table');
      var rows = table.querySelectorAll('tbody tr');

      rows.forEach(function(row) {
          var columns = row.querySelectorAll('td');
          var rowData = Array.from(columns).map(function(column) {
              return column.textContent;
          });
          csvContent += rowData.join(',') + '\n';
      });

      var encodedUri = encodeURI(csvContent);
      var link = document.createElement("a");
      link.setAttribute("href", encodedUri);
      link.setAttribute("download", "monthly_attendance.csv");
      document.body.appendChild(link);

      link.click(); // This will trigger the download
  }