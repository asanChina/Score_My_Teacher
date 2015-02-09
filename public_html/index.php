#!/usr/local/bin/php
<?php
	require_once('forum_fns.php');
	session_start();
	do_html_header('Welcome to Score My Teacher');
	$_SESSION['visitor'] = "visitor";
	if(isset($_SESSION['valid_user']) || isset($_SESSION['visitor']))
	{
		$sql = "select username, teachername, coursename, semester, articleid, articletitle, to_char(articledate, 'mm/dd/yyyy hh24:mi:ss') articledate, overallrating, likenum, dislikenum from forumarticleheader";

		if(isset($_GET['search']))
		{
			$search = $_GET['search'];
			if($search == 0)
			{	
				$teacher_array = $_SESSION['teacher_array'];
				$i = 0;
				foreach($teacher_array as $row)
				{
					$value = $row['TEACHERNAME'];
					if($i == 0)
						$sql .= " where teachername='$value'";
					else
						$sql .= " or teachername='$value'";	
					$i++;
						
				}
				$sql .= " order by teachername asc";
			}
			else if($search == 1)
			{
				$course_array = $_SESSION['course_array'];
				$i = 0;
				foreach($course_array as $row)
				{
					$value = $row['COURSENAME'];
					if($i == 0)
						$sql .= " where coursename='$value'";
					else
						$sql .= " or coursename='$value'";
					$i++;
				}
				$sql .= " order by coursename asc";
			}
		}
		else
		{
			if(isset($_SESSION['teacher_array']))
				unset($_SESSION['teacher_array']);
			if(isset($_SESSION['course_array']))
				unset($_SESSION['course_array']);
		}

		if(isset($_GET['search']))
			$sql .= " , likenum/(dislikenum+1) desc, articledate desc";
		else
			$sql .= " order by articledate desc, likenum/(dislikenum+1) desc";

		$conn = db_connect();
		if(!$conn)
			die("Failed to connect to database!");

		$append="";
		if(isset($_SESSION['teacher_array']))
			$append .= "search=0&";
		else if(isset($_SESSION['course_array']))
			$append .= "search=1&";

		
		$pager = new ps_pagination($conn, $sql, 30, 8, $append);
		$pager->setDebug(true);
		$res = $pager->paginate();
		if(!$res)
			die("Error");

		//we should display the related(statistical) info about the searching
		if(isset($_SESSION['teacher_array']) || isset($_SESSION['course_array']))
			display_search_result($_SESSION['teacher_array'], $_SESSION['course_array']);

		display_articles($res);
		echo $pager->renderFullNav();
	}
	else
		display_site_info();
	do_html_footer();
?>
