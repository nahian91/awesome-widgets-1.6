<?php
/**
 * Awesome Countdown Studio Widget.
 * Architectural Precision Countdown with Timezone Calibration & Kinetic Micro-Interactions.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Countdown extends Widget_Base {

	public function get_name() {
		return 'awea_countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'countdown', 'timer', 'clock', 'launch', 'sale', 'urgent', 'event' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. TIMER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_timer',
			[
				'label' => esc_html__( 'Timer', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_due_date',
			[
				'label'       => esc_html__( 'Due Date', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => wp_date( 'Y-m-d H:i', strtotime( '+1 month' ) ),
				'description' => sprintf(
					/* translators: %s: Site current timezone string */
					esc_html__( 'Timezone: %s', 'awesome-widgets-elementor' ),
					'<strong>' . esc_html( wp_timezone_string() ) . '</strong>'
				),
			]
		);

		$this->add_control(
			'awea_expire_type',
			[
				'label'   => esc_html__( 'On Expiry', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'message',
				'options' => [
					'message'  => esc_html__( 'Show Message', 'awesome-widgets-elementor' ),
					'redirect' => esc_html__( 'Redirect URL', 'awesome-widgets-elementor' ),
					'none'     => esc_html__( 'Stay at Zero', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_expire_message',
			[
				'label'     => esc_html__( 'Message', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 3,
				'default'   => esc_html__( 'This event or offer has concluded.', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_expire_type' => 'message' ],
			]
		);

		$this->add_control(
			'awea_expire_link',
			[
				'label'       => esc_html__( 'URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_expire_type' => 'redirect' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. UNITS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_units',
			[
				'label' => esc_html__( 'Units', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_days',
			[
				'label'        => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_label_days',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_days' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_hours',
			[
				'label'        => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_hours',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_minutes',
			[
				'label'        => esc_html__( 'Minutes', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_minutes',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Mins', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_minutes' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_seconds',
			[
				'label'        => esc_html__( 'Seconds', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_seconds',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Secs', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_seconds' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_separators',
			[
				'label'        => esc_html__( 'Separators', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 1. BOXES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_cells',
			[
				'label' => esc_html__( 'Boxes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cells_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-timer-row' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cells_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timer-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_min_width',
			[
				'label'      => esc_html__( 'Min Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 60, 'max' => 250 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '28', 'right' => '20', 'bottom' => '24', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cell_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_cell_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cell_bg_color',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cell_border',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cell_shadow',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_cell_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cell_bg_color_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cell_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cell_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-time-cell:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. DIGITS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_digits',
			[
				'label' => esc_html__( 'Digits', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_digit_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-digit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_digit_typography',
				'selector' => '{{WRAPPER}} .awea-digit',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_digit_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-digit' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. LABELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_labels',
			[
				'label' => esc_html__( 'Labels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_unit_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_unit_typography',
				'selector' => '{{WRAPPER}} .awea-unit',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. SEPARATORS (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_separators',
			[
				'label'     => esc_html__( 'Separators', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_separators' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-colon-sep' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-colon-sep' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 5. EXPIRED (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_expired',
			[
				'label'     => esc_html__( 'Expired', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_expire_type' => 'message' ],
			]
		);

		$this->add_responsive_control(
			'awea_expired_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-countdown-expired' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_expired_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-countdown-expired' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_expired_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-countdown-expired' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_expired_typography',
				'selector' => '{{WRAPPER}} .awea-countdown-expired',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_expired_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-countdown-expired' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$due_date_raw = ! empty( $settings['awea_due_date'] ) ? $settings['awea_due_date'] : '';
		$widget_id    = $this->get_id();

		// Convert Elementor input string to target timestamp in site's timezone
		$site_timezone = wp_timezone();
		$datetime      = date_create( $due_date_raw, $site_timezone );
		$target_time   = $datetime ? $datetime->getTimestamp() : strtotime( '+1 month' );
		$current_time  = (int) wp_date( 'U' );
		$diff          = max( 0, $target_time - $current_time );

		// Pre-compute server-side numbers to prevent 00:00 flash
		$days    = floor( $diff / 86400 );
		$hours   = floor( ( $diff % 86400 ) / 3600 );
		$minutes = floor( ( $diff % 3600 ) / 60 );
		$seconds = floor( $diff % 60 );

		$show_days    = 'yes' === ( $settings['awea_show_days'] ?? 'no' );
		$show_hours   = 'yes' === ( $settings['awea_show_hours'] ?? 'no' );
		$show_mins    = 'yes' === ( $settings['awea_show_minutes'] ?? 'no' );
		$show_secs    = 'yes' === ( $settings['awea_show_seconds'] ?? 'no' );
		$show_seps    = 'yes' === ( $settings['awea_show_separators'] ?? 'no' );
		$expire_type  = $settings['awea_expire_type'] ?? 'message';
		$redirect_url = $settings['awea_expire_link']['url'] ?? '';

		$active_units = [];
		if ( $show_days ) {
			$active_units[] = 'days';
		}
		if ( $show_hours ) {
			$active_units[] = 'hours';
		}
		if ( $show_mins ) {
			$active_units[] = 'minutes';
		}
		if ( $show_secs ) {
			$active_units[] = 'seconds';
		}
		$last_unit = end( $active_units );
		?>
		<div class="awea-countdown-wrapper"
			 id="awea-countdown-<?php echo esc_attr( $widget_id ); ?>"
			 data-target="<?php echo esc_attr( (string) $target_time ); ?>"
			 data-server="<?php echo esc_attr( (string) $current_time ); ?>"
			 data-expire="<?php echo esc_attr( $expire_type ); ?>"
			 data-redirect="<?php echo esc_url( $redirect_url ); ?>">

			<div class="awea-timer-row <?php echo ( $diff <= 0 && 'message' === $expire_type ) ? 'awea-is-hidden' : ''; ?>">
				
				<?php if ( $show_days ) : ?>
					<div class="awea-time-cell awea-unit-days">
						<span class="awea-digit awea-val-days"><?php echo esc_html( sprintf( '%02d', $days ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_days'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'days' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_hours ) : ?>
					<div class="awea-time-cell awea-unit-hours">
						<span class="awea-digit awea-val-hours"><?php echo esc_html( sprintf( '%02d', $hours ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_hours'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'hours' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_mins ) : ?>
					<div class="awea-time-cell awea-unit-minutes">
						<span class="awea-digit awea-val-minutes"><?php echo esc_html( sprintf( '%02d', $minutes ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_minutes'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'minutes' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_secs ) : ?>
					<div class="awea-time-cell awea-unit-seconds">
						<span class="awea-digit awea-val-seconds"><?php echo esc_html( sprintf( '%02d', $seconds ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_seconds'] ); ?></span>
					</div>
				<?php endif; ?>

			</div>

			<?php if ( 'message' === $expire_type ) : ?>
				<div class="awea-countdown-expired <?php echo ( $diff <= 0 ) ? 'awea-is-visible' : ''; ?>" aria-live="polite">
					<?php echo esc_html( $settings['awea_expire_message'] ); ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function initCountdown() {
				var el = document.getElementById('awea-countdown-<?php echo esc_js( $widget_id ); ?>');
				if (!el || el.__aweaBound) return;
				el.__aweaBound = true;

				var targetTs    = parseInt(el.getAttribute('data-target'), 10) || 0;
				var serverTs    = parseInt(el.getAttribute('data-server'), 10) || Math.floor(Date.now() / 1000);
				var expireType  = el.getAttribute('data-expire') || 'none';
				var redirectUrl = el.getAttribute('data-redirect') || '';
				var clockOffset = serverTs - Math.floor(Date.now() / 1000);

				var timerRow   = el.querySelector('.awea-timer-row');
				var expiredBox = el.querySelector('.awea-countdown-expired');
				var daysEl     = el.querySelector('.awea-val-days');
				var hoursEl    = el.querySelector('.awea-val-hours');
				var minsEl     = el.querySelector('.awea-val-minutes');
				var secsEl     = el.querySelector('.awea-val-seconds');

				function pad(n) {
					return n < 10 ? '0' + n : String(n);
				}

				function handleExpiry() {
					if (expireType === 'message') {
						if (timerRow) timerRow.classList.add('awea-is-hidden');
						if (expiredBox) expiredBox.classList.add('awea-is-visible');
					} else if (expireType === 'redirect' && redirectUrl) {
						var isEditor = document.body.classList.contains('elementor-editor-active');
						if (!isEditor) {
							window.location.href = redirectUrl;
						}
					}
				}

				function update() {
					var nowTs = Math.floor(Date.now() / 1000) + clockOffset;
					var diff  = Math.max(0, targetTs - nowTs);

					var d = Math.floor(diff / 86400);
					var h = Math.floor((diff % 86400) / 3600);
					var m = Math.floor((diff % 3600) / 60);
					var s = Math.floor(diff % 60);

					if (daysEl)  daysEl.textContent  = pad(d);
					if (hoursEl) hoursEl.textContent = pad(h);
					if (minsEl)  minsEl.textContent  = pad(m);
					if (secsEl)  secsEl.textContent  = pad(s);

					if (diff <= 0) {
						clearInterval(interval);
						handleExpiry();
					}
				}

				var interval = setInterval(update, 1000);
				update();
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initCountdown);
			} else {
				initCountdown();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea_countdown.default', initCountdown);
			}
		})();
		</script>
		<?php
	}
}