<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$error = NULL;


if(isset($_POST['submit'])){
    //Získat data z formu
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];

    //Připojení do databáze
    $mysqli = NEW MySQLi('localhost','root','','bass_acad');

    //Ověření dat
    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);
    $password2 = $mysqli->real_escape_string($password2);
    $email = $mysqli->real_escape_string($email);

    //Kontrola, zda už není uživatelské jméno v databázi
    $select_username = $mysqli->query("SELECT * FROM uzivatele WHERE uziv_jmeno='$username'");

    if(strlen($username) < 5){
        $error = "<p>Vaše uživatelské jméno musí obsahovat aspoň 5 znaků</p>";
    }elseif($password != $password2){
        $error = "<p>Vaše hesla nejsou stejná</p>";
    }elseif(strlen($password) < 8){
        $error = "<p>Vaše heslo musí obsahovat aspoň 8 znaků</p>";
    }elseif($select_username){
        $error = "<p>Vaše uživatelské jméno už někdo používá :)</p>";
    }else{
        //Form je platný

        //Generovani ověřovacího kódu
        $vcode = md5(time().$username);

        //Přidání účtu do databáze
        $password = sha1($password);
        $insert = $mysqli->query("INSERT INTO uzivatele(uziv_jmeno, heslo, email, over_kod)
        VALUES('$username', '$password', '$email', '$vcode')");

        if($insert){
            //Poslání ověřovacího kódu na mail
          
          $mail = new PHPMailer(true);
          
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'martinzeman011@gmail.com';
          $mail->Password = 'lzylngdepbxbolom';
          $mail->SMTPSecure = 'ssl';
          $mail->Port = 465;

          $mail->setFrom('martinzeman011@gmail.com');

          $mail->addAddress($email);

          $mail->isHTML(true);

          $mail->Subject = "Bass Academy - Overeni Emailu";
          $mail->Body = "Dobrý den, váš email byl zaregistrován, pro dokončení registrace klikněte <a href='http://localhost/bass_acad/verification.php?email=$email&vcode=$vcode'>
          ZDE</a>";

          $mail->send();

           header('location:emailauth.php');
        }else{
            echo $mysqli->error;
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
                <td align="right">Uživatelské jméno:</td>
                <td><input type="text" name="username" required/></td>
            </tr>
            <tr>
                <td align="right">Heslo:</td>
                <td><input type="password" name="password" required/></td>
            </tr>
            <tr>
                <td align="right">Heslo znovu:</td>
                <td><input type="password" name="password2" required/></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="text" name="email" required/></td>
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