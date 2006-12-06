
<ul>
<?php

foreach($classes as $key => $className) {
	?>
	<li><a href="viewClass.php?classname=<?= $className ?>"><?= $className ?></a></li>
	<?php
}
?>
</ul>
