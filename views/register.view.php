<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Register (anomey 2.1)</title>
<link rel="stylesheet" type="text/css" href="stylesheets/screen.css" />
</head>
<body id="register">

<div class="page">
<p class="title">anomey 2.1</p>

<h1>Register</h1>

<!-- <p><?php foreach($this->index as $letter => $elements): ?>
<a href="#<?php echo $letter; ?>"><?php echo $letter; ?></a>
<?php endforeach; ?></p> --> 

<?php foreach($this->index as $letter => $elements): ?>
<div class="section classes <?php $this->odd(); ?>">
<h2 class="label" id="<?php echo $letter; ?>"><?php echo $letter; ?></h2>
<ul class="content">
<?php foreach($elements as $element): ?>
	<?php switch(true):	case ($element instanceof ReflectionMethod): ?>
		<li>
			<a href="detail.php?class=<?php echo $element->getDeclaringClass()->getName() . '#' . $element->getName(); ?>"><?php echo $element->getName(); ?>()</a> in 
			<a href="detail.php?class=<?php echo $element->getDeclaringClass()->getName(); ?>"><?php echo $element->getDeclaringClass()->getName(); ?></a>
		</li>
		<?php break; default: ?>
		<li><a href="detail.php?class=<?php echo $element->getName(); ?>"><?php echo $element->getName(); ?></a></li>
	<?php endswitch; ?>
<?php endforeach; ?>
</ul>
</div>
<?php endforeach; ?>

<hr />

<?php $this->show('menu'); ?>

</div>

</body>
</html>