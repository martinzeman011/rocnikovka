<?php

$mysqli = NEW MySQLi('localhost','root','','bass_acad');
$email = $_GET['email'];
$vcode = $_GET['vcode'];

echo"$email <br> $vcode";

if(isset($_GET['email']) && isset($_GET['vcode'])){
//    $query="SELECT * FROM uzivatele WHERE email='$email' AND over_kod='$vcode'";
    $result=$mysqli->query("SELECT * FROM uzivatele WHERE email='$email' AND over_kod='$vcode'");
    if($result){
        if(mysqli_num_rows($result)==1){
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['overeni']==0){
                $update=$mysqli->query("UPDATE uzivatele SET overeni='1' WHERE email='$email'");
                if($update){
                    echo"
                        <script>
                        alert('Email byl úspěšně ověřen');
                        window.location.href='http://localhost/bass_acad/login.php?email=$email&vcode=$vcode';
                        </script>
                        ";
                }
            }else{
                echo"
                    <script>
                    alert('Email je již ověřený');
                    window.location.href='index.php';
                    </script>
                    ";
            }
        }
    }
    else{
        echo"
        <script>
        alert('Nejde spustit query');
        window.location.href='index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Bass Academy</title>

    
</head>
<body>
</body>
</html>