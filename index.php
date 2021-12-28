<?php require 'config.php'; ?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Edit Txt File! Easy & Fast Way to Online Editing Texts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="Split, combine and more for your text files. Free, easy and fastest way to online txt file editing. You can edit online your txt now with detailed customizable options..">
  <meta name="author" content="Edit Txt">

  <script src="jquery-3.4.1.min.js"></script>
  <script src="typed.min.js"></script>

  <link rel="stylesheet" href="bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">

	<?php $pageAbout = isset($_GET["page"]) ? $_GET["page"] : "";
	if($pageAbout != "about-edittxt" && $pageAbout != ""){ ?>
		<script data-name="BMC-Widget" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="batuhan" data-description="You can support me on Buy me a coffee!" data-message="Hey! You can buy me a coffee for supporting me. -Developer😊" data-color="#5F7FFF" data-position="left" data-x_margin="18" data-y_margin="18"></script>
	<?php } ?>
</head>

<body>

<header>
	<div class="inner-center">

		<div class="logo-coll">
			<a href="<?php echo $mainUrl; ?>" title="Edit Txt">
				<img src="icons/edittxt-logo.png" height="100" width="auto">
				<h1>EDIT TXT</h1>
			</a>
		</div>

		<nav class="menu-coll">
			<ul>
				<li>
					<a href="split-txt-online">
						<img src="icons/EditTxt-split-files.png" height="50" width="auto">
						<p><span>Split</span> Txt Files</p>
					</a>
				</li>

				<li>
					<a href="merge-txt-online">
						<img src="icons/EditTxt-merge-files.png" height="50" width="50">
						<p><span>Merge</span> Txt Files</p>
					</a>
				</li>

				<li>
					<a href="about-edittxt">
						<img src="icons/EditTxt-info.png" height="30" width="30">
						<p>About</p>
					</a>
				</li>

			</ul>
		</nav>

		<div class="clearboth"></div>
	</div>
</header>


<div id="main">
		<?php

		$page = isset($_GET["page"]) ? $_GET["page"] : "";
		$getPage = "";

		switch ($page) {
			case "split-txt-online":
				$getPage = "split-files-online";
				break;
			
			case "merge-txt-online":
				$getPage = "merge-files-online";
				break;

			case "about-edittxt":
				$getPage = "about";
				break;


			default:
				$getPage = "homepage-content";
				break;
		}

		include $getPage.".php";

		?>
</div>


<footer>
	<h5>Copyright © 2021 <a href="<?php echo $mainUrl; ?>" title="Edit Txt">EditTxt.com</a></h5>

</footer>

<script type="text/javascript">
	$(function(){
	$(".typed").typed({
		strings: ["split", "merge", "edit"],
		// Optionally use an HTML element to grab strings from (must wrap each string in a <p>)
		stringsElement: null,
		// typing speed
		typeSpeed: 30,
		// time before typing starts
		startDelay: 1200,
		// backspacing speed
		backSpeed: 20,
		// time before backspacing
		backDelay: 500,
		// loop
		loop: true,
		// false = infinite
		loopCount: 5,
		// show cursor
		showCursor: false,
		// character for cursor
		cursorChar: "|",
		// attribute to type (null == text)
		attr: null,
		// either html or text
		contentType: 'html',
		// call when done callback function
		callback: function() {},
		// starting callback function before each string
		preStringTyped: function() {},
		//callback for every typed string
		onStringTyped: function() {},
		// callback for reset
		resetCallback: function() {}
	});
});

</script>

</body>

</html>


<?php define ('SITE_ROOT', realpath(dirname(__FILE__))); ?>