<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bigambitions.co.za/meet-the-team/
 * @since      1.0.0
 *
 * @package    Time_To_Travel
 * @subpackage Time_To_Travel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Time_To_Travel
 * @subpackage Time_To_Travel/admin
 * @author     Steph Reinstein <steph@bigambitions.co.za>
 */
class Time_To_Travel_Admin
{

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Time_To_Travel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Time_To_Travel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/time-to-travel-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Time_To_Travel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Time_To_Travel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/time-to-travel-admin.js', array('jquery'), $this->version, false);
	}
}



// Settings Page: Best Time
class besttime_Settings_Page
{

	public function __construct()
	{
		add_action('admin_menu', array($this, 'wph_create_settings'));
		add_action('admin_init', array($this, 'wph_setup_sections'));
		add_action('admin_init', array($this, 'wph_setup_fields'));
	}

	public function wph_create_settings()
	{
		$page_title = 'Best Time To Travel Settings';
		$menu_title = 'Best Time';
		$capability = 'manage_options';
		$slug = 'besttime';
		$callback = array($this, 'wph_settings_content');
		add_management_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function wph_settings_content()
	{ ?>
		<div class="wrap">
			<h1>Best Time To Travel Settings</h1>

			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
				settings_fields('besttime');
				do_settings_sections('besttime');
				submit_button();
				?>
			</form>
			<pre><code>Shortcode: [btt jan="0" feb="0" mar="0" apr="0" may="0" jun="0" jul="0" aug="0" sep="0" oct="0" nov="0" dec="0"]</code></pre>
			<h4> Set to 1 for active months and set to 0 for non-active months (Default to non-active if omitted</h4>
		</div> <?php
			}

			public function wph_setup_sections()
			{
				add_settings_section('besttime_section', 'Settings for the best time to travel', array(), 'besttime');
			}

			public function wph_setup_fields()
			{
				$fields = array(
					array(
						'label' => 'Icon Size',
						'id' => 'bttt-icon-size',
						'type' => 'radio',
						'section' => 'besttime_section',
						'options' => array(
							'Small' => 'Small',
							'Medium' => 'Medium',
							'Large' => 'Large',
							'Extra Large' => 'Extra Large',
						),
						'desc' => 'Choose the icon size to display',
					),
					array(
						'label' => 'Title',
						'id' => 'bttt-h-title',
						'type' => 'text',
						'section' => 'besttime_section',
						'desc' => 'The tittle to appear above the widget',
						'placeholder' => 'Best Time To Travel',
					),
					array(
						'label' => 'Title Colour',
						'id' => 'bttt-h-colour',
						'type' => 'color',
						'section' => 'besttime_section',
						'desc' => 'Choose the colour for your title',
					),
				);
				foreach ($fields as $field) {
					add_settings_field($field['id'], $field['label'], array($this, 'wph_field_callback'), 'besttime', $field['section'], $field);
					register_setting('besttime', $field['id']);
				}
			}

			public function wph_field_callback($field)
			{
				$value = get_option($field['id']);
				$placeholder = '';
				if (isset($field['placeholder'])) {
					$placeholder = $field['placeholder'];
				}
				switch ($field['type']) {
					case 'radio':
						if (!empty($field['options']) && is_array($field['options'])) {
							$options_markup = '';
							$iterator = 0;
							foreach ($field['options'] as $key => $label) {
								$iterator++;
								$options_markup .= sprintf(
									'<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
									$field['id'],
									$field['type'],
									$key,
									checked($value, $key, false),
									$label,
									$iterator
								);
							}
							printf(
								'<fieldset>%s</fieldset>',
								$options_markup
							);
						}
						break;
					default:
						printf(
							'<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
							$field['id'],
							$field['type'],
							$placeholder,
							$value
						);
				}
				if (isset($field['desc'])) {
					if ($desc = $field['desc']) {
						printf('<p class="description">%s </p>', $desc);
					}
				}
			}
		}
		new besttime_Settings_Page();

		// Create Shortcode btt
		// Shortcode: [btt jan="0" feb="0" mar="0" apr="0" may="0" jun="0" jul="0" aug="0" sep="0" oct="0" nov="0" dec="0"]
		function create_btt_shortcode($atts)
		{

			$atts = shortcode_atts(
				array(
					'jan' => '0',
					'feb' => '0',
					'mar' => '0',
					'apr' => '0',
					'may' => '0',
					'jun' => '0',
					'jul' => '0',
					'aug' => '0',
					'sep' => '0',
					'oct' => '0',
					'nov' => '0',
					'dec' => '0',
				),
				$atts,
				'btt'
			);
			$jan = $atts['jan'];
			$feb = $atts['feb'];
			$mar = $atts['mar'];
			$apr = $atts['apr'];
			$may = $atts['may'];
			$jun = $atts['jun'];
			$jul = $atts['jul'];
			$aug = $atts['aug'];
			$sep = $atts['sep'];
			$oct = $atts['oct'];
			$nov = $atts['nov'];
			$dec = $atts['dec'];

			$size = get_option('bttt-icon-size');
			if ($size == 'Small') {
				$si = 'month-small';
			} elseif ($size == 'Medium') {
				$si = '';
			} elseif ($size == 'Large') {
				$si = 'month-big';
			} else {
				$si = "month-huge";
			}

			if ($jan == 1) {
				$janm = 'jan-act';
			} else {
				$janm = 'jan';
			}
			if ($feb == 1) {
				$febm = 'feb-act';
			} else {
				$febm = 'feb';
			}
			if ($mar == 1) {
				$marm = 'mar-act';
			} else {
				$marm = 'mar';
			}
			if ($apr == 1) {
				$aprm = 'apr-act';
			} else {
				$aprm = 'apr';
			}
			if ($may == 1) {
				$maym = 'may-act';
			} else {
				$maym = 'may';
			}
			if ($jun == 1) {
				$junm = 'jun-act';
			} else {
				$junm = 'jun';
			}
			if ($jul == 1) {
				$julm = 'jul-act';
			} else {
				$julm = 'jul';
			}
			if ($aug == 1) {
				$augm = 'aug-act';
			} else {
				$augm = 'aug';
			}
			if ($sep == 1) {
				$sepm = 'sep-act';
			} else {
				$sepm = 'sep';
			}
			if ($oct == 1) {
				$octm = 'oct-act';
			} else {
				$octm = 'oct';
			}
			if ($nov == 1) {
				$novm = 'nov-act';
			} else {
				$novm = 'nov';
			}
			if ($dec == 1) {
				$decm = 'dec-act';
			} else {
				$decm = 'dec';
			}

			$htitle = get_option('bttt-h-title');
			$hcolour = get_option('bttt-h-colour');

			$output = '';
			$output .= '<div class="bttt">';
			$output .= '<div class="bttt-header"><h4 style="color:' . $hcolour . '">' . $htitle . '</h4></div>';
			$output .= '<div class="bttt-m-container>';
			$output .= '<div class="month ' . $janm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $febm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $marm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $aprm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $maym . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $junm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $julm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $augm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $sepm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $octm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $novm . ' ' . $si . '"></div>';
			$output .= '<div class="month ' . $decm . ' ' . $si . '"></div>';
			$output .= '</div>';
			$output .= '</div>';
			return $output;
		}
		add_shortcode('btt', 'create_btt_shortcode');
