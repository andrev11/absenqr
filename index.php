<style>
        body {
            background-image: url("bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            /*opacity: 0.9;*/
        }
</style>

<?php 

if( !session_id() )
{
    session_start();
}

if(@$_SESSION['logged_in'] == true){
    header("Location: home.php");
}
?>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="./main.js"></script>
<script type="text/javascript" src="./llqrcode.js"></script>

<body>
<div style="display:none" id="result"></div>
	<div class="selector" id="webcamimg" onclick="setwebcam()" align="right" ></div>
		<div class="selector" id="qrimg" onclick="setimg()" align="right" ></div>
			<center id="mainbody"><div id="outdiv"></div></center>
				<canvas id="qr-canvas" width="800" height="600"></canvas>

<?php
/**
 * QR Code + Logo Generator
 *
 * http://labs.nticompassinc.com
 */
$data = isset($_GET['data']) ? $_GET['data'] : 'http://labs.nticompassinc.com';
$size = isset($_GET['size']) ? $_GET['size'] : '200x200';
$logo = isset($_GET['logo']) ? $_GET['logo'] : FALSE;
header('Content-type: image/png');
// Get QR Code image from Google Chart API
// http://code.google.com/apis/chart/infographics/docs/qr_codes.html
$QR = imagecreatefrompng('https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs='.$size.'&chl='.urlencode($data));
if($logo !== FALSE){
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    
    // Scale logo to fit in the QR Code
    $logo_qr_width = $QR_width/3;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;
    
    imagecopyresampled($QR, $logo, $QR_width/3, $QR_height/3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
imagepng($QR);
imagedestroy($QR);
?>

</body>

<script type="text/javascript">load();</script>
<script src="./jquery-1.11.2.min.js"></script>