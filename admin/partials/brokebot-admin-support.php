<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       brokebot.com
 * @since      1.0.0
 *
 * @package    Brokebot
 * @subpackage Brokebot/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2>BrokeBot Support</h2>
<div class="support-wrapper">
    <div class="support-left">
        <p>Please allow 48-72 hours for responses to support tickets.</p>
    </div>
    <div class="support-right">
        <form id="brokebot-support-form">
            <fieldset>
                <legend class="screen-reader-text">
                    <span>Full Name</span>
                </legend>
                <label for="full-name">
                    <p>Full Name</p>
                    <input type="text" id="full-name" name="full-name" />
                </label>
            </fieldset>
            <fieldset>
                <legend class="screen-reader-text">
                    <span>Email</span>
                </legend>
                <label for="email">
                    <p>Email</p>
                    <input type="email" id="email" name="email" />
                </label>
            </fieldset>
            <fieldset>
                <legend class="screen-reader-text">
                    <span>Subject</span>
                </legend>
                <label for="subject">
                    <p>Subject</p>
                    <input type="text" id="subject" name="subject" />
                </label>
            </fieldset>
            <fieldset>
                <legend class="screen-reader-text">
                    <span>Message</span>
                </legend>
                <label for="message">
                    <p>Message</p>
                    <textarea id="message" name="message"></textarea>
                </label>
            </fieldset>            
        </form>
        <p class="submit">
                <button name="support_submit_button" id="support_submit_button" class="button button-primary">Submit Support Form</button>
            </p>
            <div id="support-message"></div>
    </div>
</div>
