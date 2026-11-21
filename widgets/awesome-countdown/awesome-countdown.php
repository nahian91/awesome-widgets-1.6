<?php
/**
 * Awesome Countdown Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

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
		return [ 'awea', 'countdown', 'timer', 'clock', 'launch', 'sale', 'urgent', 'evergreen' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. TIMER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_section_timer',
			[
				'label' => esc_html__( 'Timer', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_countdown_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'due_date',
				'options' => [
					'due_date'  => esc_html__( 'Fixed Due Date', 'awesome-widgets-elementor' ),
					'evergreen' => esc_html__( 'Evergreen (Per Visitor)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_countdown_due_date',
			[
				'label'       => esc_html__( 'Target Date & Time', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => wp_date( 'Y-m-d H:i', strtotime( '+1 month' ) ),
				'description' => sprintf(
					/* translators: %s: Site current timezone string */
					esc_html__( 'Site Timezone: %s', 'awesome-widgets-elementor' ),
					'<strong>' . esc_html( wp_timezone_string() ) . '</strong>'
				),
				'condition'   => [ 'awea_countdown_type' => 'due_date' ],
			]
		);

		$this->add_control(
			'awea_countdown_evergreen_hours',
			[
				'label'     => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 720,
				'default'   => 24,
				'condition' => [ 'awea_countdown_type' => 'evergreen' ],
			]
		);

		$this->add_control(
			'awea_countdown_evergreen_minutes',
			[
				'label'     => esc_html__( 'Minutes', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 59,
				'default'   => 0,
				'condition' => [ 'awea_countdown_type' => 'evergreen' ],
			]
		);

		$this->add_control(
			'awea_countdown_heading',
			[
				'label'       => esc_html__( 'Header Label (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. Limited-Time Launch Offer Ends In', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. UNITS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_section_units',
			[
				'label' => esc_html__( 'Units', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_countdown_show_days',
			[
				'label'        => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_countdown_label_days',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_countdown_show_days' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_countdown_show_hours',
			[
				'label'        => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_countdown_label_hours',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_countdown_show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_countdown_show_minutes',
			[
				'label'        => esc_html__( 'Minutes', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_countdown_label_minutes',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Mins', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_countdown_show_minutes' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_countdown_show_seconds',
			[
				'label'        => esc_html__( 'Seconds', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_countdown_label_seconds',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Secs', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_countdown_show_seconds' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_section_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_countdown_show_separators',
			[
				'label'        => esc_html__( 'Display Separator', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_countdown_sep_char',
			[
				'label'     => esc_html__( 'Symbol', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => ':',
				'options'   => [
					':' => esc_html__( 'Colon ( : )', 'awesome-widgets-elementor' ),
					'/' => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'•' => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'—' => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_countdown_show_separators' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_countdown_sep_blink',
			[
				'label'        => esc_html__( 'Pulse Animation', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [ 'awea_countdown_show_separators' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. EXPIRY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_section_expiry',
			[
				'label' => esc_html__( 'After Expiry', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_countdown_expire_type',
			[
				'label'   => esc_html__( 'Action', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'message',
				'options' => [
					'message'  => esc_html__( 'Show Message', 'awesome-widgets-elementor' ),
					'redirect' => esc_html__( 'Redirect URL', 'awesome-widgets-elementor' ),
					'none'     => esc_html__( 'Freeze at Zero', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_countdown_expire_message',
			[
				'label'     => esc_html__( 'Message', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 3,
				'default'   => esc_html__( 'This event or offer has concluded.', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_countdown_expire_type' => 'message' ],
			]
		);

		$this->add_control(
			'awea_countdown_expire_link',
			[
				'label'       => esc_html__( 'Redirect Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_countdown_expire_type' => 'redirect' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cells_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_timer_row' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_cell_direction',
			[
				'label'     => esc_html__( 'Box Content Direction', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'column',
				'options'   => [
					'column'         => esc_html__( 'Stacked (Digits Top)', 'awesome-widgets-elementor' ),
					'column-reverse' => esc_html__( 'Reversed (Labels Top)', 'awesome-widgets-elementor' ),
					'row'            => esc_html__( 'Inline (Side by Side)', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cells_gap',
			[
				'label'      => esc_html__( 'Gap Between Boxes', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 50 ],
					'rem' => [ 'min' => 0, 'max' => 4 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_timer_row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. HEADER LABEL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_heading',
			[
				'label'     => esc_html__( 'Header Label', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_countdown_heading!' => '' ],
			]
		);

		$this->add_control(
			'awea_countdown_heading_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_countdown_heading_typo',
				'selector' => '{{WRAPPER}} .awea_countdown_heading',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_heading_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BOXES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_cells',
			[
				'label' => esc_html__( 'Boxes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cell_min_width',
			[
				'label'      => esc_html__( 'Minimum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 60, 'max' => 280 ],
					'%'  => [ 'min' => 15, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cell_max_width',
			[
				'label'      => esc_html__( 'Maximum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 400 ],
					'%'  => [ 'min' => 20, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 220 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cell_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '28',
					'right'    => '20',
					'bottom'   => '24',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_cell_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_accent_bar',
			[
				'label'        => esc_html__( 'Top Accent Bar', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'awea_countdown_bar_',
			]
		);

		$this->add_control(
			'awea_countdown_accent_bar_color',
			[
				'label'     => esc_html__( 'Accent Bar Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_countdown_accent_bar' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea_countdown_bar_yes .awea_countdown_time_cell::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_countdown_cell_tabs' );

		$this->start_controls_tab(
			'awea_countdown_cell_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_countdown_cell_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_countdown_cell_border',
				'selector'       => '{{WRAPPER}} .awea_countdown_time_cell',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_countdown_cell_shadow',
				'selector' => '{{WRAPPER}} .awea_countdown_time_cell',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_countdown_cell_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_countdown_cell_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_time_cell:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_cell_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_time_cell:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_countdown_cell_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_countdown_time_cell:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. DIGITS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_digits',
			[
				'label' => esc_html__( 'Digits', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_countdown_digit_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_digit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_countdown_digit_typo',
				'selector' => '{{WRAPPER}} .awea_countdown_digit',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_digit_space',
			[
				'label'      => esc_html__( 'Spacing to Label', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_time_cell' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. LABELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_labels',
			[
				'label' => esc_html__( 'Unit Labels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_countdown_unit_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_countdown_unit_typo',
				'selector' => '{{WRAPPER}} .awea_countdown_unit',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_separators',
			[
				'label'     => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_countdown_show_separators' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_colon_sep' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_colon_sep' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. EXPIRED
		   ========================================================================== */
		$this->start_controls_section(
			'awea_countdown_style_expired',
			[
				'label'     => esc_html__( 'Expired Message', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_countdown_expire_type' => 'message' ],
			]
		);

		$this->add_responsive_control(
			'awea_countdown_expired_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_expired' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_expired_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_expired' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_countdown_expired_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_countdown_expired' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_countdown_expired_typo',
				'selector' => '{{WRAPPER}} .awea_countdown_expired',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_countdown_expired_border',
				'selector' => '{{WRAPPER}} .awea_countdown_expired',
			]
		);

		$this->add_responsive_control(
			'awea_countdown_expired_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_countdown_expired' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_countdown_expired_shadow',
				'selector' => '{{WRAPPER}} .awea_countdown_expired',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$timer_type   = $settings['awea_countdown_type'] ?? 'due_date';
		$due_date_raw = ! empty( $settings['awea_countdown_due_date'] ) ? $settings['awea_countdown_due_date'] : '';
		$heading      = $settings['awea_countdown_heading'] ?? '';
		$widget_id    = $this->get_id();

		$current_time   = time();
		$evergreen_secs = 0;

		if ( 'evergreen' === $timer_type ) {
			$eg_hours       = max( 0, (int) ( $settings['awea_countdown_evergreen_hours'] ?? 24 ) );
			$eg_minutes     = max( 0, (int) ( $settings['awea_countdown_evergreen_minutes'] ?? 0 ) );
			$evergreen_secs = ( $eg_hours * HOUR_IN_SECONDS ) + ( $eg_minutes * MINUTE_IN_SECONDS );
			$target_time    = $current_time + $evergreen_secs;
		} else {
			$site_timezone = wp_timezone();
			$datetime      = date_create_immutable( $due_date_raw, $site_timezone );
			$target_time   = $datetime ? $datetime->getTimestamp() : $current_time + MONTH_IN_SECONDS;
		}

		$diff = max( 0, $target_time - $current_time );

		$show_days  = 'yes' === ( $settings['awea_countdown_show_days'] ?? 'no' );
		$show_hours = 'yes' === ( $settings['awea_countdown_show_hours'] ?? 'no' );
		$show_mins  = 'yes' === ( $settings['awea_countdown_show_minutes'] ?? 'no' );
		$show_secs  = 'yes' === ( $settings['awea_countdown_show_seconds'] ?? 'no' );

		// Roll hidden higher units down into the largest visible unit.
		$remaining = $diff;
		$days      = $show_days ? (int) floor( $remaining / DAY_IN_SECONDS ) : 0;
		if ( $show_days ) {
			$remaining %= DAY_IN_SECONDS;
		}
		$hours = $show_hours ? (int) floor( $remaining / HOUR_IN_SECONDS ) : 0;
		if ( $show_hours ) {
			$remaining %= HOUR_IN_SECONDS;
		}
		$minutes = $show_mins ? (int) floor( $remaining / MINUTE_IN_SECONDS ) : 0;
		if ( $show_mins ) {
			$remaining %= MINUTE_IN_SECONDS;
		}
		$seconds = $show_secs ? $remaining : 0;

		$show_seps    = 'yes' === ( $settings['awea_countdown_show_separators'] ?? 'no' );
		$sep_char     = ! empty( $settings['awea_countdown_sep_char'] ) ? $settings['awea_countdown_sep_char'] : ':';
		$sep_blink    = 'yes' === ( $settings['awea_countdown_sep_blink'] ?? '' );
		$expire_type  = $settings['awea_countdown_expire_type'] ?? 'message';
		$raw_redirect = $settings['awea_countdown_expire_link']['url'] ?? '';
		$redirect_url = $raw_redirect ? esc_url_raw( $raw_redirect, [ 'http', 'https' ] ) : '';

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

		$sep_classes = [ 'awea_countdown_colon_sep' ];
		if ( $sep_blink ) {
			$sep_classes[] = 'awea_countdown_sep_pulse';
		}
		?>
		<div class="awea_countdown_wrap"
			 id="awea_countdown_<?php echo esc_attr( $widget_id ); ?>"
			 data-awea_countdown_type="<?php echo esc_attr( $timer_type ); ?>"
			 data-awea_countdown_evergreen="<?php echo esc_attr( (string) $evergreen_secs ); ?>"
			 data-awea_countdown_target="<?php echo esc_attr( (string) $target_time ); ?>"
			 data-awea_countdown_server="<?php echo esc_attr( (string) $current_time ); ?>"
			 data-awea_countdown_expire="<?php echo esc_attr( $expire_type ); ?>"
			 data-awea_countdown_redirect="<?php echo esc_url( $redirect_url ); ?>">

			<?php if ( ! empty( $heading ) ) : ?>
				<div class="awea_countdown_heading"><?php echo esc_html( $heading ); ?></div>
			<?php endif; ?>

			<div class="awea_countdown_timer_row <?php echo ( $diff <= 0 && 'message' === $expire_type ) ? 'awea_countdown_is_hidden' : ''; ?>" role="timer">

				<?php if ( $show_days ) : ?>
					<div class="awea_countdown_time_cell awea_countdown_unit_days">
						<span class="awea_countdown_digit awea_countdown_val_days"><?php echo esc_html( sprintf( '%02d', $days ) ); ?></span>
						<span class="awea_countdown_unit"><?php echo esc_html( $settings['awea_countdown_label_days'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'days' !== $last_unit ) : ?>
						<span class="<?php echo esc_attr( implode( ' ', $sep_classes ) ); ?>" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_hours ) : ?>
					<div class="awea_countdown_time_cell awea_countdown_unit_hours">
						<span class="awea_countdown_digit awea_countdown_val_hours"><?php echo esc_html( sprintf( '%02d', $hours ) ); ?></span>
						<span class="awea_countdown_unit"><?php echo esc_html( $settings['awea_countdown_label_hours'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'hours' !== $last_unit ) : ?>
						<span class="<?php echo esc_attr( implode( ' ', $sep_classes ) ); ?>" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_mins ) : ?>
					<div class="awea_countdown_time_cell awea_countdown_unit_minutes">
						<span class="awea_countdown_digit awea_countdown_val_minutes"><?php echo esc_html( sprintf( '%02d', $minutes ) ); ?></span>
						<span class="awea_countdown_unit"><?php echo esc_html( $settings['awea_countdown_label_minutes'] ?? '' ); ?></span>
					</div>
					<?php if ( $show_seps && 'minutes' !== $last_unit ) : ?>
						<span class="<?php echo esc_attr( implode( ' ', $sep_classes ) ); ?>" aria-hidden="true"><?php echo esc_html( $sep_char ); ?></span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_secs ) : ?>
					<div class="awea_countdown_time_cell awea_countdown_unit_seconds">
						<span class="awea_countdown_digit awea_countdown_val_seconds"><?php echo esc_html( sprintf( '%02d', $seconds ) ); ?></span>
						<span class="awea_countdown_unit"><?php echo esc_html( $settings['awea_countdown_label_seconds'] ?? '' ); ?></span>
					</div>
				<?php endif; ?>

			</div>

			<?php if ( 'message' === $expire_type ) : ?>
				<div class="awea_countdown_expired <?php echo ( $diff <= 0 ) ? 'awea_countdown_is_visible' : ''; ?>" aria-live="polite">
					<?php echo esc_html( $settings['awea_countdown_expire_message'] ?? '' ); ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function awea_countdown_bind(el) {
				if (!el || el.dataset.aweaCountdownBound === '1') return;
				el.dataset.aweaCountdownBound = '1';

				var timerType     = el.getAttribute('data-awea_countdown_type') || 'due_date';
				var evergreenSecs = parseInt(el.getAttribute('data-awea_countdown_evergreen'), 10) || 0;
				var targetTs      = parseInt(el.getAttribute('data-awea_countdown_target'), 10) || 0;
				var serverTs      = parseInt(el.getAttribute('data-awea_countdown_server'), 10) || Math.floor(Date.now() / 1000);
				var expireType    = el.getAttribute('data-awea_countdown_expire') || 'none';
				var redirectUrl   = el.getAttribute('data-awea_countdown_redirect') || '';
				var clockOffset   = serverTs - Math.floor(Date.now() / 1000);

				var isEditor = document.body.classList.contains('elementor-editor-active') || !!(window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode());

				if (timerType === 'evergreen' && evergreenSecs > 0 && !isEditor) {
					var storageKey = 'awea_countdown_eg_' + el.id + '_' + evergreenSecs;
					try {
						var savedTarget = parseInt(window.localStorage.getItem(storageKey), 10);
						var nowServer   = Math.floor(Date.now() / 1000) + clockOffset;
						if (savedTarget && savedTarget > 0) {
							targetTs = savedTarget;
						} else {
							targetTs = nowServer + evergreenSecs;
							window.localStorage.setItem(storageKey, String(targetTs));
						}
					} catch (e) {}
				}

				var timerRow   = el.querySelector('.awea_countdown_timer_row');
				var expiredBox = el.querySelector('.awea_countdown_expired');
				var daysEl     = el.querySelector('.awea_countdown_val_days');
				var hoursEl    = el.querySelector('.awea_countdown_val_hours');
				var minsEl     = el.querySelector('.awea_countdown_val_minutes');
				var secsEl     = el.querySelector('.awea_countdown_val_seconds');

				function pad(n) {
					return n < 10 ? '0' + n : String(n);
				}

				function handleExpiry() {
					if (expireType === 'message') {
						if (timerRow) timerRow.classList.add('awea_countdown_is_hidden');
						if (expiredBox) expiredBox.classList.add('awea_countdown_is_visible');
					} else if (expireType === 'redirect' && redirectUrl) {
						if (!isEditor && /^https?:\/\//i.test(redirectUrl)) {
							window.location.assign(redirectUrl);
						}
					}
				}

				function update() {
					var nowTs     = Math.floor(Date.now() / 1000) + clockOffset;
					var remaining = Math.max(0, targetTs - nowTs);
					var diff      = remaining;

					var d = daysEl ? Math.floor(remaining / 86400) : 0;
					if (daysEl) remaining %= 86400;

					var h = hoursEl ? Math.floor(remaining / 3600) : 0;
					if (hoursEl) remaining %= 3600;

					var m = minsEl ? Math.floor(remaining / 60) : 0;
					if (minsEl) remaining %= 60;

					var s = secsEl ? remaining : 0;

					if (daysEl)  daysEl.textContent  = pad(d);
					if (hoursEl) hoursEl.textContent = pad(h);
					if (minsEl)  minsEl.textContent  = pad(m);
					if (secsEl)  secsEl.textContent  = pad(s);

					if (diff <= 0) {
						clearInterval(interval);
						handleExpiry();
					}
				}

				var interval = setInterval(function() {
					if (!document.body.contains(el)) {
						clearInterval(interval);
						return;
					}
					update();
				}, 1000);

				update();
			}

			function awea_countdown_init() {
				awea_countdown_bind(document.getElementById('awea_countdown_<?php echo esc_js( $widget_id ); ?>'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_countdown_init);
			} else {
				awea_countdown_init();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.awea_countdown_hooked) {
				window.awea_countdown_hooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea_countdown.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_countdown_wrap') : null;
					awea_countdown_bind(el);
				});
			}
		})();
		</script>
		<?php
	}
}