<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <p><?php _e( 'Block based on', 'totalcontest' ); ?> <span class="totalcontest-feature-details"
                                                                  tooltip="<?php esc_attr_e( 'The methods used to control rate of voting.', 'totalcontest' ); ?>">?</span>
        </p>
        <div class="totalcontest-settings-field">
            <label> <input type="checkbox" name="" ng-model="editor.settings.vote.frequency.cookies.enabled">
				<?php _e( 'Cookies', 'totalcontest' ); ?>
            </label>
        </div>
        <div class="totalcontest-settings-field">
            <label> <input type="checkbox" name="" ng-model="editor.settings.vote.frequency.ip.enabled"
                           >
				<?php _e( 'IP', 'totalcontest' ); ?>
                
            </label>
        </div>
        <div class="totalcontest-settings-field">
            <label> <input type="checkbox" name="" ng-model="editor.settings.vote.frequency.user.enabled"
                           >
				<?php _e( 'User', 'totalcontest' ); ?>
                
            </label>
        </div>
    </div>
</div>
<div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Votes per user', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details"
                  tooltip="<?php esc_attr_e( 'Number of votes per each user.', 'totalcontest' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.count"
               ng-disabled="!(editor.settings.vote.frequency.cookies || editor.settings.vote.frequency.ip || editor.settings.vote.frequency.user)">
    </div>

    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Votes per submission', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details"
                  tooltip="<?php esc_attr_e( 'Number of allowed votes for the same submission.', 'totalcontest' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.perItem"
               ng-disabled="!(editor.settings.vote.frequency.cookies || editor.settings.vote.frequency.ip || editor.settings.vote.frequency.user)">
    </div>

    <div class="totalcontest-settings-field" ng-if="editor.hasRequiredCategoryField()">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Votes per category', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details"
                  tooltip="<?php esc_attr_e( 'Number of allowed votes for submissions in the same category.', 'totalcontest' ); ?>">?</span>
        </label>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat"
               ng-model="editor.settings.vote.frequency.perCategory"
               ng-disabled="!(editor.settings.vote.frequency.cookies || editor.settings.vote.frequency.ip || editor.settings.vote.frequency.user)">

        <p class="totalcontest-feature-tip"><?php _e( '0 means unlimited', 'totalcontest' ) ?></p>
    </div>

    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
            <?php _e( 'Vote timeout', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details"
                  tooltip="<?php esc_attr_e( 'The period of time that a user must wait until he can vote again.', 'totalcontest' ); ?>">?</span>
        </label>
        <div class="totalcontest-settings-timeout">
            <label class="totalcontest-settings-timeout-value" ng-repeat="(key, value) in editor.presets.timeout">
                <input type="radio" ng-checked="editor.settings.vote.frequency.timeout == key" ng-click="editor.setTimeout('vote', key)" name="voteFrequencyTimeout"/>{{ value }}
            </label>
            <label class="totalcontest-settings-timeout-value">
                <input type="radio" name="voteFrequencyTimeout" ng-checked="editor.isCustomTimeout('vote')" ng-click="!editor.isCustomTimeout('vote') && editor.setTimeout('vote', 1)"/><?php echo _e('Custom (minutes)', 'totalcontest'); ?>
            </label>
        </div>
        <input type="number" min="0" step="1" class="totalcontest-settings-field-input widefat"
               ng-model-options="{ updateOn : 'blur' }"
               ng-show="editor.isCustomTimeout('vote')"
               ng-model="editor.settings.vote.frequency.timeout"
               ng-disabled="!(editor.settings.vote.frequency.cookies || editor.settings.vote.frequency.ip || editor.settings.vote.frequency.user)">
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
        <a href="#"
           ng-click="editor.settings.vote.frequency.cookies.enabled = true;editor.settings.vote.frequency.ip.enabled = false;editor.settings.vote.frequency.user.enabled = false;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on database and IP, more secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#"
           ng-click="editor.settings.vote.frequency.cookies.enabled = false;editor.settings.vote.frequency.ip.enabled = true;editor.settings.vote.frequency.user.enabled = false;editor.settings.vote.frequency.count=10;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on logged in user, more secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#"
           ng-click="editor.settings.vote.frequency.cookies.enabled = false;editor.settings.vote.frequency.ip.enabled = false;editor.settings.vote.frequency.user.enabled = true;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
    <p>
		<?php _e( 'Based on browser, IP and logged in user, most secure but may hurt server performance on heavy load.', 'totalcontest' ); ?>
        <a href="#"
           ng-click="editor.settings.vote.frequency.cookies.enabled = true;editor.settings.vote.frequency.ip.enabled = true;editor.settings.vote.frequency.user.enabled = true;editor.settings.vote.frequency.count=1;"><?php _e( 'Apply', 'totalcontest' ); ?></a>
    </p>
</div>

