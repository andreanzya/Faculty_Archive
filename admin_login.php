

<?php

require_once("../include/connection.php");

session_start();

if(isset($_POST["adminlog"])){


  date_default_timezone_set("asia/manila");
  $date = date("M-d-Y h:i A",strtotime("+0 HOURS"));

 $username = mysqli_real_escape_string($conn, $_POST["admin_email"]);  
 $password = mysqli_real_escape_string($conn, $_POST["admin_password"]);



$query=mysqli_query($conn,"SELECT * FROM admin_login WHERE admin_email = '$username'")or die(mysqli_error($conn));
		$row=mysqli_fetch_array($query);
           $id=$row['id'];
            $admin=$row['admin_email'];
           $_SESSION["admin_email"] = $row["admin_email"];

	
	
    
           $counter=mysqli_num_rows($query);
            
		  	if ($counter == 0) 
			  {	
				   echo "<script type='text/javascript'>alert('Invalid Email Address or Password, Please try again!');
				  document.location='index.html'</script>";
			  } 
			  else
			  {
			  	if(password_verify($password, $row["admin_password"]))  
                     {
				        $_SESSION['admin_email']=$id;	

				         if (!empty($_SERVER["HTTP_CLIENT_IP"]))
							{
							 $ip = $_SERVER["HTTP_CLIENT_IP"];
							}
							elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
							{
							 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
							}
							else
							{
							 $ip = $_SERVER["REMOTE_ADDR"];
							}

							$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);


			
                       $remarks="Has LoggedIn the system at";  
                       mysqli_query($conn,"INSERT INTO history_login(id,admin_email,action,ip,host,login_time) VALUES('$id','$admin','$remarks','$ip','$host','$date')")or die(mysqli_error($conn));
    
                 
			  	echo "<script type='text/javascript'>document.location='dashboard.php'</script>";  
			  }
	    }
   }
?>