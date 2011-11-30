<?php
if (!(count($_POST)>1)) {
  die('Don\'t think you rated a movie...');
}

$con = mysql_connect("localhost","root","root");
if (!$con)
    {
        die('Could not connect: ' . mysql_error());
          }

mysql_select_db("movieCol", $con);

$mysqldate = date( 'Y-m-d H:i:s', time() );

extract($_POST);

$sql="INSERT INTO user_ratings VALUES ('funkhouserw', '$imdb', '$rating', '$mysqldate') ON DUPLICATE KEY UPDATE rating='$rating', datetime='$mysqldate'";

if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
          }
echo "1 record added";

mysql_close($con)
?>
