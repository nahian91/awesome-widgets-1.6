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

		/* ==========================================================================
		   CONTENT: 1. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_status',
			[
				'label'        => esc_html__( 'Live Status Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_open_text',
			[
				'label'     => esc_html__( 'Open Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Open Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_closed_text',
			[
				'label'     => esc_html__( 'Closed Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Closed Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( "We're ready to create.", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_title_tag',
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
			'awea_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Visit our studio or connect directly with our team during operational business hours.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_timezone_note',
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
		   CONTENT: 2. PHONE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_phone',
			[
				'label' => esc_html__( 'Direct Contact', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_phone_show',
			[
				'label'        => esc_html__( 'Show Contact Block', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_phone_label',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Support Line', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_phone_num',
			[
				'label'     => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 456-7890',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_phone_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18004567890',
				'default'     => [ 'url' => 'tel:+18004567890' ],
				'condition'   => [ 'awea_phone_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SCHEDULE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_schedule',
			[
				'label' => esc_html__( 'Schedule', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_day',
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
			'awea_closed',
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
			'awea_hours',
			[
				'label'       => esc_html__( 'Display Hours', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00 AM — 06:00 PM',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_closed!' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_closed_label',
			[
				'label'       => esc_html__( 'Closed Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'CLOSED', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_closed' => 'yes' ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_open_24',
			[
				'label'       => esc_html__( 'Opens At (24h HH:MM)', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Used for live Open/Closed status detection.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '09:00',
				'placeholder' => '09:00',
				'condition'   => [ 'awea_closed!' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_close_24',
			[
				'label'       => esc_html__( 'Closes At (24h HH:MM)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '18:00',
				'placeholder' => '18:00',
				'condition'   => [ 'awea_closed!' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_schedule',
			[
				'label'       => esc_html__( 'Weekly Days', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_day }}} — {{{ awea_closed === "yes" ? (awea_closed_label || "CLOSED") : awea_hours }}}',
				'default'     => [
					[ 'awea_day' => 'Monday', 'awea_hours' => '09:00 AM — 06:00 PM', 'awea_open_24' => '09:00', 'awea_close_24' => '18:00' ],
					[ 'awea_day' => 'Tuesday', 'awea_hours' => '09:00 AM — 06:00 PM', 'awea_open_24' => '09:00', 'awea_close_24' => '18:00' ],
					[ 'awea_day' => 'Wednesday', 'awea_hours' => '09:00 AM — 06:00 PM', 'awea_open_24' => '09:00', 'awea_close_24' => '18:00' ],
					[ 'awea_day' => 'Thursday', 'awea_hours' => '09:00 AM — 06:00 PM', 'awea_open_24' => '09:00', 'awea_close_24' => '18:00' ],
					[ 'awea_day' => 'Friday', 'awea_hours' => '09:00 AM — 06:00 PM', 'awea_open_24' => '09:00', 'awea_close_24' => '18:00' ],
					[ 'awea_day' => 'Saturday', 'awea_hours' => '10:00 AM — 04:00 PM', 'awea_open_24' => '10:00', 'awea_close_24' => '16:00' ],
					[ 'awea_day' => 'Sunday', 'awea_closed' => 'yes', 'awea_closed_label' => 'CLOSED' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_layout_mode',
			[
				'label'        => esc_html__( 'Layout Mode', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'split',
				'options'      => [
					'split'   => esc_html__( 'Split Card', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Stacked List', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bh-mode-',
			]
		);

		$this->add_control(
			'awea_surface_theme',
			[
				'label'        => esc_html__( 'Surface Scheme', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'dark',
				'options'      => [
					'dark'  => esc_html__( 'Dark Slate', 'awesome-widgets-elementor' ),
					'light' => esc_html__( 'Clean Light', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-bh-theme-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_card',
			[
				'label' => esc_html__( 'Card Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Main Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_right_bg',
			[
				'label'     => esc_html__( 'Schedule Panel Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-right' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_panel_divider_color',
			[
				'label'     => esc_html__( 'Panel Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-right' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-bh-card',
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
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
					'{{WRAPPER}} .awea-bh-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
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
					'{{WRAPPER}} .awea-bh-left, {{WRAPPER}} .awea-bh-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-bh-card',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STATUS BADGE & CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Status & Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_badge_heading',
			[
				'label'     => esc_html__( 'Status Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_badge_typo',
				'selector'  => '{{WRAPPER}} .awea-bh-badge',
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_open_color',
			[
				'label'     => esc_html__( 'Open Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-open' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_open_bg',
			[
				'label'     => esc_html__( 'Open Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-open' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_closed_color',
			[
				'label'     => esc_html__( 'Closed Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-closed' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_closed_bg',
			[
				'label'     => esc_html__( 'Closed Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-badge.is-closed' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_status' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_heading',
			[
				'label'     => esc_html__( 'Title & Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-bh-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-bh-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_phone_heading',
			[
				'label'     => esc_html__( 'Direct Contact', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_phone_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_phone_label_color',
			[
				'label'     => esc_html__( 'Caption Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_phone_show' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_phone_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_phone_show' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_phone_ico_bg',
			[
				'label'     => esc_html__( 'Icon Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_phone_show' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_phone_ico_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_phone_show' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bh-phone-ico' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_phone_typo',
				'selector'  => '{{WRAPPER}} .awea-bh-phone-num',
				'condition' => [ 'awea_phone_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. SCHEDULE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_schedule',
			[
				'label' => esc_html__( 'Schedule Table', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_row_pad',
			[
				'label'      => esc_html__( 'Row Vertical Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bh-row' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_line_color',
			[
				'label'     => esc_html__( 'Row Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_day_typo',
				'label'    => esc_html__( 'Day Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-day',
			]
		);

		$this->add_control(
			'awea_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_hours_typo',
				'label'    => esc_html__( 'Hours Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-bh-time',
			]
		);

		$this->add_control(
			'awea_hours_color',
			[
				'label'     => esc_html__( 'Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_today_color',
			[
				'label'     => esc_html__( 'Current Day Accent', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-today'             => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_today_time_color',
			[
				'label'     => esc_html__( 'Current Day Hours Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-today .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_closed_color',
			[
				'label'     => esc_html__( 'Closed Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-bh-row.is-closed .awea-bh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tz_color',
			[
				'label'     => esc_html__( 'Timezone Note Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-bh-tz' => 'color: {{VALUE}};',
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
			$day_name = trim( $item['awea_day'] ?? '' );
			if ( 0 === strcasecmp( $day_name, $yesterday_day ) && 'yes' !== ( $item['awea_closed'] ?? '' ) ) {
				$open_time  = $this->normalize_24h( $item['awea_open_24'] ?? '' );
				$close_time = $this->normalize_24h( $item['awea_close_24'] ?? '' );
				if ( '' !== $open_time && '' !== $close_time && $close_time < $open_time && $current_time <= $close_time ) {
					return true;
				}
			}
		}

		// 2. Check today's operational window.
		foreach ( $schedule_list as $item ) {
			$day_name = trim( $item['awea_day'] ?? '' );
			if ( 0 === strcasecmp( $day_name, $current_day ) ) {
				if ( 'yes' === ( $item['awea_closed'] ?? '' ) ) {
					return false;
				}
				$open_time  = $this->normalize_24h( $item['awea_open_24'] ?? '' );
				$close_time = $this->normalize_24h( $item['awea_close_24'] ?? '' );
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
		$schedule     = $settings['awea_schedule'] ?? [];
		$current_day  = wp_date( 'l' );
		$is_open_now  = $this->calculate_is_open_now( $schedule );
		$show_status  = 'yes' === ( $settings['awea_show_status'] ?? 'yes' );
		$open_label   = ! empty( $settings['awea_open_text'] ) ? $settings['awea_open_text'] : esc_html__( 'Open Now', 'awesome-widgets-elementor' );
		$closed_label = ! empty( $settings['awea_closed_text'] ) ? $settings['awea_closed_text'] : esc_html__( 'Closed Now', 'awesome-widgets-elementor' );
		$tz_note      = $settings['awea_timezone_note'] ?? '';
		$show_phone   = 'yes' === ( $settings['awea_phone_show'] ?? 'no' );
		$phone_num    = $settings['awea_phone_num'] ?? '';
		$phone_link   = $settings['awea_phone_url'] ?? [];
		$title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );
		$widget_id    = $this->get_id();
		$wp_timezone  = wp_timezone_string();
		$gmt_offset   = (float) get_option( 'gmt_offset', 0 );

		if ( $show_phone && ! empty( $phone_num ) ) {
			$this->remove_render_attribute( 'awea_phone_call' );
			if ( empty( $phone_link['url'] ) ) {
				$clean_tel         = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_link['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'awea_phone_call', $phone_link );
		}
		?>
		<div class="awea-bh-root" id="awea-bh-<?php echo esc_attr( $widget_id ); ?>"
			 data-open-label="<?php echo esc_attr( $open_label ); ?>"
			 data-closed-label="<?php echo esc_attr( $closed_label ); ?>"
			 data-timezone="<?php echo esc_attr( $wp_timezone ); ?>"
			 data-gmt-offset="<?php echo esc_attr( (string) $gmt_offset ); ?>">
			<div class="awea-bh-card">

				<!-- Left Status Panel -->
				<div class="awea-bh-left">
					<?php if ( $show_status ) : ?>
						<div class="awea-bh-badge <?php echo $is_open_now ? 'is-open' : 'is-closed'; ?>">
							<span class="awea-bh-pulse" aria-hidden="true"></span>
							<span class="awea-bh-badge-text"><?php echo esc_html( $is_open_now ? $open_label : $closed_label ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_title'] ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-bh-title">
							<?php echo esc_html( $settings['awea_title'] ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings['awea_desc'] ) ) : ?>
						<p class="awea-bh-desc"><?php echo esc_html( $settings['awea_desc'] ); ?></p>
					<?php endif; ?>

					<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
						<div class="awea-bh-phone">
							<?php if ( ! empty( $settings['awea_phone_label'] ) ) : ?>
								<span class="awea-bh-phone-label"><?php echo esc_html( $settings['awea_phone_label'] ); ?></span>
							<?php endif; ?>

							<a class="awea-bh-phone-link" <?php $this->print_render_attribute_string( 'awea_phone_call' ); ?>>
								<span class="awea-bh-phone-ico" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
									</svg>
								</span>
								<span class="awea-bh-phone-num"><?php echo esc_html( $phone_num ); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right Weekly Schedule -->
				<div class="awea-bh-right">
					<?php if ( ! empty( $schedule ) ) : ?>
						<div class="awea-bh-list">
							<?php foreach ( $schedule as $item ) :
								$day_name  = trim( $item['awea_day'] ?? '' );
								$is_closed = 'yes' === ( $item['awea_closed'] ?? '' );
								$is_today  = ( 0 === strcasecmp( $day_name, $current_day ) );
								$time_str  = $is_closed
									? ( ! empty( $item['awea_closed_label'] ) ? $item['awea_closed_label'] : esc_html__( 'CLOSED', 'awesome-widgets-elementor' ) )
									: ( $item['awea_hours'] ?? '' );

								$row_classes = [ 'awea-bh-row' ];
								if ( $is_today ) {
									$row_classes[] = 'is-today';
								}
								if ( $is_closed ) {
									$row_classes[] = 'is-closed';
								}
								?>
								<div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>"
									 data-day="<?php echo esc_attr( $day_name ); ?>"
									 data-closed="<?php echo $is_closed ? '1' : '0'; ?>"
									 data-open="<?php echo esc_attr( $this->normalize_24h( $item['awea_open_24'] ?? '' ) ); ?>"
									 data-close="<?php echo esc_attr( $this->normalize_24h( $item['awea_close_24'] ?? '' ) ); ?>">
									<div class="awea-bh-day-wrap">
										<span class="awea-bh-dot" aria-hidden="true"></span>
										<span class="awea-bh-day"><?php echo esc_html( $day_name ); ?></span>
									</div>
									<span class="awea-bh-time"><?php echo esc_html( $time_str ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $tz_note ) ) : ?>
						<div class="awea-bh-tz"><?php echo esc_html( $tz_note ); ?></div>
					<?php endif; ?>
				</div>

			</div>
		</div>

		<script>
		(function() {
			var DAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

			function getSiteDateParts(tz, gmtOffset) {
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

				// Fallback to WordPress numeric GMT offset (handles manual UTC±X settings)
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

			function syncBusinessHours(root) {
				if (!root) return;

				var tz = root.getAttribute('data-timezone') || '';
				var gmtOffset = root.getAttribute('data-gmt-offset') || '0';
				var parts = getSiteDateParts(tz, gmtOffset);
				var todayName = parts.dayName;
				var yesterdayName = parts.dayIndex >= 0 ? DAYS[(parts.dayIndex + 6) % 7] : '';
				var nowStr = parts.timeStr;

				var isOpen = false;
				var rows = root.querySelectorAll('.awea-bh-row');

				rows.forEach(function(row) {
					var day = (row.getAttribute('data-day') || '').trim();
					var closed = row.getAttribute('data-closed') === '1';
					var open24 = row.getAttribute('data-open') || '';
					var close24 = row.getAttribute('data-close') || '';

					// Check yesterday's overnight spillover into early morning today
					if (yesterdayName && day.toLowerCase() === yesterdayName.toLowerCase() && !closed) {
						if (open24 && close24 && close24 < open24 && nowStr <= close24) {
							isOpen = true;
						}
					}

					if (day.toLowerCase() === todayName.toLowerCase()) {
						row.classList.add('is-today');
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
						row.classList.remove('is-today');
					}
				});

				var badge = root.querySelector('.awea-bh-badge');
				var badgeText = root.querySelector('.awea-bh-badge-text');
				if (badge && badgeText) {
					badge.classList.toggle('is-open', isOpen);
					badge.classList.toggle('is-closed', !isOpen);
					badgeText.textContent = isOpen
						? root.getAttribute('data-open-label')
						: root.getAttribute('data-closed-label');
				}
			}

			function initInstance() {
				var el = document.getElementById('awea-bh-<?php echo esc_js( $widget_id ); ?>');
				syncBusinessHours(el);
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initInstance);
			} else {
				initInstance();
			}

			if (!window.aweaBhHookRegistered && window.elementorFrontend && window.elementorFrontend.hooks) {
				window.aweaBhHookRegistered = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-business-hours.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea-bh-root') : null;
					syncBusinessHours(el);
				});
			}
		})();
		</script>
		<?php
	}
}