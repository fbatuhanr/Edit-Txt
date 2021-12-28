<?php
if( isset($_POST['submitmerge']) ) {

	$createdFolderPath = CreateFolderAndGetPath("merge");
	$createdAndOpenedMergeFile = CreateTxtFileInFolderAndOpen($createdFolderPath, "merged_files");
	
	$filesOrderedNums = explode("-", $_POST['filesordernumbered']);
		foreach($filesOrderedNums as $thisOrderNum)
		{
			$tmpFilePath = $_FILES['thesefiles']['tmp_name'][$thisOrderNum];

			if ($tmpFilePath != "") {

				$tmpFileContent = file_get_contents($_FILES['thesefiles']['tmp_name'][$thisOrderNum]);
				fwrite($createdAndOpenedMergeFile, $tmpFileContent.PHP_EOL);
			}
		}
	fclose($createdAndOpenedMergeFile);

	DownloadTxtFileAndRemoveFolder("merged_files", $createdFolderPath);
}

function CreateFolderAndGetPath($folderRootName = "folder"){
	
	$folderDestinationPath = getcwd().DIRECTORY_SEPARATOR."uploads/";
	$thisUserFolderName = $folderRootName.date("_d-m-Y_H-i-s_").round(microtime(true) * 1000);

	$folderPathAndName = $folderDestinationPath.$thisUserFolderName;

	if (!file_exists($folderPathAndName))
	mkdir($folderPathAndName, 0777, true);

	$createFolderDestinationPath = $folderPathAndName."/";

	return $createFolderDestinationPath;
}
function CreateTxtFileInFolderAndOpen($fileCreationPath = "uploads/", $fileName = "file"){

 	$filePathAndName = $fileCreationPath.$fileName;

    $createFile = fopen($filePathAndName, "a") or die("Something went wrong!");

    return $createFile;
}
function DownloadTxtFileAndRemoveFolder($fileName, $fileFolderPath){
	
	$filePathAndName = $fileFolderPath.$fileName;
	if(file_exists($filePathAndName)) {
	    
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.$fileName.'.txt"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($filePathAndName));
	        ob_clean();
	        flush();
	    readfile($filePathAndName);

		$allFilesForRemove = glob($fileFolderPath."*");
		foreach($allFilesForRemove as $removingFile){
		  if(is_file($removingFile))
		    unlink($removingFile);
		}
		rmdir($fileFolderPath);
		exit;
	}
}
?>

<div id="files-header">
	<h1>Merge Txt Files Online</h1>
</div>

<div class="container files-container">
	<div class="row">
	<div class="col-md-8 col-md-offset-2">
	  <form name="yukleme" id="mergeform" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
	  	<p class="table-mobile-swipe-information">If the table not fit on the screen, <br> you can swipe left the table.</p>
	  	<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><h4>Select Multiple TXT Files</h4></th>
						<th><h4>Order of Files</h4></th>
					</tr>
				</thead>
			    <tbody>
			      <tr>
			        <td align="center">
						<input name="thesefiles[]" type="file" id="thesefiles" class="form-control-file fileinput" multiple="multiple" required />
					</td>
					<td align="center"><b>#</b><input type="hidden" name="filesordernumbered" id="filesordernumbered"></td>
			      </tr>	
			    </tbody>
			    <tbody class="filesorder">
			    </tbody>
			    <tbody>      
			      <tr>	  	  	
			        <td colspan="2" align="center">
			        	<button type="submit" name="submitmerge" id="submitmerge" class="filesformsubmit-btn btn btn-success mb-2">COMBINE AND DOWNLOAD!</button>
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

		$("#main .files-container input#thesefiles").change(function (){
			var filesOrderUpButtonHtml = "<button class=\"orderupbtn\" type=\"button\">&#8679;</button>";
			$("#main .files-container table tbody.filesorder").empty();
		    for (var i = 0; i < $(this).get(0).files.length; ++i) {

		    	var filesOrderNumberHtml = "<span class=\"fileordernumb\">" + (i+1) + ")</span>";
		    	var filesOrderHiddenRealNumberHtml = "<span class=\"fileorderhiddennumb\">" + i + "</span>";
		    	var uploadedFilesNameHtml = "<span class=\"filename\">" + $(this).get(0).files[i].name + "</span>";
		    	var uploadedFilesSizeHtml = "<span class=\"filesize\">" + $(this).get(0).files[i].size + " Bytes</span>";

		    	$("#main .files-container table tbody.filesorder").append("<tr><td>"+filesOrderHiddenRealNumberHtml+filesOrderNumberHtml+"<span class=\"filenamesize-coll\">"+uploadedFilesNameHtml+uploadedFilesSizeHtml+"</div></td><td>"+filesOrderUpButtonHtml+"</td></tr>");
		    }
		});


  		$("#main .files-container table").on("click","button.orderupbtn",function(){
			
			var row = $(this).closest('tr');
			row.insertBefore( row.prev() );

			$("#main .files-container table tbody.filesorder tr td span.fileordernumb").each(function(ind){
				$(this).text((ind+1) + ")");
			});
		});

		$("#main .files-container form#mergeform").submit(function(){

			var filesOrderNumbered = "";
			$(this).find("tbody.filesorder span.fileorderhiddennumb").each(function(){
				filesOrderNumbered += $(this).text() + "-";
			});
			$(this).find("input#filesordernumbered").val(filesOrderNumbered.slice(0,-1));
		});

	});
</script>