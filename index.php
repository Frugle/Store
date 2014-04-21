<?php
	include "include/header.php"
?>

<canvas id="carousel" width="600" height="200" style="border: solid 1px #aaa;"></canvas>
<script type="text/javascript" src="js/carousel.js"></script>
<script type="text/javascript">

	var pictures = [
		"carousel/a.png",
		"carousel/b.png",
		"carousel/c.png"
	];

	var urls = [
		"http://www.google.com/search?q=a#q=a",
		"http://www.google.com/search?q=b#q=b",
		"http://www.google.com/search?q=c#q=c"
	];

	var canvas = document.getElementById("carousel");
	var a = NewCarousel();
	a.SetCanvas(canvas);
	a.SetInterval(5000);
	a.SetBarType(0);
	a.SetImages(pictures);
	a.SetURLs(urls);
	a.Start();

</script>

<?php
	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1)
		echo "Logged in as " . $_SESSION["username"];
?>

<?php
	include "include/footer.php"
?>