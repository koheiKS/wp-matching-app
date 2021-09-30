<?php
?>
<div class="updated">
	<ul>
<?php
	foreach( $atts as $message ):
?>
		<li>
			<?php echo esc_html($message); ?>
		</li>
<?php
	endforeach;
?>
	</ul>
</div>

