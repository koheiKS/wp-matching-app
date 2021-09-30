<?php

class ScModelService {

	function display_template($file, $atts) {
		ob_start();
		require $file;
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
	}


}

?>
