<?php

namespace hitcookiemaster\app\classes;
defined('ABSPATH') or die('No Time for Looking for Freedom');
    class MyClass
    {

        // public $_dataserver;


        function __construct()
        {
            //		add_action( 'init', array( $this, 'custom_post_type' ) );
            //  $this->_dataserver = DATASERVER;
        }

        public static function activate()
        {
            Self::custom_post_type();

            flush_rewrite_rules();
            set_transient('fx-admin-notice-example', true, 5);
        }

        public static function deactivate()
        {

            flush_rewrite_rules();
        }

        public static function uninstall()
        {

        }


        public static function custom_post_type()
        {
            //	register_post_type( 'book', [ 'public' => true, 'label' => 'Bücher' ] );
        }

//methods


        public static function fx_admin_notice_example_notice()
        {

            /* Check transient, if available display notice */
            if (get_transient('fx-admin-notice-example')) {
                ?>
                <div class="updated notice is-dismissible">
                    <p>Thank you for using this plugin! <strong>You are awesome</strong>.</p>
                </div>
                <?php
                /* Delete transient, only display this notice once. */
                delete_transient('fx-admin-notice-example');
            }
        }
    }


