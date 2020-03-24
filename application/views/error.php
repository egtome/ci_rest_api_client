<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>QESolver Client - Error response</title>
</head>
<body>
<div>
	<?php
		if($message !== false){
			echo "<div>$message</div>";
			echo "<a href='$back_url'>Back</a>";
		}
	?>
</div>

</body>
</html>