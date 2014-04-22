<?php
	include "include/header.php"
?>

<canvas id="carousel" width="580" height="200" style="border: solid 1px #aaa;"></canvas>
<script type="text/javascript" src="js/carousel.js"></script>
<script type="text/javascript">

	var pictures = [
		"carousel/NGTX770-Banner.png",
		"carousel/SC4DE-Banner.png",
		"carousel/WC3BC-Banner.png"
	];

	var urls = [
		"/store/product/66",
		"/store/product/10",
		"/store/product/2"
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
	include "include/footer.php"
?>