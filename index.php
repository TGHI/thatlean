<?php 
/**
 * @package     thatlean
 *
 * @copyright   Copyright (C) 2014 Justin Renaud (tghidsgn.com)
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
defined('_JEXEC') or die;

$templatePath = JURI::base() . "templates/" . $this->template;

?>
<!doctype html>
<html lang="en-us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>test</title>
<link href="<?php echo $templatePath ?>/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo $templatePath ?>/css/bootstrap-theme.min.css" rel="stylesheet" />
<link href="<?php echo $templatePath ?>/css/style.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Libre+Baskerville:400,700,400italic|Oswald:700,400,300' rel='stylesheet' type='text/css'>
<script src="<?php echo $templatePath ?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $templatePath ?>/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $templatePath ?>/js/skrollr.js" type="text/javascript"></script>
<script src="<?php echo $templatePath ?>/js/scripts.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
	<section>
		<jdoc:include type="component" />
	</section>
</div>
<script type="text/javascript">
	skrollr.init({
		forceHeight: false
	});
	</script>
</body>
</html>