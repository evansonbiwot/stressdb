<head>
<link rel="stylesheet" type="text/css" href="my_stsyle.css">

</head>
<body>

<p> MYSQLI </p>



<?php
require_once('Timer.php') ;


function run_test($all_t){
	
	echo 'Start test '.$all_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

$timer = new Timer(1);


$servername = "localhost";
$username = "root";
$password = "";
$database = 'randomy';
$looper = 10;
// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE ".$database;
if ($conn->query($sql) === TRUE) {
   $time1 = $timer->get();
    echo "Start(pass) ".$time1.'&nbsp;&nbsp;&nbsp;&nbsp;';
} else {
    echo "Error creating database: " . $conn->error.'<br>';
    //echo 'Database Exists';
    $time1 = $timer->get();
     echo "Start(fail) ".$time1.'&nbsp;&nbsp;&nbsp;&nbsp;';
}

$conn->close();

$time_2 = $time_3 = $time_4 = $time_5 = array();


for($ff=1; $ff<=$looper; $ff++){


$mysqli = mysqli_connect($servername,$username,$password, $database) or die ("could not connect to mysql");



$time_2[] = $timer->get() ;
//echo  "<br>Db connection established  at  : " . $timer->get() . "<br \> " ;
  // Create an sql command structure for creating a table
    $tableCreate = "CREATE TABLE IF NOT EXISTS test_tbl (
                                          id int(11) NOT NULL auto_increment ,
                                          RandomTxt TEXT ,
                                          RandomTxty TEXT,
                                          PRIMARY KEY (id)
                                          ) ";
    // This line uses the mysqli_query() function to create the table now
    $queryResult = mysqli_query($mysqli , $tableCreate);
$time_3[] = $timer->get() ;









//echo  "Table created at  : " . $timer->get() . "<br \> " ;
    // Create a conditional to see if the query executed successfully or not
    if ($queryResult === TRUE) {
        for ($i = 1; $i <= 1000; $i++) {
    mysqli_query($mysqli ,
    "INSERT INTO Test_tbl (RandomTxt,RandomTxty) VALUES ('abcdefghklmnopqrsst','abcdefghklmnopqrsst')" )  ;
               }
    } else {
    print "<br /><br />No TABLE created. Check";
    }

$time_4[] = $timer->get() ;
//echo  "Data inserted into the table at  : " . $timer->get() . "<br \> " ;
   $result = mysqli_query($mysqli , 'SELECT * FROM Test_tbl') ;
   $arrayResults = array() ;
   while ($row = $result->fetch_assoc()) {
 array_push($arrayResults , $row['RandomTxt']);     }

 $time_5[] = $timer->get() ;

//echo "Data is read from table and inserted into an array at  : ". $timer->get() . "" ;
//print_r($arrayResults) ;

$mysqli->close();


}

//drop database
//drop database
$connt = mysqli_connect($servername, $username, $password);
// Check connection
if ($connt->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "DROP DATABASE ".$database;
if ($connt->query($sql) === TRUE) {
   $time10 = $timer->get();
    echo " End(pass): ".$time10;
} else {
    //echo "Error creating database: " . $conn->error;
    //echo 'Database Exists';
    $time10 = $timer->get();
     echo " End(fail) ".$time10;
}

$connt->close();


?>
<BR>
<table class="my_sup_table">
  <tbody>
    <tr>
      <td>&nbsp;</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td> Test <?php echo $ff+1;
	   ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td>Connection established</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td><?PHP
	   if($ff>0){
	   if(isset($time_5[$ff-1])){
		   
		   $first = roundme($time_2[$ff]-$time_5[$ff-1]);
		   
		   }else{
			   
			   $first = roundme($time_2[$ff]-$time1);
			   
			   }
	   
	   }else{
			   
			   $first =  roundme($time_2[$ff]-$time1);
			   
			   }
			   
			   echo $first;
	   
	    ?></td>
      <?php } ?>
    </tr>
    <tr>
      <td>Table created</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td><?PHP echo roundme($time_3[$ff]-$time_2[$ff]);?></td>
      <?php } ?>
    </tr>
    <tr>
      <td>Records inserted</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td><?PHP echo roundme($time_4[$ff]-$time_3[$ff]);?></td>
      <?php } ?>
    </tr>
    <tr>
      <td>Data read</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td><?PHP echo roundme($time_5[$ff]-$time_4[$ff]);?></td>
      <?php } ?>
    </tr>
    <tr class="orange">
      <td>&nbsp;</td>
      <?php  for($ff=0; $ff<$looper; $ff++){  ?>
       <td> <?php echo roundme($first+($time_3[$ff]-$time_2[$ff])+($time_4[$ff]-$time_3[$ff])+($time_5[$ff]-$time_4[$ff]));?> </td>
      <?php } ?>
    </tr>
  </tbody>
</table>
<br><br>


<?php

}

function roundme($value,$nums = 6){
	
	return round($value,$nums);
	
	}


for($all_t =1;$all_t<=2;$all_t++){
run_test($all_t);
}




?>


</body>