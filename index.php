<?php
error_reporting(E_ALL);
include 'include/database.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>ITG-LAN Västerås</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- START Susnet BESÖKSREGISTRERINGSKOD -->
<script type="text/javascript" src="http://susnet.se/susnetstat.js">
</script>
<script type="text/javascript">
susnet_counter_id = 160565;
susnet_security_code = '1399a8';
susnet_node=0;
register();
</script>
<!-- SLUT Susnet BESÖKSREGISTRERINGSKOD -->


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'custom'
 };
 </script>
<?php
$db = new mysqli('mysql507.loopia.se', 'lolas142@i116580', '1qa2ws3ed', 'itg_lan_se') OR die("Kunde inte ansluta till databasen");
//Variabler för kontakt
$namnErr = $emailErr = $klassErr = $reglerErr = $secureErr = $skolaKlassErr = $fickredaErr = "";
$namn = $email = $regler = $skolaKlass = "";

$klass1 = "selected";
$klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
$klassMeddelande = "";

$fickreda1 = "";
$fickreda2 = $fickreda3 = $fickreda4 = "";
$fickredaMeddelande = "";

$korrektNummer = "0";
  if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $namn = test_input($_POST["namn"]);
      $namn = $db->real_escape_string($namn);

      $email = test_input($_POST["email"]);
      $email = $db->real_escape_string($email);

      $annat = test_input($_POST["annat"]);
      $annat = $db->real_escape_string($annat);

      $fickreda = test_input($_POST["fickreda"]);
      $fickreda = $db->real_escape_string($fickreda);

      $regler = test_input($_POST["regler"]);
      $regler = $db->real_escape_string($regler);

      if (empty($namn))
      {$namnErr = "Ett namn krävs";}
      else
      {
        if (!preg_match("/^[a-zsA-ZåÅäÄöÖéè ]*$/i",$namn))
        {
          $namnErr = "Bara mellanslag och Svenska bokstäver är tillåtna!";
        }
        else
        {
          if(strlen($namn) > 25)
          {
            $namnErr = "Ditt namn är för långt";
          }
          else
          {
            $korrektNummer++;
          }
        }
      }

      if (empty($email))
      {$emailErr = "En email krävs";}
      else
      {
          if (strlen($email) > 50)
          {
              $emailErr = "För lång email, max 50 tecken";
          }
          else
          {
              if(preg_match("/^\b[ÅÄÖåäöA-Z0-9._%+-]+@[A-ZÅÄÖåäö0-9.-]+\.[A-ZÅÄÖåäö]{1,6}\b$/iu", $email))
              {
                  $korrektNummer++;
              }
              else
              {
                  $emailErr = "Felaktig mailaddress";
              }
          }
      }

      if ($_POST["klass"] == "")
      {
        $klassErr = "Du måste välja en klass";

        $klass1 = "selected";
        $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
      }
      else
      {
        if (strlen($_POST["klass"]) > 5)
        {
          $klassErr = "För långt klassnamn... (」ﾟﾛﾟ)｣";
        }
        else
        {
          if ($_POST["klass"] == "0")
          {
            $klassMeddelande = "12A";
            $korrektNummer++;

            $klass2 = "selected";
            $klass1 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "1")
          {
            $klassMeddelande = "12B";
            $korrektNummer++;

            $klass3 = "selected";
            $klass2 = $klass1 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "2")
          {
            $klassMeddelande = "12D";
            $korrektNummer++;

            $klass4 = "selected";
            $klass2 = $klass3 = $klass1 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "3")
          {
            $klassMeddelande = "13A";
            $korrektNummer++;

            $klass5 = "selected";
            $klass2 = $klass3 = $klass4 = $klass1 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "4")
          {
            $klassMeddelande = "13B";
            $korrektNummer++;

            $klass6 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass1 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "5")
          {
            $klassMeddelande = "13C";
            $korrektNummer++;

            $klass7 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass1 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "6")
          {
            $klassMeddelande = "14A";
            $korrektNummer++;

            $klass8 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass1 = $klass9 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "7")
          {
            $klassMeddelande = "14B";
            $korrektNummer++;

            $klass9 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass1 = $klass10 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "8")
          {
            $klassMeddelande = "14C";
            $korrektNummer++;

            $klass10 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass1 = $klass11 = "";
          }
          elseif ($_POST["klass"] == "9")
          {
            $klassMeddelande = "Annat";
            $korrektNummer++;

            $klass11 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass1 = "";
          }
          else
          {
            $klass1 = "selected";
            $klass2 = $klass3 = $klass4 = $klass5 = $klass6 = $klass7 = $klass8 = $klass9 = $klass10 = $klass11 = "";
          }
        }
      }

      if (empty($annat) && $klassMeddelande == "Annat")
      {$skolaKlassErr = "En skola och klass krävs";}
      else
      {
        if ($klassMeddelande == "Annat")
        {
          if (strlen($annat) > 50)
          {
            $skolaKlassErr = "För lång text, max 50 tecken";
          }
          else
          {
            if (preg_match("/^[a-zsA-ZåÅäÄöÖ0-9 ]*$/",$annat))
            {
              $skolaKlass = $annat;
              $korrektNummer++;
            }
            else
            {
              $skolaKlass = $annat;
              $skolaKlassErr = "Felaktigt format på text";
            }
          }
        }
        else
        {
          $skolaKlass = "-";
        }
      }

      if ($_POST["fickreda"] == "")
      {
        $fickredaErr = "Du måste välja ett alternativ";

        $fickreda1 = "";
        $fickreda2 = $fickreda3 = $fickreda4 = "";
      }
      else
      {
        if ($klassMeddelande == "Annat")
        {
          if (strlen($_POST["fickreda"]) > 5)
          {
            $fickredaErr = "För långt namn på valt alternativ... (」ﾟﾛﾟ)｣";
          }
          else
          {
            if ($_POST["fickreda"] == "0")
            {
              $fickredaMeddelande = "En kompis berättade";
              $korrektNummer++;

              $fickreda1 = "checked";
              $fickreda2 = $fickreda3 = $fickreda4 = "";
            }
            elseif ($_POST["fickreda"] == "1")
            {
              $fickredaMeddelande = "Hittade er på FB";
              $korrektNummer++;

              $fickreda2 = "checked";
              $fickreda1 = $fickreda3 = $fickreda4 = "";
            }
            elseif ($_POST["fickreda"] == "2")
            {
              $fickredaMeddelande = "Walter tvingade mig";
              $korrektNummer++;

              $fickreda3 = "checked";
              $fickreda2 = $fickreda1 = $fickreda4 = "";
            }
            elseif ($_POST["fickreda"] == "3")
            {
              $fickredaMeddelande = "Såg er affisch";
              $korrektNummer++;

              $fickreda4 = "checked";
              $fickreda2 = $fickreda3 = $fickreda1 = "";
            }
            else
            {
              $fickredaErr = "Felaktigt alternativ";
              $fickreda1 = "";
              $fickreda2 = $fickreda3 = $fickreda4 = "";
            }
          }
        }
        else
        {
          $fickreda1 = "";
          $fickreda2 = $fickreda3 = $fickreda4 = "";

          $fickredaMeddelande = "-";
        }
      }

    require_once('include/recaptchalib.php');
    $privatekey = "6LfxEPsSAAAAAE0O5MBMM9ofOrcjI2Ej9WlXX0yZ";
    $resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

    if (!$resp->is_valid)
    {
      $secureErr = "reCAPTCHA felaktigt ifylld";
    }
    else
    {
      $korrektNummer++;
    }

    if (empty($regler))
    {$reglerErr = "Du måste acceptera reglerna  (╯°□°）╯︵ ┻━┻";}
    else
    {
      if(strtolower($regler) == "ja")
      {
        $korrektNummer++;
      }
      else
      {
        $reglerErr = "Du måste acceptera reglerna";
      }
    }

    if($korrektNummer == "5" && $klassMeddelande != "Annat")
    {
      $db->query("SET NAMES 'UTF8' ");
      $db->query("INSERT INTO anmalningar (namn, email, klass, klassmeddelande, fickreda) VALUES ('$namn','$email','$klassMeddelande', '-', '-')");
      echo "<meta http-equiv='refresh' content='0;url=done.php'>";
    }
    elseif ($korrektNummer == "7" && $klassMeddelande == "Annat")
    {
      $db->query("SET NAMES 'UTF8' ");
      $db->query("INSERT INTO anmalningar (namn, email, klass, klassmeddelande, fickreda) VALUES ('$namn','$email','$klassMeddelande', '$skolaKlass', '$fickredaMeddelande')");
      echo "<meta http-equiv='refresh' content='0;url=done.php'>";
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }?>
  <nav class="container navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid ">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">ITG-LAN</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Hem</a></li>
          <li><a href="perrent.php">För föräldrar</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Event<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="events.php">Tävlingar</a></li>
              <li><a href="brackets.php">Brackets</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="">Antal unika besökare:</a></li>
            <li>
              <!-- START Susnet KOD som skriver ut TOTALT ANTAL BESÖKARE -->
              <script type="text/javascript" src="http://susnet.se/susnetstat.js">
              </script>
              <script type="text/javascript">
              susnet_counter_id = 160565;
              susnet_security_code = '1399a8';
              susnet_node=0;
              getTotalUniqueVisitors();
              </script>
              <!-- SLUT Susnet KOD som skriver ut TOTALT ANTAL BESÖKARE -->
            </li>
            <li><a href="admin/"></a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <br>
  <div id="content" class="pad-section">
    <div class="container">
      <div class="row">
        <div id="egenpanel" class="col-xs-12 col-sm-12 col-md-12">
          <div class="panel">
            <div class="panel-body">
              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8">
                <h1 class="itg">ITG-LAN Västerås</h1>
                <p>Det här är anmälningssidan för IT-Gymnasiet Västerås LAN den 28/10 kl 18:00 - 30/10 kl 12:00. LAN:et är öppet för alla som går på skolan och är sugna på LAN.
                Vi kommer att ta ut en depositionsavgift på 50 kr (inte mer eller mindre!) som återbetalas när du lämnar LAN:et med en städad plats.
                </p>
                <p>För att vi ska kunna genomföra ett LAN måste alla deltagare vara införstådda i reglerna:
                  <ul>
                    <li>Ta med egen dator och kablar.</li>
                    <li>LAN:et är 100% alkohol- och drogfritt.</li>
                    <li>Bara personer som anmält sig får komma in.</li>
                    <li>Ingen illegal aktivitet får föregå i eller utanför lokalerna (gäller även illegal nedladdning).</li>
                    <li>Depositionsavgiften får du endast tillbaka om du lämnar din plats ren och städad.</li>
                    <li>Allt som lämnas kvar på LANet i form av drickor, pengar eller annan mat kommer gå till LAN crew.</li>
                    <li>Inga dörrar får lämnas öppna då Securitas bevakar området och kostnad kommer debiteras.</li>
                    <li>Tag med ethernet kabel och grenuttag då vi inte har så det räcker till alla.</li>
                    <li>Att sitta vid andras datorer är inte tillåtet utan tillåtelse från datorns ägare.</li>
                    <li>Stöld är inte tillåtet i någon form, litet som smått, detta är olagligt och kommer vid allvarligare incidenter att polisanmälas.</li>

                  </ul>
                  Om du skulle bryta mot dessa regler så har personal och annan crew rätt att vidta lämpliga åtgärder såsom t.ex. stänga av ditt nätverk eller avvisa dig från lokalen.
                </p>
                <div id="viktigt">
                  <div id="viktigt-text">
                    Vi vill passa på att förklara för alla att denna sidan genomgår uppbyggnad just nu. Detta innebär att det kommer ske ändringar i text, bilder och så vidare. Dock kommer er anmälan till LAN:et inte att försvinna. <br>
                    Tack för att ni förstår. /LAN Crew
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 text-center">
                <div class="fb-like-box" data-href="https://www.facebook.com/ITGLANCrew" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="true"></div>
              </div>
            </div>
          </div>

          <div class="panel">
            <div class="panel-body">
              <div>
                <form class="anmalning" id="anmalning-personer" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <fieldset>
                    <p id="obligator">*Obligatorisk</p>

                    <div class="form-group">
                      <label class="itg" >Namn (för och efternamn)   *</label>
                      <input class="form-control" type="text" name="namn" maxlength="25" value="<?php echo $namn; ?>" placeholder="Ex. Kurt Kurtsson"><span class="error"><?php echo $namnErr;?></span>
                    </div>

                    <div class="form-group">
                      <label class="itg" >Email   *</label>
                      <input class="form-control" type="text" name="email" maxlength="50" value="<?php echo $email; ?>" placeholder="Ex. namn@sida.se"><span class="error"><?php echo $emailErr;?></span>
                    </div>

                    <div class="form-group">
                      <label class="itg">Klass   *</label>
                      <select class="form-control" id="klass" onchange="kollaKlassValue()" name="klass">
                        <option disabled <?php echo $klass1; ?> value="">Välj ett alternativ</option>
                        <option <?php echo $klass2; ?> value="0">12A</option>
                        <option <?php echo $klass3; ?> value="1">12B</option>
                        <option <?php echo $klass4; ?> value="2">12D</option>
                        <option <?php echo $klass5; ?> value="3">13A</option>
                        <option <?php echo $klass6; ?> value="4">13B</option>
                        <option <?php echo $klass7; ?> value="5">13C</option>
                        <option <?php echo $klass8; ?> value="6">14A</option>
                        <option <?php echo $klass9; ?> value="7">14B</option>
                        <option <?php echo $klass10; ?> value="8">14C</option>
                        <option <?php echo $klass11; ?> value="9">Annat</option>
                      </select>
                      <span class="error"><?php echo $klassErr;?></span>
                    </div>

                    <div id="annat">
                      <div class="form-group">
                        <label class="itg">vilken skola och klass går du i?   *</label>
                        <textarea class="form-control" name="annat" rows="6" maxlength="50" placeholder="Max antal tecken: 50"><?php echo $skolaKlass; ?></textarea>
                        <span class="error"><?php echo $skolaKlassErr; ?></span>
                      </div>

                      <div class="form-group">
                        <label class="itg">Hur fick du reda på ITG-LAN?   *</label>
                        <input <?php echo $fickreda1; ?> type="radio" name="fickreda" value="0">En kompis berättade</input><br>
                        <input <?php echo $fickreda2; ?> type="radio" name="fickreda" value="1">Hittade er på FB</input><br>
                        <input <?php echo $fickreda3; ?> type="radio" name="fickreda" value="2">Walter tvingade mig</input><br>
                        <input <?php echo $fickreda4; ?> type="radio" name="fickreda" value="3">Såg er affisch</input><br>
                        <span class="error"><?php echo $fickredaErr; ?></span>
                      </div>
                    </div>

                    <?php
                    require_once('include/recaptchalib.php');
                    $publickey = "6LfxEPsSAAAAAEvO7J0-jKn1ulayB2Lo4wr31NqE";
                    echo recaptcha_get_html($publickey);
                    ?>
                    <div id="recaptcha_image"></div>
                    <span class="recaptcha_only_if_image vitmesvart">Skriv in de tecken du ser ovan:</span><br>
                    <span class="recaptcha_only_if_audio vitmesvart">Skriv in de nummer du hör:</span><br>
                    <input class="form-control" type="text" placeholder="reCaptcha" id="recaptcha_response_field" name="recaptcha_response_field">
                    <div><a class="vitmesvart" href="javascript:Recaptcha.reload()">Få en ny CAPTCHA</a></div>
                    <div class="recaptcha_only_if_image"><a class="vitmesvart" href="javascript:Recaptcha.switch_type('audio')">Få en ljud CAPTCHA</a></div>
                    <div class="recaptcha_only_if_audio"><a class="vitmesvart" href="javascript:Recaptcha.switch_type('image')">Få en bild CAPTCHA</a></div>
                    <div><a class="vitmesvart" href="javascript:Recaptcha.showhelp()">Hjälp</a></div>
                    <span class="error"><?php echo $secureErr;?></span><br><br>

                    <label class="itg">Jag har läst och accepterar reglerna   *</label><br>
                    <input type="radio" name="regler" value="ja">Ja<br>
                    <input type="radio" checked name="regler" value="nej">Nej<br>
                    <span class="error"><?php echo $reglerErr;?></span><br><br>

                    <button class="btn btn-default" type="submit" value="Skicka">Skicka</button><br>
                  </fieldset>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript">
  function kollaKlassValue()
  {
      var select = document.getElementById("klass");
      var selected = select.options[select.selectedIndex].value;

      if(selected == "9")
      {
          $('#annat').fadeIn();
      }
      else
      {
          $('#annat').fadeOut();
      }
  }
  $(document).ready(function(){
      kollaKlassValue();
  });
  </script>

</body>
</html>
