<?php
include_once 'DBConnector.php';
include_once 'user.php';
include_once 'fileUploader.php';
$db = new DBConnector();

if (isset($_POST['btn-save'])) {    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city_name'];
    $uname = $_POST['username'];
    $pass = $_POST['password'];

    $utc_timestamp = $_POST['utc_timestamp'];
    $offset = $_POST['time_zone_offset'];

    $user = new User($first_name,$last_name,$city,$uname,$pass,$utc_timestamp,$offset);
    $uploader = new FileUploader();
    if (!$user->valiteForm()) {
        $user->createFormErrorSessions();        
        header("Refresh:0");
        die();
    } else if ($user->isUserExist($db->conn)){
        $user->createFormErrorSessions();
        $_SESSION['form_errors'] = "This username is already taken";
        header("Refresh:0");
        die();
    }

    $res = $user->save($db->conn);

    $file_upload_response = $uploader->uploadFile($_FILES['fileToUpload']);


    if ($res && $file_upload_response) {
        echo "Save operation was successful";
    } else if(!$file_upload_response && empty($_SESSION['form_errors'])){
        $_SESSION['form_errors'] = "File upload was unsuccessful";
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
    <form method="post" name="user_details" id="user_details" enctype="multipart/form-data" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">
        <table align="center">
            <tr>
                <td>
                    <div id="form-errors">
                    <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        if (!empty($_SESSION['form_errors'])) {
                            echo " " . $_SESSION['form_errors'];
                            unset($_SESSION['form_errors']);
                        }
                    ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="first_name" required placeholder="First Name" required></td>
            </tr>
            <tr>
                <td><input type="text" name="last_name" placeholder="Last Name" required></td>
            </tr>
            <tr>
                <td><input type="text" name="city_name" placeholder="City" required></td>
            </tr>
            <tr>
                <td><input type="text" name="username" placeholder="Username" required></td>
            </tr>
            <tr>
                <td><input type="password" name="password" placeholder="Password" required></td>
            </tr>
            <tr>
                <td>Profile image:<input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" required></td>
            </tr>
            <tr>
                <td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
            </tr>
            <input type="hidden" name="utc_timestamp" id="utc_timestamp" value="">
            <input type="hidden" name="time_zone_offset" id="time_zone_offset" value="">
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
            <?php            
                $user = User::create();
                $db_users = $user->readAll($db->conn);
                foreach ($db_users as $db_user) {
            ?>
             <tr>
                    <td><?php echo $db_user[0] ?></td>
                    <td><?php echo $db_user[1] ?></td>
                    <td><?php echo $db_user[2] ?></td>
             </tr>
            <?php
                }
                $db->closeDatabase();
            ?>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./timezone.js" type="text/javascript"></script>
</body>
</html>