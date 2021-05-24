<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="tpl-video-field">
    
	<?php
	/**
	 * Fires before video field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field', 'video', $this );
	?>
    <div class="totalcontest-tab-content active" tab="editor>form>field-{{field.uid}}>basic">
		<?php
		/**
		 * Fires before video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/basic', 'video', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-basic-label-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-name-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-placeholder-template'"></div>
		<?php
		/**
		 * Fires after video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/basic', 'video', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>validations">
		<?php
		/**
		 * Fires before video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/validations', 'video', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-validations-filled-template'"></div>

        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.file.enabled" ng-checked="field.validations.file.enabled">
					<?php _e( 'File upload', 'totalcontest' ); ?>
                </label>
            </div>
        </div>
        <div class="totalcontest-settings-item-advanced" ng-if="field.validations.file.enabled" ng-class="{active: field.validations.file.enabled}">
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.size.enabled" ng-checked="field.validations.size.enabled" ng-disabled="!field.validations.file.enabled">
						<?php _e( 'File size', 'totalcontest' ); ?>
                    </label>
                </div>
            </div>
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.size.enabled}">
                <div class="totalcontest-settings-item totalcontest-settings-item-inline">
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Minimum video size (kB)', 'totalcontest' ); ?>
                        </label>
                        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="field.validations.size.min">
                    </div>
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Maximum video size (kB)', 'totalcontest' ); ?>
                        </label>
                        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="field.validations.size.max">
                    </div>
                </div>
            </div>

            <div class="totalcontest-settings-item" ng-if="field.validations.file.enabled">
                <div class="totalcontest-settings-field">
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.length.enabled" ng-checked="field.validations.length.enabled" ng-disabled="!field.validations.file.enabled">
						<?php _e( 'Length', 'totalcontest' ); ?>
                    </label>
                </div>
            </div>
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.length.enabled}">
                <div class="totalcontest-settings-item totalcontest-settings-item-inline">
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Minimum length (seconds)', 'totalcontest' ); ?>
                        </label>
                        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="field.validations.length.min">
                    </div>
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Maximum length (seconds)', 'totalcontest' ); ?>
                        </label>
                        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="field.validations.length.max">
                    </div>
                </div>
            </div>

            <div class="totalcontest-settings-item" ng-if="field.validations.file.enabled">
                <div class="totalcontest-settings-field">
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.enabled" ng-checked="field.validations.formats.enabled" ng-disabled="!field.validations.file.enabled">
						<?php _e( 'Formats', 'totalcontest' ); ?>
                    </label>
                </div>
            </div>
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.formats.enabled}">

                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
						<?php _e( 'Allowed formats', 'totalcontest' ); ?>
                    </label>

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['mp4']">
						<?php _e( 'MP4', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['m4v']">
						<?php _e( 'M4V (Apple MP4-like)', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['mpeg']">
						<?php _e( 'MPEG-4', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <br><br>

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['avi']">
						<?php _e( 'AVI', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['3gp']">
						<?php _e( '3GP', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['webm']">
						<?php _e( 'WebM', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['mov']">
						<?php _e( 'MOV', 'totalcontest' ); ?>
                    </label>
                </div>

            </div>
        </div>


        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.enabled" ng-checked="field.validations.services.enabled">
					<?php _e( 'Allowed services', 'totalcontest' ); ?>
                </label>
            </div>
        </div>
        <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.services.enabled}">
            <div class="totalcontest-settings-field">
                <label class="totalcontest-settings-field-label">
					<?php _e( 'Supported services', 'totalcontest' ); ?>
                </label>

                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.youtube">
					<?php _e( 'YouTube', 'totalcontest' ); ?>
                </label>
                &nbsp;&nbsp;

                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.dailymotion">
					<?php _e( 'Dailymotion', 'totalcontest' ); ?>
                </label>
                &nbsp;&nbsp;

                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.vk">
					<?php _e( 'VK.RU', 'totalcontest' ); ?>
                </label>
                &nbsp;&nbsp;

                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.vimeo">
					<?php _e( 'Vimeo', 'totalcontest' ); ?>
                </label>
                &nbsp;&nbsp;

                <br>
                <br>

                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.hulu">
					<?php _e( 'Hulu', 'totalcontest' ); ?>
                </label>

                &nbsp;&nbsp;
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.ustream">
					<?php _e( 'Ustream', 'totalcontest' ); ?>
                </label>

                &nbsp;&nbsp;
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.vine">
					<?php _e( 'Vine', 'totalcontest' ); ?>
                </label>

                &nbsp;&nbsp;
                <label>
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.metacafe">
					<?php _e( 'Metacafe', 'totalcontest' ); ?>
                </label>


            </div>
        </div>
		<?php
		/**
		 * Fires after video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/validations', 'video', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>html">
		<?php
		/**
		 * Fires before video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/html', 'video', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-html-css-class-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-html-template-template'"></div>
		<?php
		/**
		 * Fires after video field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/html', 'video', $this );
		?>
    </div>
	<?php
	/**
	 * Fires after video field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field', 'video', $this );
	?>
    
</script>