<?php

function do_html_header($title='')
{
  // print an HTML header
	if($title)
		$webtitle = $title;
	if(isset($_SESSION['valid_user']))
	{
		$username = $_SESSION['valid_user'];
//		$changepassword = "<td colspan='2' id='second2'><a href='forgetpassword.php'>Change password</a>";
	}
?>
  <html>
	<head>
		<title><?php echo $webtitle; ?></title>
		<link rel="stylesheet" type="text/css" href="style/style_main.css" />
		<link rel="stylesheet" type="text/css" href="style/style_content.css" />
		<link rel="stylesheet" type="text/css" href="style/style_search.css" />
		<script type="text/javascript" src="//ajax.googleapis/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript">
		$(function(){
	$('#search_auto').css({'width':$('#searchbox input[name="searchtext"]').width()+4});
	$('#searchbox input[name="searchtext"]').keyup(function(){
		$.post('search_auto.php',{'value':$(this).val()}, function(data){
			if(data=='0') $('search_auto').html('').css('display','none');
			else
				$('search_auto').html(data).css('display', 'block');
		});
		});
		});
		</script>
	</head>
	<body>
		<div id="container">
			<div id="header"> 
				<div id="left">
					<a href="index.php"><img id="logo" src="image/logo.png" /></a>
				</div>
				<div id="middle">
					<h4>A place to freely express idea about the teacher and course</h4>
				</div>
				<div id="right">
					<table>
						<tr>
							<td id="first1"><a href="login_form.php">Log in</a></td>
							<td id="second1"><a href="register_form.php">Register</a></td>
							<td id="third1"><a href="logout.php">Log out</a></td>
							<td id="fourth1"><a href="administrator_form.php">Administrator?</a></td>
						</tr>
						<tr>
							<td colspan="2" id="first2">welcome! <?php echo "<a href='index.php'>$username</a>";?></td><?php 
			if(isset($_SESSION['valid_user']))
				echo "<td colspan='2' id='second2'><a href='changepassword_form.php'>Change password?</a></td>";
		?>
						</tr>
					</table>
				</div>
			</div>
			<div id="page">
				<div id="searchbox">
					<form action="search.php" method="post">
						<input type="text" name="searchtext" class="searchtext"/>&nbsp;
						<input type="submit" value="search"  name="searchbutton"/>
						<a id="newpost" href="newpost_form.php">New Post?</a>
					</form>
				</div>
				<div id="search_auto"></div>
				<hr />
				<div id="content">
<?php
}

function display_site_info()
{
	?>
		<div id="siteinfo">
			<h1 align="center">Welcome to the "Score my teacher" forum site</h1>
			<p>This site is used by UF students to expressed their ideas/opinions about the Course+Teacher in UF.</p>
			<p>Students can post articles, reply articles, socre the Teacher+Course which is usually done by their teacher.</p>
			<p>Only registered users can view the content of the website, and all actions attach to registerd users.</p>
			<p>This site is developed by Pengjie Zhang, Ying She, Qile Zhu, Weiren Wang, for more information about the authors, please refer to the about.</p>
		</div>
	<?php
}

function do_html_footer()
{
  // print an HTML footer
?>
  				</div>
			</div>
			<div id="footerpush">
			</div>
		</div>
		<div id="footer">
			<p>Copyright &copy; 2014~2015 <a href="mailto:pengjiezhang@ufl.edu?subject=Problem">Pengjie Zhang</a>, <a href="mailto:valder@ufl.edu?subject=Problem">Qile Zhu</a>, <a href="mailto:yshe@ufl.edu?subject=Problem">Ying She</a>,<a href="mailto:weirenwang@ufl.edu?subject=Problem">Weiren Wang</a>. All Rights Researved.</p>
		</div>
	</body>
</html>
<?php
}
?>
