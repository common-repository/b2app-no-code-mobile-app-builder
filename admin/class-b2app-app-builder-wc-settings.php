<?php
/**
 * Extends the WC_Settings_Page class
 *
 * @link        https://b2app.tech
 * @since       1.0.0
 *
 * @package     B2App
 * @subpackage  B2App/admin
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'B2App_WC_Settings' ) ) {

    /**
     * Settings class
     *
     * @since 1.0.0
     */
    class B2App_WC_Settings extends WC_Settings_Page {

        /**
         * Constructor
         * @since  1.0
         */
        public function __construct() {
                
            $this->id    = 'b2app';
            $this->label = __( 'B2App', 'b2app' );

            // Define all hooks instead of inheriting from parent                    
            add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
            add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
            add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
            add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
            
        }


        /**
         * Get sections.
         *
         * @return array
         */
        public function get_sections() {
            $sections = array(
                '' => __( 'Settings', 'b2app' )
            );

            return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
        }


        /**
         * Get settings array
         *
         * @return array
         */
        public function get_settings() {

            global $current_section;
            $prefix = 'b2app_';
            $settings = array();

            switch ($current_section) {
                case 'help':
                    $settings = array(                              
                            array()
                    );
                    break;
                default:
                     include 'partials/b2app-app-builder-settings-main.php';               
            }   

            return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section);                   
        }

        /**
         * Output the settings
         */
        public function output() {                  
            global $current_section;

            switch ($current_section) {
                case 'help':
                    $settings = $this->get_settings();
                    include 'partials/b2app-app-builder-settings-help.php';
                    break;
                default:
                    $settings = $this->get_settings();
                    $option_value = (array) WC_Admin_Settings::get_option( "b2app_agree");
                    
                    if($option_value[0] == "yes") {
                        include 'partials/b2app-app-builder-settings-app-created.php';
                        
                    }
                    else {
                        WC_Admin_Settings::output_fields( $settings );
                        include 'partials/b2app-app-builder-settings-app-info.php';
                    }
                   
            }   
        }

        /**
         * Save settings
         *
         * @since 1.0
         */
        public function save() {                    
            $settings = $this->get_settings();
            
            $option_value = (array) WC_Admin_Settings::get_option( "b2app_agree");
            if($option_value[0] == "yes") {
                WC_Admin_Settings::save_fields( $settings );
            }
            else {
                if(!empty($_POST['appType']) && !empty($_POST['appTheme']) && !empty($_POST['b2app_app_name']) && !empty($_POST['b2app_email']) && !empty($_POST['b2app_password']) && !empty($_FILES['b2app_app_icon'])) {
                    $appIconTmpfile = $_FILES['b2app_app_icon']['tmp_name'];
                    $appIconFilename = basename($_FILES['b2app_app_icon']['name']);
                    
                    $appLogoTmpfile = $_FILES['b2app_app_logo']['tmp_name'];
                    $appLogoFilename = basename($_FILES['b2app_app_logo']['name']);
                    
                    global $woocommerce, $wpdb;

                    $current_user = wp_get_current_user(); 
                    $user_id = $current_user->ID;
                    $app_name = "B2App ".sanitize_text_field($_POST['b2app_app_name']);
                    $app_user_id = $user_id;
                    $scope = 'read_write';
                    $description = 'B2App '.sanitize_text_field($_POST['b2app_app_name']);
                    $user        = $current_user;
                    
                    // Created API keys.
                    $permissions     = in_array( $scope, array( 'read', 'write', 'read_write' ), true ) ? sanitize_text_field( $scope ) : 'read';
                    $consumer_key    = 'ck_' . wc_rand_hash();
                    $consumer_secret = 'cs_' . wc_rand_hash();
                    
                    $wpdb->insert(
                    	$wpdb->prefix . 'woocommerce_api_keys',
                    	array(
                    		'user_id'         => $user->ID,
                    		'description'     => $description,
                    		'permissions'     => $permissions,
                    		'consumer_key'    => wc_api_hash( $consumer_key ),
                    		'consumer_secret' => $consumer_secret,
                    		'truncated_key'   => substr( $consumer_key, -7 ),
                    	),
                    	array(
                    		'%d',
                    		'%s',
                    		'%s',
                    		'%s',
                    		'%s',
                    		'%s',
                    	)
                    );
                    
                    
                    $data = array(
                        'action' => 'create_user_and_app',
                        'email' => sanitize_email($_POST['b2app_email']),
                        'password' => sanitize_text_field($_POST['b2app_password']),
                        'name' => sanitize_text_field($_POST['b2app_app_name']),
                        'appType' => intval(sanitize_text_field($_POST['appType'])),
                        'appTheme' => intval(sanitize_text_field($_POST['appTheme'])),
                        'cs_key' => $consumer_key,
                        'cs_secret' => $consumer_secret,
                        'site' => sanitize_text_field($_SERVER['HTTP_HOST']),
                    );
                    
                    $data_check = array(
                        'action' => 'check_email',
                        'email' => sanitize_email($_POST['b2app_email'])
                    );
                    
                    $args = array(
                        'body'        => $data_check,
                        'timeout'     => '5',
                        'redirection' => '5',
                        'httpversion' => '1.0',
                        'blocking'    => true,
                        'headers'     => array(),
                        'cookies'     => array(),
                    );
                    
                    $response = wp_remote_post( 'https://builder.b2app.tech/cms.php', $args );
                    
                    $result = wp_remote_retrieve_body( $response );
                    
                   
                    
                    if($result == "ok") {
                        
                    $boundary = wp_generate_password(24);
                    $headers  = array(
                    	'content-type' => 'multipart/form-data; boundary=' . $boundary,
                    );
                    $payload = '';
                    // First, add the standard POST fields:
                    foreach ( $data as $name => $value ) {
                    	$payload .= '--' . $boundary;
                    	$payload .= "\r\n";
                    	$payload .= 'Content-Disposition: form-data; name="' . $name .
                    		'"' . "\r\n\r\n";
                    	$payload .= $value;
                    	$payload .= "\r\n";
                    }
                    // Upload the file icon
                  
                    $icon_file_type = sanitize_text_field($_FILES['b2app_app_icon']['type']);
                    $payload .= '--' . $boundary;
                	$payload .= "\r\n";
                	$payload .= 'Content-Disposition: form-data; name="' . 'icon' .
                		'"; filename="' . basename( $appIconFilename ) . '"' . "\r\n";
                	        $payload .= 'Content-Type: '.$icon_file_type. "\r\n";
                	$payload .= "\r\n";
                	$payload .= file_get_contents( $appIconTmpfile );
                	$payload .= "\r\n";
                    
                    // Upload the file logo
                    $logo_file_type = sanitize_text_field($_FILES['b2app_app_logo']['type']);
                    $payload .= '--' . $boundary;
                	$payload .= "\r\n";
                	$payload .= 'Content-Disposition: form-data; name="' . 'logo' .
                		'"; filename="' . basename( $appLogoFilename ) . '"' . "\r\n";
                	        $payload .= 'Content-Type: '.$logo_file_type. "\r\n";
                	$payload .= "\r\n";
                	$payload .= file_get_contents( $appLogoTmpfile );
                	$payload .= "\r\n";
                    
                    
                    $payload .= '--' . $boundary . '--';  
                    
                    
                        
                    $args = array(
                        'body'        => $payload,
                        'timeout'     => '5',
                        'redirection' => '5',
                        'httpversion' => '1.0',
                        'blocking'    => true,
                        'headers'     => array(),
                        'cookies'     => array(),
                        'headers'    => $headers,
                    );
                    
                    $response = wp_remote_post( 'https://builder.b2app.tech/cms.php', $args );
                    
                    $result_send_data = wp_remote_retrieve_body( $response );
                        
                        
                        if($result_send_data == "ok") {
                            WC_Admin_Settings::save_fields( $settings );
                        }
                        else {
                            add_action( 'admin_notices', 'b2app_error_create_app' );
                        }
                    }
                    else {
                        add_action( 'admin_notices', 'b2app_error_email' );
                    }
                    
                    
                }
                else {
                    add_action( 'admin_notices', 'b2app_missing_b2app_inputs' );
                }
            }
            
        }

    }

}


return new B2App_WC_Settings();