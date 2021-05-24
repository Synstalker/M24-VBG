<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="tpl-file-field">
    
	<?php
	/**
	 * Fires before file field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field', 'file', $this );
	?>
    <div class="totalcontest-tab-content active" tab="editor>form>field-{{field.uid}}>basic">
		<?php
		/**
		 * Fires before file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/basic', 'file', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-basic-label-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-name-template'"></div>
		<?php
		/**
		 * Fires after file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/basic', 'file', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>validations">
		<?php
		/**
		 * Fires before file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/validations', 'file', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-validations-filled-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-validations-file-size-template'"></div>

        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.formats.enabled" ng-checked="field.validations.formats.enabled">
					<?php _e( 'Formats', 'totalcontest' ); ?>
                </label>
            </div>
        </div>
        <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.formats.enabled}">
            <div class="totalcontest-settings-field">
                <label class="totalcontest-settings-field-label">
					<?php _e( 'Allowed extensions', 'totalcontest' ); ?>
                </label>
                <input type="text" class="totalcontest-settings-field-input widefat" ng-model="field.validations.formats.extensions">
                <p class="totalcontest-feature-tip"><?php _e( 'Separate between extensions by comma. Example: zip, pdf, doc', 'totalcontest' ); ?></p>
            </div>
        </div>
		<?php
		/**
		 * Fires after file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/validations', 'file', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>html">
		<?php
		/**
		 * Fires before file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/html', 'file', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-html-css-class-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-html-template-template'"></div>
		<?php
		/**
		 * Fires after file field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/html', 'file', $this );
		?>
    </div>
	<?php
	/**
	 * Fires after file field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field', 'file', $this );
	?>
    
</script>