<?php
/**
 * Build the primary admin page
 */
function gj_display_admin_settings() {
	$asset_count = get_option( 'gj_posts' ) ? count( get_option( 'gj_posts' ) ) : 0;
	$tax_count   = get_option( 'gj_taxes' ) ? count( get_option( 'gj_taxes' ) ) : 0;
	//$ui          = new GJ_Admin_UI();
	?>
    <div class="wrap" style="margin: 10px 20px 0 2px;">
        <h1 style="font-size:2.5rem;"><?php echo esc_html( get_admin_page_title() ); ?>
            <small style="font-size: 1rem; color: #666;"><?php esc_html_e( GJ_VERSION, GJ_TEXT ); ?></small>
        </h1>
        <hr style="margin: 1.5rem 0;">
        <p style="font-size: 1rem;">
            <strong><?php echo $asset_count; ?></strong> registered asset types<br>
            <strong><?php echo $tax_count; ?></strong> registered taxonomies
        </p>

        <div class="postbox-container">
            <div id="poststuff">
                <form action="<?php esc_url( admin_url( 'admin-post.php' ) ); ?>" class="gj-form" method="post">
					<?php wp_nonce_field( 'gj_create_asset_nonce_action', 'gj_create_asset_nonce_field' ); ?>
                    <input type="hidden" name="action" value="gj_process_asset">
                    <div class="postbox basic-settings">
                        <div class="postbox-header">
                            <h2><?php esc_html_e( 'Basic Settings', GJ_TEXT ); ?></h2>
                        </div>
                        <div class="inside">
                            <div class="main">
                                <table class="form-table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="singular_name">
												<?php esc_html_e( 'Asset Name (Singular)', GJ_TEXT ); ?>
                                            </label>
                                        </th>
                                        <td>
                                            <input type="text" name="singular_name" class="regular-text"
                                                   id="singular_name"
                                                   placeholder="Asset" maxlength="32">
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'This is the name of your new asset type', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="name">
												<?php esc_attr_e( 'Asset Name (Plural)', GJ_TEXT ); ?>
                                            </label>
                                        </th>
                                        <td>
                                            <input type="text" name="name" class="regular-text"
                                                   id="name"
                                                   placeholder="Assets" maxlength="32">
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'This is the plural version of the name of your new asset type', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
											<?php esc_attr_e( 'Hierarchical Display', GJ_TEXT ); ?>
                                        </th>
                                        <td>
                                            <select name="hierarchical" id="hierarchical" class="regular-text">
                                                <option value=" true">Yes</option>
                                                <option value="false" selected="selected">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Do you want assets of this type to have parent/child relationships?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="asset_description">
												<?php esc_attr_e( 'Description (optional)', GJ_TEXT ); ?>
                                            </label>
                                        </th>
                                        <td>
                                            <textarea name="asset_description" id="asset_description"
                                                      class="regular-text" rows="5"></textarea>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Describe your custom asset', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p>
                                    <input type="submit" name="submit" id="submit" class="button button-primary"
                                           value="Save Asset">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="postbox advanced-settings">
                        <div class="postbox-header">
                            <h2><?php esc_html_e( 'Advanced Setup', GJ_TEXT ); ?></h2>
                        </div>
                        <div class="inside">
                            <div class="main">
                                <table class="form-table" role="presentation">
                                    <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="public"><?php esc_attr_e( 'Public', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="public" id="public" class="regular-text">
                                                <option value=" true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Is this asset type intended for use publicly either via the admin interface or by front-end users?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="publicly_queryable"><?php esc_attr_e( 'Public Query', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="publicly_queryable" id="publicly_queryable"
                                                    class="regular-text">
                                                <option value=" true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should queries be performed on the front end for this asset type?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="exclude_from_search"><?php esc_attr_e( 'Exclude From Search', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="show_ui" id="show_ui" class="regular-text">
                                                <option value="true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should queries be performed on the front end for this asset type?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="show_ui"><?php esc_attr_e( 'Show Interface', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="show_ui" id="show_ui" class="regular-text">
                                                <option value="true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should queries be performed on the front end for this asset type?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="show_in_menu"><?php esc_attr_e( 'Create Menu', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="show_in_menu" id="show_in_menu" class="regular-text">
                                                <option value="true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should WordPress create a section in the admin menu for this asset type?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="show_in_nav_menus"><?php esc_attr_e( 'Show in Nav Menus', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="show_in_nav_menus" id="show_in_nav_menus"
                                                    class="regular-text">
                                                <option value="true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should WordPress make this asset type available for selection in navigation menus?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="show_in_admin_bar"><?php esc_attr_e( 'Show in Admin Bar', GJ_TEXT ); ?></label>
                                        </th>
                                        <td>
                                            <select name="show_in_admin_bar" id="show_in_admin_bar"
                                                    class="regular-text">
                                                <option value="true" selected="selected">Yes</option>
                                                <option value="false">No</option>
                                            </select>
                                            <br>
                                            <span class="description"><?php esc_attr_e( 'Should WordPress make this asset type available available via the admin bar?', GJ_TEXT ); ?></span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p>
                                    <input type="submit" name="submit" id="submit" class="button button-primary"
                                           value="Save Asset">
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php
}