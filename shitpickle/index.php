<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title></title>
</head>
<body>

	<!-- HEADER -->

	<header>
		Header
	</header>	

	<!-- CONTENT -->

	<div class="content">
		
		<!-- NAVIGATION -->

		<div class="navigation">
			Navigation

			<!-- <p><a href="../product/?id=1"></a>Product 1</p> -->

			<?php for($i=1;$i<=50;$i++){printf('<p><a href="../product/?id=1"></a>Product %d</p>', $i);} ?>
		</div>

		<!-- MAIN -->

		<div class="main">
			Main
		</div>

	</div>

	<!-- FOOTER -->

	<footer>
		Footer
	</footer>

	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script type="text/javascript" src="script.js"></script>

</body>
</html>