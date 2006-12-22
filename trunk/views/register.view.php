<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Classes (anomey 2.1)</title>
<link rel="stylesheet" type="text/css" href="stylesheets/screen.css" />
</head>
<body id="register">

<div class="page">
<p class="title">anomey 2.1</p>

<h1>Register</h1>

<?php foreach($this->index as $letter => $classes): ?>
<div class="section classes <?php $this->odd(); ?>">
<h2 class="label"><?php echo $letter; ?></h2>
<ul class="content">
<?php foreach($classes as $class): ?>
	<li><a href="detail.php?class=<?php echo $class->getName(); ?>"><?php echo $class->getName(); ?></a></li>
<?php endforeach; ?>
</ul>
</div>
<?php endforeach; ?>

<hr />

<?php $this->show('menu'); ?>

</div>

</body>
</html>