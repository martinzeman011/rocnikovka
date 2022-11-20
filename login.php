<?php

$error = NULL;


if(isset($_GET['submit'])){
    
        //Získat data z formu
        $username = $_GET['username'];
        $password = $_GET['password'];

        //Připojení do databáze
        $mysqli = NEW MySQLi('localhost','root','','bass_acad');

        //Ověření dat
        $username = $mysqli->real_escape_string($username);
        $password = $mysqli->real_escape_string($password);

        //Ověření účtu z databáze
        $password = sha1($password);
        $select = $mysqli->query("SELECT * FROM uzivatele WHERE uziv_jmeno='$username' AND heslo='$password'");
        if($select){
            echo"
            <script>
            alert('Úspěšně přihlášeno')
            window.location.href='http://localhost/bass_acad/index.php?username=$username';
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
    <form method="GET" action="">
        <table id="registration" align="center" cellpadding="5">
            <tr>
                <td align="right">Uživatelské jméno:</td>
                <td><input type="text" name="username" required/></td>
            </tr>
            <tr>
                <td align="right">Heslo:</td>
                <td><input type="password" name="password" required/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="Přihlásit se" required/></td>
            </tr>
            <tr>
            <td  align="right"><a href="forgotpasswd.php"><p>Zapomněl jsem heslo</p></a></td>   
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