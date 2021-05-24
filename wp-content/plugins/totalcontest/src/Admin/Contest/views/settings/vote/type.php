<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-settings-item">
    <div class="totalcontest-settings-field">
        <label class="totalcontest-settings-field-label">
			<?php _e( 'Vote type', 'totalcontest' ); ?>
            <span class="totalcontest-feature-details" tooltip="<?php esc_attr_e( 'This option defines how votes are metered.', 'totalcontest' ); ?>">?</span>
        </label>

        <p>
            <label> <input type="radio" name="" value="count" ng-model="editor.settings.vote.type">
				<?php _e( 'Count (Incremental)', 'totalcontest' ); ?>
            </label>
        </p>

        <p>
            <label> <input type="radio" name="" value="rate" ng-model="editor.settings.vote.type" >
				<?php _e( 'Rate (Average)', 'totalcontest' ); ?>
                
            </label>
        </p>
        
        <div class="totalcontest-settings-item-advanced" ng-class="{active: editor.settings.vote.type === 'rate'}">
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
						<?php _e( 'Scale', 'totalcontest' ); ?>
                    </label>
                    <input type="number" min="5" max="10" step="1" class="totalcontest-settings-field-input widefat" ng-model="editor.settings.vote.scale" >
                </div>
            </div>
            <div class="totalcontest-settings-item">
                <div class="totalcontest-settings-field">
                    <label class="totalcontest-settings-field-label">
						<?php _e( 'Criteria', 'totalcontest' ); ?>
                    </label>

                    <div ng-controller="VoteCriteriaCtrl as voteCriteria">
                        <div class="totalcontest-input-group with-button" ng-repeat="criterion in criteria track by $index">
                            <input type="text" class="totalcontest-settings-field-input widefat" ng-model="criterion.name">
                            <button class="button button-small button-danger" type="button" ng-click="voteCriteria.remove($index, true)"><?php _e( 'Remove', 'totalcontest' ); ?></button>
                        </div>
                        <button class="button button-large" type="button" ng-click="voteCriteria.add()"><?php _e( 'Add new', 'totalcontest' ); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <p class="totalcontest-warning"><?php _e( 'Heads up! Changing vote type back and forth may cause inconsistency so choose wisely.', 'totalcontest' ); ?></p>
        
    </div>
</div>