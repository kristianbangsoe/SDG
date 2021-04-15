<?php if( ! defined( 'ABSPATH' ) ) exit; // Exit if file was accessed directly ?>

<div class="wrap">

    <h2><?php _e('General Settings', 'html24');?></h2>

    <?php if(isset($_POST['submit'])) : ?>

        <div id="setting-error-settings_updated" class="updated settings-error">

            <p>
                <strong><?php _e('Theme settings saved.', 'html24');?></strong>
            </p>

        </div>

    <?php endif; ?>

    <p><?php _e('Here you can edit the general setting for the theme', 'html24');?></p>

    <form method="post">

        <table class="form-table">

            <tbody>

            <tr>

                <th>

                    <label for="theme_logo"><?php _e('Theme Logo', 'html24');?></label>

                </th>

                <td>

                    <input id="theme_logo" class="button" type="hidden" size="36" name="theme_logo" value="<?php echo get_option('theme_logo'); ?>" />

                    <input id="theme_logo_button" data-text-input="theme_logo" class="upload_logo_button button" type="button" value="<?php _e('Upload/Insert', 'html24');?>" />

                    <input class="remove_logo button" type="button" data-logo-type="theme_logo" value="<?php _e('Delete Logo', 'html24');?>">

                    <p class="description"><?php _e('Here you can upload the logo for the theme, or use an image that already exists in the media library', 'html24');?></p>

                </td>
            </tr>

            <tr>

                <th>

                    <label><?php _e('Current theme logo', 'html24');?></label>

                </th>

                <td id="theme_logo_wrapper" class="theme-logo">

                    <?php if(get_option('theme_logo')) :

                        $attachment_id = get_attachment_id_by_guid(get_option('theme_logo'));

                        $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'full'); ?>

                        <img src="<?php echo $attachment_image_array[0]; ?>" height="100" alt="<?php echo get_bloginfo().' logo'; ?>" />

                    <?php endif; ?>

                </td>

            </tr>

            <tr>

                <th>

                    <label for="theme_backend_logo"><?php _e('Theme Backend Logo', 'html24');?></label>

                </th>

                <td>

                    <input id="theme_backend_logo" class="button" type="hidden" size="36" name="theme_backend_logo" value="<?php echo get_option('theme_backend_logo'); ?>" />

                    <input id="theme_backend_logo_button" data-text-input="theme_backend_logo" class="upload_logo_button button" type="button" value="<?php _e('Upload/Insert', 'html24');?>" />

                    <input class="remove_logo button" type="button" data-logo-type="theme_backend_logo" value="<?php _e('Delete Logo', 'html24');?>">

                    <p class="description"><?php _e("Here you can upload the logo for the backend login screen. If you don't upload one. The standard wordpress logo will be used", "html24");?></p>

                </td>

            </tr>

            <tr>

                <th>

                    <label><?php _e('Current theme backend logo', 'html24');?></label>

                </th>

                <td id="theme_backend_logo_wrapper" class="theme-logo">

                    <?php if(get_option('theme_backend_logo')) :

                        $attachment_id = get_attachment_id_by_guid(get_option('theme_backend_logo'));

                        $attachment_image_array = wp_get_attachment_image_src($attachment_id, 'full'); ?>

                        <img src="<?php echo $attachment_image_array[0]; ?>" height="100" alt="<?php echo get_bloginfo().' logo'; ?>" />

                    <?php endif; ?>

                </td>

            </tr>

            </tbody>

        </table>

        <p class="submit">

            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save changes', 'html24');?>">

        </p>

    </form>

</div>