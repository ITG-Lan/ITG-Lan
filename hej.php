<?php
include '/include/database.php'; //Inkludera så att vi kan ansluta till databasen
include '/include/functions.php';
?>
<script type="text/javascript" src="/include/susnet.js"></script>

<?php
if($db->login_check = true) {
  echo "Hello";
  echo "<br>";
}

$result  = $db->query("SELECT  * FROM  tavlingar");


while($row = $result->fetch_row()){
echo "<br><td>$row[1]</td> <td>$row[2]</td><br><br>";
}

?>
