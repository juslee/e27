<?php 
/**
<div id="startup_quote">
	<div id="startup_quote_body">
		<?php
			$xml = @simplexml_load_file("http://api.1001mutiarakata.com/startupquotes/");
			if($xml) :
                $author = !empty($xml->author) ? " - {$xml->author}" : '';
				echo "{$xml->quote}{$author}";
			else:
				echo "Don't find fault, find a remedy. Anybody can complain - Henry Ford";
			endif;		
		?>
	</div>
</div>
 */
?>