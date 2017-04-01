<?php
	function dbConnect()
	{
		$sql = mysqli_connect('localhost' ,'root','','quiz');
		return $sql;
	}
?>