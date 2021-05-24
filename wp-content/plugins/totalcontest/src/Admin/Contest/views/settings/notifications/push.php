<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="">
    <div class="totalcontest-settings-item" ng-controller="NotificationsCtrl as $ctrl">
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
                <?php _e( 'OneSignal App ID', 'totalcontest' ); ?> - <a href="https://onesignal.com/" target="_blank"><?php _e( 'Get one', 'totalcontest' ); ?></a>
            </label>
            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.notifications.push.appId" dir="ltr" >
        </div>
        <div class="totalcontest-settings-field">
            <label class="totalcontest-settings-field-label">
                <?php _e( 'OneSignal API Key', 'totalcontest' ); ?>
            </label>
            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.notifications.push.apiKey" dir="ltr" >
        </div>
        <div class="totalcontest-settings-field">
            <button type="button" class="button button-primary"
                    ng-disabled="$ctrl.pushCompleted || !editor.settings.notifications.push.appId || !editor.settings.notifications.push.apiKey"
                    ng-click="$ctrl.setupPushService()">
                <?php _e( 'Setup push notification', 'totalcontest' ); ?>
            </button>
        </div>
    </div>
    <div class="totalcontest-settings-item">
        <p>
            <?php _e( 'Send notification when', 'totalcontest' ); ?>
        </p>
        <div class="totalcontest-settings-field">
            <label>
                <input type="checkbox" name="" ng-model="editor.settings.notifications.push.on.newSubmission" ng-checked="editor.settings.notifications.push.on.newSubmission" >
                <?php _e( 'New submission', 'totalcontest' ); ?>
            </label>
        </div>
    </div>
    
</div>