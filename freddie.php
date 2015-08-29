<?php
	$test = "Off";
	require_once (dirname(__FILE__).'/stripePHP/init.php');
	$return_message = "Thank you for purchasing. We will be in touch with you very soon.";
	
	// create time stamp
	date_default_timezone_set('America/Los_Angeles');
	$timestamp = date("Y-m-d\TH:i:s\Z");

	// connect to database
	$username = "";
	$password = "";
	$hostname = ""; 
	$database = "";
	$tableName = "";
	$con = mysqli_connect($hostname,$username,$password,$database) or die("Failed to connect to MySQL. Please contact the administrator.");

	// shipping info with SQL security for escaping protected
	$ship_firstname = mysqli_real_escape_string($con, $_POST['NAME']);
	$ship_lastname = mysqli_real_escape_string($con, $_POST['LAST']);
	$ship_email = mysqli_real_escape_string($con, $_POST['ship-email']);
	$ship_comp = mysqli_real_escape_string($con, $_POST['ship-comp']);
	$ship_phone= mysqli_real_escape_string($con, $_POST['ship-phone']);
	$ship_address = mysqli_real_escape_string($con, $_POST['ship-address']);

	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here https://dashboard.stripe.com/accounts
	//if ($test == "On")
	//	Stripe::setApiKey("sk_test_0NlvygbUKoCIcrTP0TnyWCes");
	//else
		Stripe::setApiKey("");
	// Get the credit card details submitted by the form
	if ($_POST['stripeToken'])
	{
	   $token = $_POST['stripeToken'];
	        // when success
        try {
                $customer = Stripe_Customer::create(array(
                  "card" => $token,
                  "plan" => "testplan",
                  "email" => $ship_email )
                );

                //Enter Custumer info into database
                $sql="INSERT INTO $tableName (timeStamp, firstName, lastName, company, phone, address, email, serviceType)
                        VALUES ('$timestamp', '$ship_firstname', '$ship_lastname','$ship_comp','$ship_phone','$ship_address','$ship_email','default');"
                        or die('something wrong');
                if (!mysqli_query($con,$sql)) {
                  die('Database Error: ' . mysqli_error($con).' Please Contact the administrator.');
                }
        /*
                $confirm="SELECT * FROM $tableName WHERE lastName = '$ship_lastname' AND timeStamp = '$timestamp'";
                $result = mysqli_query($con,$confirm);
                if (!mysqli_query($con,$confirm)) {
                  die('Database Error: ' . mysqli_error($con).' Please Contact the administrator.');
                }
                $confirmNum = mysql_fetch_array($result);
                Print $confirmNum['id_key'];
                Print $confirmNum['firstName'];
                $return_message = $return_message."\r\n".'Please remember your confirmation number: 1000'.$confirmNum['id_key'].$confirmNum['firstName'];
        
        */

        }


        // when failsure
        catch(Stripe_CardError $e)
        {
                $return_message = 'Submission failed. Please contact the administrator. <br><br> Error Message: '. $e;
        }
}
	

	else { $return_message = "Wrong Card Information. Please enter again";}
	

	// when success
/*	try {
		$customer = Stripe_Customer::create(array(
		  "card" => $token,
		  "plan" => "testplan",
		  "email" => $ship_email )
		);

		//Enter Custumer info into database
		$sql="INSERT INTO $tableName (timeStamp, firstName, lastName, company, phone, address, email, serviceType)
	 		VALUES ('$timestamp', '$ship_firstname', '$ship_lastname','$ship_comp','$ship_phone','$ship_address','$ship_email','default');"
			or die('something wrong');
		if (!mysqli_query($con,$sql)) {
		  die('Database Error: ' . mysqli_error($con).' Please Contact the administrator.');
		}
	
		$confirm="SELECT * FROM $tableName WHERE lastName = '$ship_lastname' AND timeStamp = '$timestamp'";
		$result = mysqli_query($con,$confirm);
		if (!mysqli_query($con,$confirm)) {
                  die('Database Error: ' . mysqli_error($con).' Please Contact the administrator.');
                }
		$confirmNum = mysql_fetch_array($result);
		Print $confirmNum['id_key'];
	        Print $confirmNum['firstName'];
		$return_message = $return_message."\r\n".'Please remember your confirmation number: 1000'.$confirmNum['id_key'].$confirmNum['firstName'];
	
	
	
	}


	// when failsure
	catch(Stripe_CardError $e)
	{
		$return_message = 'Submission failed. Please contact the administrator. <br><br> Error Message: '. $e;
	}
*/

?>







<!DOCTYPE HTML>
<html>
<head>
<title>Boxit - We can help!</title>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/social_mail.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="css/magnific-popup1.css">
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
	<!--  jquery plguin -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<!--start slider -->
	    <link rel="stylesheet" href="css/fwslider.css" media="all">
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/css3-mediaqueries.js"></script>
		<script src="js/fwslider.js"></script>
	<!--end slider -->
	 <script type="text/javascript">
			$(document).ready(function() {
			
				var defaults = {
		  			containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
		 		};
				
				
				$().UItoTop({ easingType: 'easeOutQuart' });
				
			});                                   
		</script>
		<!-- Add fancyBox light-box -->
		<script src="js/jquery.magnific-popup.js" type="text/javascript"></script>
				<script>
					$(document).ready(function() {
						$('.popup-with-zoom-anim').magnificPopup({
							type: 'inline',
							fixedContentPos: false,
							fixedBgPos: true,
							overflowY: 'auto',
							closeBtnInside: true,
							preloader: false,
							midClick: true,
							removalDelay: 300,
							mainClass: 'my-mfp-zoom-in'
					});
				});
		</script>
		<!-- //End fancyBox light-box -->

</head>
<body>
<!-- start header -->
<div class="header_bg">
<div class="wrap">
	<div class="header">
		<div class="logo">
			<h1><a href="index.html"><img src="images/boxitsub_logo.png" alt=""/></a></h1>
		</div>
		<div class="h_right">
			<ul class="menu">		
				<li class="active"><a  href="#home">Home</a></li>
				<li><a href="index.html#services" class="scroll">Services</a></li>
		
				<li><a href="index.html#pricing" class="scroll">Pricing</a></li>
				<li><a href="index.html#about" class="scroll">About</a></li>
				<!-- <li><a href="#about" class="scroll">Partners</a></li> -->
				<li ><a href="index.html#contact"  class="scroll">Contact</a></li>
				<li ><a href="investors.html"  target="new">Investors</a></li>
	            <li class="last"> <a href="careers.html"  target="new">Careers</a></li>
			</ul>
			<div id="sb-search" class="sb-search">
				<form>
					<input class="sb-search-input" placeholder="Enter your search term..." type="text" value="" name="search" id="search">
					<input class="sb-search-submit" type="submit" value="">
					<span class="sb-icon-search"></span>
				</form>
			</div>
			<script src="js/classie.js"></script>
			<script src="js/uisearch.js"></script>
			<script>
				new UISearch( document.getElementById( 'sb-search' ) );
			</script>
			<!-- start smart_nav * -->
	        <nav class="nav">
	            <ul class="nav-list">
	                <li class="nav-item"><a  href="#home">Home</a></li>
	                <li class="nav-item"><a href="#services" class="scroll">Services</a></li>
	           
	                <li class="nav-item"><a href="#pricing" class="scroll">Pricing</a></li>
	                <li class="nav-item"><a href="#about" class="scroll">About</a></li>
	                <li class="nav-item"><a href="#contact"  class="scroll">Contact</a></li>
	                <li class="nav-item"><a href="#about" class="scroll">Investors</a></li>
	                <li class="nav-item"><a href="#contact"  class="scroll">Careers</a></li>
	                <div class="clear"></div>
	            </ul>
	        </nav>
	        <script type="text/javascript" src="js/responsive.menu.js"></script>
			<!-- end smart_nav * -->
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>

<!----------- message3 ------------>
<div class="social_mail">
	<div class="wrap">
		<style>
			background: url("../images/smallshutter/yogabeach.jpg") no-repeat;
		</style>
		<p> <font size="6">
			<?php echo $return_message ?>
		</font></p>
		<br>
		<br>
		<p> <font size="4">Follow Us On Social Networks</font> </p>
	<!---start-social-icons---->
							<div class="social-icons-set">
								<ul>
									<li><a class="facebook" href="https://www.facebook.com/profile.php?id=100008197922713&fref=ts" target="_blank"> </a></li>
									<li><a class="twitter" href="https://twitter.com/BoxItBob" target="_blank"> </a></li>
									<!-- <li><a class="vimeo" href="#"> </a></li>
									<li><a class="rss" href="#"> </a></li>
									<li><a class="gplus" href="#"> </a></li> -->
									<li><a class="pin" href="#"> </a></li>
									<div class="clear"> </div>
								</ul>
								<div class="clear"> </div>
							</div>					
							<!---//End-social-icons----> 
							<div class="clear"> </div>
</div>
</div>
<div class="footer-bottom">
	<div class="wrap">
		<div class="image">
			<a href="index.html"><img src="images/boxitsub_logo.png" alt=""></a>
		</div>	
		<div class="copy-right">
			
		</div>	
		 <div class="clear"></div>
	</div>
</div>		
</body>
</html>