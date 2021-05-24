<?php ! defined( 'ABSPATH' ) && exit(); ?><script type="text/ng-template" id="feedback-collector-component-template">
    <div class="totalcontest-feedback-collector-wrapper" ng-if="$ctrl.visible">
        <div class="totalcontest-feedback-collector">
            <h3 class="totalcontest-feedback-collector-title"><?php _e( 'Feedback', 'totalcontest' ); ?></h3>
            <p class="totalcontest-feedback-collector-question"><?php _e( 'How likely are you to recommend our product to your colleagues or friends?', 'totalcontest' ); ?></p>

            <button type="button" ng-click="$ctrl.postponeFeedback()" class="totalcontest-feedback-collector-close">&times;</button>

            <div class="totalcontest-feedback-collector-items">
                <button type="button"
                        class="button"
                        ng-repeat="item in [1,2,3,4,5,6,7,8,9,10]"
                        ng-click="$ctrl.setScore(item)"
                        ng-class="{'button-primary': $ctrl.isScore(item)}">
                    {{item}}
                </button>
            </div>

            <div class="totalcontest-feedback-collector-items">
                <span>Not likely at all</span>
                <span>Extremely likely</span>
            </div>

            <div class="totalcontest-settings-field totalcontest-feedback-collector-comment" ng-if="$ctrl.isCommentNeeded()">
                <label for="comment" class="totalcontest-settings-field-label">Comment</label>
                <textarea id="comment" rows="3" placeholder="Comment" class="totalcontest-settings-field-input widefat" ng-model="$ctrl.comment"></textarea>
            </div>

            <div class="totalcontest-feedback-collector-footer" ng-if="$ctrl.score > 0">
                <label class="checkbox">
                    <input type="checkbox" ng-model="$ctrl.email" ng-true-value="'<?php echo esc_attr( get_option( 'admin_email' ) ); ?>'" ng-false-value="''">
                    <span class="label">Include my email</span>
                </label>
                <button type="button" ng-click="$ctrl.markFeedbackAsCollected()" class="button button-large button-primary"><?php _e( 'Submit', 'totalcontest' ); ?></button>
            </div>
        </div>
    </div>
</script>
