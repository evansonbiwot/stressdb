<head>
<link rel="stylesheet" type="text/css" href="my_stsyle.css">

</head>
<body>

<p> PDO </p>



<?php
require_once('Timer.php') ;


function run_test($all_t){
	
	echo 'Start test '.$all_t.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

$timer = new Timer(1);


$servername = "localhost";
$username = "root";
$password = "";
$database = 'randomy';
$looper = 15;
// Create connection
//$conn = mysqli_connect($servername, $username, $password);







try {
    $dbh = new PDO('mysql:host='.$servername.';', $username, $password);
    
	
	$stmt = $dbh->query("CREATE DATABASE ".$database);
	 $time1 = $timer->get();
	  echo "Start(pass) ".$time1.'&nbsp;&nbsp;&nbsp;&nbsp;';
	
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
	$time1 = $timer->get();
	 echo "Start(fail) ".$time1.'&nbsp;&nbsp;&nbsp;&nbsp;';
    die();
}







$time_2 = $time_3 = $time_4 = $time_5 = array();


for($ff=1; $ff<=$looper; $ff++){


//$mysqli = mysqli_connect($servername,$username,$password, $database) ;
$mysqli = new PDO('mysql:host='.$servername.';dbname='.$database, $username, $password);



$time_2[] = $timer->get() ;






    $tableCreate = "CREATE TABLE IF NOT EXISTS test_tbl (
                                          id int(11) NOT NULL auto_increment ,
                                          RandomTxt TEXT ,
                                          RandomTxty TEXT,
                                          PRIMARY KEY (id)
                                          ) ";
    



try {
    
    
	
	$stmt = $mysqli->query($tableCreate);
	 $time1 = $timer->get();
	  //echo "table created ".$time1.'&nbsp;&nbsp;&nbsp;&nbsp;';
	  $time_3[] = $timer->get() ;
	
   
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
	$time_3[] = $timer->get() ;
	 echo "unable to create table ";
   
}
















//echo  "Table created at  : " . $timer->get() . "<br \> " ;
    // Create a conditional to see if the query executed successfully or not
    
        for ($i = 1; $i <= 1000; $i++) {
			
			$mysqli->query("INSERT INTO Test_tbl (RandomTxt,RandomTxty) VALUES ('abcdefghklmnopqrsst','abcdefghklmnopqrsst')");
			
   
               }
    

$time_4[] = $timer->get() ;












   $arrayResults_data = [];
   
   foreach($mysqli->query('SELECT * from Test_tbl') as $arrayResults) {
	   
	   $arrayResults_data[] = $arrayResults;
       // print_r($arrayResults);
    }
   
   

 $time_5[] = $timer->get() ;

//echo "Data is read from table and inserted into an array at  : ". $timer->get() . "" ;
//print_r($arrayResults) ;

$mysqli=null;


}

//drop database
//drop database
//$connt = mysqli_connect($servername, $username, $password);
try {
    $dbh2 = new PDO('mysql:host='.$servername.';', $username, $password);
    
	
	$stmt = $dbh2->query("DROP DATABASE ".$database);
	 $time10 = $timer->get();
	  echo "End(pass) ".$time10.'&nbsp;&nbsp;&nbsp;&nbsp;';
	
    $dbh2 = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "";
	$time10 = $timer->get();
	 echo "End(fail) ".$time10.'&nbsp;&nbsp;&nbsp;&nbsp;';
    die();
}


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


for($all_t =1;$all_t<=4;$all_t++){
run_test($all_t);
}




?>


</body>