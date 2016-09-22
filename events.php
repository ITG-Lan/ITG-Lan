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

<?php
error_reporting(E_ALL);
$db = new mysqli('mysql507.loopia.se', 'lolas142@i116580', '1qa2ws3ed', 'itg_lan_se') OR die("Kunde inte ansluta till databasen");
//Variabler för kontakt
$namnErr = $captainnameErr = $reglerErr = "";
$namn    = $captainname    = $regler    = "";

$korrektNummer = "0";
  if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $namn = test_input($_POST["namn"]);
      $namn = $db->real_escape_string($namn);

      $captainname = htmlspecialchars($_POST["captainname"]);


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
          if(strlen($namn) > 70)
          {
            $namnErr = "Ditt namn är för långt";
          }
          else
          {
            $korrektNummer++;
          }
        }
      }

      if (empty($captainname))
      {$captainnameErr = "Ett lagkaptensnamn krävs";}
      else
      {
          if (strlen($captainname) > 80)
          {
              $captainnameErr = "För långt lagkaptensnamn, max 80 tecken";
          }
          else
          {
              if(preg_match("/^[a-zA-ZåÅäÄöÖ\" ]*$/", htmlspecialchars_decode($captainname)))
              {
                  $korrektNummer++;
              }
              else
              {
                  $captainnameErr = "Felaktig mailaddress";
              }
          }
      }

    if (empty($regler))
    {$reglerErr = "Du måste acceptera reglerna (╯°□°）╯︵ ┻━┻";}
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

    if($korrektNummer == "3")
    {
      $captainname = $db->real_escape_string($captainname);

      $db->query("SET NAMES 'UTF8' ");
      $db->query("INSERT INTO tavlingar (namn, captainname) VALUES ('$namn', '$captainname')");

      header("location:perrent.php");
    }
  }

  function test_input($data)
  {
    $data = trim($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }?>



  <nav class="container navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">      <!-- Brand and toggle get grouped for better mobile display -->
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
          <li><a href="index.php">Hem</a></li>
          <li><a href="perrent.php">För föräldrar</a></li>
          <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Event<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li class="active"><a href="events.php">Tävlingar</a></li>
              <li><a href="brackets.php">Brackets</a></li>
              <li class="divider"></li>
              <li><a href="info_events.php">Info tävlingar</a></li>
            </ul>
          </li>
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
                <form class="anmalning" id="anmalning-lag" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <fieldset>
                    <p id="obligator">*Obligatorisk</p>

                    <div class="form-group">
                      <label class="itg" >Lagnamn   *</label>
                      <input class="form-control" type="text" name="namn" maxlength="70" value="<?php echo $namn; ?>" placeholder="Ex. DragonSlayerZ"><span class="error"><?php echo $namnErr;?></span>
                    </div>

                    <div class="form-group">
                      <label class="itg" >Namn (Lagkapten)   *</label>
                      <input class="form-control" type="text" name="captainname" maxlength="80" value="<?php echo $captainname; ?>" placeholder='Ex. Kurt "Kurten" Kurtsson'><span class="error"><?php echo $captainnameErr;?></span>
                    </div>

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
</body>
</html>
