<?php if( ! defined( 'ABSPATH' ) ) exit; // Exit if file was accessed directly ?>

<div class="wrap">
    <h2>Analytics Settings</h2>
    <?php
    if(isset($_POST['submit'])) {
        ?>
        <div id="setting-error-settings_updated" class="updated settings-error">
            <p><strong>Theme settings saved.</strong></p>
        </div>
        <?php
    }
    ?>
    <p>Here you can insert your google analytics tracking code</p>
    <form method="post">
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label>Tracking code</label>
                </th>
            </tr>
            <tr>
                <td>
                    <p><textarea rows="15" cols="50" class="large-text code" name="theme_analytics"><?php echo stripslashes(get_option('theme_analytics')); ?></textarea></p>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>