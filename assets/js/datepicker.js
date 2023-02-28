require('bootstrap-datepicker/dist/css/bootstrap-datepicker3.standalone.min.css');
require('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
$(document).ready(function() {
    $('.created-form-control').datepicker({
        format: "yyyy-mm-dd",
        //orientation: "bottom left",
        todayHighlight: true
    });
});