<?php foreach($parameter->getChildren() as $child): ?>
	<li><a href="detail.php?class=<?php echo $child; ?>"><?php echo $child; ?></a></li>
	<?php if(count($child->getChildren()) > 0): ?>
	<ul>
	<?php $this->show('tree', $child); ?>
	</ul>
	<?php endif; ?>
<?php endforeach; ?>