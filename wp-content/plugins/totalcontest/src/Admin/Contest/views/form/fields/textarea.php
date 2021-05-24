<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="tpl-textarea-field">
    
	<?php
	/**
	 * Fires before textarea field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field', 'textarea', $this );
	?>
    <div class="totalcontest-tab-content active" tab="editor>form>field-{{field.uid}}>basic">
		<?php
		/**
		 * Fires before textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/basic', 'textarea', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-basic-label-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-name-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-default-value-template'"></div>
		<?php
		/**
		 * Fires after textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/basic', 'textarea', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>validations">
		<?php
		/**
		 * Fires before textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/validations', 'textarea', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-validations-filled-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-validations-filter-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-validations-regex-template'"></div>
		<?php
		/**
		 * Fires after textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/validations', 'textarea', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>html">
		<?php
		/**
		 * Fires before textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/html', 'textarea', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-html-css-class-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-html-template-template'"></div>
		<?php
		/**
		 * Fires after textarea field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/html', 'textarea', $this );
		?>
    </div>
	<?php
	/**
	 * Fires after textarea field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field', 'textarea', $this );
	?>
    
</script>