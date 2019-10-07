<?php
/*
Plugin Name: Thesaurus
Plugin URI: http://reddes.bvsalud.org/projects/fi-admin/
Description: Search thesaurus records from FI-ADMIN.
Author: BIREME/OPAS/OMS
Version: 1.0
Author URI: http://reddes.bvsalud.org/
*/

define('THESAURUS_PLUGIN_VERSION', '1.0' );

define('THESAURUS_SYMBOLIC_LINK', false );
define('THESAURUS_PLUGIN_DIRNAME', 'thesaurus' );

if(THESAURUS_SYMBOLIC_LINK == true) {
    define('THESAURUS_PLUGIN_PATH',  ABSPATH . 'wp-content/plugins/' . THESAURUS_PLUGIN_DIRNAME );
} else {
    define('THESAURUS_PLUGIN_PATH',  plugin_dir_path(__FILE__) );
}

define('THESAURUS_PLUGIN_DIR',   plugin_basename( THESAURUS_PLUGIN_PATH ) );
define('THESAURUS_PLUGIN_URL',   plugin_dir_url(__FILE__) );


require_once(THESAURUS_PLUGIN_PATH . '/settings.php');
require_once(THESAURUS_PLUGIN_PATH . '/template-functions.php');

if(!class_exists('Thesaurus_Plugin')) {
    class Thesaurus_Plugin {

        private $plugin_slug = 'thesaurus';
        private $service_url = 'http://fi-admin.bvsalud.org/';

        /**
         * Construct the plugin object
         */
        public function __construct() {
            // register actions

            add_action( 'init', array(&$this, 'load_translation'));
            add_action( 'admin_menu', array(&$this, 'admin_menu'));
            add_action( 'plugins_loaded', array(&$this, 'plugin_init'));
            add_action( 'wp_head', array(&$this, 'google_analytics_code'));
            add_action( 'template_redirect', array(&$this, 'template_redirect'));
            add_action( 'widgets_init', array(&$this, 'register_sidebars'));
            add_filter( 'get_search_form', array(&$this, 'search_form'));
            add_filter( 'document_title_parts', array(&$this, 'theme_slug_render_title'));


        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate


        function load_translation(){
            // Translations
            load_plugin_textdomain( 'ths', false,  THESAURUS_PLUGIN_DIR . '/languages' );
        }

        function plugin_init() {
            global $ths_texts;

            $ths_config = get_option('ths_config');
            $ths_config['use_translation'] = true;

            if ($ths_config && $ths_config['plugin_slug'] != ''){
                $this->plugin_slug = $ths_config['plugin_slug'];
            }
            if ($ths_config['use_translation']){
                $site_language = strtolower(get_bloginfo('language'));
                $lang = substr($site_language,0,2);

                $ths_texts = @parse_ini_file(THESAURUS_PLUGIN_PATH . "/languages/texts_" . $lang . ".ini", true);
            }

        }

        function admin_menu() {
            add_options_page(__('Thesaurus record settings', 'ths'), __('Thesaurus records', 'ths'),
                'manage_options', 'ths', 'ths_page_admin');
            //call register settings function
            add_action( 'admin_init', array(&$this, 'register_settings'));
        }

        function template_redirect() {
            global $wp, $ths_service_url, $ths_plugin_slug;
            $pagename = '';

            // check if request contains plugin slug string
            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);
            }

            if ( is_404() && $pos_slug !== false ){

                $ths_service_url = $this->service_url;
                $ths_plugin_slug = $this->plugin_slug;

                if ($pagename == $this->plugin_slug || $pagename == $this->plugin_slug . '/resource') {

                    add_action( 'wp_enqueue_scripts', array(&$this, 'page_template_styles_scripts'));

                    if ($pagename == $this->plugin_slug){
                        $template = THESAURUS_PLUGIN_PATH . '/template/home.php';
                    }else{
                        $template = THESAURUS_PLUGIN_PATH . '/template/resource.php';
                    }
                    // force status to 200 - OK
                    status_header(200);

                    // redirect to page and finish execution
                    include($template);
                    die();
                }
            }
        }

        function register_sidebars(){
            $args = array(
                'name' => __('Thesaurus sidebar', 'ths'),
                'id'   => 'ths-home',
                'before_widget' => '<section id="%1$s" class="row-fluid marginbottom25 widget_categories">',
                'after_widget'  => '</section>',
                'before_title'  => '<header class="row-fluid border-bottom marginbottom15"><h1 class="h1-header">',
                'after_title'   => '</h1></header>',
            );
            register_sidebar( $args );

            $args2 = array(
                'name' => __('Thesaurus header', 'ths'),
                'id'   => 'ths-header',
                'before_widget' => '<section id="%1$s" class="row-fluid widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<header class="row-fluid border-bottom marginbottom15"><h1 class="h1-header">',
                'after_title'   => '</h1></header>',
            );
            register_sidebar( $args2 );

        }


        function theme_slug_render_title($title) {
            global $wp, $ths_plugin_title;
            $pagename = '';

            // check if request contains plugin slug string
            $pos_slug = strpos($wp->request, $this->plugin_slug);
            if ( $pos_slug !== false ){
                $pagename = substr($wp->request, $pos_slug);
            }

            if ( is_404() && $pos_slug !== false ){
                $ths_config = get_option('ths_config');
                if ( function_exists( 'pll_the_languages' ) ) {
                    $current_lang = pll_current_language();
                    $ths_plugin_title = $ths_config['plugin_title_' . $current_lang];
                }else{
                    $ths_plugin_title = $ths_config['plugin_title'];
                }
                $title['title'] = $ths_plugin_title;
            }

            return $title;
        }

        function search_form( $form ) {
            global $wp;
            $pagename = $wp->query_vars["pagename"];

            if ($pagename == $this->plugin_slug || $pagename == $this->plugin_slug .'/resource') {
                $form = preg_replace('/action="([^"]*)"(.*)/','action="' . home_url($this->plugin_slug) . '"',$form);
            }

            return $form;
        }

        function page_template_styles_scripts(){
            wp_enqueue_style ('ths-tooltipster',  THESAURUS_PLUGIN_URL . 'template/css/tooltipster.css');
        }


        function register_settings(){
            register_setting('ths-settings-group', 'ths_config');
            // wp_enqueue_style('biblio' ,  THESAURUS_PLUGIN_URL . 'template/css/admin.css');
            wp_enqueue_script('jquery-ui-sortable');
        }

        function google_analytics_code(){
            global $wp;

            $pagename = $wp->query_vars["pagename"];
            $ths_config = get_option('ths_config');

            // check if is defined GA code and pagename starts with plugin slug
            if ($ths_config['google_analytics_code'] != ''
                && strpos($pagename, $this->plugin_slug) === 0){
        ?>

        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', '<?php echo $ths_config['google_analytics_code'] ?>']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>

        <?php
            } //endif
        }


    } // END class Thesaurus_Plugin
} // END if(!class_exists('Thesaurus_Plugin'))

if(class_exists('Thesaurus_Plugin'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Thesaurus_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('Thesaurus_Plugin', 'deactivate'));

    // instantiate the plugin class
    $wp_plugin_template = new Thesaurus_Plugin();
}

?>
