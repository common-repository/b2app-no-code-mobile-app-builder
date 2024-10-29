<?php
/**
 * Displays in the WC Settings page
 *
 * @link        https://b2app.tech
 * @since       1.0.0
 *
 * @package     B2App
 * @subpackage  B2App/admin
 *
 */

$GLOBALS['hide_save_button'] = true;
$option_value_email = (array) WC_Admin_Settings::get_option( "b2app_email" );
$option_value_password = (array) WC_Admin_Settings::get_option( "b2app_password" );
?>

<h2>Congratulations! Your mobile app has been created.</h2>




<table class="form-table form-table-cc">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label>Download Preview App for your mobile app.</label>
            </th>
            <td class="theme-browser rendered">
                <div class="text-center d-flex gap-5">
                    <a style="font-size: 0;" href="https://play.google.com/store/apps/details?id=tech.b2app.app.b2app" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'images/download_app_qr.svg'); ?>" width="200" height="200" alt="">
                    </a>
                    <a class="store_btn btn btn-iconized btn-lg" href="https://play.google.com/store/apps/details?id=tech.b2app.app.b2app" target="_blank" rel="noopener">
                        <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="56" height="56" rx="16" fill="#1BD2A4"></rect>
                            <path d="M18.0016 16.1063C18.25 15.9636 18.5558 15.9646 18.8032 16.109L31.3505 23.4283L27.4668 26.9236L17.6001 18.0436V16.8C17.6001 16.5135 17.7533 16.249 18.0016 16.1063Z" fill="white"></path>
                            <path d="M17.6001 20.1962V35.8036L26.2709 27.9999L17.6001 20.1962Z" fill="white"></path>
                            <path d="M17.6001 37.9562V39.2C17.6001 39.4865 17.7533 39.751 18.0016 39.8937C18.25 40.0364 18.5558 40.0354 18.8032 39.891L31.3506 32.5717L27.4668 29.0762L17.6001 37.9562Z" fill="white"></path>
                            <path d="M32.8018 31.7252L38.0032 28.691C38.249 28.5477 38.4001 28.2845 38.4001 28C38.4001 27.7155 38.249 27.4523 38.0032 27.309L32.8017 24.2748L28.6627 27.9999L32.8018 31.7252Z" fill="white"></path>
                        </svg>
                        <span class="btn--text">
                            <small>Get it on</small>
                            <strong>Google Play</strong>
                        </span>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="form-table form-table-cc">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label>Information for b2app.tech</label>
            </th>
            <td class="theme-browser rendered">
                <fieldset>
                    <legend class="screen-reader-text"><span>Email</span></legend>
                    <input class="input-text regular-input" type="text" value="<?php echo esc_attr($option_value_email[0]);?>" readonly="">
                    <p class="description">Email</p>
                </fieldset>
                <fieldset>
                    <legend class="screen-reader-text"><span>Password</span></legend>
                    <input class="input-text regular-input inputPassword" type="password" value="<?php echo esc_attr( $option_value_password[0]);?>" readonly="">
                    <p class="description">Password <a href="javascript:void(0)" onclick="togglePassword(this)" class="togglePass">
                        <span class="show_link">show</span>
                        <span class="hide_link">hide</span>
                    </a></p>
                </fieldset>
                <br>
                <p>
                    <a href="https://b2app.tech/login.php" target="_blank" rel="noopener" class="button-primary">Manage your created Mobile App</a>
                </p>
            </td>
        </tr>
        
    </tbody>
</table>




<?php