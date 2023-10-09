<?php
namespace Plugin_Seedproject;

    if ( ! defined( 'ABSPATH' ) ) {
	    exit; // Exit if accessed directly.
    }

    $plugin_images = plugin_dir_url(__FILE__). 'assets/images';

    final class SeedProject_Elementor_Extension {
        const VERSION = '1.0.0';
        const MINIMUM_ELEMENTOR_VERSION = '3.2.4';
        const MINIMUM_PHP_VERSION = '7.0';

        private static $_instance = null;

        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct() {
            if ($this->is_compatible()) {
                add_action('elementor/init', [$this, 'init']);
            }
        }

        public function is_compatible() {
            if (!did_action('elementor/loaded')) {
                add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
                return false;
            }
            if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
                add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
                return false;
            }
            if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
                add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
                return false;
            }
            return true;
        }

        public function admin_notice_missing_main_plugin() {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor */
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'seedproject-elementor-extension' ),
                '<strong>' . esc_html__( 'Elementor Extensions', 'seedproject-elementor-extension' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'seedproject-elementor-extension' ) . '</strong>'
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        public function admin_notice_minimum_elementor_version() {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'seedproject-elementor-extension' ),
                '<strong>' . esc_html__( 'Elementor Extensions', 'seedproject-elementor-extension' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'seedproject-elementor-extension' ) . '</strong>',
                 self::MINIMUM_ELEMENTOR_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        public function admin_notice_minimum_php_version() {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'seedproject-elementor-extension' ),
                '<strong>' . esc_html__( 'Elementor Extensions', 'seedproject-elementor-extension' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'seedproject-elementor-extension' ) . '</strong>',
                 self::MINIMUM_PHP_VERSION
            );
            printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
        }

        public function init() {
            $this->__i18n();
            add_action( 'elementor/elements/categories_registered', [$this, 'init_categories'] );
            add_action('elementor/widgets/register', [$this, 'init_widgets']);
        }

        public function __i18n() {
            load_plugin_textdomain('plugin-seedproject');
        }

        public function init_widgets($widgets_manager) {
            require_once(__DIR__ . '/widgets/class-buttons.php');
            $widgets_manager->register(new \SeedProject_Buttons_Widget());
        }

        public function init_categories($elements_manager) {
            $elements_manager->add_category(
                'seedproject-category',
                [
                    'title' => esc_html__( 'Seed Project', 'plugin-seedproject' ),
                    'icon' => 'eicon-ai',
                ]
            );
        }
    }

?>