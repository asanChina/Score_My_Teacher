<?php

function db_connect()
{
	$conn = oci_connect($username = 'your username', $password = 'your password', $connection_string = 'database string');
	if(!$conn)
		throw new Exception('Could not connect the backend database server, please try again later!');
	else 
		return $conn;
}

function get_articles()
{
	$conn = db_connect();
	$statement = oci_parse($conn, "select username, teachername, coursename, semester, articleid, to_char(articledate, 'mm/dd/yyyy hh24:mi:ss'), overallrating, likenum, dislikenum from forumarticleheader order by articledate desc");
	$result = oci_execute($statement);
	if(!$result)
	{
		oci_free_statement($statement);
		oci_close($conn);
		throw new Exception('Could not access the backend database server now, please try again later');
	}
	$nrows = oci_fetch_all($statement, $article_array, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $article_array;
}

function get_courses()
{
	// connect to db
	$conn = db_connect();
	$statement = oci_parse($conn, "select coursename from forumcourse");
	$result = oci_execute($statement);
	if(!$result)
			throw new Exception('Could not access the backend database server now, please try again later');
	$nrows = oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;
}

function get_teachers()
{
	// connect to db
	$conn = db_connect();
	
	$statement = oci_parse($conn, "select teachername from forumteacher");
	$result = oci_execute($statement);
	if(!$result)
			throw new Exception('Could not access the backend database server now, please try again later');
	oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;
}

function get_articlebody($articleid)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "select articlecomment from forumarticlebody where articleid='$articleid'");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access backend database server now, please try again later');
	oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;
}

function get_articlereply($articleid)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "select forumuser.username author, replycomment, replyid from forumuser, forumreply where forumuser.userid = forumreply.userid AND forumreply.articleid = '$articleid' order by replydate asc");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access backend database server, please try again later!');
	oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;
}

function get_teachercourse($teachers)
{
	$conn = db_connect();
	$sql = "select * from forumteachercourse";
	$i = 0;
	foreach($teachers as $row)
	{
		$value = $row['TEACHERNAME'];
		if($i == 0)
			$sql .= " where teachername='$value'";
		else
			$sql .= " or teachername='$value'";
		$i++;
	}
	$sql .= " order by teachername asc, avgrating desc";
	$statement = oci_parse($conn, $sql);
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access backend database server, please try again later!');
	oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;
}

function get_courseteacher($courses)
{
	$conn = db_connect();
	$sql = "select * from forumteachercourse";
	$i = 0;
	foreach($courses as $row)
	{
		$value = $row['COURSENAME'];
		if($i == 0)
			$sql .= " where coursename='$value'";
		else
			$sql .= " or coursename='$value'";
		$i++;
	}
	$sql .= " order by coursename asc, avgrating desc";
	$statement = oci_parse($conn, $sql);
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access backend database server, please try again later!');
	oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW+OCI_ASSOC);
	oci_free_statement($statement);
	oci_close($conn);
	return $res;

}
?>
