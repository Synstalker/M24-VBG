<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="tpl-category-field">
    
	<?php
	/**
	 * Fires before category field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field', 'category', $this );
	?>
    <div class="totalcontest-tab-content active" tab="editor>form>field-{{field.uid}}>basic">
		<?php
		/**
		 * Fires before category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/basic', 'category', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-basic-label-template'"></div>
        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field" ng-init="fieldsCtrl.refreshCategories()">
                <div class="totalcontest-row">
                    <div class="totalcontest-column">
                        <label class="totalcontest-settings-field-label" for="field-{{field.uid}}-options">
							<?php _e( 'Categories', 'totalcontest' ); ?>
                            <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'The categories that contestant can choose from.', 'totalcontest' ); ?>">?</span>
                        </label>
                    </div>
                    <div class="totalcontest-column totalcontest-column-end">
                        <div class="button-group">
                            <a href="<?php echo esc_attr( admin_url( 'edit-tags.php?taxonomy=' . TC_SUBMISSION_CATEGORY_TAX_NAME . '&post_type=' . TC_CONTEST_CPT_NAME ) ) ?>" target="_blank" class="button button-small"><?php _e( 'Manage', 'totalcontest' ); ?></a>
                            <button type="button" class="button button-small" ng-click="fieldsCtrl.refreshCategories()"><?php _e( 'Refresh', 'totalcontest' ); ?></button>
                        </div>
                    </div>
                </div>
                <select name="" id="field-{{field.uid}}-options" class="totalcontest-settings-field-input widefat" multiple size="7" ng-model="field.options" ng-options="category.id as category.name for category in fieldsCtrl.categories"></select>
                <p class="totalcontest-feature-tip"><?php _e( 'Hold Control/Command for multiple selection.', 'totalcontest' ); ?></p>
            </div>
        </div>
		<?php
		/**
		 * Fires after category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/basic', 'category', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>validations">
		<?php
		/**
		 * Fires before category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/validations', 'category', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-validations-filled-template'"></div>
		<?php
		/**
		 * Fires after category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/validations', 'category', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>html">
		<?php
		/**
		 * Fires before category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/html', 'category', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-html-css-class-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-html-template-template'"></div>
		<?php
		/**
		 * Fires after category field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/html', 'category', $this );
		?>
    </div>
    
</script>