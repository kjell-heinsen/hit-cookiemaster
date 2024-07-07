<?php

namespace hitcookiemaster\app\classes\core;



defined('ABSPATH') or die('No Time for Looking for Freedom');

    class views
    {


        // Funktion um die Views zu laden.
        public function render($path, $data = false, $error = false)
        {
            $path = HITCOOKIEMASTER_CLASSES . "views/$path.php";
            if (file_exists($path)) {
                require $path;
            } else {

                //   touch($path);
                file_put_contents($path, 'Dieses View(' . $path . ') ist leer und automatisch generiert.</br>');
                require $path;
                unlink($path);
            }

        }
    }

