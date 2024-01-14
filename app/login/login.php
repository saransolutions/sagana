<?php 
ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$errMsg=-1;
if(isset($_POST['login']))
{
	$errMsg=verifyUser($_POST['username'], $_POST['password']);
	if($errMsg!= 0){
		header("Location: ../index.php");
	}
	
}

function verifyUser($username, $password){
	$sql="SELECT bid,role FROM bookies WHERE username='".$username."' 
	and password='".$password."'";

	require_once '../funcs/db/db.php';	
	$rows=getFetchArray($sql);
	$bid=null;
	if(count($rows)!=0){
		foreach($rows as $result)
		{
			$bid=$result['bid'];
			$role=$result['role'];
			if($role=="admin"){
				$_SESSION['role']=$role;	
			}			
			$_SESSION['bid']=$bid;
			$_SESSION['user']=$username;
		}
		return $bid; 
	}else{
		return 0;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 		
        <title>Invoice System</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/modernizr.custom.63321.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		<style>	
			@import url(http://fonts.googleapis.com/css?family=Montserrat:400,700|Handlee);
			body {
				background: #eedfcc url(images/bg3.jpg) no-repeat center top;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-size: cover;
			}
			.container > header h1,
			.container > header h2 {
				color: #fff;
				text-shadow: 0 1px 1px rgba(0,0,0,0.5);
			}
		</style>
    </head>
    <body>
        <div class="container">
			<header>
				<h1><strong>Invoice System</strong> </h1>
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>				
			</header>
			
			<section class="main">
				
				<form class="form-5 clearfix" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
					<?php if($errMsg==0){
						echo "<p style='font-size:14px;color:red;padding:5px;border:none;'><b>Invalid username or password</b></p>";
					}?>
						
				    <p>
				        <input type="text" id="login" name="username" placeholder="Username">
				        <input type="password" name="password" id="password" placeholder="Password"> 
				    </p>
				    <button type="submit" name="login">
				    	<i class="icon-arrow-right"></i>
				    	<span>Sign in</span>
				    </button>     
				</form>​​​​
			</section>
			
        </div>
		<!-- jQuery if needed -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.placeholder.min.js"></script>
		<script type="text/javascript">
		$(function(){
			$('input, textarea').placeholder();
		});
		</script>
    </body>
</html>
<?php $errMsg=null;?>