<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="">
    <div class="totalcontest-settings-item">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
				<?php _e( 'URL', 'totalcontest' ); ?>
            </label>
            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.notifications.webhook.url"  dir="ltr">
        </div>
        <p class="totalcontest-feature-tip">
			<?php _e( 'This URL will receive an HTTP POST with the following body', 'totalcontest' ); ?>
        </p>
        <div class="totalcontest-code-sample">
        <pre style="font-family: monospace; font-size: 9.6pt;">{<br>  <span style="color:#660e7a;">"contest"</span>: {<span style="color:#0000ff;">CONTEST_OBJECT</span>},<br>  <span
                    style="color:#660e7a;">"submission"</span>: {<span style="color:#0000ff;">SUBMISSION_OBJECT</span>},<br>  <span
                    style="color:#660e7a;">"log"</span>: {<span style="color:#0000ff;">LOG_OBJECT</span>}<br>}</pre>
        </div>
    </div>
    <div class="totalcontest-settings-item">
        <p>
			<?php _e( 'Send notification when', 'totalcontest' ); ?>
        </p>
        <div class="totalcontest-settings-field">
            <label>
                <input type="checkbox" name="" ng-model="editor.settings.notifications.webhook.on.newSubmission"  ng-checked="editor.settings.notifications.webhook.on.newSubmission">
				<?php _e( 'New submission', 'totalcontest' ); ?>
            </label>
        </div>
    </div>
    
</div>