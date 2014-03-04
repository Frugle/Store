<!doctype html>
<html>
<head>
	<title</title>
</head>
<body>
	<button name="btnTest" onClick="btnText_onClick();">Click Me!</button>
	<span id="counter">0</span>

	<script type="text/javascript">

		setInterval(countUp, 100);

		function btnText_onClick()
		{
			countUp();
		}

		function countUp()
		{
			var val = Number(document.getElementById("counter").innerHTML);

			document.getElementById("counter").innerHTML = val + 1;
		}

	</script>
</body>
</html>
