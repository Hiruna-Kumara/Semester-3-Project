<?php 
include 'Classes/User.php';
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kuliyata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
<?php
    $user = new User();
    //echo $user->username;
    //echo $user->password;
    //echo $user->username;
    echo "<br>". $user-> getUsername();
    ?>


</body>
</html>