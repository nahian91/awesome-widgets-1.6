<?php
/**
 * Awesome Business Hours Widget.
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
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Business_Hours extends Widget_Base {

	public function get_name() {
		return 'awesome-business-hours';
	}

	public function get_title() {
		return esc_html__( 'Business Hours', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-clock-o';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'business hours', 'schedule', 'opening hours', 'timetable', 'open now' ];
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
		   CONTENT: 1. STATUS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_section_status',
			[
				'label' => esc_html__( 'Live Status', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_business_hours_show_status',
			[
				'label'        => esc_html__( 'Display Status Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_business_hours_open_text',
			[
				'label'     => esc_html__( 'Open Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Open Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_business_hours_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_closed_text',
			[
				'label'     => esc_html__( 'Closed Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Closed Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_business_hours_show_status' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_business_hours_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( "We're ready to create.", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_business_hours_title_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Visit our studio or connect directly with our team during operational business hours.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_business_hours_timezone_note',
			[
				'label'       => esc_html__( 'Timezone Note', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Local Time • EST (UTC-5)', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. CONTACT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_section_phone',
			[
				'label' => esc_html__( 'Contact', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_business_hours_phone_show',
			[
				'label'        => esc_html__( 'Display Contact', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_business_hours_phone_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_business_hours_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_label',
			[
				'label'     => esc_html__( 'Caption', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Support Line', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_business_hours_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_num',
			[
				'label'     => esc_html__( 'Number / Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 456-7890',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_business_hours_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18004567890',
				'default'     => [ 'url' => 'tel:+18004567890' ],
				'condition'   => [ 'awea_business_hours_phone_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. SCHEDULE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_section_schedule',
			[
				'label' => esc_html__( 'Schedule', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_business_hours_day',
			[
				'label'   => esc_html__( 'Day', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'Monday',
				'options' => [
					'Monday'    => esc_html__( 'Monday', 'awesome-widgets-elementor' ),
					'Tuesday'   => esc_html__( 'Tuesday', 'awesome-widgets-elementor' ),
					'Wednesday' => esc_html__( 'Wednesday', 'awesome-widgets-elementor' ),
					'Thursday'  => esc_html__( 'Thursday', 'awesome-widgets-elementor' ),
					'Friday'    => esc_html__( 'Friday', 'awesome-widgets-elementor' ),
					'Saturday'  => esc_html__( 'Saturday', 'awesome-widgets-elementor' ),
					'Sunday'    => esc_html__( 'Sunday', 'awesome-widgets-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'awea_business_hours_closed',
			[
				'label'        => esc_html__( 'Closed All Day', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_business_hours_hours',
			[
				'label'       => esc_html__( 'Display Hours', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00 AM — 06:00 PM',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_business_hours_closed!' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_business_hours_closed_label',
			[
				'label'       => esc_html__( 'Closed Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CLOSED', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_business_hours_closed' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_business_hours_open_24',
			[
				'label'       => esc_html__( 'Opens (24h)', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Used for live Open/Closed status detection (HH:MM).', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00',
				'placeholder' => '09:00',
				'condition'   => [ 'awea_business_hours_closed!' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_business_hours_close_24',
			[
				'label'       => esc_html__( 'Closes (24h)', 'awesome-widgets-elementor' ),
				'description' => esc_html__( '24h HH:MM format (supports overnight e.g. 02:00).', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '18:00',
				'placeholder' => '18:00',
				'condition'   => [ 'awea_business_hours_closed!' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_schedule',
			[
				'label'       => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_business_hours_day }}} — {{{ awea_business_hours_closed === "yes" ? (awea_business_hours_closed_label || "CLOSED") : awea_business_hours_hours }}}',
				'default'     => [
					[ 'awea_business_hours_day' => 'Monday', 'awea_business_hours_hours' => '09:00 AM — 06:00 PM', 'awea_business_hours_open_24' => '09:00', 'awea_business_hours_close_24' => '18:00' ],
					[ 'awea_business_hours_day' => 'Tuesday', 'awea_business_hours_hours' => '09:00 AM — 06:00 PM', 'awea_business_hours_open_24' => '09:00', 'awea_business_hours_close_24' => '18:00' ],
					[ 'awea_business_hours_day' => 'Wednesday', 'awea_business_hours_hours' => '09:00 AM — 06:00 PM', 'awea_business_hours_open_24' => '09:00', 'awea_business_hours_close_24' => '18:00' ],
					[ 'awea_business_hours_day' => 'Thursday', 'awea_business_hours_hours' => '09:00 AM — 06:00 PM', 'awea_business_hours_open_24' => '09:00', 'awea_business_hours_close_24' => '18:00' ],
					[ 'awea_business_hours_day' => 'Friday', 'awea_business_hours_hours' => '09:00 AM — 06:00 PM', 'awea_business_hours_open_24' => '09:00', 'awea_business_hours_close_24' => '18:00' ],
					[ 'awea_business_hours_day' => 'Saturday', 'awea_business_hours_hours' => '10:00 AM — 04:00 PM', 'awea_business_hours_open_24' => '10:00', 'awea_business_hours_close_24' => '16:00' ],
					[ 'awea_business_hours_day' => 'Sunday', 'awea_business_hours_closed' => 'yes', 'awea_business_hours_closed_label' => 'CLOSED' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_section_layout',
			[
				'label' => esc_html__( 'Layout & Theme', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_business_hours_layout_mode',
			[
				'label'        => esc_html__( 'Layout Mode', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'split',
				'options'      => [
					'split'   => esc_html__( 'Split Columns', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Stacked', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_business_hours_mode_',
			]
		);

		$this->add_control(
			'awea_business_hours_panel_pos',
			[
				'label'        => esc_html__( 'Schedule Position', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'right',
				'prefix_class' => 'awea_business_hours_pos_',
				'condition'    => [ 'awea_business_hours_layout_mode' => 'split' ],
			]
		);

		$this->add_control(
			'awea_business_hours_surface_theme',
			[
				'label'        => esc_html__( 'Surface Theme', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'dark',
				'options'      => [
					'dark'  => esc_html__( 'Dark Slate', 'awesome-widgets-elementor' ),
					'light' => esc_html__( 'Clean Light', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_business_hours_theme_',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_card',
			[
				'label' => esc_html__( 'Card & Panels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_business_hours_card_bg',
			[
				'label'     => esc_html__( 'Main Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_right_bg',
			[
				'label'     => esc_html__( 'Schedule Panel Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_right' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_panel_divider_color',
			[
				'label'     => esc_html__( 'Panel Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_right' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_business_hours_card_border',
				'selector' => '{{WRAPPER}} .awea_business_hours_card',
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '28',
					'right'    => '28',
					'bottom'   => '28',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_card_padding',
			[
				'label'      => esc_html__( 'Panel Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '48',
					'right'    => '48',
					'bottom'   => '48',
					'left'     => '48',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_left, {{WRAPPER}} .awea_business_hours_right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_business_hours_card_shadow',
				'selector' => '{{WRAPPER}} .awea_business_hours_card',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STATUS BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_status',
			[
				'label'     => esc_html__( 'Status Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_business_hours_show_status' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_badge_typo',
				'selector' => '{{WRAPPER}} .awea_business_hours_badge',
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_badge_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_business_hours_status_tabs' );

		$this->start_controls_tab(
			'awea_business_hours_status_open_tab',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_business_hours_badge_open_color',
			[
				'label'     => esc_html__( 'Text & Pulse Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_badge.awea_business_hours_is_open' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_badge_open_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_badge.awea_business_hours_is_open' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_business_hours_status_closed_tab',
			[ 'label' => esc_html__( 'Closed', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_business_hours_badge_closed_color',
			[
				'label'     => esc_html__( 'Text & Pulse Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_badge.awea_business_hours_is_closed' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_badge_closed_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_badge.awea_business_hours_is_closed' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE & DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_title',
			[
				'label' => esc_html__( 'Title & Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_business_hours_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_title_typo',
				'selector' => '{{WRAPPER}} .awea_business_hours_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_title_spacing',
			[
				'label'      => esc_html__( 'Title Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_desc_typo',
				'selector' => '{{WRAPPER}} .awea_business_hours_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_desc_spacing',
			[
				'label'      => esc_html__( 'Description Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. CONTACT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_phone',
			[
				'label'     => esc_html__( 'Contact', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_business_hours_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_label_color',
			[
				'label'     => esc_html__( 'Caption Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_phone_label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_phone_label_typo',
				'label'    => esc_html__( 'Caption Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_business_hours_phone_label',
			]
		);

		$this->add_control(
			'awea_business_hours_phone_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_phone_num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_phone_typo',
				'label'    => esc_html__( 'Number Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_business_hours_phone_num',
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_phone_box_size',
			[
				'label'      => esc_html__( 'Icon Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 30, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_phone_ico' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_phone_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_phone_ico'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_business_hours_phone_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_ico_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_phone_ico'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_business_hours_phone_ico svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_phone_ico_bg',
			[
				'label'     => esc_html__( 'Icon Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_phone_ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. SCHEDULE ROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_schedule',
			[
				'label' => esc_html__( 'Schedule Rows', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_business_hours_row_pad',
			[
				'label'      => esc_html__( 'Row Vertical Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_business_hours_row' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_line_color',
			[
				'label'     => esc_html__( 'Row Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_row' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_day_typo',
				'label'    => esc_html__( 'Day Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_business_hours_day',
			]
		);

		$this->add_control(
			'awea_business_hours_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_business_hours_hours_typo',
				'label'    => esc_html__( 'Hours Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_business_hours_time',
			]
		);

		$this->add_control(
			'awea_business_hours_hours_color',
			[
				'label'     => esc_html__( 'Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_closed_color',
			[
				'label'     => esc_html__( 'Closed Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_closed .awea_business_hours_time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_tz_color',
			[
				'label'     => esc_html__( 'Timezone Note Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_tz' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. TODAY HIGHLIGHT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_business_hours_style_today',
			[
				'label' => esc_html__( 'Today Highlight', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_business_hours_today_color',
			[
				'label'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_today'                           => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_today .awea_business_hours_day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_today .awea_business_hours_dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_today_time_color',
			[
				'label'     => esc_html__( 'Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_today .awea_business_hours_time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_business_hours_today_bg',
			[
				'label'     => esc_html__( 'Row Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_business_hours_row.awea_business_hours_is_today' => 'background-color: {{VALUE}}; padding-inline: 12px; border-radius: 10px;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Normalize 24h time string (e.g. "9:00" -> "09:00") for reliable comparison.
	 */
	private function normalize_24h( $time_str ) {
		$time_str = trim( (string) $time_str );
		if ( preg_match( '/^(\d{1,2}):(\d{2})$/', $time_str, $matches ) ) {
			return sprintf( '%02d:%02d', (int) $matches[1], (int) $matches[2] );
		}
		return '';
	}

	/**
	 * Evaluate whether the business is currently open (supports overnight ranges & post-midnight rollover).
	 */
	private function calculate_is_open_now( $schedule_list ) {
		if ( empty( $schedule_list ) ) {
			return false;
		}

		$days_order    = [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];
		$today_index   = (int) wp_date( 'w' );
		$current_day   = $days_order[ $today_index ];
		$yesterday_day = $days_order[ ( $today_index + 6 ) % 7 ];
		$current_time  = wp_date( 'H:i' );

		// 1. Check if yesterday's overnight hours carry into early morning today.
		foreach ( $schedule_list as $item ) {
			$day_name = trim( $item['awea_business_hours_day'] ?? '' );
			if ( 0 === strcasecmp( $day_name, $yesterday_day ) && 'yes' !== ( $item['awea_business_hours_closed'] ?? '' ) ) {
				$open_time  = $this->normalize_24h( $item['awea_business_hours_open_24'] ?? '' );
				$close_time = $this->normalize_24h( $item['awea_business_hours_close_24'] ?? '' );
				if ( '' !== $open_time && '' !== $close_time && $close_time < $open_time && $current_time <= $close_time ) {
					return true;
				}
			}
		}

		// 2. Check today's operational window.
		foreach ( $schedule_list as $item ) {
			$day_name = trim( $item['awea_business_hours_day'] ?? '' );
			if ( 0 === strcasecmp( $day_name, $current_day ) ) {
				if ( 'yes' === ( $item['awea_business_hours_closed'] ?? '' ) ) {
					return false;
				}
				$open_time  = $this->normalize_24h( $item['awea_business_hours_open_24'] ?? '' );
				$close_time = $this->normalize_24h( $item['awea_business_hours_close_24'] ?? '' );
				if ( '' === $open_time || '' === $close_time ) {
					return true;
				}
				if ( $close_time < $open_time ) {
					return ( $current_time >= $open_time );
				}
				return ( $current_time >= $open_time && $current_time <= $close_time );
			}
		}

		return false;
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$schedule     = $settings['awea_business_hours_schedule'] ?? [];
		$current_day  = wp_date( 'l' );
		$is_open_now  = $this->calculate_is_open_now( $schedule );
		$show_status  = 'yes' === ( $settings['awea_business_hours_show_status'] ?? 'yes' );
		$open_label   = ! empty( $settings['awea_business_hours_open_text'] ) ? $settings['awea_business_hours_open_text'] : esc_html__( 'Open Now', 'awesome-widgets-elementor' );
		$closed_label = ! empty( $settings['awea_business_hours_closed_text'] ) ? $settings['awea_business_hours_closed_text'] : esc_html__( 'Closed Now', 'awesome-widgets-elementor' );
		$tz_note      = $settings['awea_business_hours_timezone_note'] ?? '';
		$show_phone   = 'yes' === ( $settings['awea_business_hours_phone_show'] ?? 'no' );
		$phone_num    = $settings['awea_business_hours_phone_num'] ?? '';
		$phone_link   = $settings['awea_business_hours_phone_url'] ?? [];
		$title_tag    = Utils::validate_html_tag( $settings['awea_business_hours_title_tag'] ?? 'h2' );
		$widget_id    = $this->get_id();
		$wp_timezone  = wp_timezone_string();
		$gmt_offset   = (float) get_option( 'gmt_offset', 0 );

		if ( $show_phone && ! empty( $phone_num ) ) {
			$this->remove_render_attribute( 'awea_business_hours_phone_call' );
			if ( empty( $phone_link['url'] ) ) {
				$clean_tel         = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_link['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'awea_business_hours_phone_call', $phone_link );
		}
		?>
		<div class="awea_business_hours_root" id="awea_business_hours_<?php echo esc_attr( $widget_id ); ?>"
			 data-awea_business_hours_open_label="<?php echo esc_attr( $open_label ); ?>"
			 data-awea_business_hours_closed_label="<?php echo esc_attr( $closed_label ); ?>"
			 data-awea_business_hours_timezone="<?php echo esc_attr( $wp_timezone ); ?>"
			 data-awea_business_hours_gmt_offset="<?php echo esc_attr( (string) $gmt_offset ); ?>">
			<div class="awea_business_hours_card">

				<!-- Left Status Panel -->
				<div class="awea_business_hours_left">
					<?php if ( $show_status ) : ?>
						<div class="awea_business_hours_badge <?php echo $is_open_now ? 'awea_business_hours_is_open' : 'awea_business_hours_is_closed'; ?>">
							<span class="awea_business_hours_pulse" aria-hidden="true"></span>
							<span class="awea_business_hours_badge_text"><?php echo esc_html( $is_open_now ? $open_label : $closed_label ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_business_hours_title'] ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_business_hours_title">
							<?php echo esc_html( $settings['awea_business_hours_title'] ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_business_hours_desc'] ) ) : ?>
						<p class="awea_business_hours_desc"><?php echo esc_html( $settings['awea_business_hours_desc'] ); ?></p>
					<?php endif; ?>

					<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
						<div class="awea_business_hours_phone">
							<?php if ( ! empty( $settings['awea_business_hours_phone_label'] ) ) : ?>
								<span class="awea_business_hours_phone_label"><?php echo esc_html( $settings['awea_business_hours_phone_label'] ); ?></span>
							<?php endif; ?>

							<a class="awea_business_hours_phone_link" <?php $this->print_render_attribute_string( 'awea_business_hours_phone_call' ); ?>>
								<?php if ( ! empty( $settings['awea_business_hours_phone_icon']['value'] ) ) : ?>
									<span class="awea_business_hours_phone_ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_business_hours_phone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span class="awea_business_hours_phone_num"><?php echo esc_html( $phone_num ); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right Weekly Schedule -->
				<div class="awea_business_hours_right">
					<?php if ( ! empty( $schedule ) ) : ?>
						<div class="awea_business_hours_list">
							<?php foreach ( $schedule as $item ) :
								$day_name  = trim( $item['awea_business_hours_day'] ?? '' );
								$is_closed = 'yes' === ( $item['awea_business_hours_closed'] ?? '' );
								$is_today  = ( 0 === strcasecmp( $day_name, $current_day ) );
								$time_str  = $is_closed
									? ( ! empty( $item['awea_business_hours_closed_label'] ) ? $item['awea_business_hours_closed_label'] : esc_html__( 'CLOSED', 'awesome-widgets-elementor' ) )
									: ( $item['awea_business_hours_hours'] ?? '' );

								$row_classes = [ 'awea_business_hours_row' ];
								if ( $is_today ) {
									$row_classes[] = 'awea_business_hours_is_today';
								}
								if ( $is_closed ) {
									$row_classes[] = 'awea_business_hours_is_closed';
								}
								?>
								<div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>"
									 data-awea_business_hours_day="<?php echo esc_attr( $day_name ); ?>"
									 data-awea_business_hours_closed="<?php echo $is_closed ? '1' : '0'; ?>"
									 data-awea_business_hours_open="<?php echo esc_attr( $this->normalize_24h( $item['awea_business_hours_open_24'] ?? '' ) ); ?>"
									 data-awea_business_hours_close="<?php echo esc_attr( $this->normalize_24h( $item['awea_business_hours_close_24'] ?? '' ) ); ?>">
									<div class="awea_business_hours_day_wrap">
										<span class="awea_business_hours_dot" aria-hidden="true"></span>
										<span class="awea_business_hours_day"><?php echo esc_html( $day_name ); ?></span>
									</div>
									<span class="awea_business_hours_time"><?php echo esc_html( $time_str ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $tz_note ) ) : ?>
						<div class="awea_business_hours_tz"><?php echo esc_html( $tz_note ); ?></div>
					<?php endif; ?>
				</div>

			</div>
		</div>

		<script>
		(function() {
			var DAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

			function awea_business_hours_get_date_parts(tz, gmtOffset) {
				var now = new Date();
				try {
					if (tz && tz.indexOf('/') !== -1) {
						var dayFmt = new Intl.DateTimeFormat('en-US', { timeZone: tz, weekday: 'long' });
						var timeFmt = new Intl.DateTimeFormat('en-GB', {
							timeZone: tz,
							hour: '2-digit',
							minute: '2-digit',
							hour12: false,
							hourCycle: 'h23'
						});
						var dayName = dayFmt.format(now);
						return {
							dayName: dayName,
							dayIndex: DAYS.indexOf(dayName),
							timeStr: timeFmt.format(now)
						};
					}
				} catch (e) {}

				var offsetMs = (parseFloat(gmtOffset) || 0) * 3600000;
				var shifted = new Date(now.getTime() + offsetMs);
				var dayIdx = shifted.getUTCDay();
				var hh = String(shifted.getUTCHours()).padStart(2, '0');
				var mm = String(shifted.getUTCMinutes()).padStart(2, '0');
				return {
					dayName: DAYS[dayIdx],
					dayIndex: dayIdx,
					timeStr: hh + ':' + mm
				};
			}

			function awea_business_hours_sync(root) {
				if (!root) return;

				var tz = root.getAttribute('data-awea_business_hours_timezone') || '';
				var gmtOffset = root.getAttribute('data-awea_business_hours_gmt_offset') || '0';
				var parts = awea_business_hours_get_date_parts(tz, gmtOffset);
				var todayName = parts.dayName;
				var yesterdayName = parts.dayIndex >= 0 ? DAYS[(parts.dayIndex + 6) % 7] : '';
				var nowStr = parts.timeStr;

				var isOpen = false;
				var rows = root.querySelectorAll('.awea_business_hours_row');

				rows.forEach(function(row) {
					var day = (row.getAttribute('data-awea_business_hours_day') || '').trim();
					var closed = row.getAttribute('data-awea_business_hours_closed') === '1';
					var open24 = row.getAttribute('data-awea_business_hours_open') || '';
					var close24 = row.getAttribute('data-awea_business_hours_close') || '';

					if (yesterdayName && day.toLowerCase() === yesterdayName.toLowerCase() && !closed) {
						if (open24 && close24 && close24 < open24 && nowStr <= close24) {
							isOpen = true;
						}
					}

					if (day.toLowerCase() === todayName.toLowerCase()) {
						row.classList.add('awea_business_hours_is_today');
						if (!closed) {
							if (!open24 || !close24) {
								isOpen = true;
							} else if (close24 < open24) {
								if (nowStr >= open24) isOpen = true;
							} else if (nowStr >= open24 && nowStr <= close24) {
								isOpen = true;
							}
						}
					} else {
						row.classList.remove('awea_business_hours_is_today');
					}
				});

				var badge = root.querySelector('.awea_business_hours_badge');
				var badgeText = root.querySelector('.awea_business_hours_badge_text');
				if (badge && badgeText) {
					badge.classList.toggle('awea_business_hours_is_open', isOpen);
					badge.classList.toggle('awea_business_hours_is_closed', !isOpen);
					badgeText.textContent = isOpen
						? root.getAttribute('data-awea_business_hours_open_label')
						: root.getAttribute('data-awea_business_hours_closed_label');
				}
			}

			function awea_business_hours_init() {
				var el = document.getElementById('awea_business_hours_<?php echo esc_js( $widget_id ); ?>');
				awea_business_hours_sync(el);
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_business_hours_init);
			} else {
				awea_business_hours_init();
			}

			if (!window.awea_business_hours_hooked && window.elementorFrontend && window.elementorFrontend.hooks) {
				window.awea_business_hours_hooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-business-hours.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_business_hours_root') : null;
					awea_business_hours_sync(el);
				});
			}
		})();
		</script>
		<?php
	}
}