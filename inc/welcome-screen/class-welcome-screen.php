<?php
/**
 * Envy Blog Welcome Screen
 *
 * @package Courtyard
 * @since   1.2.1
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Envy_Blog_Welcome_Screen' ) ) :

    /**
     * Envy_Blog_Welcome_Screen Class.
     */
    class Envy_Blog_Welcome_Screen {

        /**
         * Constructor.
         */
        public function __construct() {
            $theme_options = wp_get_theme( get_template() );
            $theme = $theme_options->get( 'Name' );
            $description = $theme_options->get( 'Description' );
            $text_domain = $theme_options->get( 'TextDomain' );
            $version = $theme_options->get( 'Version' );
            define( 'THEME', $theme );
            define( 'DESCRIPTION', $description );
            define( 'TEXT_DOMAIN', $text_domain );
            define( 'VERSION', $version );

            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_init', array( 'PAnD', 'init' ) );
            add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
        }

        /**
         * Add admin menu.
         */
        public function admin_menu() {

            $page = add_theme_page( esc_html__( 'About', 'courtyard' ) . ' ' . THEME, esc_html__( 'About', 'courtyard' ) . ' ' . THEME, 'activate_plugins', 'courtyard-welcome', array( $this, 'welcome_screen' ) );
            add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
        }

        /**
         * Enqueue styles.
         */
        public function enqueue_styles() {

            wp_enqueue_style( 'courtyard-welcome-style', get_template_directory_uri() . '/inc/welcome-screen/css/welcome.css', array(), true );

            wp_enqueue_script( 'courtyard-welcome-style-script', get_template_directory_uri() . '/inc/welcome-screen/js/welcome.js', array('jquery'),'', true );
        }

        /**
         * Show welcome notice.
         */
        public function welcome_notice() {
            if ( ! PAnD::is_admin_notice_active( 'courtyard-welcome-forever' ) ) {
                return;
            }

            ?>
            <div data-dismissible="courtyard-welcome-forever" class="updated notice notice-success is-dismissible">
                <h1><?php printf( esc_html__( 'Welcome to %s', 'courtyard' ), THEME ); ?></h1>
                <p><?php printf( esc_html__( 'Welcome! Thank you for choosing %s ! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'courtyard' ),THEME,'<a href="' . esc_url( admin_url( 'themes.php?page=courtyard-welcome' ) ) . '">', '</a>' ); ?></p>
                <p>
                    <a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=courtyard-welcome' ) ); ?>">
                        <?php printf( esc_html__( 'Get started with %s', 'courtyard' ), THEME ); ?>
                    </a>
                </p>
                <button type="button" class="notice-dismiss">
                    <a class="courtyard-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'courtyard-hide-notice', 'welcome' ) ), 'envy-blog_hide_notices_nonce', '_envy-blog_notice_nonce' ) ); ?>">
                        <span class="screen-reader-text"><?php esc_html_e( 'Dismiss', 'courtyard' ); ?></span>
                    </a>
                </button>
            </div>
            <?php
        }

        /**
         * Welcome screen page.
         */
        public function welcome_screen() {
            $user = wp_get_current_user();
            ?>
            <div class="info-container">
                <div class="main-welcome-container">
                    <div class="container-left">
                        <p class="hello-user"><?php echo sprintf( __( 'Hello, %s,', 'courtyard' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></p>
                        <h1 class="info-title"><?php echo sprintf( __( 'Welcome to %s version %s', 'courtyard' ), THEME, VERSION ); ?></h1>
                        <p class="welcome-desc"><?php echo wp_kses_post( DESCRIPTION ); ?></p>
                    </div>
                    <div class="container-right">
                        <figure>
                            <img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
                        </figure>
                    </div>
                </div>
                <div class="courtyard-theme-tabs">

                    <div class="courtyard-tab-nav nav-tab-wrapper">
                        <a href="#begin" data-target="begin" class="nav-button nav-tab begin active"><?php esc_html_e( 'Getting started', 'courtyard' ); ?></a>
                        <a href="#actions" data-target="actions" class="nav-button actions nav-tab"><?php esc_html_e( 'Recommended Actions', 'courtyard' ); ?></a>
                        <a href="#support" data-target="support" class="nav-button support nav-tab"><?php esc_html_e( 'Support', 'courtyard' ); ?></a>
                        <a href="#free-vs-pro" data-target="free-vs-pro" class="nav-button free-vs-pro nav-tab"><?php esc_html_e( 'Free vs Pro', 'courtyard' ); ?></a>
                        <a href="#changelog" data-target="changelog" class="nav-button changelog nav-tab"><?php esc_html_e( 'Changelog', 'courtyard' ); ?></a>
                    </div>

                    <div class="courtyard-tab-wrapper">

                        <?php $this->getting_started();?>

                        <?php $this->recommended_actions();?>

                        <?php $this->supports();?>

                        <?php $this->free_vs_pro();?>

                        <?php $this->changelog();?>

                        <div class="return-to-dashboard">
                            <?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
                                <a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
                                    <?php is_multisite() ? esc_html_e( 'Return to Updates', 'courtyard' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'courtyard' ); ?>
                                </a> |
                            <?php endif; ?>
                            <a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'courtyard' ) : esc_html_e( 'Go to Dashboard', 'courtyard' ); ?></a>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Show Getting Started Content.
         */
        public function getting_started() {
            ?>
            <div id="#begin" class="courtyard-tab begin show">

                <h3><?php esc_html_e( 'Step 1 - Implement recommended actions', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'We\'ve made a list of steps for you to follow to get the most of %s.', 'courtyard' ), THEME ); ?></p>
                <p><a class="actions" href="#actions"><?php esc_html_e( 'Check recommended actions', 'courtyard' ); ?></a></p>
                <hr>

                <h3><?php esc_html_e( 'Step 2 - Read documentation', 'courtyard' ); ?></h3>
                <p><?php esc_html_e( 'Our documentation (including video tutorials) will have you up and running in no time.', 'courtyard' ); ?></p>
                <p><a href="<?php echo esc_attr( 'https://precisethemes.com/courtyard-documentation/' ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'courtyard' ); ?></a></p>
                <hr>

                <h3><?php esc_html_e( 'Step 3 - Customize', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'Use the Customizer to make %s your own.', 'courtyard' ), THEME ); ?></p>
                <p><a class="button button-primary button-large" href="<?php echo admin_url( 'customize.php' ); ?>"><?php esc_html_e( 'Go to Customizer', 'courtyard' ); ?></a></p>

            </div>
            <?php
        }

        /**
         * Show Getting Started Content.
         */
        public function recommended_actions() {
            ?>
            <div id="#actions" class="courtyard-tab actions">
                <h3><?php esc_html_e( 'Install: Contact Form 7', 'courtyard' ); ?></h3>
                <p><?php esc_html_e( 'It is highly recommended that you install Contact Form 7. It will enable you to create pages by adding widgets to them using drag and drop.', 'courtyard' ); ?></p>

                <?php if ( !class_exists( 'WPCF7' ) ) : ?>
                    <?php $so_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=contact-form-7'), 'install-plugin_contact-form-7'); ?>
                    <p>
                        <a target="_blank" class="install-now button" href="<?php echo esc_url( $so_url ); ?>"><?php esc_html_e( 'Install and Activate', 'courtyard' ); ?></a>
                    </p>
                <?php else : ?>
                    <p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'courtyard' ); ?></p>
                <?php endif; ?>
                <hr>

                <h3><?php esc_html_e( 'Install: WooCommerce', 'courtyard' ); ?></h3>
                <p><?php esc_html_e( 'It is highly recommend that you install WooCommerce. It will create custom post types like services and employees for you to use on your website.', 'courtyard' ); ?></p>
                <?php if ( !class_exists('WooCommerce') ) : ?>
                    <?php $st_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=woocommerce'), 'install-plugin_woocommerce'); ?>
                    <p>
                        <a target="_blank" class="install-now button" href="<?php echo esc_url( $st_url ); ?>"><?php esc_html_e( 'Install and Activate', 'courtyard' ); ?></a>
                    </p>
                <?php else : ?>
                    <p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'courtyard' ); ?></p>
                <?php endif; ?>
                <hr>

                <h3><?php esc_html_e( 'Demo content', 'courtyard' ); ?></h3>
                <div class="column-wrapper">
                    <h4><?php esc_html_e( 'Install:  One Click Demo Import', 'courtyard' ); ?></h4>
                    <p><?php esc_html_e( 'Install the following plugin and then come back here to access the importer. With it you can import all demo content and change your homepage and blog page to the ones from our demo site, automatically. It will also assign a menu.', 'courtyard' ); ?></p>

                    <?php if ( !class_exists('OCDI_Plugin') ) : ?>
                        <?php $odi_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=one-click-demo-import'), 'install-plugin_one-click-demo-import'); ?>
                        <p>
                            <a target="_blank" class="install-now button importer-install" href="<?php echo esc_url( $odi_url ); ?>"><?php esc_html_e( 'Install and Activate', 'courtyard' ); ?></a>
                            <a style="display:none;" class="button button-primary button-large importer-button" href="<?php echo admin_url( 'themes.php?page=pt-one-click-demo-import.php' ); ?>"><?php esc_html_e( 'Go to the importer', 'courtyard' ); ?></a>
                        </p>
                    <?php else : ?>
                        <p style="color:#23d423;font-style:italic;font-size:14px;"><?php esc_html_e( 'Plugin installed and active!', 'courtyard' ); ?></p>
                        <a class="button button-primary button-large" href="<?php echo admin_url( 'themes.php?page=pt-one-click-demo-import.php' ); ?>"><?php esc_html_e( 'Go to the automatic importer', 'courtyard' ); ?></a>
                    <?php endif; ?>

                </div>
            </div>
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function supports() {
            ?>
            <div id="#support" class="courtyard-tab support">
                <div class="column-wrapper">
                    <div class="tab-column">
                        <span class="dashicons dashicons-sos"></span>
                        <h3><?php esc_html_e( 'Visit our forums', 'courtyard' ); ?></h3>
                        <p><?php esc_html_e( 'Need help? Go ahead and visit our support forums and we\'ll be happy to assist you with any theme related questions you might have', 'courtyard' ); ?></p>
                        <a href="<?php echo esc_url( 'https://precisethemes.com/support-forum/forum/courtyard-free-wordpress-hotel-theme/' ); ?>" target="_blank"><?php esc_html_e( 'Visit the forums', 'courtyard' ); ?></a>
                    </div>
                    <div class="tab-column">
                        <span class="dashicons dashicons-book-alt"></span>
                        <h3><?php esc_html_e( 'Documentation', 'courtyard' ); ?></h3>
                        <p><?php esc_html_e( 'Our documentation can help you learn how to use the theme and also provides you with premade code snippets and answers to FAQs.', 'courtyard' ); ?></p>
                        <a href="<?php echo esc_url( 'https://precisethemes.com/courtyard-documentation/' ); ?>" target="_blank"><?php esc_html_e( 'See the Documentation', 'courtyard' ); ?></a>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function free_vs_pro() {
            ?>
            <div id="#free-vs-pro" class="courtyard-tab free-vs-pro">
                <table class="widefat fixed featuresList">
                    <thead>
                    <tr>
                        <td><strong><h3><?php esc_html_e( 'Feature', 'courtyard' ); ?></h3></strong></td>
                        <td style="width:20%;"><strong><h3><?php echo esc_html( THEME ); ?></h3></strong></td>
                        <td style="width:20%;"><strong><h3><?php echo sprintf( __( '%s Pro', 'courtyard' ), THEME ); ?></h3></strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php esc_html_e( 'Access to all Google Fonts', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Responsive', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Parallax backgrounds', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Social Icons', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Slider, image or video header', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Front Page Blocks', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Translation ready', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Polylang integration', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Color options', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Blog options', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Widgetized footer', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Background image support', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Footer Credits option', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Extra widgets (timeline, latest news in carousel, pricing tables, a new employees widget and a new contact widget)', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Extra Customizer Options (Front Page Section Titles, Single Employees, Single Projects, Header Contact Info, Buttons)', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Header support for Crelly Slider', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Header support for shortcodes', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Single Post/Page Options', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Woocommerce compatible', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( '5 Extra Page Templates (Contact, Featured Header - Default, Featured Header - Wide, No Header - Default, No Header - Wide)', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Priority support', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>
                    </tbody>
                </table>
                <p style="text-align: right;"><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/courtyard/' );?>" target="_blank"><?php echo sprintf( __( '%s Pro', 'courtyard' ), THEME ); ?></a></p>
            </div>
            <?php
        }

        /**
         * Show Changelog Content.
         */
        public function changelog() {
            global $wp_filesystem;
            ?>
            <div id="#changelog" class="courtyard-tab changelog">
                <div class="wrap about-wrap">
                    <?php
                    $changelog_file = apply_filters( 'envy_blog_changelog_file', get_template_directory() . '/readme.txt' );

                    // Check if the changelog file exists and is readable.
                    if ( $changelog_file && is_readable( $changelog_file ) ) {
                        WP_Filesystem();
                        $changelog = $wp_filesystem->get_contents( $changelog_file );
                        $changelog_list = $this->parse_changelog( $changelog );

                        echo wp_kses_post( $changelog_list );
                    }
                    ?>
                </div>
            </div>
            <?php
        }







        /**
         * Parse changelog from readme file.
         */
        private function parse_changelog( $content ) {
            $matches   = null;
            $regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
            $changelog = '';

            if ( preg_match( $regexp, $content, $matches ) ) {
                $changes = explode( '\r\n', trim( $matches[1] ) );

                $changelog .= '<pre class="changelog">';

                foreach ( $changes as $index => $line ) {
                    $changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
                }

                $changelog .= '</pre>';
            }

            return wp_kses_post( $changelog );
        }
    }

endif;

return new Envy_Blog_Welcome_Screen();