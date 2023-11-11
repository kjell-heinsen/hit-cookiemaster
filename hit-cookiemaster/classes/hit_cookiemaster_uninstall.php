<?php
if (!defined('ABSPATH')) {
    exit;
}

class HIT_COOKIEMASTER_uninstall
{

    public function hit_deleteOptions()
    {

        delete_option(HITDBVERSION);

        // if parent is deinstalled before this plugin we can delete all settings.
        if (defined("HITCOOKIEMASTER_VERSION") === false || class_exists("hit_plugin_configdata") === false) {
            $bannersettings_option_names = $this->hit_getallsettings();
            foreach ($bannersettings_option_names as $name) {
                delete_option($name);
            }
            return true;
        }

        // if parent is not deinstalled yet we delete only the options of this plugin.
        $parent_configs = new nsc_bar_plugin_configs;

        $addon_configs = new nsc_bara_addon_configs();
        $settings = $addon_configs->nsc_bara_get_settings_as_object();
        foreach ($settings->tabs as $tab) {
            foreach ($tab->tabfields as $fields) {
                $parent_configs->nsc_bar_delete_option($fields->field_slug);
            }
        }

        $translated_settings = $this->hit_getlangsettings();
        foreach ($translated_settings as $name) {
            delete_option($name);
        }
        // plus we want to delete some options of the main plugin which are only used by this plugin
        delete_option("nsc_bar_blocked_services");
        delete_option("nsc_bar_custom_services");

    }

    public function hit_delete_folder()
    {
        $addon_configs = new nsc_bara_addon_configs;
        $base_folder_path = $addon_configs->nsc_bara_return_plugin_upload_base_dir();
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }
        $base_dir = $wp_filesystem->delete($base_folder_path, true, "d");
    }

    private function hit_getallsettings()
    {
        global $wpdb;
        $options = $wpdb->get_results("select * from $wpdb->options where option_name like 'wp_hit_%' or option_name like 'wp_hit_%'");
        $names = array();
        foreach ($options as $option) {
            $names[] = $option->option_name;
        }
        return $names;
    }

    private function hit_getlangsettings()
    {
        global $wpdb;
        $options = $wpdb->get_results("select * from $wpdb->options where option_name like 'nsc_bar_bannersettings_json_%' or option_name like 'nsc_bar_shortcode_link_show_banner_text_%'");
        $names = array();
        foreach ($options as $option) {
            $names[] = $option->option_name;
        }
        return $names;
    }
}
