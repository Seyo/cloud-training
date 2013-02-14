<?php 
$username=getenv('DATABASE_APPLICATION_USERNAME');
$password=getenv('DATABASE_APPLICATION_PASSWORD');
$database=getenv('DATABASE_SCHEMA_NAME');
$remoteIp = $_SERVER['REMOTE_ADDR'];
$ip = file_get_contents('http://icanhazip.com/');

echo "user: ".$username. "<br />";

if($remoteIp == "::1")
{
	$remoteIp = "localhost";
}


mysql_connect('localhost',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "INSERT INTO `demo_access_log`(`instance`, `user_ip`) VALUES ('".$ip."','".$remoteIp."')";

mysql_query($query);

$result = mysql_query("SELECT * FROM demo_access_log order by access_time desc");

echo '<table style="border-spacing: 0;"><th>Server IP</th><th style=\"padding:0 10px 0 10px;\">Remote IP</th><th style=\"padding:0 10px 0 10px;\">Access Time</th>';
$count=0;
while($row = mysql_fetch_array($result))
{
	if($count%2==0)
	{
		$color="#fff";
	}
	else
	{
		$color="#f7f7f7";
	}
	echo "<tr style=\"background:".$color."\"><td>".$row['instance'] . "</td><td style=\"border-left:1px solid #ccc;border-right:1px solid #ccc;padding:0 10px 0 10px;\">" . $row['user_ip'] . "</td><td style=\"padding:0 10px 0 10px;\"> " . $row['access_time'] . "</td><tr>";
	$count++;
}
echo '</table>';


mysql_close();
 ?>
