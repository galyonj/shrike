<?php
/**
 * Build the assets management page
 * @since             1.0.5
 * @author            galyonj
 * @package           Asset_Management
 * @subpackage        inc/display-manage-assets
 */

function gj_manage_assets() {
	?>
    <div class="wrap gj-wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Manage Custom Asset Types', GJ_TEXT ); ?></h1>
        <hr>
        <div class="row">
            <div class="col">
                <h2><?php esc_html_e( 'Add Custom Asset Type', GJ_TEXT ); ?></h2>
                <h3><?php esc_html_e( 'Basic Settings', GJ_TEXT ); ?></h3>
                <form action="<?php esc_url( admin_url( 'admin-post.php' ) ); ?>" class="gj-form" method="post">
					<?php wp_nonce_field( 'gj_create_asset_nonce_action', 'gj_create_asset_nonce_field' ); ?>
                    <input type="hidden" name="action" value="gj_process_asset">
                    <table class="form-table" role="presentation">
                        <tbody>
                        <tr>
                            <th scope="row">
                                <label for="singular_name">
									<?php esc_html_e( 'Name (Singular)', GJ_TEXT ); ?>
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
									<?php esc_attr_e( 'Name (Plural)', GJ_TEXT ); ?>
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
                            <textarea name="asset_description" id="asset_description" class="regular-text"
                                      rows="5"></textarea>
                                <br>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p>
                        <input type="submit" name="submit" id="submit" class="button button-primary"
                               value="Save Asset">
                    </p>
                </form>
            </div>
            <div class="col">
                <pre>
                    <?php print_r( $_POST ); ?>
                    <hr>
                    <?php print_r( get_option( 'gj_assets' ) ); ?>
                </pre>
            </div>
        </div>
    </div>
	<?php
}