<?php

error_reporting(E_ALL);
include '../include/database.php'; //Inkludera så att vi kan ansluta till databasen
include '../include/functions.php';
sec_session_start();
include '../include/csrf.php';

$csrf = new csrf();

// Generate Token Id and Value
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

// Generate Random Form Names
$form_names = $csrf->form_names(array('username', 'password'), false);

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    sec_session_start(); // Our custom secure way of starting a PHP session.

    if(isset($_POST[$form_names['username']], $_POST[$form_names['password']]))
    {
        // Check if token id and token value are valid.
        if($csrf->check_valid('post'))
        {
            // Get the Form Variables.
            $username = $_POST[$form_names['username']];
            $password = $_POST[$form_names['password']];

            if(isset($_POST[$form_names['username']], $_POST[$form_names['password']]))
            {
                $username = $_POST[$form_names['username']];
                $password = $_POST[$form_names['password']]; // The hashed password.

                if(isset($_SESSION['brute']))
                {
                    if($_SESSION['brute'] == "captcha")
                    {
                        require_once('../include/recaptchalib.php');
                        $privatekey = "6LfxEPsSAAAAAE0O5MBMM9ofOrcjI2Ej9WlXX0yZ";
                        $resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
                        if ($resp->is_valid) //Eftersom det kan vara brute så kollar vi recaptchan, är den ok så kollar vi resten
                        {
                            if (login($username, $password, $db, true) == true)
                            {
                                // Login success
                                header('Location: adminpanel.php');
                            }
                            else
                            {
                                // Login failed
                                header('Location: index.php?error=brute');
                            }
                        }
                        else
                        {
                            // Login failed
                            header('Location: index.php?error=brute');
                        }
                    }
                    else
                    {
                        if (login($username, $password, $db) == true)
                        {
                            // Login success
                            header('Location: adminpanel.php');
                        }
                        else
                        {
                            // Login failed
                            header('Location: index.php?error=brute');
                        }
                    }

                }
                else
                {
                    if (login($username, $password, $db) == false)
                    {
                        // Login success
                        header('Location: adminpanel.php');
                    }
                    else
                    {
                        if (isset($_SESSION['brute']))
                        {
                            header('Location: index.php?error=brute');
                        }
                        else
                        {
                            // Login failed
                            header('Location: index.php?error=Felaktiga uppgifter');
                        }
                    }
                }
            }
            else
            {
                // The correct POST variables were not sent to this page.
                header("Location: index.php?error=Felaktig request");
            }
        }
        // Regenerate a new random value for the form.
        $form_names = $csrf->form_names(array('username', 'password'), true);
    }
    else
    {
        // Login failed
        header('Location: index.php?error=Ofyllda fält');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="itg lan">
    <meta name="author" content="itg lan crew">
    <title>Logga in - ITGLAN</title>
    <link rel="stylesheet" href="../css/login.css" media="screen" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
</head>
<body>
    <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'custom'
 };
 </script>
    <div id="login">


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <fieldset class="clearfix">
                <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />

                <p><span class="fontawesome-user"></span>
                <input name="<?= $form_names['username']; ?>" type="text" value="Användarnamn" onBlur="if(this.value == '') this.value = 'Användarnamn'" onFocus="if(this.value == 'Användarnamn') this.value = ' '" required></p>

                <p><span class="fontawesome-lock"></span>
                <input name="<?= $form_names['password']; ?>" type="password"  value="Lösenord" onBlur="if(this.value == '') this.value = 'Lösenord'" onFocus="if(this.value == 'Lösenord') this.value = ''" required></p>

                <?php
                if (isset($_GET['error'])) {
                    if($_GET['error'] == "brute")
                    {
                        if(isset($_SESSION['brute']))
                        {
                            if ($_SESSION['brute'] == "captcha")
                            {
                                require_once('../include/recaptchalib.php');
                                $publickey = "6LfxEPsSAAAAAEvO7J0-jKn1ulayB2Lo4wr31NqE";
                                echo recaptcha_get_html($publickey, null, TRUE);
                                ?>
                                <div id="recaptcha_image"></div>
                                <span class="recaptcha_only_if_image recaptchalank">Skriv de tecken du ser ovan: *</span><br>
                                <span class="recaptcha_only_if_audio recaptchalank">Skriv in nummrena du hör: *</span><br>

                                <p><span class="fontawesome-lock"></span>
                                <input class="form-control" type="text" placeholder="reCaptcha" id="recaptcha_response_field" name="recaptcha_response_field"></p>
                                <div><a class="recaptchalank" href="javascript:Recaptcha.reload()">Få en ny CAPTCHA</a></div>
                                <div class="recaptcha_only_if_image"><a class="recaptchalank" href="javascript:Recaptcha.switch_type('audio')">Få en ljud CAPTCHA</a></div>
                                <div class="recaptcha_only_if_audio"><a class="recaptchalank" href="javascript:Recaptcha.switch_type('image')">Få en bild CAPTCHA</a></div>
                                <div><a class="recaptchalank" href="javascript:Recaptcha.showhelp()">Hjälp</a></div>
                                <span class="error">Bekräfta att du är en människa!</span>
                                <?php
                            } elseif ($_SESSION['brute'] == "locked") {
                                echo '<span class="error">Försök igen om en timme!</span>';
                            }
                        }
                        else
                        {
                            echo '<span class="error">¯\_(ツ)_/¯</span>';
                        }
                    }
                    elseif($_GET['error'] == "afk")
                    {
                        echo '<span class="error">Du har varit inaktiv för länge, logga in igen!</span>';
                    }
                    elseif($_GET['error'] == "timeout")
                    {
                        echo '<span class="error">Du har överskridit max tillåtna tid för att vara inloggad, logga in igen!</span>';
                    }
                    else
                    {
                        echo '<span class="error">Ett fel uppstod vid inloggning, försök igen!</span>';
                    }
                }
                ?>
                <p><input type="submit" value="Logga in"></p>
                <span class="pls" ><a id="return" href="../index.php">Gå tillbaka till ITG-LAN.se</a></span>

            </fieldset>
        </form>

    </div>

</body>
</html>
