<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="">
    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'Recipient email', 'totalcontest' ); ?>
            </label>
            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.notifications.email.recipient" dir="ltr" >
        </div>
    </div>
    <div class="totalcontest-settings-item">
        <p>
			<?php _e( 'Send notification when', 'totalcontest' ); ?>
        </p>
        <div class="totalcontest-settings-field">
            <label>
                <input type="checkbox" name="" ng-model="editor.settings.notifications.email.on.newSubmission" ng-checked="editor.settings.notifications.email.on.newSubmission" >
				<?php _e( 'New submission', 'totalcontest' ); ?>
            </label>
        </div>
    </div>
    
</div>
