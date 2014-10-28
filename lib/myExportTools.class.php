<?php
class myExportTools {
	public static function exportHighchartGraph() {
		
		/**
		 * This file is part of the exporting module for Highcharts JS.
		 * www.highcharts.com/license
		 *
		 *
		 * Available POST variables:
		 *
		 * $tempName string The desired filename without extension
		 * $type string The MIME type for export.
		 * $width int The pixel width of the exported raster image. The height is calculated.
		 * $svg string The SVG source code to convert.
		 */
		
		// Options
		define ( 'BATIK_PATH', sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'batik' . DIRECTORY_SEPARATOR . 'batik-rasterizer.jar' );
		define ( 'TEMP_PATH', sfConfig::get ( 'sf_web_dir' ) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'batik' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR );
		
		// /////////////////////////////////////////////////////////////////////////////
		ini_set ( 'magic_quotes_gpc', 'off' );
		
		$type = $_POST ['type'];
		$svg = ( string ) $_POST ['svg'];
		$filename = ( string ) $_POST ['filename'];
		
		// prepare variables
		if (! $filename)
			$filename = 'chart';
		if (get_magic_quotes_gpc ()) {
			$svg = stripslashes ( $svg );
		}
		
		$tempName = md5 ( rand () );
		
		// allow no other than predefined types
		if ($type == 'image/png') {
			$typeString = '-m image/png';
			$ext = 'png';
		} elseif ($type == 'image/jpeg') {
			$typeString = '-m image/jpeg';
			$ext = 'jpg';
		} elseif ($type == 'application/pdf') {
			$typeString = '-m application/pdf';
			$ext = 'pdf';
		} elseif ($type == 'image/svg+xml') {
			$ext = 'svg';
		}
		$outfile = TEMP_PATH . "$tempName.$ext";
		
		if (isset ( $typeString )) {
			
			// size
			if ($_POST ['width']) {
				$width = ( int ) $_POST ['width'];
				if ($width)
					$width = "-w $width";
			}
			
			// generate the temporary file
			if (! file_put_contents ( TEMP_PATH . "$tempName.svg", $svg )) {
				die ( "Couldn't create temporary file. Check that the directory permissions for
				the /temp directory are set to 777." );
			}
			
			// do the conversion
			$string_exec = "java -Djava.awt.headless=true -jar '" . BATIK_PATH . "' $typeString $width '" . TEMP_PATH . "$tempName.svg'";
			$output = shell_exec ( escapeshellcmd ( $string_exec ) );
			
			// catch error
			if (! is_file ( $outfile ) || filesize ( $outfile ) < 10) {
				echo "<pre>$string_exec</pre>";
				echo "<pre>$output</pre>";
				echo "Error while converting SVG";
			} 			

			// stream it
			else {
				header ( "Content-Disposition: attachment; filename=$filename.$ext" );
				header ( "Content-Type: $type" );
				echo file_get_contents ( $outfile );
			}
			
			// delete it
			unlink ( TEMP_PATH . "$tempName.svg" );
			unlink ( $outfile );
			
			// SVG can be streamed directly back
		} else if ($ext == 'svg') {
			header ( "Content-Disposition: attachment; filename=$filename.$ext" );
			header ( "Content-Type: $type" );
			echo $svg;
		} else {
			echo "Invalid type";
		}
		
		return sfView::NONE;
	}
}

?>