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

//$GLOBALS['hide_save_button'] = true;



?>


<a href="https://b2app.tech/privacy-policy.html" target="_blank">
    Privacy Policy
</a>

<h2>Step #2: Enter Mobile App Info</h2>

<table class="form-table">

<tbody><tr valign="top">
	<th scope="row" class="titledesc">
		<label for="b2app_app_name">Mobile App Name</label>
	</th>
	<td class="forminp forminp-text">
		<input name="b2app_app_name" id="b2app_app_name" type="text" style="" value="" class="" placeholder=""> 							</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="b2app_app_icon">Mobile App Icon</label>
	</th>
	<td class="forminp forminp-text">
		<input name="b2app_app_icon" id="b2app_app_icon" accept="image/jpeg, image/png, image/jpg" type="file" style="" value="" class="" placeholder=""> 							</td>
</tr>
<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="b2app_app_icon">Mobile App Logo</label>
	</th>
	<td class="forminp forminp-text">
		<input name="b2app_app_logo" id="b2app_app_logo" accept="image/jpeg, image/png, image/jpg"  type="file" style="" value="" class="" placeholder=""> 							</td>
</tr>
</tbody></table>

<h2>Step #3: Select Mobile App Template & Color Theme</h2>


<table class="form-table form-table-cc">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label>Select Mobile App Template</label>
            </th>
            
            <td class="theme-browser rendered">
<?php

$body = array(
    'action'    => 'get_templates',
);

$args = array(
    'body'        => $body,
    'timeout'     => '5',
    'redirection' => '5',
    'httpversion' => '1.0',
    'blocking'    => true,
    'headers'     => array(),
    'cookies'     => array(),
);

$response = wp_remote_post( 'https://builder.b2app.tech/cms.php', $args );

$server_output = wp_remote_retrieve_body( $response );

$templates = json_decode($server_output, true);


?>
                <div class="themes wp-clearfix">
                    <?php
                    foreach($templates as $template) {
                        $image_src = plugin_dir_url( __FILE__ ).'images/apptypes/'.$template['images'];
                        ?>
                        <label class="theme" data-slug="storefront">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="appType"
                                value="<?php echo intval($template['id']);?>"
                                id="appType<?php echo intval( $template['id']);?>">
                    
                            <div class="theme-screenshot">
                                <img src="<?php echo esc_url($image_src);?>" alt="">
                            </div>
                    
                            <div class="theme-id-container">
                                <h2 class="theme-name" id="storefront-name">
                                    <span>Selected</span>
                                    <span>Select</span>
                                </h2>
                            </div>
                        </label>
                        <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table class="form-table form-table-cc">
    <tbody>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label>Select App Color Theme</label>
            </th>
            <td class="theme-browser rendered">
<?php

$body = array(
    'action'    => 'get_color_themes',
);

$args = array(
    'body'        => $body,
    'timeout'     => '5',
    'redirection' => '5',
    'httpversion' => '1.0',
    'blocking'    => true,
    'headers'     => array(),
    'cookies'     => array(),
);

$response = wp_remote_post( 'https://builder.b2app.tech/cms.php', $args );

$server_output = wp_remote_retrieve_body( $response );
$themes = json_decode($server_output, true);



?>
                <div class="themes-color wp-clearfix">
                    <?php
                    foreach($themes as $theme) {
                        $theme_props = json_decode($theme['properties']);
                        ?>
                        <label class="theme" data-slug="storefront">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="appTheme"
                            value="<?php echo intval($theme['id']);?>"
                            id="appTheme<?php echo intval($theme['id']);?>">
                
                        <div class="theme-screenshot">
                            <div class="colorsGrid" for="appTheme<?php echo intval($theme['id']);?>">
                                <div class="colorsGrid--accent" style="background-color: <?php echo esc_html($theme_props->primary_accent, 'text_domain');?>; color: white;">Accent</div>
                                                    <div class="colorsGrid--background" style="background-color: <?php echo  esc_html($theme_props->primary_background, 'text_domain')?>;">Background</div>
                                                    <div class="colorsGrid--secondary" style="background-color: <?php echo esc_html($theme_props->secondary_accent, 'text_domain');?>;">Secondary</div>
                                                    <div class="colorsGrid--text" style="background-color: <?php echo esc_html($theme_props->primary_text, 'text_domain');?>; color: white;">Text</div>
                                                    <div class="colorsGrid--textLight" style="background-color: <?php echo esc_html($theme_props->secondary_text, 'text_domain');?>; color: white;">Subtext</div>
                            </div>
                        </div>
                
                        <div class="theme-id-container">
                            <h2 class="theme-name" id="storefront-name">
                                <span>Selected</span>
                                <span>Select</span>
                            </h2>
                        </div>
                    </label>
                        <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>


<?php