<?php
/*
	minimindex 1.1
	Copyright (C) 2010 Joel Cogen [http://joelcogen.com]
	Based on PHPDL by Greg Johnson [http://greg-j.com]
	Licensed under the Creative Commons Attribution-ShareAlike 3.0 United States
	[http://creativecommons.org/licenses/by-sa/3.0/us/]
	
	Print list
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Index of <?=$reqdir?></title>
<style type="text/css">
body{font-family:Verdana; font-size:12px; color:#333; background:#f8f8f8}
a{color:#b00; font-weight:bold; text-decoration:none}
a:hover{color:#000}
.error{color:#b00}
img{vertical-align:bottom; padding:0 3px 0 0; border:0}
pre{white-space:-moz-pre-wrap; white-space:-pre-wrap; white-space:-o-pre-wrap; white-space:pre-wrap; word-wrap:break-word}
table{margin:0 auto; padding:0; width:800px}
table td{padding:5px}
thead td{padding-left:0; font-size:16px; font-weight:bold}
tbody .folder td{border:solid 1px #f8f8f8}
tbody .file td{background:#fff; border:solid 1px #ddd}
tbody .file td.size,
tbody .file td.time{white-space:nowrap; width:1%; padding:5px 10px}
tbody .file td.size span{color:#999; font-size:12px}
tbody .file td.time{color:#555}
tfoot td{padding:10px 0 0 0; color:#777; font-size:10px; background:#f8f8f8; border-color:#f8f8f8; vertical-align:top}
tfoot td.copy{text-align:right; white-space:nowrap}
tfoot td.total{line-height:15px}
tfoot td.cc{padding:40px; text-align:center}
tfoot td.cc img{padding:0; border:none}
tfoot td a{font-weight:normal}
tr.filehead td{font-size:10px; padding:0 5px; color:#999}
</style>
</head>

<body>
<!-- error -->
<? if($error_message){ ?>
<table>
	<tr class="file"><td><strong class="error"><?=$error_message?></strong></td></tr>
</table>
<br/>
<? } ?>
<? if(filesize("$dir/readme.txt")){ ?>
<table>
	<tr><td style="padding-top: 20px;"><strong>readme.txt</strong></td></tr>
	<tr class="file"><td colspan="5" style="padding: 10px;"><pre><? readfile("$dir/readme.txt"); ?></pre></td></tr>
</table>
<? } ?>
<!-- /error -->
<table cellpadding="0" cellspacing="1">
	<thead>
		<tr><td colspan="3">Index of <?=$reqdir?></td></tr>
	</thead>
	<tfoot>
		<tr>
			<td class="total">
				<?=count($file_list)?> files / <?=$total_size['num']?> <?=$total_size['str']?> / Sums: <a href="?md5">MD5</a> - <a href="?sha1">SHA1</a><br/>
				<? list ($monthcount, $monthsize)=db_monthstat(); $monthsize=bytes_to_string($monthsize, 2); ?>Downloaded this month: <?=$monthcount?> files, totaling <?=$monthsize["num"]?> <?=$monthsize["str"]?>
			</td>
			<td colspan="4" class="copy">
				<a href="http://joelcogen.com/pub/minimindex/" target="_blank">minimindex</a> 1.1 / &copy; 2010 Joel Cogen / <a target="_blank" href="http://creativecommons.org/licenses/by-sa/3.0/us/">(cc) by-sa</a>
			</td>
		</tr>
	</tfoot>
	<tbody>
<!-- folders -->
<? if($folder_list){ ?>
<? foreach($folder_list as $item){ ?>
		<tr class="folder">
			<td colspan="3" class="name"><img src="?image=dir" alt="dir" /> <a href="<?="$reqdir/".$item['name']?>"><?=$item['name']?></a></td>
		</tr>
<? } ?>
<? } ?>
<!-- /folders -->
<!-- files -->
<? if($file_list){ ?>
		<tr class="filehead">
			<td>Name</td><td>Size</td><td>Date</td><td>DL</td><td>QR</td>
		</tr>
<? foreach($file_list as $item){ ?>
		<tr class="file">
			<td><img src="?image=<?=$item['ext']?>" alt="<?=$item['ext']?>" /> <a href="?d=<?=$item['name']?>"><?=$item['name']?></a></td>
			<td class="size"><?=$item['size']['num']?> <span><?=$item['size']['str']?></span></td>
			<td class="time"><?=date('Y-m-d H:i:s', $item['mtime'])?></td>
			<td class="size"><?=$item['dl']?></td>
			<td class="size"><? $durl=curPageURL()."?d=".$item['name'] ?><a href="javascript:void()" onclick="javascript: document.getElementById('qr_<?=$item['name']?>').src='http://joelcogen.com/qr/img.php?u=<?=$durl?>'; document.getElementById('qr_<?=$item['name']?>').width=150; document.getElementById('qr_<?=$item['name']?>').height=150" title="Click to generate" alt="Click to generate"><img src="http://joelcogen.com/qr/empty.png" alt="qr-code" width="15" height="15" id="qr_<?=$item['name']?>" /></a></td>
		</tr>
<? } ?>
<? } ?>
<!-- /files -->
	</tbody>
</table>
<!-- readme -->
<? if(filesize("$dir/readme.html")){ ?>
<table>
	<tr><td style="padding-top: 20px;"><strong>readme.html</strong></td></tr>
	<tr class="file"><td colspan="5" style="padding: 10px;"><? readfile("$dir/readme.html"); ?></td></tr>
</table>
<? } ?>
<? if(filesize("$dir/readme.txt")){ ?>
<table>
	<tr><td style="padding-top: 20px;"><strong>readme.txt</strong></td></tr>
	<tr class="file"><td colspan="5" style="padding: 10px;"><pre><? readfile("$dir/readme.txt"); ?></pre></td></tr>
</table>
<? } ?>
<!-- /readme -->
</body>
</html>
