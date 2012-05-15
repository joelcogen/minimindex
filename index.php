<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Main file
*/
error_reporting(1);

// Config
include("config.php");
$basedir = $config["basedir"];
$realdir = $config["realdir"];

// What directory do we want?
$reqdir_a = explode("?", $_SERVER["REQUEST_URI"]);
$reqdir = rtrim($reqdir_a[0], "/");
if(substr($reqdir, 0, strlen($basedir)) == $basedir){
	$dir = $realdir . substr($reqdir, strlen($basedir));
}else{
	die("File not found");
}

// Set sorting properties.
$sort = array(array('key'=>'sortname', 'sort'=>'asc'),
              array('key'=>'size', 'sort'=>'asc'));

// Are we requesting an image?
if(isset($_GET['image'])){
	include("images.php");
	serve_image($_GET['image']);
}

// Include utility functions
include("utils.php");

// Open DB connection
include("db.php");

// Open the current directory
$total_size = 0;
if ($handle = opendir($dir)){
    while (false !== ($file = readdir($handle))){
        if ($file != "." && $file != ".."){
			// Basic info
			$realfile           = "$dir/$file";
			$stat				= stat($realfile);
			$info				= pathinfo($realfile);
			$item['realname']   = $realfile;
			$item['name']		= $file;
			$item['sortname']	= strtolower($info['filename']);
			$item['ext']		= $info['extension'];
			if($item['ext'] == '')
				$item['ext'] = 'text';
			$item['bytes']		= $stat['size'];
			$item['size']		= bytes_to_string($stat['size'], 2);
			$item['mtime']		= $stat['mtime'];
			// Download count
			$item['dl']			= db_getdl($item['name']);
			// Add to list
			if(is_dir($realfile)){
				$folder_list[] = $item;
			}else{
				$file_list[] = $item;
				$total_size += $item['bytes'];
			}
        }
    }
    closedir($handle);
}

// Sort
$pardir['name'] = "..";
$folder_list[] = $pardir;
$folder_list = php_multisort($folder_list, $sort);
if($file_list){
	$file_list = php_multisort($file_list, $sort);
}
$total_size = bytes_to_string($total_size, 2);

// Result
if(isset($_GET['md5'])){
	// MD5
	include("sums.php");
	out_md5($file_list);
}else if(isset($_GET['sha1'])){
	// SHA1
	include("sums.php");
	out_sha1($file_list);
}else if(isset($_GET['d'])){
	// Download
	include("download.php");
}else{
	// Listing
	include("list.php");
}