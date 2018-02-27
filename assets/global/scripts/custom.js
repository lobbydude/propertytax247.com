$(document).ready(function () {
    $("input[name=payment_option]").click(function () {
        var myVal = $(this).val();
        if (myVal == 'order') {
           // $("#billing_order_pp").hide();
            $("#billing_order").show();
        } else {
            $("#billing_order").hide();
        //    $("#billing_order_pp").show();
        }
    });

    $(".radio").change(function () {
        var myVal = $(this).val();
        var radio_id=$(this).attr('id');
        alert(myVal + "<br>" + radio_id);
    });

});