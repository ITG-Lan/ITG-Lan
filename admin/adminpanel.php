<?php
include '../include/database.php'; //Inkludera så att vi kan ansluta till databasen
include '../include/functions.php';
sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>ITG-LAN Västerås</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?php
if(login_check($db) == false)
{
?>
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
        <a class="navbar-brand" href="adminpanel.php">ITG-LAN</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="adminpanel.php">Anmälningar</a></li>
          <li><a href="#">Anmälda Lag</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php"><strong>Logga ut</strong></a></li>
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
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="itg text-center">ITG-LAN Västerås Anmälningar</h1>
                <?php
                  $db->query("SET NAMES 'UTF8';");
                  if($result  = $db->query("SELECT  * FROM  anmalningar"))
                  {
                      $row_cnt = $result->num_rows;
                      if($row_cnt > 0)
                      {
                          echo "<h3 class=\"text-center\"><a href=\"download.php\">Ladda ner till excel</a></h3>";
                          echo "<div class=\"table-responsive\">";
                            echo "<table class=\"table table-hover\">";
                              echo "<thead>";
                              echo "<tr class=\"info\">";

                                echo "<th><strong>Namn:</strong></th>";
                                echo "<th><strong>Mail:</strong></th>";
                                echo "<th><strong>Klass:</strong></th>";
                                echo "<th><strong>Klassmeddelande:</strong></th>";
                                echo "<th><strong>Fick reda?:</strong></th>";

                              echo "</tr>";
                              echo "</thead>";
                              echo "<tbody>";
                              while ($row = $result->fetch_row())
                              {
                                echo "<tr>";

                                  echo "<td>$row[1]</td>";
                                  echo "<td>$row[2]</td>";
                                  echo "<td>$row[3]</td>";
                                  echo "<td>$row[4]</td>";
                                  echo "<td>$row[5]</td>";

                                echo "</tr>";
                              }
                              echo "</tbody>";
                            echo "</table>";
                          echo "</div>";
                          $db->close();
                      }
                      else
                      {
                          echo("<h4>Det finns inga anmälningar att visa just nu, försök igen senare.</h4>");
                          $db->close();
                      }
                  }
                  else
                  {
                      echo("<h4>Det finns inga anmälningar att visa just nu, försök igen senare.</h4>");
                      $db->close();
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="../js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
<?php
}
else
{
  echo '<h1 class=\'text-center error\'>Du måste logga in för att se den här sidan.</h1>';
  echo "<meta http-equiv=\"refresh\" content=\"2;url=index.php\">";
}
?>
</html>
