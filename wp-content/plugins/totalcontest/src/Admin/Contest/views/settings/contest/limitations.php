<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="editor.settings.contest.limitations.period.enabled" ng-checked="editor.settings.contest.limitations.period.enabled">
			<?php _e( 'Time period', 'totalcontest' ); ?>
        </label>
    </div>
</div>
<div class="totalcontest-settings-item-advanced" ng-class="{active: editor.settings.contest.limitations.period.enabled}">
    <div class="totalcontest-settings-item totalcontest-settings-item-inline">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'Start date', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'Entries submission will be closed before reaching this date.', 'totalcontest' ); ?>">?</span>
            </label>
            <input type="text" datetime-picker min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.limitations.period.start">
        </div>

        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'End date', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'Entries submission will be closed after reaching this date.', 'totalcontest' ); ?>">?</span>
            </label>
            <input type="text" datetime-picker min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.limitations.period.end">
        </div>
    </div>
</div>
<!-- Membership -->
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="editor.settings.contest.limitations.membership.enabled" ng-checked="editor.settings.contest.limitations.membership.enabled" >
			<?php _e( 'Membership', 'totalcontest' ); ?>
            
        </label>
    </div>
</div>

<div class="totalcontest-settings-item-advanced" ng-class="{active: editor.settings.contest.limitations.membership.enabled}">
    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="totalcontest-settings-limitations-membership-type">
				<?php _e( 'Required membership roles', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'The roles that are allowed to submit.', 'totalcontest' ); ?>">?</span>
            </label>
            <select id="totalcontest-settings-limitations-membership-type" class="totalcontest-settings-field-input widefat" multiple size="7" ng-model="editor.settings.contest.limitations.membership.roles">
				<?php foreach ( get_editable_roles() as $role => $details ): ?>
                    <option value="<?php echo esc_attr( $role ); ?>" <?php selected( in_array( $role, [] ), true ); ?>><?php echo translate_user_role( $details['name'] ); ?></option>
				<?php endforeach; ?>
            </select>

            <p class="totalcontest-feature-tip"><?php _e( 'Hold Control/Command for multiple selection.', 'totalcontest' ); ?></p>
        </div>
    </div>
</div>


<!-- Quota -->
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="editor.settings.contest.limitations.quota.enabled" ng-checked="editor.settings.contest.limitations.quota.enabled" >
			<?php _e( 'Quota', 'totalcontest' ); ?>
            
        </label>
    </div>
</div>

<div class="totalcontest-settings-item-advanced" ng-class="{active: editor.settings.contest.limitations.quota.enabled}">
    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label" for="totalcontest-settings-limitations-quota">
				<?php _e( 'Number of submissions', 'totalcontest' ); ?>
                <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'The quota where the contest will not accept submissions after reaching.', 'totalcontest' ); ?>">?</span>
            </label>
            <input id="totalcontest-settings-limitations-quota" type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.limitations.quota.value">
        </div>
    </div>
</div>
<div class="totalcontest-settings-item">
    <p><strong><?php _e( 'Presets', 'totalcontest' ); ?></strong></p>
    <p>
		<?php _e( '15 days contest.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.limitations.period.enabled = true;editor.settings.contest.limitations.period.end = '<?php echo date( 'm/d/Y H:i', strtotime( '+15 days', time() ) ); ?>';"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( '1 month contest.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.limitations.period.enabled = true;editor.settings.contest.limitations.period.end = '<?php echo date( 'm/d/Y H:i', strtotime( '+1 month', time() ) ); ?>';"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( '100 submissions contest.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.limitations.quota.enabled = true;editor.settings.contest.limitations.quota.value = 100;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
</div>

