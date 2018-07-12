<?php
/**
 * Courtyard Welcome Screen
 *
 * @package Courtyard
 * @since   1.2.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Courtyard_Welcome_Screen' ) ) :

    /**
     * Courtyard_Welcome_Screen Class.
     */
    class Courtyard_Welcome_Screen {

        /**
         * Constructor.
         */
        public function __construct() {
            $courtyard_theme_options = wp_get_theme( get_template() );
            $courtyard_theme_name = $courtyard_theme_options->get( 'Name' );
            $courtyard_desc = $courtyard_theme_options->get( 'Description' );
            $courtyard_text_domain = $courtyard_theme_options->get( 'TextDomain' );
            $courtyard_version = $courtyard_theme_options->get( 'Version' );
            define( 'COURTYARD_THEME', $courtyard_theme_name );
            define( 'COURTYARD_DESC', $courtyard_desc );
            define( 'COURTYARD_TEXT_DOMAIN', $courtyard_text_domain );
            define( 'COURTYARD_VERSION', $courtyard_version );

            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_init', array( 'PAnD', 'init' ) );
            add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
        }

        /**
         * Add admin menu.
         */
        public function admin_menu() {

            add_theme_page(
                esc_html__( 'Getting Started', 'courtyard' ),
                esc_html__( 'Getting Started', 'courtyard' ),
                'edit_theme_options',
                'courtyard-welcome' ,
                array( $this, 'welcome_screen' )
            );
        }

        /**
         * Show welcome notice.
         */
        public function welcome_notice() {
            if ( ! PAnD::is_admin_notice_active( 'courtyard-welcome-forever' ) ) {
                return;
            }

            ?>
            <div data-dismissible="courtyard-welcome-forever" class="updated notice notice-success is-dismissible welcome-notice">
                <h1><?php printf( esc_html__( 'Welcome to %s', 'courtyard' ), COURTYARD_THEME ); ?></h1>
                <p><?php printf( esc_html__( 'Welcome! Thank you for choosing %1$s ! To fully take advantage of the best our theme can offer please make sure you visit our %2$sswelcome page%3$s.', 'courtyard' ),COURTYARD_THEME,'<a href="' . esc_url( admin_url( 'themes.php?page=courtyard-welcome' ) ) . '">', '</a>' ); ?></p>
                <p>
                    <a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=courtyard-welcome' ) ); ?>">
                        <?php printf( esc_html__( 'Get started with %s', 'courtyard' ), COURTYARD_THEME ); ?>
                    </a>
                </p>
                <button type="button" class="notice-dismiss">
                    <a class="courtyard-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'courtyard-hide-notice', 'welcome' ) ), 'courtyard_hide_notices_nonce', '_courtyard_notice_nonce' ) ); ?>">
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
            $user = wp_get_current_user(); ?>

            <div class="about-container">
                <div class="flex theme-info">
                    <div class="theme-details">
                        <h4><?php echo sprintf( __( 'Hello, %s,', 'courtyard' ), '<span>' . esc_html( ucfirst( $user->display_name ) ) . '</span>' ); ?></h4>
                        <h1 class="entry-title"><?php echo sprintf( __( 'Welcome to %1$s version %2$s', 'courtyard' ), COURTYARD_THEME, COURTYARD_VERSION ); ?></h1>
                        <p class="entry-content"><?php echo wp_kses_post( COURTYARD_DESC ); ?></p>
                    </div>

                    <figure class="theme-screenshot">
                        <img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
                    </figure>
                </div>

                <div class="about-theme-tabs">
                    <ul class="about-theme-tab-nav">
                        <li class="tab-link active" data-tab="getting_started"><?php esc_html_e( 'Getting Started', 'courtyard' ); ?></li>
                        <li class="tab-link" data-tab="recommendation"><?php esc_html_e( 'Recommendation', 'courtyard' ); ?></li>
                        <li class="tab-link" data-tab="support"><?php esc_html_e( 'Theme Support', 'courtyard' ); ?></li>
                        <li class="tab-link" data-tab="free_vs_pro"><?php esc_html_e( 'Free vs Pro', 'courtyard' ); ?></li>
                        <li class="tab-link" data-tab="changelog"><?php esc_html_e( 'Changelog', 'courtyard' ); ?></li>
                    </ul>

                    <?php $this->getting_started();?>

                    <?php $this->recommendation();?>

                    <?php $this->supports();?>

                    <?php $this->free_vs_pro();?>

                    <?php $this->changelog();?>
                </div>
            </div>
            <?php
        }

        /**
         * Show Getting Started Content.
         */
        public function getting_started() { ?>

            <div id="getting_started" class="about-theme-tab active">

                <h3><?php esc_html_e( 'Read Documentation & Installation Guide', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'Theme documentation page will guide you to install and configure theme quick and easy. We have included details, screenshots and stepwise description about theme installation guides and tutorials. Follow the link: ', 'courtyard' ), COURTYARD_THEME ); ?><a class="button button-primary button-large" href="<?php echo esc_attr( 'https://precisethemes.com/courtyard-documentation/' ); ?>" target="_blank"><?php esc_html_e( 'View Courtyard Documentation', 'courtyard' ); ?></a></p>

                <hr>

                <h3><?php esc_html_e( 'Recommended Plugins', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'We have listed some of recommended plugins that works perfect with %s.', 'courtyard' ), COURTYARD_THEME ); ?></p>

                <hr>

                <h3><?php esc_html_e( 'Import Demo Content', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'Importing demo data may help you to get started with default content for quick and easy site setup.', 'courtyard' ), COURTYARD_THEME ); ?></p>

                <hr>

                <h3><?php esc_html_e( 'Theme Option & Customization', 'courtyard' ); ?></h3>
                <p><?php echo sprintf( __( 'Most of theme settings customization options are available through theme customizer. To setup and customise your website elements and sections ', 'courtyard' ), COURTYARD_THEME ); ?><a class="button button-primary button-large" href="<?php echo admin_url( 'customize.php' ); ?>"><?php esc_html_e( 'Go to Customizer', 'courtyard' ); ?></a></p>

            </div>
            <?php
        }

        /**
         * Show Getting Started Content.
         */
        public function recommendation() { ?>

            <div id="recommendation" class="about-theme-tab">
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

                <h3><?php esc_html_e( 'Demo content', 'courtyard' ); ?></h3>

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
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function supports() { ?>

            <div id="support" class="about-theme-tab flex">
                <h3><?php esc_html_e( 'Support Forum', 'courtyard' ); ?></h3>

                <p><?php echo sprintf( __( 'Need help to setup your website with %s theme? Visit our support forum and browse support topics or create new, one of our support member will follow and help you to solver your issue.', 'courtyard' ), COURTYARD_THEME ); ?></p>

                <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/support-forum/forum/courtyard-free-wordpress-hotel-theme/' ); ?>" target="_blank"><?php esc_html_e( 'Visit Support Forum', 'courtyard' ); ?></a></p>

                <hr>

                <h3><?php esc_html_e( 'Documentation', 'courtyard' ); ?></h3>

                <p><?php esc_html_e( 'Theme documentation page will guide you to install and configure theme quick and easy. We have included details, screenshots and stepwise description about theme installation guides and tutorials.', 'courtyard' ); ?></p>

                <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/courtyard-documentation/' ); ?>" target="_blank"><?php esc_html_e( 'View Courtyard Documentation', 'courtyard' ); ?></a></p>
            </div>
            <?php
        }

        /**
         * Show Getting Supports Content.
         */
        public function free_vs_pro() { ?>

            <div id="free_vs_pro" class="about-theme-tab">
                <table>
                    <tr>
                        <td><?php esc_html_e( 'Theme Features', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( 'Free Version', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( 'Pro Version', 'courtyard' ); ?></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Number of Header Layouts', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '1', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '3', 'courtyard' ); ?></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Number of Header Bar Type', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '1 (Sticky Only)', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '3 (Sticky, Scroll and Hide/Show on Scroll)', 'courtyard' ); ?></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Header Top Bar', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Number of Custom Widgets', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '10', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '15', 'courtyard' ); ?></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Smooth Page Scroll', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Coming Soon Page', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Advanced Options for Homepage Widgets', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Google Fonts', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Advanced Post Settings', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>


                    <tr>
                        <td><?php esc_html_e( 'Advanced Page Settings', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Custom 404 Error Page', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Advanced WooCommerce Settings', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Number of Footer Layouts', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '4', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( '8', 'courtyard' ); ?></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Sortable Footer Bar Elements', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Footer Copyright Editor', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'WPML Compatible', 'courtyard' ); ?></td>
                        <td class="redFeature"><span class="dashicons dashicons-no-alt dash-red"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Contact Form 7 Compatible', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'WooCommerce Compatible', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Polylang Compatible', 'courtyard' ); ?></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                        <td class="greenFeature"><span class="dashicons dashicons-yes dash-green"></span></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Theme Support', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( 'Quick Ticket Support', 'courtyard' ); ?></td>
                        <td><?php esc_html_e( 'Support via Forum', 'courtyard' ); ?></td>
                    </tr>
                </table>

                <br>

                <p><?php esc_html_e( 'Need more features and customization option? Try Pro Version of Courtyard theme.', 'courtyard' ); ?></p>
                <p><a class="button button-primary button-large" href="<?php echo esc_url( 'https://precisethemes.com/courtyard-pro/' );?>" target="_blank"><?php echo sprintf( __( 'View %s Pro Version', 'courtyard' ), COURTYARD_THEME ); ?></a><br></p>
            </div>
            <?php
        }

        /**
         * Show Changelog Content.
         */
        public function changelog() {
            global $wp_filesystem; ?>

            <div id="changelog" class="about-theme-tab">
                <div class="wrap about-wrap">

                    <?php

                    $changelog_file = apply_filters( 'courtyard_changelog_file', get_template_directory() . '/readme.txt' );

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

return new Courtyard_Welcome_Screen();
