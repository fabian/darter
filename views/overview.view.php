<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Overview (<?php echo $this->project; ?>)</title>
<link rel="stylesheet" type="text/css" href="stylesheets/screen.css" />
</head>
<body id="overview">

<div class="page">
<p class="title"><?php echo $this->project; ?></p>

<h1>Overview</h1>

<div class="section description odd">
<h2 class="label">Description</h2>
<p class="content"><?php echo $this->description; ?></p>
</div>

<div class="section packages">
<h2 class="label">Packages</h2>
<ul class="content">
<li><a href="package.php?package=foo">anomey</a></li>
<li><a href="package.php?package=foo">anomey.test</a></li>
<li><a href="package.php?package=foo">anomey.service</a></li>
<li><a href="package.php?package=foo">anomey.service.rest</a></li>
</ul>
</div>

<div class="section interfaces odd">
<h2 class="label">Interfaces</h2>
<ul class="content">
<?php foreach($this->interfaces as $interface): ?>
<li>
	<a href="detail.php?class=<?php echo $interface->getName(); ?>"><?php echo $interface->getName(); ?></a>
</li>
<?php endforeach; ?>
</ul>
</div>

<div class="section classes">
<h2 class="label">Classes</h2>
<ul class="content">
<?php $this->show('tree', $this->classes); ?>
</ul>
</div>

<hr />

<?php $this->show('menu'); ?>

</div>

</body>
</html>