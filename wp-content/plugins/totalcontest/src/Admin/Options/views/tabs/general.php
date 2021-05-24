<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="totalcontest-tabs-container">
    <div class="totalcontest-tab-content active">
        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label>
                    <input type="checkbox" name="" ng-model="$ctrl.options.general.showCredits.enabled">
				    <?php _e( 'Spread the love by adding "Powered by TotalContest" underneath the contests.', 'totalcontest' ); ?>
                </label>
            </div>
        </div>

        <div class="totalcontest-settings-item">
            <div class="totalcontest-settings-field">
                <label>
                    <input type="checkbox" name="" ng-model="$ctrl.options.general.structuredData.enabled" >
					<?php _e( 'Structured Data', 'totalcontest' ); ?>
                    
                </label>

                <p class="totalcontest-feature-tip"><?php _e( 'Improve your appearance in search engine through <a href="https://developers.google.com/search/docs/guides/intro-structured-data" target="_blank">Structured Data</a> implementation..', 'totalcontest' ); ?></p>
            </div>
        </div>
    </div>
</div>
