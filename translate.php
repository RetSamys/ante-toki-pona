<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>ante toki pona - pali</title>
<meta property="og:title" content="ante toki pona - pali" />
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

function back(){
document.getElementById("start").style.display="block";
document.getElementById("next").style.display="none";
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
		trs[i].childNodes[1].style.opacity="100%";
		trs[i].childNodes[2].childNodes[0].style.display="block";
	}else if ((i==randnr-1)||i==randnr+1){
		trs[i].style.display="table-row";
		trs[i].childNodes[1].style.opacity="0%";
		trs[i].childNodes[2].childNodes[0].style.display="none";
	}else{
		trs[i].style.display="none";
	}
}
	}
}
</script>
<style>
body{
}
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
    clear:all;
}

table{
	max-width:90%;
	margin:auto;
}

th{
	background:#9acfdf;
}

td:nth-child(odd){
	background:#f1f3f4;
	min-width:40vw;
	padding:.4em;
}

td:nth-child(even){
	max-width:9%;
	text-align:center;
}

a{
	color:#107896;
}

textarea{
	width: 90%;
	margin: auto;
}

.book{
	background:#f1f3f4;
	margin-left:2em;
	margin-top:.5em;
	margin-bottom:.7em;
	padding:.7em;
	border-radius:.5em;
	float:left;
}

@media only screen and (max-width: 800px) {
table{
    max-width:100%;
    width:100%;
}

tr th, tr td {
    display: block;
}

tr td:nth-child(1){
    border-top: 2px solid black;
}

}
</style>
</head>
<body>

<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
$pathtofile=$_SERVER["DOCUMENT_ROOT"]."/csv" ;
if (isset($_GET['book'])){
	
// sanitize the file request, keep just the name and extension
// also, replaces the file location with a preset one ('./myfiles/' in this example)
$file_path  = $_GET['book'];
$path_parts = pathinfo($file_path);
$file_name  = $path_parts['filename'];
$targetfile=$pathtofile."/".$file_name.".csv";
//$csv = array_map('str_getcsv',array_map("utf8_encode", file($targetfile)));
$csv = array_map('str_getcsv', file($targetfile));
$title="";
$author="";
$link="";
$cw="";
$translationnotes="";
$textnotes="";
$textlines=false;
$rando=false;
$activated=true;
$votable=true;
foreach($csv as $line){
	$el=strtolower($line[0]);
	if ($el=="author/copyright"){$author=$line[1];}
	if ($el=="title"){$title=$line[1];}
	if ($el=="link"){$link=$line[1];}
	if ($el=="cw notes"){$cw=$line[1];}
	if ($el=="translation notes"){$translationnotes=$line[1];}
	if ($el=="text notes"){$textnotes=$line[1];}
	if ($el=="randomized"){
		if (!(strpos($line[1],"y")===false)){$rando=true;}
	}
    if ($el=="activated"){
		if (!(strpos($line[1],"n")===false)){$activated=false;}
	}
    if ($el=="votable"){
		if (!(strpos($line[1],"n")===false)){$votable=false;}
	}
	if ($el=="text start"){
		break;
	}
}
if (isset($_GET['random'])){
    if($rando){
        $rando=false;
    }else{
        $rando=true;
    }
}
echo "<h2>".$title."</h2><p>".$author."<br><a href='".$link."' target='_blank'>[full text]</a></p>";
if ($activated){
    echo '<form method="post">';

if (isset($_POST["copyright"]) and isset($_POST["idname"])){
	$idname=$_POST["idname"];
    if(strtolower($idname)=="translation" or strtolower($idname)=="original" or strtolower($idname)=="final"){
        echo "<p>Sorry, that name is reserved.</p>";
    }else{
	if (strlen($idname)>1 and !((strtolower($idname)=="translation") or (strtolower($idname)=="original"))){
		echo "<div id='start'><p>Before we begin, here are some terms and/or proper names that appear with some frequency. You may fill those out later if you like.</p><table><tbody><tr><th>original</th><th>count</th><th>translation</th></tr>";
		$textlines=false;
		$key=array_search($idname,$csv[0]);
		foreach($csv as $line){
			$filtercounter = count(array_filter(array_slice($line,3), function($it) {
						// check for empty strings as 0 for example is a valid value
						return $it !== '';
					}));
			$final=$line[2];
			if ($textlines){
				if(strlen($final)>0){
					if ($key){
						echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='textline[]'>".$line[$key]."</textarea></td>";
					}else{
						echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='textline[]'>".$final."</textarea></td>";
					}
				}else{
					if ($key){
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='textline[]'>".$line[$key]."</textarea></td>";
					}else{
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='textline[]'></textarea></td>";
					}
				}
			}else{
				$el=strtolower($line[0]);
				if ($el=="predefine"){
					if(strlen($final)>0){
						if ($key){
							echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='predefine[]'>".$line[$key]."</textarea></td>";
						}else{
							echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='predefine[]'>".$final."</textarea></td>";
						}
					}else{
						
					if ($key){
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='predefine[]'>".$line[$key]."</textarea></td>";
					}else{
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='predefine[]'></textarea></td>";
					}
					}
				}
				if ($el=="text start"){
					$textlines=true;
					echo "</tbody></table><p><button onclick='next();".(($rando)?"more();":"")."return false;'>Next</button></p></div><div id='next'><table id='tbl'><tbody><tr><th>original</th><th>count</th><th>translation</th></tr>";
					if(strlen($final)>0){
					if ($key){
						echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='textline[]'>".$line[$key]."</textarea></td>";
					}else{
						echo "<tr><td>".$line[1]."</td><td></td><td><textarea name='textline[]'>".$final."</textarea></td>";
					}
				}else{if ($key){
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='textline[]'>".$line[$key]."</textarea></td>";
					}else{
						echo "<tr><td>".$line[1]."</td><td>".($filtercounter)."</td><td><textarea name='textline[]'></textarea></td>";
					}
				}
				}
			}
		}
	}
	echo "</tbody></table>".(($rando)?"<p><button onclick='more();return false;'>More</button></p>":"")."<p><button onclick='back();return false;'>Back</button></p><p><input type='hidden' value='".$idname."' name='idname'><input type='submit' value='Submit all'></p></div>";
}
}elseif (isset($_POST["predefine"])){
	$idname=$_POST["idname"];
	$predefine=$_POST["predefine"];
	$textline=$_POST["textline"];
	$key=array_search($idname,$csv[0]);
	$pushcounter=0;
	if ($key){
		foreach($csv as &$line){
			if ($textlines){
				$line[$key]=str_replace(array("\r", "\n"), '<br>', $textline[$pushcounter]);
				$pushcounter=$pushcounter+1;
			}else{
				$el=strtolower($line[0]);
				if ($el=="predefine"){
					$line[$key]=str_replace(array("\r", "\n"), '<br>', $predefine[$pushcounter]);
					$pushcounter=$pushcounter+1;
				}
				if ($el=="text start"){
					$pushcounter=0;
					$line[$key]=str_replace(array("\r", "\n"), '<br>', $textline[$pushcounter]);
					$pushcounter=$pushcounter+1;
					$textlines=true;
				}
			}
		}
	}else{
		array_push($csv[0],$idname);
		foreach($csv as &$line){
			if ($textlines){
				array_push($line,str_replace(array("\r", "\n"), '<br>', $textline[$pushcounter]));
				$pushcounter=$pushcounter+1;
			}else{
				$el=strtolower($line[0]);
				if ($el=="predefine"){
					array_push($line,str_replace(array("\r", "\n"), '<br>', $predefine[$pushcounter]));
					$pushcounter=$pushcounter+1;
				}
				if ($el=="text start"){
					$pushcounter=0;
					array_push($line,str_replace(array("\r", "\n"), '<br>', $textline[$pushcounter]));
					$pushcounter=$pushcounter+1;
					$textlines=true;
				}
			}
		}
	}
	copy ($targetfile,$pathtofile."/archive/".$file_name.time().".csv");
	$fp = fopen($targetfile, 'w');
    //fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
	foreach ($csv as $liner){
		fputcsv($fp, $liner);
	}
	fclose($fp);
	echo "<p>Thank you for your submission. ".(($votable)?": You can check out the progress and vote here: <a href='reader.php?book=".$file_name."'>[submissions]</a>":"")."</p>";
}else{
	echo "<div id='start'>".((strlen($textnotes)>1)?"<p>".$textnotes."</p>":"").((strlen($cw)>1)?"<p><b>Content warning:</b> ".$cw."</p>":"")."<p><button onclick='next();return false;'>Next</button></p></div><div id='next'><p><label>What is your name?* <input type='text' name='idname'></label><p><label>By clicking this box, you submit your translation under a Creative Commons Attribution (CC-BY) licence:* <input type='checkbox' name='copyright'></label><br>Under this licence, you give anyone the right to <br>share <br>and adapt <br>your submission, under the following terms:<br>correct attribution<br>no additional restricitons<br><a href='https://creativecommons.org/licenses/by/4.0/' target='_blank'>Click here to learn more about CC-BY</a></p><p><input type='submit' value='Next'></p></div>";
    echo "<p>* required</p>";
}
echo "</form>";
}else{echo "Submissions to this project are currently closed. However, you can check out the progress".(($votable)?" and vote":"")." here: <a href='reader.php?book=".$file_name."'>[submissions]</a>";}
}else{
	echo "<h2>Available projects</h2><div id='start'>";
    $nextelem="";
	$targetfile=$pathtofile."/titles.csv";
	//$csv = array_slice(array_map('str_getcsv',array_map("utf8_encode", file($targetfile))),1);
    $csv = array_slice(array_map('str_getcsv', file($targetfile)),1);
	foreach($csv as $book){
		$title=$book[1];
		$author=$book[2];
		$link=$book[3];
		$project=$book[0];
        $targetfile_book=$pathtofile."/".$project.".csv";
        //$csvb= array_slice(array_map('str_getcsv',array_map("utf8_encode", file($targetfile_book))),1);
        $csvb= array_slice(array_map('str_getcsv', file($targetfile_book)),1);
        $contributorc=count(array_map('str_getcsv', file($targetfile_book))[0])-3;
        $totalc=0;
        $finalc=0;
        $contc=0;
        $text=false;
        foreach($csvb as $line){
            if($text){
                $totalc=$totalc+1;
                if (!($line[2]=="")){
                    $finalc=$finalc+1;
                }
                $filterc=count(array_filter(array_slice($line,3), function($it) {
						// check for empty strings as 0 for example is a valid value
						return $it !== '';
					}));
                if ($filterc>0){$contc=$contc+1;}
            }else{
                if (strtolower($line[0])=="text start"){
                    $text=true;
                    $totalc=$totalc+1;
                if (!($line[2]=="")){
                    $finalc=$finalc+1;
                }
                $filterc=count(array_filter(array_slice($line,3), function($it) {
						// check for empty strings as 0 for example is a valid value
						return $it !== '';
					}));
                if ($filterc>0){$contc=$contc+1;}
                }
            }
        }
		$elem="<div class='book'><b>".$title."</b><br>by ".$author."<br><a href='".$link."' target='_blank'>[link to full text]</a><br><br>Translation units: ".$totalc."<br>Contributors: ".($contributorc)."<br>Contribution progress: ".(100*$contc/$totalc)."%<br>Final progress: ".(100*$finalc/$totalc)."%<br><br>Want to help with the translation?<br><a href='translate.php?book=".$project."'>click here</a></div>";
        if(($finalc/$totalc)==1){$nextelem.=$elem;}else{echo $elem;}
	}
    echo "<p><button onclick='next();return false;'>Show completed projects</button></p></div><div id='next'>".$nextelem."<p><button onclick='back();return false;'>Show uncompleted projects</button></p></div>";
}
?>

</body>
</html>