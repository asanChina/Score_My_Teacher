#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	$username = $_GET['username'];
	$teachername = $_GET['teachername'];
	$coursename = $_GET['coursename'];
	$articleid = $_GET['articleid'];
	$overallrating = $_GET['overallrating'];
	$_SESSION['current_viewing_article'] = $articleid;
	$articleinfo = array();
	$articleinfo['username'] = $username;
	$articleinfo['teachername'] = $teachername;
	$articleinfo['$coursename'] = $coursename;
	$articleinfo['articleid'] = $articleid;
	$articleinfo['overallrating'] = $overallrating;
	$_SESSION['articleinfo'] = $articleinfo;
	do_html_header();
	display_article_detail($username, $teachername, $coursename, $articleid, $overallrating);
	display_reply_form();
	do_html_footer();
?>
