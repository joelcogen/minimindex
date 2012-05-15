<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Configuration
*/

$config = array(
	// Base URL with starting '/' and no trailing '/'
	// Eg for http://joelcogen.com/pub, use '/pub'
	"basedir"	=>  "/pub",
	
	// Real filesystem directory (no trailing '/')
	// Can be a relative path
	"realdir"	=>  "files",
	
	// Save DL count into a database
	"usedb"		=>  true,
	// DB parameters (don't edit if you said 'false' above)
	"db_host"	=>  "localhost",
	"db_user"	=>  "midx",
	"db_pass"	=>  "midx",
	// Database will be created if it doesn't exist
	"db_db"		=>  "midx"
);