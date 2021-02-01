
$(document).ready(function() {
    loademplcredit();
    credit_load();

});

var loademplcredit = () => {
    $(document).gmLoadPage({
        url: baseUrl + 'credit/empl_credit',
        load_on: '#loademplcredit'
    });
}

var credit_load = () =>{
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const token = urlParams.get('token')

    $.ajax({
        url: baseUrl + 'credit/orderlist',
        type: "POST",
        data: {
            token : token
        },
    }).always(function(e) {
        $('#credit-order').html(e);
       
    });


}



$(document).on('click', '.clearallcredit', function(){
    if (confirm('Are you sure you want to clear all credits?')) {
        // Save it!
        var auth = $(this).val();
        $(document).gmPostHandler({
            url: 'credit/clearall',
            data: {
                token : auth
            },
            parameter: true,
            function_call: true,
            function: prompt,
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
      } else {
        // Do nothing!
        alert('Sorry, Unable to proceed this action. Please try again!');
      }
})

function prompt(data){
    alert(data.message);
    location.reload();
}