<!DOCTYPE html>
<html>
<head>
<style>
#next{
	display:none;
}
h1,h2,p{
	margin:auto;
	display:table;
	background:#f1f3f4;
	margin-top:.5em;
	margin-bottom:.7em;
	padding:.7em;
	border-radius:.5em;
	min-width:50%;
	max-width:85%;
}

/*table{
	max-width:90%;
	margin:auto;
}

td:nth-child(odd){
	background:#f4fbff;
}*/

tr:nth-child(odd){
	background:#f6fdff;
}
</style>
<meta charset="UTF-8">
</head>
<body>
<?php
if (isset($_GET['book'])){
    $file_path  = $_REQUEST['book'];
    $path_parts = pathinfo($file_path);
    $file_name  = $path_parts['filename'];
    $pathtofile=$_SERVER["DOCUMENT_ROOT"]."/csv" ;
    $targetfile=$pathtofile."/".$file_name.".csv";
    $csv = array_map('str_getcsv',file($targetfile));
    $activated=true;
    $acount=-1;
    $votable=true;
    $vcount=-1;
    $lcount=0;
    foreach($csv as $line){
        if (strtolower($line[0])=="activated"){
		    if (!(strpos($line[1],"n")===false)){
                $activated=false;
                $acount=$lcount;
            }
	    }
        if (strtolower($line[0])=="votable"){
		    if (!(strpos($line[1],"n")===false)){
                $votable=false;
                $vcount=$lcount;
            }
        }
        if (strtolower($line[0])=="text start"){
		    break;
        }

        $lcount=$lcount+1;
    }
    if (isset($_POST['makeactive'])){
        $fp = fopen($targetfile, 'w');
        fputcsv($fp, $csv[0]);
        $tweena=false;
        $tweenv=false;
        if (isset($_POST['breaksub'])){
            if ($acount>=0){
                $csv[$acount][1]="no";
            }else{
                fputcsv($fp, ["Activated","no"]);
            }
        }else{
            if ($acount>=0){
                $csv[$acount][1]="yes";
            }else{
                fputcsv($fp, ["Activated","yes"]);
            }
        }
        if (isset($_POST['breakvote'])){
            if ($vcount>=0){
                $csv[$vcount][1]="no";
            }else{
                fputcsv($fp, ["Votable","no"]);
            }
        }else{
            if ($vcount>=0){
                $csv[$vcount][1]="yes";
            }else{
                fputcsv($fp, ["Votable","yes"]);
            }
        }

        foreach(array_slice($csv,1) as $line){
            fputcsv($fp,$line);
        }
        fclose($fp);
    }else{
        echo "<form method='post'><input type='hidden' name='makeactive'><p><label>Disable translating for ".$file_name.".csv ?<input type='checkbox' name='breaksub'".(($activated)?"":" checked='checked'")."></label></p><p><label>Disable voting for ".$file_name.".csv ?<input type='checkbox' name='breakvote'".(($votable)?"":" checked='checked'")."></label></p><p><input type='submit' value='Submit'></p>";
    }
}
?>

</body>