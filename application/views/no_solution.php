<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>QESolver Client - No solution</title>
</head>
<body>
<div>
	<?php
		if($message !== false){
			echo "<div>$message<p>X1: <b>$val_1</b></p><p>X2: <b>$val_2</b></p></div>";
			echo "<a href='$back_url'>Back</a>";			
		}
	?>
</div>

</body>
</html>