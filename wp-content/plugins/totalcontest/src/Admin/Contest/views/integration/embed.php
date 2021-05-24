<?php ! defined( 'ABSPATH' ) && exit(); ?><div class="">
    <div class="totalcontest-integration-steps">
        <div class="totalcontest-integration-steps-item">
            <div class="totalcontest-integration-steps-item-number">
                <div class="totalcontest-integration-steps-item-number-circle">1</div>
            </div>
            <div class="totalcontest-integration-steps-item-content">
                <h3 class="totalcontest-h3">
                    <?php _e( 'Copy code', 'totalcontest' ); ?>
                </h3>
                <p>
                    <?php _e( 'Start by copying the following HTML code:', 'totalcontest' ); ?>
                </p>
                <div class="totalcontest-integration-steps-item-copy">
                    
	                <?php $iframe = esc_attr( sprintf( '<iframe id="%s" src="%s" frameborder="0" allowtransparency="true" width="100%%" height="400"></iframe>', 'totalcontest-iframe-' . get_the_ID(), add_query_arg( [ 'embed' => true ], get_permalink() ) ) ); ?>
                    <?php $script = esc_attr( sprintf( "<script>window.addEventListener('message', function (event) {if (event.data.totalcontest && event.data.totalcontest.action === 'resizeHeight') {document.querySelector('#totalcontest-iframe-%1\$d').height = event.data.totalcontest.value;}}, false);document.querySelector('#totalcontest-iframe-%1\$d').contentWindow.postMessage({totalcontest: {action: 'requestHeight'}}, '*');</script>", get_the_ID() ) ); ?>
                    <input name="" type="text" readonly onfocus="this.setSelectionRange(0, this.value.length)" value="<?php echo $iframe . $script; ?>" >
                    <button class="button button-primary button-large" type="button" copy-to-clipboard="<?php echo $iframe . $script; ?>">
		                <?php _e( 'Copy', 'totalcontest' ); ?>
                    </button>
                    
                    
                </div>
            </div>
        </div>
        <div class="totalcontest-integration-steps-item">
            <div class="totalcontest-integration-steps-item-number">
                <div class="totalcontest-integration-steps-item-number-circle">2</div>
            </div>
            <div class="totalcontest-integration-steps-item-content">
                <h3 class="totalcontest-h3">
                    <?php _e( 'Paste the code', 'totalcontest' ); ?>
                </h3>
                <p>
                    <?php _e( 'Paste the copied code into an HTML page.', 'totalcontest' ); ?>
                </p>
            </div>
        </div>
        <div class="totalcontest-integration-steps-item">
            <div class="totalcontest-integration-steps-item-number">
                <div class="totalcontest-integration-steps-item-number-circle">3</div>
            </div>
            <div class="totalcontest-integration-steps-item-content">
                <h3 class="totalcontest-h3">
                    <?php _e( 'Preview', 'totalcontest' ); ?>
                </h3>
                <p>
                    <?php _e( 'Open the page which you have pasted the code in and test contest functionality.', 'totalcontest' ); ?>
                </p>
            </div>
        </div>
    </div>
    
</div>