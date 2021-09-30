<div class='whatsnew'>
	<?php if ( $info->title ): ?>
		<?php echo '<h2>'.$info->title.'</h2>'; ?>
	<?php endif; ?>

	<hr/>
	<?php foreach($info->items as $item): ?>
	<dl>
		<a href="<?php echo $item->url; ?>">
		<dt>
			<?php echo $item->date; ?>
		</dt>
		<dd>
			<?php if ( $item->newmark ): ?>
			<span class='newmark'>NEW!</span>
			<?php endif; ?>
			<?php echo $item->title; ?>
		</dd>
		</a>
	</dl>
	<hr/>
	<?php endforeach; ?>
</div>
