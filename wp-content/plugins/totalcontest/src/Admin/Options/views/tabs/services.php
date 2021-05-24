<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-tabs-container">
    <div class="totalcontest-tab-content active">
        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label> <input type="checkbox" name="" ng-model="$ctrl.options.services.recaptcha.enabled" >
					<?php _e( 'reCaptcha by Google', 'totalcontest' ); ?>
                    
                </label>
            </div>
        </div>
        
        <div class="totalcontest-settings-item-advanced" ng-class="{active: $ctrl.options.services.recaptcha.enabled}">
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
					    <?php _e( 'Site key', 'totalcontest' ); ?>
                    </label>
                    <input type="text" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.options.services.recaptcha.key">
                </div>
            </div>
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
					    <?php _e( 'Site secret', 'totalcontest' ); ?>
                    </label>
                    <input type="text" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.options.services.recaptcha.secret">
                </div>
            </div>
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label> <input type="checkbox" name="" ng-model="$ctrl.options.services.recaptcha.invisible">
					    <?php _e( 'Enable invisible captcha.', 'totalcontest' ); ?>
                    </label>
                </div>
            </div>
        </div>
        
    </div>
</div>