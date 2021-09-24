<?php
$kuldott = ($_POST["kuldott"] ?? "0") === "1";
$username = $_POST["username"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";
$password2 = $_POST["password2"] ?? "";
$mindenRendben = false;
$userHiba = false;
$emailHiba = false;
$jelszoHiba = false;
$jelszoHiba2 = false;
$userHibaUzenet = '';
$emailHibaUzenet = '';
$jelszoHibaUzenet = '';
$jelszoHibaUzenet2 = '';
if ($kuldott){
    if (mb_strlen($username) < 3){
        $userHibaUzenet = "A felhasználónév minimum 3 karakter hosszúnak kell lennie!";
        $userHiba = true;
    }
    if(!strcasecmp($username,"admin")){
        $userHibaUzenet .= ($userHiba?"<br>":"")."A felhasználónév tiltott!";
        $userHiba = true;
    }
    if (mb_strpos($email,"@") === false){
        $emailHibaUzenet = "Az e-mail '@' nélkül érvénytelen!";
        $emailHiba = true;
    }
    if(mb_strpos($email,".") === false){
        $emailHibaUzenet .= ($emailHiba?"<br>":"")."Az e-mail '.' nélkül érvénytelen!";
        $emailHiba = true;
    }
    $jelszoHiba = mb_strlen($password) <8;
    if($jelszoHiba)
    {
        $jelszoHibaUzenet = "A jelszónak minimum 8 karakter hosszúnak kell lennie!";
    }
    $jelszoHiba2 = $password === $password2;
    if($jelszoHiba2)
    {
        $jelszoHibaUzenet2 = "A két jelszó nem egyezik";
    }
    $mindenRendben = !($userHiba || $emailHiba || $jelszoHiba || $jelszoHiba2);
}
function ki($mit)
{
    return htmlspecialchars($mit,ENT_QUOTES);
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Regisztráció</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
</head>
<body>
    <form method="POST">
        <div>
            <label>
                Usernév:<br>
                <input type='text' name='username' value='<?php echo ki($username)?>'>
            </label>
            <div class='errormessage'><?php echo $userHiba?$userHibaUzenet:""; ?></div>
        </div>
        <div>
            <label>
                Email cím:<br>
                <!--email típus--><input type='text' name='email' value='<?php echo ki($email)?>'>
            </label>
            <div class='errormessage'><?php echo $emailHiba?$emailHibaUzenet:""; ?></div>
        </div>
        <div>
            <label>
                Jelszó:<br>
                <input type='password' name='password' value='<?php echo ki($password)?>'>
            </label>
            <div class='errormessage'><?php echo $jelszoHiba?$jelszoHibaUzenet:""; ?></div>
        </div>
        <div>
            <label>
                Jelszó még egyszer:<br>
                <input type='password' name='password2' value='<?php echo ki($password2)?>'>
            <div class='errormessage'><?php echo $jelszoHiba?$jelszoHibaUzenet2:""; ?></div>
            </label>
        </div>
        <div>
            <input type='submit' value='Regisztráció'>
            <input name="kuldott" value="1" hidden>
        </div>
    </form>
    <p class='success' <?php echo($kuldott && $mindenRendben)?"":"hidden";?>>Sikeres regisztráció!</p>
</body>
</html>
