<?php
include_once 'DBConnector.php';
include_once 'user.php';
$db = new DBConnector();

if (isset($_POST['btn-save'])) {    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $uname = $_POST['username'];
    $pass = $_POST['password'];

    $user = new User($first_name,$last_name,$city,$uname,$pass);
    if (!$user->valiteForm()) {
        $user->createFormErrorSessions();        
        header("Refresh:0");
        die();
    } else if (!$user->isUserExist($db->conn)){
        $user->createFormErrorSessions();
        $_SESSION['form_errors'] = "This username is already taken";
        header("Refresh:0");
        die();
    }

    $res = $user->save($db->conn);

    if ($res) {
        echo "Save operation was successful";
    } else {
        echo "An error occured!";
    }
    
}
?>
<html>
<head>
    <title>Sample Document</title>
    <script type="text/javascript" src="validate.js"></script>
    <link rel="stylesheet" type="text/css" href="validate.css">
</head>
<body>
    <form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?$_SERVER['PHP_SELF']?>">
        <table align="center">
            <tr>
                <td>
                    <div id="form-errors">
                    <?php
                        session_start();
                        if (!empty($_SESSION['form_errors'])) {
                            echo " " . $_SESSION['form_errors'];
                            unset($_SESSION['form_errors']);
                        }
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="first_name" required placeholder="First Name"></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name"></td>
            </tr>
            <tr>
                <td><input type="text" name="city_name" placeholder="City"></td>
            </tr>
            <tr>
                <td><input type="text" name="username" placeholder="Username"></td>
            </tr>
            <tr>
                <td><input type="password" name="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
            <tr>
                <td><a href="login.php">Login</a></td>
            </tr>
        </table>
    </form>
    <div>
        <h1>Saved Users</h1>
        <table>
            <thead>
                <td>First Name</td>
                <td>Last Name</td>
                <td>City</td>
            </thead>
            <?

                $user = new User("","","","","");
                $db_users = $user->readAll($db->conn);
                foreach ($db_users as $db_user) {
            ?>
             <tr>
                    <td><?echo $db_user[0]?></td>
                    <td><?echo $db_user[1]?></td>
                    <td><?echo $db_user[2]?></td>
             </tr>   
            <?
                }
                $db->closeDatabase();
            ?>
        </table>
    </div>
</body>
</html>