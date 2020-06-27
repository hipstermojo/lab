<?php

    include_once 'DBConnector.php';
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location:login.php");
    }

    

    function fetchUserApiKey()
    {
        $db = new DBConnector();
        $conn = $db->conn;
        $user_id = $_SESSION["user_id"];
        $res = $conn->query("SELECT api_key FROM api_keys WHERE user_id = $user_id");
        if ($res===FALSE) {
            return "";
        } else {
            $row = $res->fetch_assoc();
            return $row['api_key'];
        }
    }
?>
<html>
    <head>
        <title>Title goes here</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="validate.js" type="text/javascript"></script>


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="apikey.js" type="text/javascript"></script>
    </head>
    <body>
        
        <p align="right"><a href="logout.php">Logout</a></p>
        <hr>
        <h3>Here, we will create an API that will allow Users/Developer to order items from external systems</h3>
        <hr>
        <h4>We now put this feature of allowing users to generate an API key. Click the button to generate the API key</h4>

        <button class="btn btn-primary" id="api-key-btn">Generate API key </button> <br> <br>

        <strong>Your API key:</strong>(Note that if your API key is already in use by already running applications, generating a new key will stop the application from functioning) <br>
        <textarea name="api_key" id="api_key" cols="100" rows="2"><?php echo fetchUserApiKey();?></textarea>
        
        <h3>Service description</h3>
        We have a service/API that allows external applications to order food and also
        pull all order status by using order id. Let's do it.

        <hr>
    </body>
</html>