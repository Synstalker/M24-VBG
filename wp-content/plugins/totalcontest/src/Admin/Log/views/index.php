<?php ! defined( 'ABSPATH' ) && exit(); ?><div id="totalcontest-log" class="wrap totalcontest-page" ng-app="log">
    <h1 class="totalcontest-page-title"><?php _e( 'Log', 'totalcontest' ); ?></h1>
    <log-browser></log-browser>
    <script type="text/ng-template" id="log-browser-component-template">
        <table class="wp-list-table widefat striped totalcontest-log-browser-list" ng-class="{'totalcontest-processing': $ctrl.isProcessing()}">
            <thead class="totalcontest-log-browser-list-header-wrapper">
            <tr>
                <td colspan="<?php echo count( $columns ); ?>">
                    <div class="totalcontest-log-browser-list-header">
                        <div class="totalcontest-log-browser-list-header-visible-columns">
							<?php foreach ( $columns as $columnId => $column ): ?>
                                <label><input type="checkbox" ng-init="$ctrl.columns['<?php echo $columnId ?>'] = <?php echo empty( $column['default'] ) ? 'false' : 'true'; ?>" ng-model="$ctrl.columns.<?php echo esc_attr( $columnId ); ?>"><?php echo esc_html( $column['label'] ); ?></label>
							<?php endforeach; ?>
                        </div>
                        <div class="totalcontest-log-browser-list-header-date">
                            <span><?php _e( 'From', 'totalcontest' ); ?></span>
                            <input type="text" datetime-picker='{"timepicker":false, "mask":true, "format": "Y-m-d"}' ng-model="$ctrl.filters.from">
                            <span><?php _e( 'To', 'totalcontest' ); ?></span>
                            <input type="text" datetime-picker='{"timepicker":false, "mask":true, "format": "Y-m-d"}' ng-model="$ctrl.filters.to">
							<?php
							/**
							 * Fires after filter inputs in log browser interface.
							 *
							 * @since 2.0.0
							 */
							do_action( 'totalcontest/actions/admin/log/filters' );
							?>
                            <div class="button-group">
                                <button class="button" ng-click="$ctrl.resetFilters()" ng-disabled="!($ctrl.filters.from || $ctrl.filters.to)">
									<?php _e( 'Clear', 'totalcontest' ); ?>
                                </button>
                                <button class="button button-primary" ng-click="$ctrl.loadPage(1)">
									<?php _e( 'Apply', 'totalcontest' ); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
				<?php foreach ( $columns as $columnId => $column ): ?>
                    <th scope="col" <?php if ( empty( $column['compact'] ) ): ?>class="totalcontest-log-browser-list-collapsed"<?php endif; ?> ng-show="$ctrl.columns.<?php echo esc_attr( $columnId ); ?>"><?php echo esc_html( $column['label'] ); ?></th>
				<?php endforeach; ?>
                <th scope="col" class="totalcontest-log-browser-list-collapsed totalcontest-log-browser-list-column-actions"><?php echo _e( 'Actions', 'totalcontest' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr class="totalcontest-log-browser-list-entry" ng-repeat="entry in $ctrl.entries track by $index">
				<?php foreach ( $columns as $columnId => $column ): ?>
					<?php if ( $columnId === 'status' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-class="{'success': entry.isAccepted(), 'error': entry.isRejected()}" ng-show="$ctrl.columns.status">{{entry.getStatus()}}</td>
					<?php elseif ( $columnId === 'action' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.action">{{entry.getAction()}}</td>
					<?php elseif ( $columnId === 'date' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.date">{{entry.getDate()|date:'yyyy-MM-dd @ HH:mm'}}</td>
					<?php elseif ( $columnId === 'contest' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.contest"><a target="_blank" ng-href="{{entry.getContestEditLink()}}">{{entry.getContestTitle()}}</a></td>
					<?php elseif ( $columnId === 'submission' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.submission"><a target="_blank" ng-href="{{entry.getSubmissionEditLink()}}">{{entry.getSubmissionTitle() || 'N/A'}}</a></td>
					<?php elseif ( $columnId === 'user_id' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.user_id">{{entry.getUser('id') || 'N/A' }}</td>
					<?php elseif ( $columnId === 'user_login' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.user_login">{{entry.getUser('login') || 'N/A'}}</td>
					<?php elseif ( $columnId === 'user_name' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.user_name">{{entry.getUser('name') || 'Anonymous'}}</td>
					<?php elseif ( $columnId === 'user_email' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.user_email">{{entry.getUser('email') || entry.get('details.email') || 'N/A'}}</td>
					<?php elseif ( $columnId === 'browser' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.browser">{{(entry.getUseragent()|platform).description}}</td>
					<?php elseif ( $columnId === 'ip' ): ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns.ip">{{entry.getIP()}}</td>
					<?php elseif ( $columnId === 'details' ): ?>
                        <td class="totalcontest-log-browser-list-compact" ng-show="$ctrl.columns.details" ng-bind-html="entry.getDetails()|table"></td>
					<?php else: ?>
                        <td class="totalcontest-log-browser-list-collapsed" ng-show="$ctrl.columns['<?php echo esc_attr( $columnId ); ?>']"><?php echo empty( $column['content'] ) ? $column['content'] : ''; ?></td>
					<?php endif; ?>
				<?php endforeach; ?>
                <td class="totalcontest-log-browser-list-collapsed totalcontest-log-browser-list-column-actions">
                    <button type="button" class="button button-small" type="button" ng-click="$ctrl.removeItem(entry, $event)"><?php _e( 'Delete', 'totalcontest' ); ?></button>
                </td>
            </tr>
            <tr ng-if="!$ctrl.entries.length">
                <td colspan="<?php echo count( $columns ); ?>"><?php _e( 'Nothing. Nada. Niente. Nickts. Rien.', 'totalcontest' ); ?></td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="totalcontest-log-browser-list-footer-wrapper">
                <td scope="col" colspan="<?php echo count( $columns ); ?>">
                    <div class="totalcontest-log-browser-list-footer">
                        <div class="totalcontest-log-browser-list-footer-pagination">
                            <div class="button-group">
                                <button class="button" ng-class="{'button-primary': $ctrl.hasPreviousPage()}" ng-click="$ctrl.previousPage()" ng-disabled="$ctrl.isFirstPage()"><?php _e( 'Previous', 'totalcontest' ); ?></button>
                                <button class="button" ng-class="{'button-primary': $ctrl.hasNextPage()}" ng-click="$ctrl.nextPage()" ng-disabled="$ctrl.isLastPage()"><?php _e( 'Next', 'totalcontest' ); ?></button>
                            </div>
                        </div>
                        <div class="totalcontest-log-browser-list-footer-export">
                            <span><?php _e( 'Download as', 'totalcontest' ); ?></span>
                            <div class="button-group">
								<?php foreach ( $formats as $format => $label ): ?>
                                    <button class="button" ng-class="{'button-primary': $ctrl.canExport()}" ng-click="$ctrl.exportAs('<?php echo esc_js( $format ); ?>')" ng-disabled="!$ctrl.canExport()"><?php echo esc_html( $label ); ?></button>
								<?php endforeach; ?>
                                
                            </div>
                        </div>

                    </div>
                </td>
            </tr>
            </tfoot>

        </table>
    </script>

</div>
