require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
require('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
$(document).ready(function() {
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        orientation: "bottom left",
        todayHighlight: true
    });
});