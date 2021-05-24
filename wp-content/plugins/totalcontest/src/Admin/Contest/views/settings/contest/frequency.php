<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-settings-item">
    <p><?php _e( 'Block based on', 'totalcontest' ); ?> <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'The methods used to control rate of submission.', 'totalcontest' ); ?>">?</span></p>
    <div class="totalcontest-settings-field">
        <label> <input type="checkbox" name="" ng-model="editor.settings.contest.frequency.cookies.enabled">
			<?php _e( 'Cookies', 'totalcontest' ); ?>
        </label>
    </div>
    <div class="totalcontest-settings-field">
        <label> <input type="checkbox" name="" ng-model="editor.settings.contest.frequency.ip.enabled" >
			<?php _e( 'IP', 'totalcontest' ); ?>
            
        </label>
    </div>
    <div class="totalcontest-settings-field">
        <label> <input type="checkbox" name="" ng-model="editor.settings.contest.frequency.user.enabled" >
			<?php _e( 'User', 'totalcontest' ); ?>
            
        </label>
    </div>
</div>
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Submissions per user', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'Number of submissions per each user.', 'totalcontest' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.contest.frequency.count"
               ng-disabled="!(editor.settings.contest.frequency.cookies.enabled || editor.settings.contest.frequency.ip.enabled || editor.settings.contest.frequency.user.enabled)">
    </div>
</div>
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
            <?php _e( 'Timeout', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details" tooltip="<?php _e( 'The time period before the user can vote again.', 'totalcontest' ); ?>">?</span>
        </label>
        <div class="totalcontest-settings-timeout">
            <label class="totalcontest-settings-timeout-value" ng-repeat="(key, value) in editor.presets.timeout">
                <input type="radio" ng-checked="editor.settings.contest.frequency.timeout == key" ng-click="editor.setTimeout('contest', key)" name="contestFrequencyTimeout"/>{{ value }}
            </label>
            <label class="totalcontest-settings-timeout-value">
                <input type="radio" name="contestFrequencyTimeout" ng-checked="editor.isCustomTimeout('contest')" ng-click="!editor.isCustomTimeout('contest') && editor.setTimeout('contest', 1)"/><?php echo _e('Custom (minutes)', 'totalcontest'); ?>
            </label>
        </div>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat"
               ng-model="editor.settings.contest.frequency.timeout"
               ng-model-options="{ updateOn : 'blur' }"
               ng-show="editor.isCustomTimeout('contest')"
               ng-disabled="!(editor.settings.contest.frequency.cookies.enabled || editor.settings.contest.frequency.ip.enabled || editor.settings.contest.frequency.user.enabled)">
        <p class="totalcontest-feature-tip">
            <?php _e( 'After this period, users will be able to vote again. To lock the vote permanently, use 0 as a value.', 'totalcontest' ); ?>
        </p>
        <p class="totalcontest-warning" ng-if="editor.settings.contest.frequency.timeout == 0">
            <?php _e( 'Heads up! The database will be filled with permanent records which may affect the overall performance.', 'totalcontest' ); ?>
        </p>
    </div>
</div>
<div class="totalcontest-settings-item">
    <p><strong><?php _e( 'Presets', 'totalcontest' ); ?></strong></p>
    <p>
		<?php _e( 'Based on browser, less secure but lightweight on server.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.frequency.cookies.enabled = true;editor.settings.contest.frequency.ip.enabled = false;editor.settings.contest.frequency.user.enabled = false;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on database and IP, more secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.frequency.cookies.enabled = false;editor.settings.contest.frequency.ip.enabled = true;editor.settings.contest.frequency.user.enabled = false;editor.settings.contest.frequency.count=10;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on logged in user, more secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.frequency.cookies.enabled = false;editor.settings.contest.frequency.ip.enabled = false;editor.settings.contest.frequency.user.enabled = true;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on browser, IP and logged in user, most secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#" ng-click="editor.settings.contest.frequency.cookies.enabled = true;editor.settings.contest.frequency.ip.enabled = true;editor.settings.contest.frequency.user.enabled = true;editor.settings.contest.frequency.count=1;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
</div>