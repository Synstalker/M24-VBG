<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="tpl-audio-field">
    
	<?php
	/**
	 * Fires before audio field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field', 'audio', $this );
	?>
    <div class="totalcontest-tab-content active" tab="editor>form>field-{{field.uid}}>basic">
		<?php
		/**
		 * Fires before audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/basic', 'audio', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-basic-label-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-name-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-basic-placeholder-template'"></div>
		<?php
		/**
		 * Fires after audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/basic', 'audio', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>validations">
		<?php
		/**
		 * Fires before audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/validations', 'audio', $this );
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
            <div class="totalcontest-settings-item" ng-if="field.validations.file.enabled">
                <div class="totalcontest-settings-field">
                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.size.enabled" ng-checked="field.validations.size.enabled" ng-disabled="!field.validations.file.enabled">
						<?php _e( 'File size', 'totalcontest' ); ?>
                    </label>
                </div>
            </div>
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.size.enabled && field.validations.file.enabled}">
                <div class="totalcontest-settings-item totalcontest-settings-item-inline">
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Minimum file size (kB)', 'totalcontest' ); ?>
                        </label>
                        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="field.validations.size.min">
                    </div>
                    <div class="totalcontest-settings-field">
                        <label class="totalcontest-settings-field-label">
							<?php _e( 'Maximum file size (kB)', 'totalcontest' ); ?>
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
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.length.enabled && field.validations.file.enabled}">
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
            <div class="totalcontest-settings-item-advanced" ng-class="{active: field.validations.formats.enabled && field.validations.file.enabled}">

                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
						<?php _e( 'Allowed formats', 'totalcontest' ); ?>
                    </label>

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['mp3']" value="mp3">
						<?php _e( 'MP3', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['aac']" value="aac">
						<?php _e( 'AAC', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['ogg']" value="ogg">
						<?php _e( 'OGG', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['wav']" value="wav">
						<?php _e( 'WAV', 'totalcontest' ); ?>
                    </label>
                    &nbsp;&nbsp;

                    <label>
                        <input type="checkbox" name="" ng-model="field.validations.formats.extensions['webm']" value="webm">
						<?php _e( 'WebM', 'totalcontest' ); ?>
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
                    <input type="checkbox" name="" ng-model="field.validations.services.accepted.soundcloud">
					<?php _e( 'Soundcloud', 'totalcontest' ); ?>
                </label>
                &nbsp;&nbsp;

            </div>
        </div>
		<?php
		/**
		 * Fires after audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/validations', 'audio', $this );
		?>
    </div>
    <div class="totalcontest-tab-content" tab="editor>form>field-{{field.uid}}>html">
		<?php
		/**
		 * Fires before audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/before/admin/contest/editor/fields/field/html', 'audio', $this );
		?>
        <div class="totalcontest-settings-item" ng-include="'field-html-css-class-template'"></div>
        <div class="totalcontest-settings-item" ng-include="'field-html-template-template'"></div>
		<?php
		/**
		 * Fires after audio field content.
		 *
		 * @since 2.0.0
		 */
		do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field/html', 'audio', $this );
		?>
    </div>
	<?php
	/**
	 * Fires after text field content.
	 *
	 * @since 2.0.0
	 */
	do_action( 'totalcontest/actions/after/admin/contest/editor/fields/field', 'audio', $this );
	?>
    
</script>