<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       brokebot.com
 * @since      1.0.0
 *
 * @package    BrokeBot
 * @subpackage BrokeBot/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
<?php if(isset($_GET['settings-updated']) ) : ?>
<div id="message" class="updated">
    <p><strong><?php _e('Settings saved.') ?></strong></p>
</div>
<?php endif; ?>

<?php    
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general-options';    
?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=brokebot-settings&tab=general-options" class="nav-tab <?php echo $active_tab == 'general-options' ? 'nav-tab-active' : ''; ?>">General Options</a>
            <a href="?page=brokebot-settings&tab=messaging-options" class="nav-tab <?php echo $active_tab == 'messaging-options' ? 'nav-tab-active' : ''; ?>">Messaging Options</a>
        </h2>

    <form id="brokebot-settings-form" method="post" action="options.php">

    <?php
      
        
    ?>

    <?php if( $active_tab == 'general-options' ) : ?>

    <?php
        settings_fields($this->plugin_name.'-general-options');
        do_settings_sections($this->plugin_name.'-general-options');
        $general_options = get_option($this->plugin_name.'-general-options');

        $brokebot_enable = $general_options['brokebot_enable'];
        $brokebot_testmode = $general_options['brokebot_testmode'];
        $brokebot_poweredby_optin = $general_options['brokebot_poweredby_optin'];
        $brokebot_theme = $general_options['brokebot_theme'];
        $brokebot_cookie_hide = $general_options['brokebot_cookie_hide'];
        $brokebot_cookie_days = intval($general_options['brokebot_cookie_days']);
        $brokebot_redirect_auto = $general_options['brokebot_redirect_auto'];
        $brokebot_pages = $general_options['brokebot_pages'];
        $brokebot_posttypes = $general_options['brokebot_posttypes'];
    ?>

    <!-- Enable Brokebot -->    
    <fieldset>
        <div class="wrapper">
            <label class="">
                <span>Enable BrokeBot</span>
            </label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_enable">
                <input type="checkbox" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_enable" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_enable]" value="1" <?php checked($brokebot_enable, 1); ?> />
                <span><?php esc_attr_e('Enable BrokeBot', $this->plugin_name); ?></span>
            </div>
        </div>
    </fieldset>

    <!-- Testing Mode -->
    <fieldset>
        <div class="wrapper">
            <label class=""><span>Enable Test Mode</span></label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_testmode">
                <input type="checkbox" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_testmode" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_testmode]" value="1" <?php checked($brokebot_testmode, 1); ?> />
                <span><?php esc_attr_e('Enable Test Mode (only show BrokeBot for admins)', $this->plugin_name); ?></span>
            </div>
        </div>
    </fieldset>

    <!-- Brokebot Theme -->
    <fieldset>
        <div class="wrapper">
            <label class=""><span>Select Theme</span></label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_theme">
                <p>Select the BrokeBot Theme here.</p>
                <select id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_theme" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_theme]">
                    <option value="light" <?php if(!empty($brokebot_theme) && $brokebot_theme == 'light') echo 'selected'; ?>>Light Theme</option>
                    <option value="dark" <?php if(!empty($brokebot_theme) && $brokebot_theme == 'dark') echo 'selected'; ?>>Dark Theme</option>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset>
    <div class="wrapper">
        <label class="">
            <span>Automatic Redirect after BrokeBot is finished with message</span>
        </label>
        <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_redirect_auto">
            <input type="checkbox" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_redirect_auto" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_redirect_auto]" value="1" <?php checked($brokebot_redirect_auto, 1); ?> />
            <span><?php esc_attr_e('Automatic Redirect enabled', $this->plugin_name); ?></span>
        </div>
        </div>
    </fieldset>

    <fieldset>
    <div class="wrapper">
        <label class="">
            <span>Hide BrokeBot until X days</span>
        </label>
        <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_cookie_hide">
            <input type="checkbox" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_cookie_hide" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_cookie_hide]" value="1" <?php checked($brokebot_cookie_hide, 1); ?> />
            <span><?php esc_attr_e('Hide BrokeBot until X days', $this->plugin_name); ?></span>
            
        </div>
        </fieldset>

        <fieldset>
        <div class="wrapper">
            <label class="">
                <span>Amount of days to hide BrokeBot</span>
            </label>
            <div>                    
                    <input type="number" class="" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_cookie_days" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_cookie_days]" value="<?php if(!empty($brokebot_cookie_days)) echo $brokebot_cookie_days; ?>"/>
                </div>
                </div>
        </fieldset>


    <fieldset class="no-margin">           
            <input type="hidden" class="reset-cookies-field" id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_reset_cookies" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_reset_cookies]" value="0"/>
    </fieldset>
    
    <fieldset class="reset-cookies">
        <div class="wrapper">
        <label><span>Reset all cookie settings</span></label>

        <div><button type='button' class="button button-primary" name='reset-cookies-button' id='reset-cookies-button'>Reset Cookies</button></div>
            </div>
    </fieldset>

    <!-- Select Pages -->
    <fieldset>
        <div class="wrapper">
        <label class=""><span>Show on Pages</span></label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_pages">
                <p>Select the pages you would like BrokeBot to appear.</p>
                <select multiple id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_pages" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_pages][]">
                    <?php
                        $pages = get_pages();
                        foreach ($pages as $page) {
                            $selected = in_array($page->ID,$brokebot_pages) ? 'selected' : '';
                            echo '<option value="'.$page->ID.'" '.$selected.'>'.$page->post_title.'</option>';
                        }
                    ?>
                </select>
            </div>
                    </div>
    </fieldset>

    <!-- Select Post Types -->
    <fieldset>
    <div class="wrapper">
        <label class=""><span>Show on Post Types</span></label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_posttypes">
                <p>Select the post types you would like Brokebot to appear.</p>
                <select multiple id="<?php echo $this->plugin_name.'-general-options'; ?>-brokebot_posttypes" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_posttypes][]">
                    <?php
                        $posttypes_all = get_post_types();
                        $disallowed = ['page','attachment','revision','nav_menu_item','custom_css','customize_changeset','oembed_cache','user_request','scheduled-action','product_variation','shop_order','shop_order_refund','shop_coupon'];
                        $posttypes = array_diff($posttypes_all, $disallowed);
                        foreach ($posttypes as $posttype) {
                            $selected = in_array($posttype,$brokebot_posttypes) ? 'selected' : '';
                            echo '<option value="'.$posttype.'" '.$selected.'>'.$posttype.'</option>';
                        }
                    ?>
                </select>
            </div>
                    </div>
    </fieldset>

    <!-- Powered By Opt In -->
    <fieldset>
        <div class="wrapper">
            <label class=""><span>Show Support for BrokeBot</span></label>
            <div for="<?php echo $this->plugin_name.'-general-options'; ?>-poweredby_optin">
                <p><?php esc_attr_e('Show your support for BrokeBot! This will show a Built by BrokeBot message on the BrokeBot window.', $this->plugin_name); ?></p>
                <input type="checkbox" id="<?php echo $this->plugin_name.'-general-options'; ?>-poweredby_optin" name="<?php echo $this->plugin_name.'-general-options'; ?>[brokebot_poweredby_optin]" value="1" <?php checked($brokebot_poweredby_optin, 1); ?> />                
            </div>
        </div>
    </fieldset>

    <?php endif; ?>

    <?php if( $active_tab == 'messaging-options' ) : ?>

    <?php
        settings_fields($this->plugin_name.'-messaging-options');
        do_settings_sections($this->plugin_name.'-messaging-options');        
        $messaging_options = get_option($this->plugin_name.'-messaging-options');

        $brokebot_welcome = $messaging_options['brokebot_welcome'];
        $brokebot_follow_up = $messaging_options['brokebot_follow_up'];
        $brokebot_cta_text = $messaging_options['brokebot_cta_text'];
        $brokebot_redirect = $messaging_options['brokebot_redirect'];
    ?>

    <!-- Messages and Redirect -->
    <fieldset>
    <div class="wrapper">
            
            <label class=""><span><?php _e('BrokeBot Welcome message', $this->plugin_name); ?></span></label>
            <div><p>Set the initial BrokeBot Welcome message here. <em>Character Limit: 200</em></p>
            <textarea maxlength="200" class="" id="<?php echo $this->plugin_name.'-messaging-options'; ?>-brokebot_welcome" name="<?php echo $this->plugin_name.'-messaging-options'; ?>[brokebot_welcome]"><?php if(!empty($brokebot_welcome)) echo $brokebot_welcome; ?></textarea>
                    </div>
                </div>
        </fieldset>
    <fieldset>
    <div class="wrapper">            
            <label class=""><span><?php _e('BrokeBot Follow Up message', $this->plugin_name); ?></span></label>
            <div><p>Set the BrokeBot Follow Up message here. <em>Character Limit: 200</em></p>
            <textarea maxlength="200" class="" id="<?php echo $this->plugin_name.'-messaging-options'; ?>-brokebot_follow_up" name="<?php echo $this->plugin_name.'-messaging-options'; ?>[brokebot_follow_up]"><?php if(!empty($brokebot_follow_up)) echo $brokebot_follow_up; ?></textarea>
                    </div>
            </div>
        </fieldset>
     <fieldset>
     <div class="wrapper">            
            <label class=""><span><?php _e('BrokeBot CTA message', $this->plugin_name); ?></span></label>
            <div><p>Set the BrokeBot CTA message here. <em>Character Limit: 30</em></p>
            <textarea maxlength="30" class="" id="<?php echo $this->plugin_name.'-messaging-options'; ?>-brokebot_cta_text" name="<?php echo $this->plugin_name.'-messaging-options'; ?>[brokebot_cta_text]"><?php if(!empty($brokebot_cta_text)) echo $brokebot_cta_text; ?></textarea>
                    </div>
                </div>
        </fieldset>
    <fieldset>
    <div class="wrapper">            
            <label class=""><span><?php _e('BrokeBot redirect', $this->plugin_name); ?></span></label>
            <div><p>Set the BrokeBot Redirect Url here.</p>
            <input type="url" class="" id="<?php echo $this->plugin_name.'-messaging-options'; ?>-brokebot_redirect" name="<?php echo $this->plugin_name.'-messaging-options'; ?>[brokebot_redirect]" value="<?php if(!empty($brokebot_redirect)) echo $brokebot_redirect; ?>"/>
            </div>
            </div>
        </fieldset>

    <?php endif; ?>
    

    <?php submit_button('Save all changes', 'primary','submit_button', TRUE); ?>

    </form>

</div>