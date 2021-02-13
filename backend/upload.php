<?php
if (isset($_FILES["fileToUpload"])){
$FileName=explode(".",basename($_FILES["fileToUpload"]["name"]))[0];
$pathtofile=$_SERVER["DOCUMENT_ROOT"]."/csv" ;
$target_file = $pathtofile."/".$FileName.".csv";
$titles=$pathtofile."/titles.csv";
$uploadOk = 0;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$csv = array_map('str_getcsv', file($_FILES["fileToUpload"]["tmp_name"]));
foreach($csv as $line){
	$el=strtolower($line[0]);
	if ($el=="author/copyright"){$author=$line[1];}
	if ($el=="title"){$title=$line[1];}
	if ($el=="link"){$link=$line[1];}
	if ($el=="text start"){
        $uploadOk = 1;
		break;
	}
}
$titleline=array($FileName,$title,$author,$link);

if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                $uploadOk = 0;

        }else{

if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "csv") {
    echo "Sorry, only CSV files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$fp = fopen($titles, 'a');
		fputcsv($fp,$titleline);
		fclose($fp);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
		}
}
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data" style="margin:auto;display:table;margin-top:10vh;">
Select CSV file to upload:<br><br>
<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
<input type="submit" value="Upload CSV" name="submit">
</form>

</body>
</html>
