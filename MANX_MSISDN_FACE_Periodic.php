<html>
	<body bgcolor="#C0C0C0">
	<?php
	$hostname="192.168.102.4";
	$dbname="portaldb";
	$username="reader";
	$password="password";
	$portnumber="3306";

// connect and select a database 
//	print "<font color='red'>............trying to connect to mysql server...........</font><br><br>";
	$link = @mysql_connect("$hostname:$portnumber",$username,$password)
	or die ("Couldn't connect:  Check to make sure that:<br>" .
		"<ul><li>your MySQL server is running</li>" .
		"<li>you used the correct hostname (<tt>vergil/ovid</tt>)<li>" .      
		"<li>you didn't forget the 'u' in the hostname</li>" .
		"<li>you added a colon with your port number after the hostname</li>" .
		"<li>you used the username $username</li>" .       
		"<li>you used the correct password $password</li>" .
		"<li>you didn't forget to close a set of quotation marks</li><br><br>");
//	print "<font color='blue'><marquee>.......Connected successfully to mysql application.... </marquee>.<br>";
//	print "<font color='red'>............trying to connect to $dbname database...........</font><br>";
		mysql_select_db($dbname) or die("Could not select the database $dbname . Are you sure it exists?<br>" .
		"Check the following :<br>" .
		"<ol><li>you used the correct $dbname </li>" .      
		"<li>you didn't forget the hostname</li></ol>"); 

//	print "<font color='blue'><marquee>.......Connected successfully to  $dbname database </marquee></font>.<br>";


// Get data from form

$msisdn=$_POST[MSISDN];
echo "The MSISDN you are searching for is $msisdn <br><br>";
$date1=$_POST[DATE1];
$date2=$_POST[DATE2];
        print "<h2><font color='blue'><center>MANX TELECOMS</center></font></h2>";
        print "<h3><font color='blue'><center>PURCHASES BY MSISDN AND DATE</center></font></h3>";
        print "<h4><font color='blue'><center>Between $date1 and $date2 </center></font></h4>.<hr>";


// Create query

$query = "select e.msisdn 'MSISDN', ltrim(p.enduserid) 'USER ID',p.created 'DATE', RTRIM(p.purchaseprice) 'PRICE' ,r.spIdentifier 'SP ID',f.description 'DESCRIPTION',f.title 'TITLE'
from EndUser e, Purchase p,RetailItem r, Face f
where e.msisdn like '%$msisdn%' AND p.created between '$date1%' AND '$date2%' AND e.id=p.enduserid AND r.id=p.retailitemid AND f.id=r.faceid";

   $result = @mysql_query($query) or die("Query failed");

echo "The number of rows returned is " . mysql_num_rows($result)."<br><br>";

// DISPLAY ROWS OF QUERY
print "<table border='1'><th>MSISDN</th><th>USER ID</th><th>DATE</th><th>PRICE</th><th>SP ID</th><th>DESCRIPTION</th><th>TITLE</th>";
while($row = mysql_fetch_array($result,MYSQL_BOTH)){
	print "<tr><td>" . $row['MSISDN']."</td><td align='center'>". $row['USER ID']."</td><td align='center'>".$row['DATE']."</td><td align='center'>".$row['PRICE']."</td><td align='center'>".$row['SP ID']."</td><td align='center'>".$row['DESCRIPTION']."</td><td align='center'>".$row['TITLE'].   "</td></tr>";
}
print "</table>";
// free result set 
mysql_free_result($result);

// close the connection 
mysql_close($link);

?>
</body>
</html>
		
