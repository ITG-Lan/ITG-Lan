<!-- Includes -->
<?php
include '/include/database.php'; //Inkludera så att vi kan ansluta till databasen
include '/include/functions.php';
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
          <li><a href="index.php">Hem</a></li>
          <li><a href="perrent.php">För föräldrar</a></li>
          <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Event<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="events.php">Tävlingar</a></li>
              <li class="active"><a href="brackets.php">Brackets</a></li>
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
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lead">
                Här är brackets för Counter Strike. Änmälan sker på Event-Tävlingar.  <br>
                Det kommer att spelas klassisk 5 VS 5.
              </div>
              <!--Selection of rows-->
              <?php
              $result  = $db->query("SELECT * FROM tavlingar");
              $row = $result->fetch_row()
              ?>

                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                  <div class="image">
                    <img alt="" src="images/bracket.png" />
                      <div class="text">
                        <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3">
                          <div id="ladder11"><?php echo "<td>$row[1]</td>"; ?></div>
                          <div id="ladder12">Team2</div>
                          <div id="ladder13">Team4</div>
                          <div id="ladder12">Team3</div>
                          <div id="ladder13">Team8</div>
                          <div id="ladder12">Team6</div>
                          <div id="ladder13">Team5</div>
                          <div id="ladder14">Team2</div>
                        </div>
                        <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3">
                          <div id="ladder21">Team1</div>
                          <div id="ladder22">Hejsan</div>
                          <div id="ladder23">Team8</div>
                          <div id="ladder22">Team5</div>
                        </div>
                        <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3">
                          <div id="ladder31">Team1</div>
                          <div id="ladder32">Team8</div>
                        </div>
                      </div>
                    </div>
                  </div>
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
