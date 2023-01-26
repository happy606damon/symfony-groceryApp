require('bootstrap-datepicker/js/bootstrap-datepicker.js');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
    });
});