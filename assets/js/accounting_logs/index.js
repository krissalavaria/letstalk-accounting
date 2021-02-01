
$(document).ready(function() {
    employee();
});

var employee = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'accounting_logs/employee',
        load_on: '#employee'
    });
}


$(document).on('click', '.is_active', function(){
    var auth = $(this).data('value');
    var is_active = $(this).is(':checked');

    if(is_active){
        $('#label_is_active_'+auth).text('Available');
    }else{
        $('#label_is_active_'+auth).text('Out of Stock');
    }
    
    $(document).gmPostHandler({
        url: 'menu-mngmt/service/menu-mngmt-service/is_active',
        data: {
            product_auth : auth,
            is_active : $(this).is(':checked')
        },
        parameter: true,
        alert_on_error: false,
        errorsend: true,
        errorsend_function: [{
            function: error_connection,
            msg: "Please check your connection and try again."
        }],
        function_call_on_error: true,
        error_function: [{
            function: error,
            parameter: true,
        }]
    });
})