<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Premium Series
Description: A three-column, fixed-width blog design.
Version    : 1.0
Released   : 20090303

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><? echo $title;?>
<meta name="keywords" content="" />
<meta name="search" content="" />
<link href="<?=$url?>css/PremiumSeries.css" rel="stylesheet" type="text/css" media="screen" />
<script>
alert('excuse me!\nsome factor not real implement:\n\t1.prefix matching\n\t2.boolean query\nand may i fix it later.... thank u\nps:not using share memory that take u much time in fopen');
</script>
</head>
<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="<?=$url?>"><span>Aeil</span>SearchEngine</a></h1>
		<p>alpha</p>
	</div>
</div>
<!-- end header -->
<div id="wrapper">
	<!-- start page -->
	<div id="page">
			<div id="content">
			<div class="post">
				<h1 class="title"><a href="#">Welcome to Our Website!</a></h1>
				<p class="byline"><small><a href="#">try it </a></small></p>
				<div class="entry">
					<?php
					$this->load->helper('form');
					?>
					<?php echo form_open('/search/', $form_attributes);?>
						<div>
							<h2>Site Search</h2>
							<?php
							echo form_input($form_input);
							echo form_submit('b', 'search');
							?>
							<p>
							<STRONG>case sensitive</STRONG>
							<?php 
							echo form_checkbox($form_checkbox_cy) . "Yes";
							echo form_checkbox($form_checkbox_cn) . "No";
							?>
							<br />
							<STRONG>prefix matching</STRONG>
							<?php 
							echo form_checkbox($form_checkbox_py). "Yes";
							echo form_checkbox($form_checkbox_pn) . "No";
							?>
							</p>
						</div>
					<?php echo form_close("</div>");?>
					</div>
			</div>
					</div>
				<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>
<div id="footer">
	<p class="copyright">&copy;&nbsp;&nbsp;2010 All Rights Reserved &nbsp;&bull;&nbsp; Design by <a href="http://aeil.idv.tw">aeil
	<p class="link"><a href="#">Privacy Policy</a>&nbsp;&#8226;&nbsp;<a href="#">Terms of Use</a></p>
</div>
</body>
</html>
