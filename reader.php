<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ante toki pona - lukin</title>
<meta property="og:title" content="ante toki pona - lukin" />
<meta property="og:image" content="http://antetokipona.infinityfreeapp.com/ante-toki-pona.png" />

	<!-- ****** faviconit.com Favicons ****** -->
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
	<link rel="apple-touch-icon" href="/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/favicon-144.png">
	<meta name="msapplication-config" content="/browserconfig.xml">
	<!-- ****** faviconit.com Favicons ****** -->
<script>

var tbl=document.body;
var trs=[0,0];
var hadtrs=[];

function next(){
document.getElementById("next").style.display="block";
document.getElementById("start").style.display="none";
var tbl=document.getElementById("tbl");
window.scrollTo(0,0);
}

function more(){
	if (hadtrs.length<trs.length-1){
tbl=document.getElementById("tbl");
trs=tbl.getElementsByTagName("tr");
var randnr=-1;
while ((randnr>trs.length) || (randnr<=0) || (hadtrs.includes(randnr))){
	var randnr=Math.floor(Math.random() * trs.length);
}
hadtrs.push(randnr);
for (i=1;i<trs.length;i++){
	if (i==randnr){
		trs[i].style.display="table-row";
		trs[i].childNodes[1].style.opacity="0%";
		trs[i].childNodes[2].childNodes[0].style.display="block";
	}/*else if ((i==randnr-1)||i==randnr+1){
		trs[i].style.display="table-row";
		trs[i].childNodes[1].style.opacity="100%";
		trs[i].childNodes[2].childNodes[0].style.display="none";
	}*/else{
		trs[i].style.display="none";
	}
}
	}
}
</script>
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
</head>
<body>
<?php
if (isset($_POST['idname'])){
    $idname=$_POST["idname"];
    $file_path  = $_REQUEST['book'];
$path_parts = pathinfo($file_path);
$file_name  = $path_parts['filename'];
$pathtofile=$_SERVER["DOCUMENT_ROOT"]."/csv" ;
$targetfile=$pathtofile."/".$file_name.".csv";
$votefile=$pathtofile."/".$file_name."_vote.csv";

    if (isset($_POST['lines'])){
        $lines=$_POST['lines'];
        
        if (file_exists($votefile)) {
            //$csvote=array_map('str_getcsv',array_map("utf8_encode", file($votefile)));
            $csvote = array_map('str_getcsv', file($votefile));
            $named=array_search($idname,$csvote[0]);
            copy ($votefile,$pathtofile."/archive/".$file_name."_vote".time().".csv");
            $fp = fopen($votefile,"w");
            $linec=1;
            if (($named===false)){
                $named=count($csvote[0]);
                array_push($csvote[0],$idname);
                fputcsv($fp,$csvote[0]);
                foreach($lines as $litem){
                    array_push($csvote[$linec],$litem);
                    fputcsv($fp,$csvote[$linec]);
                    $linec=$linec+1;
                }
            }else{
                fputcsv($fp,$csvote[0]);
                foreach($lines as $litem){
                    $csvote[$linec][$named]=$litem;
                    fputcsv($fp,$csvote[$linec]);
                    $linec=$linec+1;
                }
            }
            
            
        }else{
            $fp = fopen($votefile,"w");
            fputcsv($fp,array($idname));
            foreach($lines as $litem){
                fputcsv($fp,array($litem));
            }
        }
        
        fclose($fp);
        echo "<p>Thank you for your submission.</p>";
    }else{

//$csv = array_map('str_getcsv',array_map("utf8_encode", file($targetfile)));
$csv = array_map('str_getcsv', file($targetfile));
$votable=true;

if (file_exists($votefile)) {
    //$csvote=array_map('str_getcsv',array_map("utf8_encode", file($votefile)));
    $csvote = array_map('str_getcsv', file($votefile));
    $named=array_search($idname,$csvote[0]);
}else{
    $named=false;
}
$linec=0;
    echo "<form method='post'><table id='tbl'><tbody>";
$header=true;
foreach($csv as $line){
    $rowc=0;
	echo "<tr>";
    
	if($header){
		echo "<th>counter</th>";
	}else{
		$filtercounter = count(array_filter(array_slice($line,3), function($it) {
						// check for empty strings as 0 for example is a valid value
						return $it !== '';
					}));
		echo "<td>".$filtercounter."<input type='radio' name='lines[".$linec."]' value='0' style='display:none;'".(($named!==false)?(($csvote[$linec][$named]==$rowc)?" checked='checked'":""):" checked='checked'")."></td>";
	}
	foreach ($line as $ritem){
		if ($header){
			echo "<th>".$ritem."</th>";
		}else{
		    echo "<td><label>".$ritem.(($rowc>2)?((strlen($ritem)>0)?"<input type='radio' name='lines[".$linec."]' value='".$rowc."'".(($named!==false)?(($csvote[$linec][$named]==$rowc)?" checked='checked'":""):"").">":""):"")."</label></td>";
		}
        $rowc=$rowc+1;
	}
	echo "</tr>";
    $header=false;
    $linec=$linec+1;
}
echo "</tbody></table><input type='hidden' name='idname' value='".$idname."'><p><input type='submit' value='Next'></p></form>";
}
}else{
echo "<form method='post'>
<p>On the following page, you'll be able to read and vote on translations.</p><p><label>What is your name?* <input type='text' name='idname'></label><p><input type='submit' value='Next'></p></form>";
}

?>

</body>