<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>QESolver Client</title>
	<script type="text/javascript" src="public/js/jquery-3.4.1.min.js"></script>
</head>
<body>
<div id="container">
	<?php
		if($error_message !== false){
			echo "<div>$error_message</div>";
		}
	?>
	<h1>Equation "ax&#178; + bx + c = 0"</h1>
    <form action="/client/send_request" id="main_form" method="POST">
        <label for="values">Values:</label>
        <p>
			<input type="text" id="a" name="a" size="8" placeholder="a value"/>X&#178;&#32;&#43;&#32;
			<input type="text" id="b" name="b" size="8" placeholder="b value"/>X&#32;&#43;&#32;
			<input type="text" id="c" name="c" size="8" placeholder="c value"/>
		</p> 
		<input type="hidden" value="<?php echo $security_check;?>" name="request_id">
        <input type="submit" value="Send"/>                
    </form>

</div>

</body>
<script type="text/javascript">
	$("#main_form").submit(function( event ) {
		$a = $("#a").val();
		$b = $("#b").val();
		$c = $("#c").val();
		if(Math.floor($a) != $a || $.isNumeric($a) == false || $a == 0){
			alert('\'a\' value must be an integer different than 0');
			$("#a").focus();
			return false;
		}
		if(Math.floor($b) != $b || $.isNumeric($b) == false){
			alert('\'b\' value must be an integer');
			$("#b").focus();
			return false;
		}
		if(Math.floor($c) != $c || $.isNumeric($c) == false){
			alert('\'c\' value must be an integer');
			$("#c").focus();
			return false;
		}
	});	 
</script>
</html>