<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Overview (anomey 2.1)</title>
<link rel="stylesheet" type="text/css" href="stylesheets/screen.css" />
</head>
<body id="overview">

<div class="page">
<p class="title">anomey 2.1</p>

<h1>Overview</h1>

<div class="section classes odd">
<h2 class="label">Classes</h2>
<ul class="content">
<?php foreach($this->classes as $class): ?>
	<li><a href="detail.php?class=<?php echo $class; ?>"><?php echo $class ?></a></li>
<?php endforeach; ?>
</ul>
</div>

<hr />

<?php include 'menu.view.php'; ?>

</div>

</body>
</html>