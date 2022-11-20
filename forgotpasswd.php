<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



$error = NULL;

        

            if(isset($_GET['submit'])){
            
            //Získat data z formu
            $email = $_GET['email'];

            //Připojení do databáze
            $mysqli = NEW MySQLi('localhost','root','','bass_acad');

            //Ověření dat
            $email = $mysqli->real_escape_string($email);

            //Ověření emailu zda je v databázi
            $select = $mysqli->query("SELECT * FROM uzivatele WHERE email='$email'");
            
            //Generování nového oveřovacího kódu
            $vcode = md5(time().$email);

            if($select){
             //Poslání nového ověřovacího kódu na mail          
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
            $mail->Body = "Dobrý den, váš email byl zaregistrován, pro dokončení registrace klikněte <a href='http://localhost/bass_acad/passwdreset.php?email=$email&vcode=$vcode'>
            ZDE</a>";

            $mail->send();

            header('location:emailauth.php');
            }else{
                echo $mysqli->error;
                echo "Nejspíš vaše emailová adresa ještě nebyla zaregistrována!";
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
                <td align="right">Email:</td>
                <td><input type="text" name="email" required/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="Přihlásit se" required/></td>
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