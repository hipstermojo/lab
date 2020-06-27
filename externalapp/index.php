<?php

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="./placeorder.js" text="text/javascript"></script>
    <title>Title goes here</title>
</head>
<body>
    <h3>It is time to communicate with the exposed API, all we need is the API key to be passed in the header</h3>
        <hr>
    <h4>1. Feature 1 - Placing an order</h4>
    <hr>
    <form name="order_form" id="order_form" method="">
        <fieldset>
            <legend>Place order</legend>
            <input type="text" name="name_of_food" id="name_of_food" placeholder="name of food">
            <br>
            <input type="number" name="number_of_units" id="number_of_units" placeholder="number of units">
            <br>
            <input type="number" name="unit_price" id="unit_price" placeholder="unit price" max="9" required>
            <br><br>
            <input type="hidden" name="status" id="status" placeholder="unit price" value="order placed" required> <br><br>

            <button class="btn btn-primary" type="submit" id="btn-place-order">Place order >></button>
        </fieldset>
    </form>

    <hr>
    <h4>Feature 2 - Checking order status</h4>
    <hr>
    <form action="" name="order_status_form" id="order_status_form" method="post">
        <fieldset>
            <legend>check order status</legend>
            <input type="number" name="order_id" id="order_id" placeholder="order ID" required><br><br>

            <button class="btn btn-warning" type="submit" id="btn-check-order">Check order status</button>
        </fieldset>
    </form>
</body>
</html>