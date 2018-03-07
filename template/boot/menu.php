        <?php $sch=0; ?>
	<?php foreach ($list as $item) : ?>
                <?php $sch++; ?>
		<li><?php echo $item->showLink(); ?></li>
                <?php if ($sch==1) echo '<li class="divider"></li><li class="dropdown-header">Компании</li>'; ?>
                <?php if ($sch==10) echo '<li class="divider"></li><li class="dropdown-header">Полезное</li>'; ?>
	<?php endforeach; ?>