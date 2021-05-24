<?php

/*
 * @class: TF_DFP_Front
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if ( ! defined ( 'ABSPATH' ) ) {
	die( '-1' );
}

class TF_DFP_Front {
	function __construct () {
		require_once ( TF_DFP_CLASS_PATH . 'TF_DFP_Data_Factory.php' );
		require_once ( TF_DFP_CLASS_PATH . 'TF_DFP_Shortcodes.php' );

		new TF_DFP_Shortcodes();

        global $tf_core;

		$data          = new TF_DFP_Data_Factory();
		$configuration = $data->get_data( array( '&' ), 0, 'configuration' );
		$cxense_tracking_active = false;

		if ( class_exists( 'TF_Tracking' ) && $tf_tracking_options = get_option( 'tf_tracking_options' ) ) {

				// Check if Cxense tracking is set in TF Tracking plugin
			$cxense_tracking_active = isset( $tf_tracking_options['cxense']['isactive'] ) && $tf_tracking_options['cxense']['isactive'];

		} else if ( ( class_exists( '\\TF_Core\\Core\\Helpers\\Base' ) || class_exists( '\TF_Core' ) ) && isset( $tf_core['addons']['tracking_cxense_active'] ) ) {

		    // Check if Cxense tracking is set in TF Core
			$cxense_tracking_active = null !== $tf_core['addons']['tracking_cxense_active'];

		}

		$this->cxense_tracking_active  = $cxense_tracking_active;
		$this->cxense_siteid           = isset( $configuration[0][3] ) ? $configuration[0][3] : '';
		$this->cxense_persistedqueryid = isset( $configuration[0][4] ) ? $configuration[0][4] : '';

		//Only enqueue if cxense is available
		if ( '' !== $this->cxense_persistedqueryid && '' !== $this->cxense_siteid ) {
			add_action ( 'wp_enqueue_scripts', array ( $this, 'cxense_enqueue_script' ) );
		}

		add_action ( 'wp_head', array ( $this, 'google_tag_script' ), 999 );
		add_action ( 'wp_footer', array ( $this, 'adverts_script_defer' ), 999 );

		//Register jQuery template + enqueue jQuery
		add_action ( 'wp_enqueue_scripts', array ( $this, 'handle_scripts' ) );

	}

	function handle_scripts () {
		wp_register_script ( TF_DFP_NAME . 'jquery-template', TF_DFP_URL . 'assets/js/libs/jquery-tmpl-min.js', array ( 'jquery' ) );
		wp_enqueue_script ( 'jquery' );
	}

	function google_tag_script () {
		$get_data      = new TF_DFP_Data_Factory();
		$is_oop_active = $get_data->is_active ( 'oop' );
		$zone          = $get_data;
		$get_data      = $get_data->get_front_data ( 'detect' );

		$output = '<!------ TF DFP GPT SCRIPT - START ------------>';
		$output .= '<meta name="ad:prefix" content="' . esc_attr ( urldecode ( $get_data['prefix'] ) ) . '">';
		if ( 'none' !== $zone->get_zone () ) {
			$output .= '<meta name="ad:zone" content="' . esc_attr ( urldecode ( $zone->get_zone () ) ) . '">';
		} else {
			$output .= '<meta name="ad:zone" content="none">';
		}
		$output .= '<meta name="ad:oop" content="' . esc_attr ( $is_oop_active ) . '">';

		$output .= '<script type="text/javascript">';
		$output .= '(function() {';
		$output .= 'var gads = document.createElement("script");';
		$output .= 'gads.async = true;';
		$output .= 'gads.type = "text/javascript";';
		$output .= 'var useSSL = "https:" == document.location.protocol;';
		$output .= 'gads.src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt.js";';
		$output .= 'var node =document.getElementsByTagName("script")[0];';
		$output .= 'node.parentNode.insertBefore(gads, node);';
		$output .= '})();';
		$output .= '</script>';
		$output .= '<!------ TF DFP GPT SCRIPT - END ------------>';
		echo $output;
	}

	function adverts_script_defer () {
		if ( is_active_sidebar ( 'tf_dfp_sb' ) ) {
			dynamic_sidebar ( 'tf_dfp_sb' );
		}
		$content_type = __( 'Not Supported', TF_DFP_NAME );
		if ( is_page () ) {
			$content_type = __( 'Page', TF_DFP_NAME );
		}
		if ( is_single () ) {
			$content_type = __( 'Post', TF_DFP_NAME );
		}
		if ( is_category () ) {
			$content_type = __( 'Category', TF_DFP_NAME );
		}
		if ( is_front_page () && is_home () || is_front_page () || is_home () ) {
			$content_type = __( 'Homepage', TF_DFP_NAME );
		}

		$output = "\n\n<!--****************** TSS - START ******************\n";
		$output .= "Content Type: " . $content_type . "\n";
		$output .= "****************** TSS - END ******************-->\n";
		$output .= "<!--****************** TF_DFP SCRIPT DEFER - START ******************-->\n";
		$output .= '<script type="text/javascript">';
		$output .= 'function TFDFPDownloadJSAtOnload( googletag ) {';
		$output .= 'var element = document.createElement("script");';
		$output .= 'element.src = "' . TF_DFP_URL . 'assets/js/tf-dfp-adverts.js";';
		$output .= 'document.body.appendChild(element);';
		$output .= 'var googletag = googletag || {};';
		$output .= 'googletag.cmd = googletag.cmd || [];';
		$output .= '}';
		$output .= 'if ( window.addEventListener )';
		$output .= 'window.addEventListener("load", TFDFPDownloadJSAtOnload, false);';
		$output .= 'else if ( window.attachEvent )';
		$output .= 'window.attachEvent("onload", TFDFPDownloadJSAtOnload);';
		$output .= 'else window.onload = TFDFPDownloadJSAtOnload;';
		$output .= '</script>';
		$output .= "\n<!--****************** TF_DFP SCRIPT DEFER - END ******************-->\n\n";
		echo $output;
	}

	function cxense_enqueue_script() {
		add_action ( 'wp_head', array ( $this, 'cx_script_defer' ), 999 );
	}

	function cx_script_defer() {
		?>
		<script type='text/javascript'>
			/* <![CDATA[ */
			var tfdfp_cxense_params = {
				"cxense_siteid": "<?php echo $this->cxense_siteid; ?>",
				"cxense_persistedqueryid": "<?php echo $this->cxense_persistedqueryid; ?>"
			};
			/* ]]> */
		</script>
		<?php if ( ! $this->cxense_tracking_active ) : /** If cxense tracking isn't active yet, add the cs.js and track **/ ?>
			<!------- TF_DFP CXENSE SCRIPT DEFER - START ------------->
			<script type='text/javascript'>
				var cxPersistedQueryId = tfdfp_cxense_params.cxense_persistedqueryid;
				var cxSiteId = tfdfp_cxense_params.cxense_siteid;

				var cX = cX || {};
				cX.callQueue = cX.callQueue || [];
				cX.callQueue.push(['setSiteId', cxSiteId]);
				cX.callQueue.push(['sendPageViewEvent']);
				cX.callQueue.push(["invoke", function () {
					var segments = cX.getUserSegmentIds({
						persistedQueryId: cxPersistedQueryId
					});

					if (segments.length > 0) {
						var meta = document.createElement("meta");
						meta.name = "ad:keyword:cxsegments";
						meta.content = segments;
						document.getElementsByTagName("head")[0].appendChild(meta);
					}
				}]);

				(function (d, s, e, t) {
					e = d.createElement(s);
					e.type = 'text/java' + s;
					e.async = 'async';
					e.src = 'http' + ('https:' === location.protocol ? 's://s' : '://') + 'cdn.cxense.com/cx.js';
					t = d.getElementsByTagName(s)[0];
					t.parentNode.insertBefore(e, t);
				})(document, 'script');
			</script>
			<!------- TF_DFP CXENSE SCRIPT DEFER - END ------------->
		<?php else: /** Just add the DFP cxense tracking code **/ ?>
			<!------- TF_DFP CXENSE SCRIPT DEFER - START ------------->
			<script type='text/javascript'>
				var cxPersistedQueryId = tfdfp_cxense_params.cxense_persistedqueryid;

				var cX = cX || {};
				cX.callQueue = cX.callQueue || [];
				cX.callQueue.push(["invoke", function () {
					var segments = cX.getUserSegmentIds({
						persistedQueryId: cxPersistedQueryId
					});

					if (segments.length > 0) {
						var meta = document.createElement("meta");
						meta.name = "ad:keyword:cxsegments";
						meta.content = segments;
						document.getElementsByTagName("head")[0].appendChild(meta);
					}
				}]);
			</script>
			<!------- TF_DFP CXENSE SCRIPT DEFER - END ------------->
		<?php endif;
	}
}