<?php
/**
 * Awesome List Group Widget.
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
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_List_Group extends Widget_Base {

	public function get_name() {
		return 'awesome-list-group';
	}

	public function get_title() {
		return esc_html__( 'List Group', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'list', 'group', 'features', 'checklist', 'directory', 'icon list' ];
	}

	protected function register_controls() {
		$this->register_content_controls();$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_list_group_repeater_tabs' );

		// --- TAB 1: CONTENT ---
		$repeater->start_controls_tab(
			'awea_list_group_tab_content',
			[ 'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_list_group_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_list_group_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'High-Throughput Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_list_group_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Engineered for sub-millisecond responses and high concurrency with zero runtime overhead.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_list_group_badge',
			[
				'label'       => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'New', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_list_group_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_list_group_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_list_group_item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_list_group_icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_list_group_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_list_group_item_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_icon_stacked {{CURRENT_ITEM}} .awea_list_group_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_list_group_item_badge_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_list_group_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_list_group_item_badge_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_list_group_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_list_group_items',
			[
				'label'       => esc_html__( 'List Items', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_list_group_title }}}',
				'default'     => [
					[
						'awea_list_group_title' => esc_html__( 'Sourced from Certified Partners', 'awesome-widgets-elementor' ),
						'awea_list_group_desc'  => esc_html__( 'Direct procurement from verified sustainable farms and ethical suppliers globally.', 'awesome-widgets-elementor' ),
						'awea_list_group_badge' => esc_html__( 'Verified', 'awesome-widgets-elementor' ),
						'awea_list_group_icon'  => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
					],
					[
						'awea_list_group_title' => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ),
						'awea_list_group_desc'  => esc_html__( 'Continuous metric reporting and end-to-end milestone notifications at every step.', 'awesome-widgets-elementor' ),
						'awea_list_group_icon'  => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
					],
					[
						'awea_list_group_title' => esc_html__( 'Automated Compliance Engine', 'awesome-widgets-elementor' ),
						'awea_list_group_desc'  => esc_html__( 'Zero-friction validation against industry standards with encrypted record persistence.', 'awesome-widgets-elementor' ),
						'awea_list_group_badge' => esc_html__( 'Core', 'awesome-widgets-elementor' ),
						'awea_list_group_icon'  => [ 'value' => 'fas fa-microchip', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_list_group_mode',
			[
				'label'        => esc_html__( 'Layout Mode', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'connected',
				'options'      => [
					'connected' => esc_html__( 'Connected Group', 'awesome-widgets-elementor' ),
					'separated' => esc_html__( 'Separated Cards', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_list_group_mode_',
			]
		);

		$this->add_responsive_control(
			'awea_list_group_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition'      => [ 'awea_list_group_mode' => 'separated' ],
				'selectors'      => [
					'{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_wrap' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_section_icon_layout',
			[
				'label' => esc_html__( 'Icon Setup', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_list_group_icon_view',
			[
				'label'        => esc_html__( 'View', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'default' => esc_html__( 'Default (Minimal)', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Stacked (Filled)', 'awesome-widgets-elementor' ),
					'framed'  => esc_html__( 'Framed (Outlined)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_list_group_icon_',
			]
		);

		$this->add_control(
			'awea_list_group_icon_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_list_group_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'awea_list_group_arrow_icon',
			[
				'label'       => esc_html__( 'Custom Link Arrow Icon (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_container',
			[
				'label'     => esc_html__( 'Container', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_list_group_mode' => 'connected' ],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_box_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_box_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_list_group_box_border',
				'selector'       => '{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_wrap',
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

		$this->add_control(
			'awea_list_group_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_list_group_box_shadow',
				'selector' => '{{WRAPPER}}.awea_list_group_mode_connected .awea_list_group_wrap',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_list_group_item_gap',
			[
				'label'      => esc_html__( 'Gap Between Cards', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'condition'  => [ 'awea_list_group_mode' => 'separated' ],
				'selectors'  => [
					'{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '22',
					'bottom'   => '20',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '18',
					'right'    => '18',
					'bottom'   => '18',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_list_group_item_tabs' );

		$this->start_controls_tab(
			'awea_list_group_item_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_list_group_item_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'awea_list_group_mode' => 'separated' ],
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_list_group_item_border',
				'selector'       => '{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_item',
				'condition'      => [ 'awea_list_group_mode' => 'separated' ],
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
				'name'      => 'awea_list_group_item_shadow',
				'selector'  => '{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_item',
				'condition' => [ 'awea_list_group_mode' => 'separated' ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_list_group_item_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_list_group_item_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item:hover, {{WRAPPER}} a.awea_list_group_item:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_item_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_list_group_mode' => 'separated' ],
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_item:hover, {{WRAPPER}}.awea_list_group_mode_separated a.awea_list_group_item:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_list_group_item_shadow_hover',
				'selector'  => '{{WRAPPER}}.awea_list_group_mode_separated .awea_list_group_item:hover, {{WRAPPER}}.awea_list_group_mode_separated a.awea_list_group_item:focus-visible',
				'condition' => [ 'awea_list_group_mode' => 'separated' ],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_icon',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_list_group_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'condition'  => [ 'awea_list_group_icon_view!' => 'default' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 42 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_list_group_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_icon_gap',
			[
				'label'      => esc_html__( 'Spacing to Content', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'condition'  => [ 'awea_list_group_icon_view!' => 'default' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_list_group_icon_tabs' );

		$this->start_controls_tab(
			'awea_list_group_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_list_group_icon_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .awea_list_group_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'condition' => [ 'awea_list_group_icon_view' => 'stacked' ],
				'selectors' => [
					'{{WRAPPER}}.awea_list_group_icon_stacked .awea_list_group_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_list_group_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_list_group_icon_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_icon, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_icon'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_icon svg, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_list_group_icon_view!' => 'default' ],
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_icon, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE & DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_list_group_title_typo',
				'selector' => '{{WRAPPER}} .awea_list_group_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_list_group_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_title, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_list_group_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_list_group_desc_typo',
				'selector' => '{{WRAPPER}} .awea_list_group_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_list_group_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_list_group_badge_typo',
				'selector' => '{{WRAPPER}} .awea_list_group_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_list_group_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_list_group_badge_border',
				'selector' => '{{WRAPPER}} .awea_list_group_badge',
			]
		);

		$this->add_responsive_control(
			'awea_list_group_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_list_group_badge_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. ARROW
		   ========================================================================== */
		$this->start_controls_section(
			'awea_list_group_style_arrow',
			[
				'label' => esc_html__( 'Link Arrow', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_list_group_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 17 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_list_group_arrow'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_list_group_arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_list_group_arrow svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_list_group_arrow_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_arrow, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_arrow'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_list_group_item:hover .awea_list_group_arrow svg, {{WRAPPER}} a.awea_list_group_item:focus-visible .awea_list_group_arrow svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_list_group_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_list_group_title_tag'] ?? 'h3' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea_list_group_wrap">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$title    = $item['awea_list_group_title'] ?? '';
				$desc     = $item['awea_list_group_desc'] ?? '';
				$badge    = $item['awea_list_group_badge'] ?? '';
				$has_url  = ! empty( $item['awea_list_group_link']['url'] );
				$link_key = 'awea_list_group_link_' . $id;
				$tag      = $has_url ? 'a' : 'article';

				$this->remove_render_attribute( $link_key );
				if ( $has_url ) {
					$this->add_link_attributes( $link_key, $item['awea_list_group_link'] );
				}
				$this->add_render_attribute( $link_key, 'class', 'awea_list_group_item elementor-repeater-item-' . $id );
				?>
				<<?php Utils::print_validated_html_tag( $tag ); ?> <?php $this->print_render_attribute_string( $link_key ); ?>>

					<?php if ( ! empty( $item['awea_list_group_icon']['value'] ) ) : ?>
						<div class="awea_list_group_icon" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_list_group_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="awea_list_group_body">
						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_list_group_title">
								<?php echo esc_html( $title ); ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea_list_group_desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $badge ) || $has_url ) : ?>
						<div class="awea_list_group_meta">
							<?php if ( ! empty( $badge ) ) : ?>
								<span class="awea_list_group_badge"><?php echo esc_html( $badge ); ?></span>
							<?php endif; ?>

							<?php if ( $has_url ) : ?>
								<span class="awea_list_group_arrow" aria-hidden="true">
									<?php if ( ! empty( $settings['awea_list_group_arrow_icon']['value'] ) ) : ?>
										<?php Icons_Manager::render_icon( $settings['awea_list_group_arrow_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									<?php else : ?>
										<svg class="awea_list_group_arrow_default" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="9 18 15 12 9 6"></polyline>
										</svg>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				</<?php Utils::print_validated_html_tag( $tag ); ?>>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		if ( ! settings.awea_list_group_items || ! settings.awea_list_group_items.length ) {
			return;
		}
		var titleTag = elementor.helpers.validateHTMLTag( settings.awea_list_group_title_tag || 'h3' );
		var arrowIco = elementor.helpers.renderIcon( view, settings.awea_list_group_arrow_icon, { 'aria-hidden': true }, 'i', 'object' );
		#>
		<div class="awea_list_group_wrap">
			<# _.each( settings.awea_list_group_items, function( item, index ) {
				var id       = item._id || index;
				var title    = item.awea_list_group_title || '';
				var desc     = item.awea_list_group_desc || '';
				var badge    = item.awea_list_group_badge || '';
				var url      = ( item.awea_list_group_link && item.awea_list_group_link.url ) ? item.awea_list_group_link.url : '';
				var hasUrl   = !! url;
				var tag      = hasUrl ? 'a' : 'article';
				var hrefAttr = hasUrl ? ' href="' + _.escape( url ) + '"' : '';
				var iconHTML = elementor.helpers.renderIcon( view, item.awea_list_group_icon, { 'aria-hidden': true }, 'i', 'object' );
			#>
				<{{{ tag }}}{{ hrefAttr }} class="awea_list_group_item elementor-repeater-item-{{ id }}">
					<# if ( iconHTML && iconHTML.rendered ) { #>
						<div class="awea_list_group_icon" aria-hidden="true">{{{ iconHTML.value }}}</div>
					<# } #>

					<div class="awea_list_group_body">
						<# if ( title ) { #>
							<{{{ titleTag }}} class="awea_list_group_title">{{{ title }}}</{{{ titleTag }}}>
						<# } #>

						<# if ( desc ) { #>
							<p class="awea_list_group_desc">{{{ desc }}}</p>
						<# } #>
					</div>

					<# if ( badge || hasUrl ) { #>
						<div class="awea_list_group_meta">
							<# if ( badge ) { #>
								<span class="awea_list_group_badge">{{{ badge }}}</span>
							<# } #>

							<# if ( hasUrl ) { #>
								<span class="awea_list_group_arrow" aria-hidden="true">
									<# if ( arrowIco && arrowIco.rendered ) { #>
										{{{ arrowIco.value }}}
									<# } else { #>
										<svg class="awea_list_group_arrow_default" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="9 18 15 12 9 6"></polyline>
										</svg>
									<# } #>
								</span>
							<# } #>
						</div>
					<# } #>
				</{{{ tag }}}>
			<# } ); #>
		</div>
		<?php
	}
}