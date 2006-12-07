<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
<head>
<title><?php echo $this->class->getName(); ?> (anomey 2.1)</title>
<link rel="stylesheet" type="text/css" href="stylesheets/screen.css" />
</head>
<body>

<div class="page">
<p class="title">anomey 2.1</p>

<h1><?php echo $this->class->getType() ?> <?php echo $this->class->getName(); ?></h1>

<div class="section class odd">
<h2 class="label">Information</h2>

<dl class="content">
	<dt>Author</dt>
	<dd><?php echo $this->class->getAnnotation('author') ?></dd>
	<dt>Package</dt>
	<dd>
		
		<?php if ($this->class->getAnnotation('package') != "undefined"): ?>
				<a href="#"><?php echo $this->class->getAnnotation('package') ?></a>
		<?php else: ?>
				<?php echo $this->class->getAnnotation('package'); ?>
		<?php endif; ?>
	</dd>
</dl>
</div>

<div class="section inheritance">
<h2 class="label">Inheritance</h2>

<ul class="content">
	<?php if($parentClass = $this->class->getParentClass()): ?>
		<li>
			<a href="viewClass.php?classname=<?php echo $parentClass->getName(); ?>"><?php echo $parentClass->getName(); ?></a>
		</li>
	<?php else: ?>
		none
	<?php endif; ?>
</ul>
</div>
	<!--<ul>
		<li>ArrayObject
		<ul>
			<li>Collection</li>
		</ul>
		</li>
	</ul>-->
	

<div class="section interfaces odd">
<h2 class="label">Interfaces</h2>

<ul class="content">

<?php if($this->class->getInterfaces()): ?>
	<?php foreach($this->class->getInterfaces() as $interface): ?>
		<li>
			<a href="viewClass.php?classname=<?php echo $interface->getName(); ?>"><?php echo $interface->getName(); ?></a>
		</li>
	<?php endforeach; ?>
<?php else: ?>
	none
<?php endif; ?>
	<!--<li>Countable</li>
	<li>IteratorAggregate</li>
	<li><a href="">SomeCoolInterface</a></li>-->
	
</ul>
</div>

<div class="section description">
<h2 class="label">Description</h2>

<p class="content">Lorem ipsum dolor sit amet, consectetuer
adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis
nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex
ea commodo consequat.</p>
</div>

<div class="section fields odd">
<h2 class="label">Fields</h2>
<?php
//var_dump($inspectionClass->getProperties());
?>
<dl class="content">
<?php foreach($this->class->getProperties() as $property): ?>
		<dt><code><?php echo $property->getModifier(); ?> $<?php echo $property->getName() ?>
		</code></dt>
		<dd>The default value for the integer.</dd>
<?php endforeach; ?>
	<!--<dt><code>const DEFAULT = 42</code></dt>
	<dd>The default value for the integer.</dd>
	<dt><code>public $name = ''</code></dt>
	<dd>The name of the object or the collection.</dd>
	-->
</dl>
</div>

<div class="section methods">
<h2 class="label">Methods</h2>

<div class="content">

<ul>

<?php foreach($this->class->getMethods() as $method): ?>
	
	<li>
		<code>
			<a href="#<?php echo $method->getName(); ?>">
				<?php echo $method->getName(); ?></a>
				<?php $i = 0; ?>
				(<?php foreach($method->getParameters() as $param): ?>
					<?php if($i++ > 0): ?>
						,
					<?php endif; ?>
					$<?php echo $param->getName(); ?>
				<?php endforeach; ?>)
		</code>
	</li>
	
<?php endforeach; ?>
	<!--
	<li><code><a href="">ArrayObject::getFoo</a>(string $value,
	array $access)</code></li>
	<li title="Returns the name of the object or the collection."><code><a
		href="">getName</a>(string $value)</code></li>-->
</ul>
<?php foreach($this->class->getMethods() as $method): ?>
<h3 id="<?= $method->getName(); ?>"><?= $method->getName(); ?>
				(<?php
				$first = true;
				foreach($method->getParameters() as $param) {
					if($first) {
						$first = false;
					}
					else {
						echo ", ";
					}
					echo "$".$param->name."";
				}
				?>)
</h3>

<div class="method">
	<!--<p><code>public string getName(string $value)</code></p>-->
	
	<!--<?= var_dump($method) ?>-->
	
	<p>Description</p>
	
	<dl>
		<dt>Parameters</dt>
		<!--<dd><code>$value</code> - the value</dd>-->
		<?php foreach ($method->getAnnotations('param') as $param): ?>
			<dd><code><?php echo $param; ?></code></dd>
		<?php endforeach; ?>
		<dt>Returns</dt>
		<!--<dd>the name</dd>-->
		<!--<dd><code>$value</code> - the value</dd>-->
		<?php foreach ($method->getAnnotations('return') as $return): ?>
			<dd><code><?php echo $return; ?></code></dd>
		<?php endforeach; ?>
	</dl>
</div>
<?php endforeach; ?>

</div>
</div>

<hr />

<ul class="menu">
	<li><a href="overview.php">Overview</a></li>
	<li><a href="">Classes</a></li>
	<li><a href="">Packages</a></li>
</ul>

<p class="footer">This <acronym
	title="Application Programming Interface">API</acronym> documentation
has been generated 2006-11-24 12:45 with <a
	href="http://code.google.com/p/darter">darter</a>. Copyright 1998-2006 by The Foobar.</p>
</div>

</body>
</html>
