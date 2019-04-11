<?php

$user = "root";
$pass = "";
$name = "localhost";
$db = "social";

$con = mysqli_connect($name, $user, $pass, $db);

if (mysqli_connect_errno()) {
    echo "Fail to connect" . mysqli_connect_errorno();
}


$sql = mysqli_query($con, "INSERT INTO test VALUES(NULL, 'Super')");

?>



<html>
<head>
</head>

<body>
heelo    
</body>

</html>
