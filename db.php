<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Database management
*/

$usedb = $config["usedb"];
if($usedb) db_connect();

function db_connect(){
	global $config, $usedb, $error_message, $conn;
	
	$conn = mysql_connect($config["db_host"], $config["db_user"], $config["db_pass"]);
	if(!$conn){
		$usedb = false;
		$error_message .= "Database connection failed, download counts will not be saved.<br/>";
		return;
	}
	
	$res = mysql_select_db($config["db_db"], $conn);
	if(!$res){
		// Try to create the DB
		mysql_query("CREATE DATABASE `".$config["db_db"]."`");
		$res = mysql_select_db($config["db_db"], $conn);
		if(!$res){
			$usedb = false;
			$error_message .= "Database selection failed, download counts will not be saved.<br/>";
			return;
		}
	}
	
	// Try to create the downloads table if it doesn't exist
	$res = mysql_query("SELECT * FROM `midx_dls` LIMIT 1", $conn);
	if(!$res){
		// Try to create table
		$res = mysql_query("CREATE TABLE `midx_dls` (`id` INT NOT NULL AUTO_INCREMENT, `filename` TEXT NULL, `count` INT NULL, PRIMARY KEY (`id`))");
		if(!$res){
			$usedb = false;
			$error_message .= "Database table creation failed, download counts will not be saved.<br/>";
			return;
		}
	}
	
	// Try to create the bandwidth table if it doesn't exist
	$res = mysql_query("SELECT * FROM `midx_bw` LIMIT 1", $conn);
	if(!$res){
		// Try to create table
		$res = mysql_query("CREATE TABLE `midx_bw` (`month` INT NOT NULL, `count` INT NULL, `size` BIGINT NULL, PRIMARY KEY (`month`))");
		if(!$res){
			$usedb = false;
			$error_message .= "Database table creation failed, bandwidth usage will not be saved.<br/>";
			return;
		}
	}
}

function db_getdl($filename){
	global $usedb, $conn, $reqdir;
	if(!$usedb){
		return "N/A";
	}
	$filename = mysql_real_escape_string("$reqdir/$filename");
	$res = mysql_query("SELECT `count` FROM `midx_dls` WHERE `filename`='$filename' LIMIT 1");
	$row = mysql_fetch_array($res);
	return ($row ? $row[0] : 0);
}

function db_updl($item){
	global $usedb, $conn, $reqdir;
	if(!$usedb) return;
	
	// Add to DLs
	$filename = mysql_real_escape_string("$reqdir/".$item["name"]);
	mysql_query("UPDATE `midx_dls` SET `count`=`count`+1 WHERE `filename`='$filename' LIMIT 1");
	if(mysql_affected_rows($conn) == 0){
		// File was not in DB, insert it
		mysql_query("INSERT INTO `midx_dls` (`filename`, `count`) VALUES ('$filename', 1)");
	}
	
	// Add to BW
	$month = date("Ym");
	mysql_query("UPDATE `midx_bw` SET `count`=`count`+1, `size`=`size`+".$item["bytes"]." WHERE `month`=$month LIMIT 1");
	if(mysql_affected_rows($conn) == 0){
		// Month was not in DB, insert it
		mysql_query("INSERT INTO `midx_bw` (`month`, `count`, `size`) VALUES ($month, 1, ".$item["bytes"].")");
	}
}

function db_monthstat(){
	global $usedb, $conn, $reqdir;
	if(!$usedb) return;
	
	$month = date("Ym");
	$res = mysql_query("SELECT `count`,`size` FROM `midx_bw` WHERE `month`=$month LIMIT 1");
	$row = mysql_fetch_array($res);
	return ($row ? array($row[0], $row[1]) : array(0, 0));
}