<?php
//Leaderboard
class TF_DFP_Widget extends WP_Widget {

    public $dfp_data = array();

    // DM: Does the above array need to be called in parent class? Maybe more secure to make it a private / protected if there is only one child class? Just playing devils advocate, probably wont make much of a difference.

    function __construct()
    {

        parent::__construct(
            'tf_dfp_ad_slot-widget', // Base ID
            __( '24 DFP', TF_DFP_NAME ), // Name
            array( 'description' => __( 'Widget used to display 24 DFP ad slots.', TF_DFP_NAME ) ) // Args
        );
    }

    // DM: Good on you for allowing translatable text!

    function widget($args, $instance)
    {
        extract($args);

        $before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

        echo $before_widget;

        ?>

        <div class="clearfix">
            <center>
                <?php
                /*if( class_exists('TF_DFP') ) {
                    do_action('tfdfp_display', $this->dfp_data);
                }*/
                ?>
            </center>
        </div>

        <?php echo $after_widget;
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array) $instance, '');

    }
    // DM: Come across this before when you need to strongly type the data type. Was it not working if you didnt implicitly state it?
}