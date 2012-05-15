<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Utility functions
*/

function php_multisort($data,$keys){
	foreach ($data as $key => $row)
		foreach ($keys as $k)
			$cols[$k['key']][$key] = $row[$k['key']];
	$idkeys = array_keys($data);
	$i=0;
	foreach ($keys as $k){
		if($i>0){$sort.=',';}
		$sort.='$cols['.$k['key'].']';
		if($k['sort']){$sort.=',SORT_'.strtoupper($k['sort']);}
		if($k['type']){$sort.=',SORT_'.strtoupper($k['type']);}
		$i++;
	}
	$sort .= ',$idkeys';
	$sort = 'array_multisort('.$sort.');';
	eval($sort);
	foreach($idkeys as $idkey)
		$result[$idkey]=$data[$idkey];
	return $result;
}

/* http://us3.php.net/manual/en/function.filesize.php#84652 */
function bytes_to_string($size, $precision = 0) {
	$sizes = array('YB', 'ZB', 'EB', 'PB', 'TB', 'GB', 'MB', 'KB', 'Bytes');
	$total = count($sizes);
	while($total-- && $size > 1024) $size /= 1024;
	$return['num'] = round($size, $precision);
	$return['str'] = $sizes[$total];
	return $return;
}

// Current page URL (http://www.webcheatsheet.com/PHP/get_current_page_url.php)
function curPageURL(){
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80")
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    return $pageURL;
}
