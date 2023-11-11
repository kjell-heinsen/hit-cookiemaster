<?php
defined( 'ABSPATH' ) or die( 'No Time for Looking for Freedom' );
if(!class_exists('HIT_COOKIEMASTER_VIEWS'))
{
class HIT_COOKIEMASTER_VIEWS {


	// Funktion um die Views zu laden.
	public function render( $path, $data = false, $error = false ) {
		$path = HITSUPPORTTOOL_DIRPATH . "views/$path.php";
		if ( file_exists( $path ) ) {
			require $path;
		} else {

			//   touch($path);
			file_put_contents( $path, 'Dieses View(' . $path . ') ist leer und automatisch generiert.</br>' );
			require $path;
			unlink( $path );
		}

	}
}
}