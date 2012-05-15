<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Download
*/

// Finds the file in the list
function check_file($fname){
    global $file_list;
	foreach($file_list as $item)
		if($item["name"] == $fname)
			return $item;
    return false;
}

// Check
$item = check_file($_GET['d']);
if($item === false){
	die("File not found");
}

// Add in DB
db_updl($item);

// Give download
$disposition = substr(mime_content_type($item["realname"]), 0, 4)=="text" ? "inline" : "attachment";
if($item['ext'] == "php") $disposition = "attachement"; // Force PHP as attachement, we don't want to execute it!
header("Content-disposition: $disposition; filename=".$item["name"]);
if($disposition != "inline")
	header("Content-type: ".mime_content_type($item["realname"]));
header("Content-Length: ".$item["bytes"]);
readfile($item["realname"]);
