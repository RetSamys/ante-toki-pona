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
$votefile=$pathtofile."/".$file_name."_vote.csv";
$csv = array_map('str_getcsv', file($targetfile));

    if (isset($_POST['lines'])){
        $lines=$_POST['lines'];
        $linec=1;
        $fp = fopen($targetfile,"w");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($fp,$csv[0]);
        foreach($lines as $line){
            if ($line=="-1"){$csv[$linec][2]="";}
            if ($line>0){$csv[$linec][2]=$csv[$linec][$line]."~~~~".$csv[0][$line];}
            fputcsv($fp,$csv[$linec]);
            $linec=$linec+1;
        }
        fclose($fp);
        echo "<p>Final translation updated!</p>";
    }else{

if (file_exists($votefile)) {
    $csvote=array_map('str_getcsv', file($votefile));
}else{
    $csvote=false;
}
$linec=0;
    echo "<form method='post'><table id='tbl'><tbody>";
$header=true;
foreach($csv as $line){
    $rowc=0;
    if ($line[2]==""){$lempty=true;}else{$lempty=false;}
    $nrow="<tr>";
	if($header){
		$nrow.="<th>counter</th>";
	}else{
		$filtercounter = count(array_filter(array_slice($line,3), function($it) {
						// check for empty strings as 0 for example is a valid value
						return $it !== '';
					}));
		$nrow.="<td>".$filtercounter."<input type='radio' name='lines[".$linec."]' value='0' style='display:none;' checked='checked'></td>";
        if($csvote){echo "<tr><td colspan='4' align='right'>Votes: </td>";}
	}
	foreach ($line as $ritem){
		if ($header){
			$nrow.= "<th>".$ritem."</th>";
		}else{
		    $nrow.="<td><label>".$ritem.(($rowc>2)?"<input type='radio' name='lines[".$linec."]' value='".$rowc."'".(($named!==false)?(($csvote[$linec][$named]==$rowc)?" checked='checked'":""):"").">":"")."</label></td>";
            if(($csvote) and ($rowc>0)){echo "<td>".count(array_keys($csvote[$linec],$rowc))."</td>";}
		}
        
        
        $rowc=$rowc+1;
	}
    if($csvote){echo "</tr>";}
    if(!($lempty)){
        if (!($header)){$nrow.= "<td><label>empty this field <input type='radio' name='lines[".$linec."]' value='-1'></label></td>";}
        }else {$nrow.="<td></td>";}
	$nrow.="</tr>";
    echo $nrow;
    $header=false;
    $linec=$linec+1;
}
echo "</tbody></table><p><input type='submit' value='Next'></p></form>";
}
}

?>

</body>