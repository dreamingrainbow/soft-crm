<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title><?= strip_tags(html_entity_decode($page->get('title|pagetitle|headline|title'))); ?></title>
        <link rel="shortcut icon" href="<?php echo $config->urls->files."images/ddplus.ico"; ?>">
        <!--
        <link rel="icon" href="<?php //echo $config->urls->files; ?>images/park-icon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="<?php //echo $config->urls->files; ?>images/park-icon.png"> 
		-->
		<meta name="description" content="<?php echo $page->summary; ?>" />
        <?php foreach($config->styles->unique() as $css) : ?>
        	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>" />
        <?php endforeach; ?>

        <script src="<?= hashtemplatefile('scripts/libs/jquery.js'); ?>"></script>
		<script src="<?= hashtemplatefile('scripts/libs/moment.js'); ?>"></script>
		<script>moment().format();</script>
		<?php include $config->paths->content.'common/phpjs/js-config.js.php'; ?>
	</head>
    <body class="fuelux">
		<?php include ($config->paths->content.'nav/nav-yt.php'); ?>
        <div class="container"><?php include $config->paths->content.'nav/yt-navigation.php';?></div>

        <br>
