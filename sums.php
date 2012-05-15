<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	MD5 and SHA1 sums generators
*/

function out_md5($file_list){
	if($file_list){
		header("Content-disposition: inline; filename=md5sums.txt");
		header("Content-type: text/plain");
		foreach($file_list as $item)
 			echo md5_file($item['realname']) ."  ". $item['name'] ."\n";
	}
	exit();
}

function out_sha1($file_list){
	if($file_list){
		header("Content-disposition: inline; filename=sha1sums.txt");
		header("Content-type: text/plain");
		foreach($file_list as $item)
			echo sha1_file($item['realname']) ."  ". $item['name'] ."\n";
	}
	exit();
}
