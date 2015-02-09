<?php
function store_new_post($post)
{
	$poster = $post['poster'];
	$course = $post['course'];
	$teacher = $post['teacher'];
	$score = $post['score'];
	$title = $post['title'];
	$semester = $post['semester'];
	$message = $post['message'];

	//if the title is not setted, we manually create a title for it
	if(!isset($title) || empty($title))
		$title = $poster;
	if(!isset($message) || empty($message))
		$message = $poster." score ".$course."+".$teacher." in ".$semester." ".$score;
	
	// connect to db
	$conn = db_connect();

	//first we should check whether the user has posted a same article before
	$statement = oci_parse($conn, "select * from forumarticleheader where username='$poster' AND teachername='$teacher' AND coursename='$course' AND semester='$semester'");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access the backend database, please try again later!');	
	$nrows = oci_fetch_all($statement, $res);
	if($nrows > 0)
	{
		throw new Exception('You have post the same article before');
	}

	//now try to store the article into the database
	$statement = oci_parse($conn, "insert into forumarticleheader(username, teachername, coursename, semester, articleid, articledate, articletitle, overallrating) values('$poster', '$teacher', '$course', '$semester', seq_forumarticle.nextval, sysdate, '$title', '$score')");	
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access the backend database, please try again later.');

	//then we should store the body of the article into another table
	$statement = oci_parse($conn, "select seq_forumarticle.currval from dual");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not post new article, please try again later.');
	$row = oci_fetch_array($statement);
	oci_free_statement($statement);
	$statement = oci_parse($conn, "insert into forumarticlebody(articleid, articlecomment) values('$row[0]', '$message')");
	$result = oci_execute($statement);

	oci_free_statement($statement);
	oci_close($conn);

	if(!$result)
		throw new Exception('Could not post new article, please try again later.');	
	return true;
}

function store_reply($user, $message, $articleid)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "select userid from forumuser where username = '$user'");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('something error in database');
	$row = oci_fetch_array($statement, OCI_NUM);

	oci_free_statement($statement);
	$statement = oci_parse($conn, "insert into forumreply(articleid, replyid, replydate, userid, replycomment) values('$articleid', seq_forumreply.nextval, sysdate, '$row[0]', '$message')");	
	$result = oci_execute($statement);
	oci_free_statement($statement);
	oci_close($conn);
	if(!$result)
		throw new Exception('cannot store your reply into the database, please try again later.');
	return true;
}

function delete_article($articleid)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "delete from forumarticleheader where articleid = '$articleid'");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access the backend database server, please try again later');
	oci_free_statement($statement);
	oci_close($conn);
}

function delete_reply($replyid)
{
	$conn = db_connect();
	$statement = oci_parse($conn, "delete from forumreply where replyid = '$replyid'");
	$result = oci_execute($statement);
	if(!$result)
		throw new Exception('Could not access the backend database server, please try again later!');
	oci_free_statement($statement);
	oci_close($conn);
}
?>
