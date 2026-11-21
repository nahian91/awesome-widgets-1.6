<?php
/**
 * Awesome Icon Box Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.2.0
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

class Widget_Awesome_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-icon-box';
	}

	public function get_title() {
		return esc_html__( 'Icon Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'icon', 'box', 'grid', 'feature', 'card', 'service', 'shape' ];
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
		   CONTENT: 1. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_icon_box_item_tabs' );

		// --- TAB 1: ICON ---
		$repeater->start_controls_tab(
			'awea_icon_box_tab_icon',
			[ 'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon_box_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_icon_box_badge',
			[
				'label'       => esc_html__( 'Corner Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'New', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_icon_box_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon_box_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lightning Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_icon_box_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Engineered for optimal rendering speeds with zero unnecessary overhead straight out of the box.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: LINK ---
		$repeater->start_controls_tab(
			'awea_icon_box_tab_link',
			[ 'label' => esc_html__( 'Link & Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon_box_btn_link',
			[
				'label'   => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_icon_box_btn_show',
			[
				'label'        => esc_html__( 'Display Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_icon_box_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Module', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_icon_box_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_icon_box_btn_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_icon_box_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_icon_box_btn_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Before', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'After', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'right',
				'condition' => [
					'awea_icon_box_btn_show'        => 'yes',
					'awea_icon_box_btn_icon[value]!' => '',
				],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_icon_box_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon_box_item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea_icon_box_item_ico_color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icon_box_item_icon_bg',
			[
				'label'     => esc_html__( 'Icon Accent / Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea_icon_box_item_ico_accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icon_box_item_border_color',
			[
				'label'     => esc_html__( 'Card Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icon_box_item_badge_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_icon_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icon_box_item_badge_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_icon_box_badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_icon_box_items',
			[
				'label'       => esc_html__( 'Cards List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_icon_box_title }}}',
				'default'     => [
					[
						'awea_icon_box_icon'     => [ 'value' => 'fas fa-bolt', 'library' => 'fa-solid' ],
						'awea_icon_box_title'    => esc_html__( 'Lightning Architecture', 'awesome-widgets-elementor' ),
						'awea_icon_box_desc'     => esc_html__( 'Engineered for optimal rendering speeds with zero unnecessary overhead straight out of the box.', 'awesome-widgets-elementor' ),
						'awea_icon_box_btn_text' => esc_html__( 'Explore Module', 'awesome-widgets-elementor' ),
					],
					[
						'awea_icon_box_icon'     => [ 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ],
						'awea_icon_box_badge'    => esc_html__( 'Core', 'awesome-widgets-elementor' ),
						'awea_icon_box_title'    => esc_html__( 'Modular Precision', 'awesome-widgets-elementor' ),
						'awea_icon_box_desc'     => esc_html__( 'Clean component primitives built to stay aligned across desktop, tablet, and mobile viewports.', 'awesome-widgets-elementor' ),
						'awea_icon_box_btn_text' => esc_html__( 'View System', 'awesome-widgets-elementor' ),
					],
					[
						'awea_icon_box_icon'     => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
						'awea_icon_box_title'    => esc_html__( 'Hardened Security', 'awesome-widgets-elementor' ),
						'awea_icon_box_desc'     => esc_html__( 'Strict escaping, sanitized attributes, and resilient markup designed for enterprise production.', 'awesome-widgets-elementor' ),
						'awea_icon_box_btn_text' => esc_html__( 'Read Specs', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_section_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea_icon_box_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_section_icon_layout',
			[
				'label' => esc_html__( 'Icon Setup', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_icon_box_icon_view',
			[
				'label'        => esc_html__( 'View', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'default' => esc_html__( 'Default (Minimal)', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Stacked (Filled)', 'awesome-widgets-elementor' ),
					'framed'  => esc_html__( 'Framed (Outlined)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_icon_box_view_',
			]
		);

		$this->add_control(
			'awea_icon_box_icon_shape',
			[
				'label'        => esc_html__( 'Shape', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'rounded',
				'options'      => [
					'rounded' => esc_html__( 'Rounded', 'awesome-widgets-elementor' ),
					'circle'  => esc_html__( 'Circle', 'awesome-widgets-elementor' ),
					'square'  => esc_html__( 'Square', 'awesome-widgets-elementor' ),
					'hexagon' => esc_html__( 'Hexagon', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_icon_box_icon_view!' => 'default' ],
				'prefix_class' => 'awea_icon_box_shape_',
			]
		);

		$this->add_control(
			'awea_icon_box_icon_pos',
			[
				'label'        => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'top',
				'toggle'       => false,
				'options'      => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'awea_icon_box_pos_',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_icon_box_link_mode',
			[
				'label'   => esc_html__( 'Link Target Area', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'Button Only', 'awesome-widgets-elementor' ),
					'title'  => esc_html__( 'Title & Button', 'awesome-widgets-elementor' ),
					'card'   => esc_html__( 'Entire Card', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_icon_box_title_tag',
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
			'awea_icon_box_hover_motion',
			[
				'label'        => esc_html__( 'Hover Card Lift', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_icon_box_motion_',
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
			'awea_icon_box_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'left',
				'selectors_dictionary' => [
					'left'   => 'flex-start; text-align: start',
					'center' => 'center; text-align: center',
					'right'  => 'flex-end; text-align: end',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_icon_box_card'     => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .awea_icon_box_body'     => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .awea_icon_box_btn_wrap' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '32',
					'right'    => '28',
					'bottom'   => '32',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_card_radius',
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
					'{{WRAPPER}} .awea_icon_box_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_box_card_tabs' );

		$this->start_controls_tab(
			'awea_icon_box_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_card' => 'background-color: {{VALUE}}; --awea_icon_box_card_bg: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_icon_box_card_border',
				'selector'       => '{{WRAPPER}} .awea_icon_box_card',
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
				'name'     => 'awea_icon_box_card_shadow',
				'selector' => '{{WRAPPER}} .awea_icon_box_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icon_box_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_card:hover' => 'background-color: {{VALUE}}; --awea_icon_box_card_bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icon_box_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_icon_box_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_style_icon',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 120 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 60 ],
				'condition'  => [ 'awea_icon_box_icon_view!' => 'default' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 72 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_icon_box_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_icon_gap',
			[
				'label'      => esc_html__( 'Spacing to Content', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [
					'awea_icon_box_icon_view!' => 'default',
					'awea_icon_box_icon_shape' => 'rounded',
				],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea_icon_box_shape_rounded .awea_icon_box_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_icon_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1.5 ],
				'condition'  => [
					'awea_icon_box_icon_view' => 'framed',
				],
				'selectors'  => [
					'{{WRAPPER}}.awea_icon_box_view_framed .awea_icon_box_icon' => 'border-width: {{SIZE}}{{UNIT}}; --awea_icon_box_hex_border: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_box_icon_tabs' );

		$this->start_controls_tab(
			'awea_icon_box_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'condition' => [ 'awea_icon_box_icon_view' => 'stacked' ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_bg: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [
					'awea_icon_box_icon_view' => 'framed',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_border: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icon_box_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_color_hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_icon_box_icon_view!' => 'default' ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_bg_hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_icon_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [
					'awea_icon_box_icon_view'   => 'framed',
					'awea_icon_box_icon_shape!' => 'hexagon',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_grid' => '--awea_icon_box_ico_border_hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_style_badge',
			[
				'label' => esc_html__( 'Corner Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_badge_top',
			[
				'label'      => esc_html__( 'Top Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_badge_side',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'inset-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icon_box_badge_typo',
				'selector' => '{{WRAPPER}} .awea_icon_box_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_icon_box_badge_border',
				'selector' => '{{WRAPPER}} .awea_icon_box_badge',
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '4',
					'right'    => '10',
					'bottom'   => '4',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_badge_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icon_box_title_typo',
				'selector' => '{{WRAPPER}} .awea_icon_box_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_box_title_tabs' );

		$this->start_controls_tab(
			'awea_icon_box_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_title, {{WRAPPER}} .awea_icon_box_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icon_box_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_title_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_title, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_icon_box_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icon_box_desc_typo',
				'selector' => '{{WRAPPER}} .awea_icon_box_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icon_box_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icon_box_btn_typo',
				'selector' => '{{WRAPPER}} .awea_icon_box_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_icon_box_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '11',
					'right'    => '20',
					'bottom'   => '11',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_icon_box_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_box_btn_tabs' );

		$this->start_controls_tab(
			'awea_icon_box_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_icon_box_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_icon_box_btn_border',
				'selector'       => '{{WRAPPER}} .awea_icon_box_btn',
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
					'color'  => [ 'default' => 'transparent' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icon_box_btn_shadow',
				'selector' => '{{WRAPPER}} .awea_icon_box_btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icon_box_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_box_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_btn:hover, {{WRAPPER}} .awea_icon_box_btn:focus-visible, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_btn'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_icon_box_btn:hover svg, {{WRAPPER}} .awea_icon_box_btn:focus-visible svg, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_btn:hover, {{WRAPPER}} .awea_icon_box_btn:focus-visible, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_box_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_icon_box_btn:hover, {{WRAPPER}} .awea_icon_box_btn:focus-visible, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icon_box_btn_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_icon_box_btn:hover, {{WRAPPER}} .awea_icon_box_btn:focus-visible, {{WRAPPER}} .awea_icon_box_card:hover .awea_icon_box_btn',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_icon_box_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_icon_box_title_tag'] ?? 'h3' );
		$link_mode = $settings['awea_icon_box_link_mode'] ?? 'button';

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea_icon_box_grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$card_key = 'awea_icon_box_card_' . $id;
				$link_key = 'awea_icon_box_link_' . $id;

				$this->remove_render_attribute( $card_key );
				$this->remove_render_attribute( $link_key );

				$title    = $item['awea_icon_box_title'] ?? '';
				$desc     = $item['awea_icon_box_desc'] ?? '';
				$badge    = $item['awea_icon_box_badge'] ?? '';
				$has_icon = ! empty( $item['awea_icon_box_icon']['value'] );

				$url_data = ! empty( $item['awea_icon_box_btn_link']['url'] ) ? $item['awea_icon_box_btn_link'] : [ 'url' => '#' ];
				$has_url  = ! empty( $item['awea_icon_box_btn_link']['url'] );

				$btn_show    = 'yes' === ( $item['awea_icon_box_btn_show'] ?? 'no' );
				$btn_text    = $item['awea_icon_box_btn_text'] ?? '';
				$btn_pos     = $item['awea_icon_box_btn_icon_pos'] ?? 'right';
				$has_btn_ico = ! empty( $item['awea_icon_box_btn_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$card_classes = [
					'awea_icon_box_card',
					'elementor-repeater-item-' . $id,
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea_icon_box_card_clickable';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_link_attributes( $link_key, $url_data );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea_icon_box_cover_link" aria-label="<?php echo esc_attr( $title ); ?>"></a>
					<?php endif; ?>

					<?php if ( ! empty( $badge ) ) : ?>
						<span class="awea_icon_box_badge"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>

					<?php if ( $has_icon ) : ?>
						<div class="awea_icon_box_icon" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_icon_box_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="awea_icon_box_body">
						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_icon_box_title">
								<?php if ( $is_title_link ) : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<?php echo esc_html( $title ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $title ); ?>
								<?php endif; ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea_icon_box_desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( $btn_show && ! empty( $btn_text ) ) : ?>
							<div class="awea_icon_box_btn_wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea_icon_box_btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea_icon_box_btn">
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea_icon_box_ico awea_icon_box_ico_left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_icon_box_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea_icon_box_ico awea_icon_box_ico_right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_icon_box_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

								<?php echo $is_card_link ? '</span>' : '</a>'; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
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
		if ( ! settings.awea_icon_box_items || ! settings.awea_icon_box_items.length ) {
			return;
		}
		var titleTag = elementor.helpers.validateHTMLTag( settings.awea_icon_box_title_tag || 'h3' );
		var linkMode = settings.awea_icon_box_link_mode || 'button';
		#>
		<div class="awea_icon_box_grid">
			<# _.each( settings.awea_icon_box_items, function( item, index ) {
				var id          = item._id || index;
				var title       = item.awea_icon_box_title || '';
				var desc        = item.awea_icon_box_desc || '';
				var badge       = item.awea_icon_box_badge || '';
				var url         = ( item.awea_icon_box_btn_link && item.awea_icon_box_btn_link.url ) ? item.awea_icon_box_btn_link.url : '';
				var href        = url || '#';
				var hasUrl      = !! url;
				var btnShow     = 'yes' === item.awea_icon_box_btn_show;
				var btnText     = item.awea_icon_box_btn_text || '';
				var btnPos      = item.awea_icon_box_btn_icon_pos || 'right';
				var isCardLink  = ( 'card' === linkMode && hasUrl );
				var isTitleLink = ( 'title' === linkMode && hasUrl );
				var iconHTML    = elementor.helpers.renderIcon( view, item.awea_icon_box_icon, { 'aria-hidden': true }, 'i', 'object' );
				var btnIconHTML = elementor.helpers.renderIcon( view, item.awea_icon_box_btn_icon, { 'aria-hidden': true }, 'i', 'object' );
				var cardClass   = 'awea_icon_box_card elementor-repeater-item-' + id + ( isCardLink ? ' awea_icon_box_card_clickable' : '' );
			#>
				<article class="{{ cardClass }}">
					<# if ( isCardLink ) { #>
						<a href="{{ href }}" class="awea_icon_box_cover_link" aria-label="{{ title }}"></a>
					<# } #>

					<# if ( badge ) { #>
						<span class="awea_icon_box_badge">{{{ badge }}}</span>
					<# } #>

					<# if ( iconHTML && iconHTML.rendered ) { #>
						<div class="awea_icon_box_icon" aria-hidden="true">{{{ iconHTML.value }}}</div>
					<# } #>

					<div class="awea_icon_box_body">
						<# if ( title ) { #>
							<{{{ titleTag }}} class="awea_icon_box_title">
								<# if ( isTitleLink ) { #>
									<a href="{{ href }}">{{{ title }}}</a>
								<# } else { #>
									{{{ title }}}
								<# } #>
							</{{{ titleTag }}}>
						<# } #>

						<# if ( desc ) { #>
							<p class="awea_icon_box_desc">{{{ desc }}}</p>
						<# } #>

						<# if ( btnShow && btnText ) { #>
							<div class="awea_icon_box_btn_wrap">
								<# if ( isCardLink ) { #>
									<span class="awea_icon_box_btn">
								<# } else { #>
									<a href="{{ href }}" class="awea_icon_box_btn">
								<# } #>

									<# if ( 'left' === btnPos && btnIconHTML && btnIconHTML.rendered ) { #>
										<span class="awea_icon_box_ico awea_icon_box_ico_left" aria-hidden="true">{{{ btnIconHTML.value }}}</span>
									<# } #>

									<span>{{{ btnText }}}</span>

									<# if ( 'right' === btnPos && btnIconHTML && btnIconHTML.rendered ) { #>
										<span class="awea_icon_box_ico awea_icon_box_ico_right" aria-hidden="true">{{{ btnIconHTML.value }}}</span>
									<# } #>

								<# if ( isCardLink ) { #>
									</span>
								<# } else { #>
									</a>
								<# } #>
							</div>
						<# } #>
					</div>
				</article>
			<# } ); #>
		</div>
		<?php
	}
}