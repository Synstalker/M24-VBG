<?php ! defined( 'ABSPATH' ) && exit(); ?><customizer-control
        type="checkbox"
        label="<?php _e( 'AJAX', 'totalcontest' ); ?>"
        ng-model="$root.settings.design.behaviours.ajax"
        help="<?php _e( 'Load contest in-place without reloading the whole page.', 'totalcontest' ); ?>"
></customizer-control>

<customizer-control type="checkbox"
                    label="<?php _e( 'Scroll up after vote submission', 'totalcontest' ); ?>"
                    ng-model="$root.settings.design.behaviours.scrollUp"
                    help="<?php _e( 'Scroll up to contest viewport after submitting a vote.', 'totalcontest' ); ?>">
</customizer-control>

<div class="">
    <customizer-control type="checkbox"
                        ng-if="$root.settings.design.behaviours.ajax"
                        label="<?php _e( 'View submissions in modal', 'totalcontest' ); ?>"
                        ng-model="$root.settings.design.behaviours.modal"
                        help="<?php _e( 'Load the submission in a modal window.', 'totalcontest' ); ?>">
    </customizer-control>
    
</div>