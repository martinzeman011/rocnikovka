<?php
$mysqli = NEW MySQLi('localhost','root','','bass_acad');
$email = $_GET['email'];
$vcode = $_GET['vcode'];

$error = NULL;


if(isset($_POST['submit'])){
    //Získat data z formu
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password != $password2){
        $error = "<p>Vaše hesla nejsou stejná</p>";
    }elseif(strlen($password) < 8){
        $error = "<p>Vaše heslo musí obsahovat aspoň 8 znaků</p>";
    }else{


        //Ověření dat
        $password = $mysqli->real_escape_string($password);
        $password2 = $mysqli->real_escape_string($password2);

        //Přidání nového hesla do databáze
        $password = sha1($password);
        $insert = $mysqli->query("UPDATE uzivatele
                                SET heslo = '$password'
                                 WHERE email = '$email';");

        if($insert){
            echo"
            <script>
            alert('Heslo bylo změněno :)')
            window.location.href='login.php';
            </script>
            ";
        }else{
            echo"
            <script>
            alert('Query nelze spustit')
            window.location.href='index.php';
            </script>
            ";
        }
        
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
    <div>
    <form method="POST" action="">
        <table id="registration" align="center" cellpadding="5">
            <tr>
                <td align="right">Heslo:</td>
                <td><input type="password" name="password" required/></td>
            </tr>
            <tr>
                <td align="right">Heslo znovu:</td>
                <td><input type="password" name="password2" required/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="Zaregistrovat se" required/></td>
            </tr>
        </table>
    </form>
</div>
<center>
<?php
echo $error;
?>
</center>

</body>
</html>