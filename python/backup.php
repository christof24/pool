 <?php
include("config.php");
$pfad =  __FILE__; 
$date = date("G.i.s_d.m.Y"); 

$pfad = str_replace("python/backup.php", "backup/", $pfad);
$pfadtar = str_replace("/backup/", "", $pfad);

$dateinamesql = $pfad . $date . "_" . $db[db] . "_backup.sql";
$dateinametar = $pfad . $date . "_Backup.tar.gz";

$backupstringsql =  "sudo /usr/bin/mysqldump " . $db[db] . " -u " . $db[username] . " --password=" . $db[password] . " > " . $dateinamesql;
$backupstringtar = "sudo tar -cvzf " . $dateinametar . " " . $pfadtar . " --exclude=" . $dateinametar;



#exec("sudo /usr/bin/mysqldump ".$db['db']." -u ".$db['username']." --password=".$db['password']."" > backup/".$dateiname . " 2>&1 >> /tmp/output.txt"); 
#echo $backupstringtar;
exec($backupstringsql);
exec($backupstringtar);
?> 