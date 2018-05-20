<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://siamcomm.com
 * @since      1.0.0
 *
 * @package    Instashare
 * @subpackage Instashare/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Instashare
 * @subpackage Instashare/public
 * @author     Eric B <ebuckley@siamcomm.com>
 */
class Instashare_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Instashare_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instashare_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instashare-public.css', array(), $this->version, 'all' );
		if (!wp_style_is('font-awesome') || !wp_style_is('fontawesome')) {
			wp_enqueue_style( $this->plugin_name.'_font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', array(), '5.0.13', 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Instashare_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instashare_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instashare-public.js', array( 'jquery' ), $this->version, false );

	}

	public function instashare_buttons($content) {
		global $post;

		if (is_singular() && !is_home()) {
			// Post or Page information
			$instashare = '';
			$instashareUrl = get_permalink();
			$instashareTitle = str_replace( ' ', '%20', get_the_title() );
			if (has_post_thumbnail( $post->ID ) ) {
				$instashareThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			} else {
				$instashareThumb = null;
			}
			
			// Social Sharing URLs
			$twitterUrl = 	'http://twitter.com/share?text=' . $instashareTitle . '&amp;url=' . $instashareUrl;
			$facebookUrl = 	'https://www.facebook.com/sharer?u=' . $instashareUrl . '&amp;t=' . $instashareTitle;
			$linkedInUrl = 	'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $instashareUrl . '&amp;title=' . $instashareTitle;
			$googleUrl = 	'https://plus.google.com/share?url=' . $instashareUrl;
			$pinterestUrl = 'https://pinterest.com/pin/create/button/?url=' . $instashareUrl . '&amp;media=' . $instashareThumb[0] . '&amp;description=' . $instashareTitle;
			
			// Social sharing services - we can add more here later if you want
			$bufferUrl = 	'https://bufferapp.com/add?url=' . $instashareUrl . '&amp;text=' . $instashareTitle;
			
			$instashare .= '<!-- InstaShare social sharing -->';
			$instashare .= '<div class="instashare-social">';
			$instashare .= '<div class="instashare-title">Share on:</div>';
			$instashare .= '<a class="instashare-link instashare-twitter" href="'. $twitterUrl .'" target="_blank"><i class="fab fa-twitter"></i> Tweet</a>';
			$instashare .= '<a class="instashare-link instashare-facebook" href="'.$facebookUrl.'" target="_blank"><i class="fab fa-facebook-f"></i> Share</a>';
			$instashare .= '<a class="instashare-link instashare-linkedin" href="'.$linkedInUrl.'" target="_blank"><i class="fab fa-linkedin-in"></i> LinkedIn</a>';
			$instashare .= '<a class="instashare-link instashare-google" href="'.$googleUrl.'" target="_blank"><i class="fab fa-google-plus-g"></i> </a>';
			$instashare .= '<a class="instashare-link instashare-pinterest" href="'.$pinterestUrl.'" data-pin-custom="true" target="_blank"><i class="fab fa-pinterest-p"></i> Pin It</a>';
			$instashare .= '<a class="instashare-link instashare-buffer" href="'.$bufferUrl.'" target="_blank">Buffer</a>';
			$instashare .= '</div>';
			
			$content .= $instashare;
			
			return $content;
		} else {
			return $content;
		}

	}

}
