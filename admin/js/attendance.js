$(document).ready(function () {
    // Initialize datepicker
    $('#daily_atdnc').datepicker({
    format: 'dd - mm - yyyy', // Specify your desired date format
    autoclose: true
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const dropdownContent = document.querySelector('.dropdown-content');
    const selectedAttendanceInput = document.getElementById('selectedAttendance');

    dropdownContent.addEventListener('click', function(e) {
      if (e.target.tagName === 'A') {
        const selectedValue = e.target.getAttribute('data-value');
        document.querySelector('.button').innerText = `${selectedValue} ▼`;
        selectedAttendanceInput.value = selectedValue;
      }
    });
  });