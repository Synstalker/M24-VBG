<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-tabs-container">
    <div class="totalcontest-tab-content active ">
        <div class="totalcontest-settings-item">
            <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( 'Contest title: {{contest.title}}', 'totalcontest' ); ?></p>
            <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( 'Submission title: {{submission.title}}', 'totalcontest' ); ?></p>
            <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( 'User IP: {{log.ip}}', 'totalcontest' ); ?></p>
            <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( 'User browser: {{log.browser}}', 'totalcontest' ); ?></p>
            <p class="totalcontest-feature-tip" ng-non-bindable><?php _e( 'Vote date: {{log.date}}', 'totalcontest' ); ?></p>

            <div class="totalcontest-settings-field">
                <label class="totalcontest-settings-field-label">
					<?php _e( 'Title', 'totalcontest' ); ?>
                </label>
                <input type="text" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.options.notifications.title" >
            </div>
            <div class="totalcontest-settings-field">
                <label class="totalcontest-settings-field-label">
					<?php _e( 'Plain text body', 'totalcontest' ); ?>
                </label>
                <textarea type="text" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.options.notifications.body" ></textarea>
            </div>
            <div class="totalcontest-settings-field">
                <label class="totalcontest-settings-field-label">
					<?php _e( 'HTML template', 'totalcontest' ); ?>
                </label>
                <textarea type="text" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.options.notifications.template"  rows="10"></textarea>
            </div>
        </div>
        
    </div>
</div>