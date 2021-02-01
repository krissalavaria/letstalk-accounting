
$(document).ready(function() {
    employee();

    orderlist();
    orderlistproduct();
});

var employee = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'dashboard/employee',
        load_on: '#employee'
    });
}



var orderlist = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const token = urlParams.get('token')

    $.ajax({
        url: baseUrl + 'dashboard/orderlist',
        type: "POST",
        data: {
            token : token
        },
    }).always(function(e) {
        $('#order-list').html(e);
    });
}

var orderlistproduct = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const orderno = urlParams.get('no')

    $.ajax({
        url: baseUrl + 'dashboard/orderlistproduct',
        type: "POST",
        data: {
            orderno : orderno
        },
    }).always(function(e) {
        $('#order-list-product').html(e);
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