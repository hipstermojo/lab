$(document).ready(function () {
    $('#btn-place-order').click(function (event) {
        event.preventDefault();

        var name_of_food = $("#name_of_food").val();
        var number_of_units = $("#number_of_units").val();
        var unit_price = $("#unit_price").val();
        var order_status = $("#status").val();

        $.ajax({
            url: "http://localhost:8000/api/v1/orders/index.php",
            type: "post",
            data: {
                name_of_food,
                number_of_units,
                unit_price,
                order_status
            },
            headers: {
                'Authorization': "Basic jobqSkKF1lDyVzDlIa3qn5aqzavxg9cFqahkzIxicC8srOakWgwkXaKQi3pDZCSy",

            },
            success: function (data) {
                alert(JSON.parse(data)['message']);
            },
            error: function () {
                alert("An error occurred");
            }
        })
    })

    $('#btn-check-order').click(function (event) {
        event.preventDefault();
        var order_id = $('#order_id').val()
        $.ajax({
            url: "http://localhost:8000/api/v1/orders/index.php",
            type: "post",
            data: {
                order_id,
                check_order: true
            },
            headers: {
                'Authorization': "Basic jobqSkKF1lDyVzDlIa3qn5aqzavxg9cFqahkzIxicC8srOakWgwkXaKQi3pDZCSy",

            },
            success: function (data) {
                alert(JSON.parse(data)['message']);
            },
            error: function () {
                alert("An error occurred");
            }
        })
    })
})