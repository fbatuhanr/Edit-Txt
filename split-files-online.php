<?php
if( isset($_POST['submitsplit']) ) {

$fileTemporaryName = $_FILES["thisfile"]["tmp_name"];

$thisUserFolder = "split_".date("d-m-Y_H-i-s_").round(microtime(true) * 1000);
$destinationPath = getcwd().DIRECTORY_SEPARATOR."uploads/";

if (!file_exists($destinationPath.$thisUserFolder))
mkdir($destinationPath.$thisUserFolder, 0777, true);

$newDestinationPath = $destinationPath.$thisUserFolder."/";
$targetPath = $newDestinationPath.basename(TurkishCharConverter($_FILES["thisfile"]["name"]));


   if ($_FILES["thisfile"]["error"]) echo "<font color='green'>Error : ".$_FILES["thisfile"]["error"]."</font>";
   else {
	    if (move_uploaded_file($fileTemporaryName, $targetPath)) {
	    	echo "<font color='green'>File uploaded successfully</font>";
	    	SplitThisFileWithThisNumber($newDestinationPath, $targetPath, $_POST["splitcount"]);
	    }
	    else echo "<font color='red'>File upload failed.</font>";
   }
}
?>



<div id="files-header">
	<h1>Split Txt Files Online</h1>
</div>

<div class="container files-container">
	<div class="row">
	<div class="col-md-8 col-md-offset-2">
	  <form name="yukleme" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
	  	<p class="table-mobile-swipe-information">If the table not fit on the screen, <br> you can swipe left the table.</p>
	  	<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><h4>Select TXT File</h4></th>
						<th><h4>Split Count</h4></th>
					</tr>
				</thead>
			    <tbody>
			      <tr>
			        <td align="center">
						<input type="file" name="thisfile" id="thisfile" class="form-control-file fileinput" required />
					</td>
					<td align="center">
						<button type="button" id="countminus" disabled></button>
						<input type="number" min="1" max="999" value="1" name="splitcount" id="splitcount" class="form-control" required readonly />
						<button type="button" id="countplus" disabled></button>
						<div class="clearboth"></div>
					</td>
			      </tr>
			      <tr>	  	  	
			        <td colspan="2" align="center">
			        	<button type="submit" name="submitsplit" id="submitsplit" class="filesformsubmit-btn btn btn-success mb-2" readonly/>SPLIT AND DOWNLOAD!</button>
			        </td>
			      </tr>
			    </tbody>
	    	</table>
	    </div>
	   </form>
	</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("input#thisfile").change(function (){

			$("button#countminus").removeAttr("disabled");
			$("button#countplus").removeAttr("disabled");
			$("input#splitcount").removeAttr("readonly");
	    });

	    $("button#countplus").click(function(){
	    	var resultVal = parseInt($("input#splitcount").val()) < 999 ? parseInt($("input#splitcount").val())+1 : $("input#splitcount").val();
	    	$("input#splitcount").val(resultVal);
		});

	    $("button#countminus").click(function(){
	    	var resultVal = parseInt($("input#splitcount").val()) > 1 ? parseInt($("input#splitcount").val())-1 : $("input#splitcount").val();
	    	$("input#splitcount").val(resultVal);
		});
	});
</script>



<?php


function SplitThisFileWithThisNumber($filesFolderPath, $thisFilePath, $splitingNumber){

	$mainUploadPath = $filesFolderPath;
	$theFile = $thisFilePath;

	$txtFileLineCount = count(file($theFile));
	$splitHowManyFiles = intval($splitingNumber);

	$dividedFileLineCount = ceil($txtFileLineCount / $splitHowManyFiles);

	$openedThisFile = fopen($theFile, "r");

	$zipName = "splitted_files.zip";
	$zipPathAndName = $mainUploadPath.$zipName;
	$zip = new ZipArchive;
	if ($zip->open($zipPathAndName, ZipArchive::CREATE) === TRUE)
	{
		for ($splitCounter = 0; $splitCounter < $splitHowManyFiles; $splitCounter++) {

			$newFile = $mainUploadPath."splitted_file_".($splitCounter+1).".txt";
			$openedNewFile = fopen($newFile, "w") or die("Unable to open file!");

			for ($dividedLineCounter = 0; $dividedLineCounter < $dividedFileLineCount; $dividedLineCounter++) {

				fwrite($openedNewFile, fgets($openedThisFile));
			}

			fclose($openedNewFile);
			$newFileName = substr($newFile,strrpos($newFile,'/') + 1);
			$zip->addFile($newFile,$newFileName);
		}
	    $zip->close();

		if(file_exists($zipPathAndName)){
	        header('Content-type: application/zip');
	        header('Content-Disposition: attachment; filename="'.$zipName.'"');
	    	header("Pragma: no-cache");
	    	header("Expires: 0");
	        ob_clean();
	        flush();
	        readfile($zipPathAndName);

			$allFilesForRemove = glob($mainUploadPath."*");
			foreach($allFilesForRemove as $removingFile){
			  if(is_file($removingFile))
			    unlink($removingFile);
			}
			rmdir($mainUploadPath);
	    	exit;
		}
	}
	fclose($openedThisFile);

}

?>