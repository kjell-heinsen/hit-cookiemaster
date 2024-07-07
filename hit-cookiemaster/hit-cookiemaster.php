<?php
/*
Plugin Name: HIT Cookiemaster
Plugin URI: https://heinsen-it.de/
Description: Cookiemaster Kjell Heinsen
Author: Kjell Heinsen
Version: 0.0.0.2
Author URI: https://heinsen-it.de
MINIMAL WP: 5.0.0
MINIMAL PHP: 5.6.0
Tested WP: 6.0.2
*/


require_once  'autoload.php';
require_once 'hit_config.php';
$basename = 'hit-cookiemaster';
$project_id = \hitcookiemaster\app\classes\core\licencemanager::GetProjectID();
$plugin_lizenz = \hitcookiemaster\app\classes\core\licencemanager::Get();


$server = random_int(1,4);

$plugin_updateurl = "https://wpu".$server.".heinsen-it.de/updates/".$basename."/";

if($project_id <> ''){
    $plugin_updateurl = $plugin_updateurl.$project_id."/";
}
if($plugin_lizenz <> ''){
    $plugin_updateurl = $plugin_updateurl.$plugin_lizenz."/";
}




require HITCOOKIEMASTER_LIB.'plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
$MyUpdateChecker = PucFactory::buildUpdateChecker(
    $plugin_updateurl,
    __FILE__, //Full path to the main plugin file.
    $basename //Plugin slug. Usually it's the same as the name of the directory.
);









// Fügt JavaScript- und CSS-Dateien hinzu
function popup_enqueue_scripts() {
    wp_enqueue_style('popup-style', plugin_dir_url(__FILE__) . 'css/cookieconsent.css');
//  wp_enqueue_style('popup-style', plugin_dir_url(__FILE__) . 'css/popup.css');
    wp_enqueue_script('popup-script', plugin_dir_url(__FILE__) . 'js/cookieconsent.js', array('jquery'), '', true);
       wp_enqueue_script('popup-script', plugin_dir_url(__FILE__) . 'js/cookieconsent-init.js');
//  wp_enqueue_script('popup-script', plugin_dir_url(__FILE__) . 'js/popup.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'popup_enqueue_scripts');

// Erzeugt den HTML-Code für das Popup
function popup_content() {
  ob_start();
  ?>
   <!--  <div class="popup-overlay">
    <div class="popup-container">
        <h2>Cookie-Einstellungen</h2>
        <p>Diese Webseite verwendet Cookies, um Ihnen das bestmögliche Erlebnis zu bieten. Bitte wählen Sie aus, welche Arten von Cookies Sie zulassen möchten:</p>

        <div class="cookie-section">
            <h3>Notwendige Cookies</h3>
            <p>Notwendige Cookies sind für das reibungslose Funktionieren der Webseite unbedingt erforderlich.</p>
            <input type="checkbox" id="necessary-cookies" checked disabled>
            <label for="necessary-cookies">Notwendige Cookies zulassen</label>
        </div>

        <div class="cookie-section">
            <h3>Marketing-Cookies</h3>
            <p>Marketing-Cookies werden verwendet, um personalisierte Werbung anzuzeigen.</p>
            <input type="checkbox" id="marketing-cookies">
            <label for="marketing-cookies">Marketing-Cookies zulassen</label>
        </div>

        <div class="cookie-section">
            <h3>Tracking-Cookies</h3>
            <p>Tracking-Cookies werden verwendet, um das Nutzerverhalten aufzuzeichnen und die Webseite zu analysieren.</p>
            <input type="checkbox" id="tracking-cookies">
            <label for="tracking-cookies">Tracking-Cookies zulassen</label>
        </div>

        <button class="btn-save">Einstellungen speichern</button>
    </div>
    </div>

    <div class="popup-overlay">
        <div class="popup-container">
            <h2>Cookie-Einstellungen</h2>
            <p>Wir verwenden Cookies, um Ihre Erfahrung auf unserer Webseite zu verbessern. Bitte treffen Sie Ihre Auswahl:</p>

            <div class="category">
                <h6>Notwendige Cookies</h6>
                <p>Notwendige Cookies sind für das reibungslose Funktionieren der Webseite unbedingt erforderlich.</p>
                <input type="checkbox" id="necessary-cookies" checked disabled>
                <label for="necessary-cookies">Notwendige Cookies zulassen</label>
            </div>

            <div class="category">
                <h6>Präferenz-Cookies</h6>
                <p>Notwendige Cookies sind für das reibungslose Funktionieren der Webseite unbedingt erforderlich.</p>
                <input type="checkbox" id="necessaryx-cookies" checked disabled>
                <label for="necessarxy-cookies">Notwendige Cookies zulassen</label>
            </div>

            <div class="category">
                <h6>Statistik-Cookies</h6>
                <p>Tracking-Cookies werden verwendet, um das Nutzerverhalten aufzuzeichnen und die Webseite zu analysieren.</p>
                <input type="checkbox" id="tracking-cookies">
                <label for="tracking-cookies">Tracking-Cookies zulassen</label>
            </div>

            <div class="category">
                <h6>Marketing-Cookies</h6>
                <p>Marketing-Cookies werden verwendet, um personalisierte Werbung anzuzeigen.</p>
                <input type="checkbox" id="marketing-cookies">
                <label for="marketing-cookies">Marketing-Cookies zulassen</label>
            </div>

            <ul class="collapsible-list">
                <li>
                    <div class="collapsible-header">Punkt 1</div>
                    <div class="collapsible-content">
                        <p>Inhalt von Punkt 1</p>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header">Punkt 2</div>
                    <div class="collapsible-content">
                        <p>Inhalt von Punkt 2</p>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header">Punkt 3</div>
                    <div class="collapsible-content">
                        <p>Inhalt von Punkt 3</p>
                    </div>
                </li>
            </ul>


            <button class="btn-save">Einstellungen speichern</button>
        </div>
    </div>
    -->
  <?php
  return ob_get_clean();
}

// Fügt das Popup der Seite hinzu
function popup_add_popup() {
  echo popup_content();
}
add_action('wp_footer', 'popup_add_popup');

// Fügt JavaScript-Code für das Popup hinzu
function popup_add_script() {
  ?>
  <script>
  jQuery(document).ready(function($) {
    // Öffnet das Popup beim Seitenaufruf
    $('#popup-container').fadeIn();

    // Schließt das Popup beim Klick auf den Schließen-Button
    $('#popup-close').click(function() {
      $('#popup-container').fadeOut();
    });
  });
  </script>
  <?php
}
add_action('wp_footer', 'popup_add_script');
?>
