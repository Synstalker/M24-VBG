<?php ! defined( 'ABSPATH' ) && exit(); ?>
<div class="totalcontest-tabs-container">
    <div class="totalcontest-tab-content active">
        <div class="totalcontest-row">
            <div class="totalcontest-column totalcontest-column-3" ng-repeat="(pluginId, plugin) in $ctrl.migration.plugins">
                <div class="totalcontest-box-media">
                    <div class="totalcontest-box-media-image">
                        <img ng-src="{{plugin.image}}" alt="{{plugin.name}}">
                    </div>
                    <div class="totalcontest-box-media-body">
                        <div style="flex: 1">
                            <div class="totalcontest-box-media-title">{{plugin.name}}</div>
                            <div class="totalcontest-box-media-description" ng-if="!$ctrl.isMigrationProcessing(plugin) && !$ctrl.isMigrationFinished(plugin)">
                                <span ng-if="!$ctrl.isMigrationFinished(plugin) && !$ctrl.hasContestsForMigration(plugin)"><?php echo _e( 'No contests to migrate.', 'totalcontest' ); ?></span>
                                <span ng-if="$ctrl.isMigrationFinished(plugin)"><?php echo _e( 'Contests migrated successfully.', 'totalcontest' ); ?></span>
                                <span ng-if="!$ctrl.isMigrationFinished(plugin) && !$ctrl.isMigrationProcessing(plugin) && $ctrl.hasContestsForMigration(plugin)">{{plugin.total - plugin.done}} <?php echo _e( 'Contests to migrate.', 'totalcontest' ); ?></span>
                            </div>
                            <div class="totalcontest-migration-progress" ng-if="$ctrl.isMigrationFinished(plugin) || $ctrl.isMigrationProcessing(plugin)">
                                <div class="totalcontest-migration-progress-container">
                                    <div class="totalcontest-migration-progress-bar" ng-style="{width: $ctrl.getMigrationProgress(plugin)}"></div>
                                </div>
                                <div class="totalcontest-migration-progress-text">{{$ctrl.getMigrationProgress(plugin)}}</div>
                            </div>
                        </div>
                        <div class="totalcontest-box-media-actions" ng-if="!$ctrl.isMigrationProcessing(plugin) && !$ctrl.isMigrationFinished(plugin)">
                            <button type="button" class="button button-large button-primary"
                                    ng-disabled="!$ctrl.hasContestsForMigration(plugin) || $ctrl.isMigrationProcessing(plugin) || $ctrl.isMigrationFinished(plugin)"
                                    ng-click="$ctrl.migrateContests(pluginId, plugin)">
                                <span ng-if="!$ctrl.isMigrationFinished(plugin) && !$ctrl.isMigrationProcessing(plugin)"><?php _e( 'Migrate', 'totalcontest' ); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

