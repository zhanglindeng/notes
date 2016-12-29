**注意：Android 测试没用**
```html
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>slider</title>
	<style type="text/css">
		html  {
			padding: 0;
			margin: 0;
		}
		.slider {
			height: 12px;
			width: 100px;
			background: #000;
			cursor: pointer;
			margin: 0;
			padding: 0;
		}
		.slider > div {
			height: 100%;
			width: 60%;
			background: #f90;
			text-align: right;
			color: #fff;
			font-size: 0.6rem;
			line-height: 12px;
		}
		.container {
			border: 1px solid #eee;
			padding: 10px;
		}
	</style>
</head>
<body>
<video autoplay src="test.mp4" width="260" id="video"></video>
<div class="container">
	<div class="slider" id="slider" ">
		<div id="div">60</div>
	</div>
</div>
<script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">

	var left = $("#slider").offset().left;
	// console.log( "left: " + offset.left + ", top: " + offset.top );

	var video = document.getElementById('video');
	video.volume = 0.6;

	var slider = document.getElementById('slider');
	var div = document.getElementById('div');
	// slider.onclick = function(e) {
	// 	console.log('onclick',e.layerX,e.layerY,e.which);
	// }
	// slider.onmousedown = function(e) {
	// 	// 左1，中间2，右3
	// 	console.log('onmousedown', e.which);
	// }
	// onmousedown
	// onmouseup
	slider.onmousemove = function(e) {
		// 左键按下并且移动
		if(e.which == 1) {
			// console.log('onmousemove', e.layerX);
			var size = e.layerX - left;
			video.volume = size * 0.01;
			div.style.width = size + '%';
			div.innerHTML = size;
			if (size == 99) {
				video.volume = 1;
				div.style.width = '100%';
				div.innerHTML = '100';
			}
		}
	}
	slider.onmouseup = function(e) {
		// console.log(e);
		// 左键按下并且移动，放开
		// 点击
		if(e.which == 1) {
			// console.log('onmouseup',e.layerX);
			var size = e.layerX - left;
			video.volume = size * 0.01;
			div.style.width = size + '%';
			div.innerHTML = size;
			if (size == 99) {
				video.volume = 1;
				div.style.width = '100%';
				div.innerHTML = '100';
			}
		}
	}
</script>
</body>
</html>
```
