<?php
/**
 * Awesome Number Box Widget.
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

class Widget_Awesome_Number_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-number-box';
	}

	public function get_title() {
		return esc_html__( 'Number Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'number', 'box', 'grid', 'step', 'process', 'milestone', 'counter' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_item_tabs' );

		// --- TAB 1: NUMBER ---
		$repeater->start_controls_tab(
			'awea_tab_number',
			[ 'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_number',
			[
				'label'       => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tag',
			[
				'label'       => esc_html__( 'Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Phase 1', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Comprehensive discovery sessions to align goals, user flows, and core system requirements.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: LINK ---
		$repeater->start_controls_tab(
			'awea_tab_link',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_link_show',
			[
				'label'        => esc_html__( 'Display', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_link_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_link_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'awea_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_link_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_link_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_item_num_color',
			[
				'label'     => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-nb-badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-nb-watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_num_bg',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-nb-mode-badge {{CURRENT_ITEM}} .awea-nb-badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-split {{CURRENT_ITEM}} .awea-nb-badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-outlined {{CURRENT_ITEM}} .awea-nb-badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_border',
			[
				'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_items',
			[
				'label'       => esc_html__( 'List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_number }}} — {{{ awea_title }}}',
				'default'     => [
					[
						'awea_number'    => '01',
						'awea_tag'       => esc_html__( 'Step One', 'awesome-widgets-elementor' ),
						'awea_title'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
						'awea_desc'      => esc_html__( 'Comprehensive discovery sessions to align goals, user flows, and core system requirements.', 'awesome-widgets-elementor' ),
						'awea_link_text' => esc_html__( 'Explore Phase', 'awesome-widgets-elementor' ),
					],
					[
						'awea_number'    => '02',
						'awea_tag'       => esc_html__( 'Step Two', 'awesome-widgets-elementor' ),
						'awea_title'     => esc_html__( 'Architecture & Build', 'awesome-widgets-elementor' ),
						'awea_desc'      => esc_html__( 'Modular design systems engineered for speed, accessibility, and effortless scalability.', 'awesome-widgets-elementor' ),
						'awea_link_text' => esc_html__( 'View Process', 'awesome-widgets-elementor' ),
					],
					[
						'awea_number'    => '03',
						'awea_tag'       => esc_html__( 'Step Three', 'awesome-widgets-elementor' ),
						'awea_title'     => esc_html__( 'Launch & Scale', 'awesome-widgets-elementor' ),
						'awea_desc'      => esc_html__( 'Seamless deployment with automated quality checks and real-time performance telemetry.', 'awesome-widgets-elementor' ),
						'awea_link_text' => esc_html__( 'See Results', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_grid',
			[
				'label' => esc_html__( 'Grid', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_columns',
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
					'{{WRAPPER}} .awea-nb-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_num_style',
			[
				'label'        => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'badge',
				'options'      => [
					'badge'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
					'outlined'  => esc_html__( 'Outlined', 'awesome-widgets-elementor' ),
					'watermark' => esc_html__( 'Watermark', 'awesome-widgets-elementor' ),
					'split'     => esc_html__( 'Split', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nb-mode-',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'   => esc_html__( 'Tag', 'awesome-widgets-elementor' ),
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

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_align',
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
				'condition'            => [ 'awea_num_style!' => 'split' ],
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start; --awea-nb-wm-left: auto; --awea-nb-wm-right: 16px; --awea-nb-btn-align: flex-start;',
					'center' => 'text-align: center; align-items: center; --awea-nb-wm-left: auto; --awea-nb-wm-right: 16px; --awea-nb-btn-align: center;',
					'right'  => 'text-align: right; align-items: flex-end; --awea-nb-wm-left: 16px; --awea-nb-wm-right: auto; --awea-nb-btn-align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-nb-card' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
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
					'{{WRAPPER}} .awea-nb-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-nb-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_tabs' );

		$this->start_controls_tab(
			'awea_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea-nb-card',
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
				'name'     => 'awea_card_shadow',
				'label'    => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'label'    => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. NUMBER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_badge',
			[
				'label'     => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_num_style!' => 'watermark' ],
			]
		);

		$this->add_responsive_control(
			'awea_badge_size',
			[
				'label'      => esc_html__( 'Box', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 54 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-nb-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_badge_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->start_controls_tabs( 'awea_badge_tabs' );

		$this->start_controls_tab(
			'awea_badge_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_num_style!' => 'outlined' ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-mode-badge .awea-nb-badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-nb-mode-split .awea-nb-badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_outline_color',
			[
				'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_num_style' => 'outlined' ],
				'selectors' => [
					'{{WRAPPER}}.awea-nb-mode-outlined .awea-nb-badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_badge_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_badge_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover .awea-nb-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover .awea-nb-badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. WATERMARK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_watermark',
			[
				'label'     => esc_html__( 'Watermark', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_num_style' => 'watermark' ],
			]
		);

		$this->add_control(
			'awea_wm_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_wm_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.02, 'max' => 0.35, 'step' => 0.01 ],
				],
				'default'   => [ 'size' => 0.08 ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-watermark' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_wm_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 60, 'max' => 220 ],
					'rem' => [ 'min' => 3, 'max' => 14 ],
				],
				'default'    => [ 'unit' => 'rem', 'size' => 7.5 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-watermark' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_tag',
			[
				'label' => esc_html__( 'Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tag_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-tag',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_tag_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_title_hover',
			[
				'label'     => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-card:hover .awea-nb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_space',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_space',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. LINK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_link',
			[
				'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_link_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-nb-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_link_icon_size',
			[
				'label'      => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nb-btn-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-nb-btn-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nb-btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-nb-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_link_hover',
			[
				'label'     => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-nb-btn:hover, {{WRAPPER}} .awea-nb-btn:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-nb-btn:hover svg, {{WRAPPER}} .awea-nb-btn:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_items'] ?? [];
		$num_style = $settings['awea_num_style'] ?? 'badge';
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-nb-grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$link_key = 'link_' . $id;

				$number   = $item['awea_number'] ?? '01';
				$tag      = $item['awea_tag'] ?? '';
				$title    = $item['awea_title'] ?? '';
				$desc     = $item['awea_desc'] ?? '';

				$show_btn = 'yes' === ( $item['awea_link_show'] ?? 'no' );
				$btn_text = $item['awea_link_text'] ?? '';
				$has_btn  = $show_btn && ! empty( $btn_text );
				$has_ico  = ! empty( $item['awea_link_icon']['value'] );

				$this->remove_render_attribute( $link_key );
				if ( $has_btn ) {
					$btn_url = ! empty( $item['awea_link_url']['url'] ) ? $item['awea_link_url'] : [ 'url' => '#' ];
					$this->add_link_attributes( $link_key, $btn_url );
					$this->add_render_attribute( $link_key, 'class', 'awea-nb-btn' );
				}
				?>
				<article class="awea-nb-card elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

					<?php if ( 'watermark' === $num_style && ! empty( $number ) ) : ?>
						<div class="awea-nb-watermark" aria-hidden="true"><?php echo esc_html( $number ); ?></div>
					<?php endif; ?>

					<?php if ( 'watermark' !== $num_style && ! empty( $number ) ) : ?>
						<div class="awea-nb-badge-wrap">
							<span class="awea-nb-badge"><?php echo esc_html( $number ); ?></span>
						</div>
					<?php endif; ?>

					<div class="awea-nb-body">
						<?php if ( ! empty( $tag ) ) : ?>
							<span class="awea-nb-tag"><?php echo esc_html( $tag ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-nb-title">
								<?php echo esc_html( $title ); ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea-nb-desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( $has_btn ) : ?>
							<div class="awea-nb-btn-wrap">
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<span><?php echo esc_html( $btn_text ); ?></span>
									<?php if ( $has_ico ) : ?>
										<span class="awea-nb-btn-ico" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
								</a>
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
		if ( ! settings.awea_items || ! settings.awea_items.length ) {
			return;
		}
		var numStyle = settings.awea_num_style || 'badge';
		var titleTag = elementor.helpers.validateHTMLTag( settings.awea_title_tag || 'h3' );
		#>
		<div class="awea-nb-grid">
			<# _.each( settings.awea_items, function( item, index ) {
				var id       = item._id || index;
				var number   = item.awea_number || '01';
				var tag      = item.awea_tag || '';
				var title    = item.awea_title || '';
				var desc     = item.awea_desc || '';
				var showBtn  = 'yes' === item.awea_link_show;
				var btnText  = item.awea_link_text || '';
				var hasBtn   = showBtn && !! btnText;
				var btnUrl   = ( item.awea_link_url && item.awea_link_url.url ) ? item.awea_link_url.url : '#';
				var iconHTML = elementor.helpers.renderIcon( view, item.awea_link_icon, { 'aria-hidden': true }, 'i', 'object' );
			#>
				<article class="awea-nb-card elementor-repeater-item-{{ id }}">
					<# if ( 'watermark' === numStyle && number ) { #>
						<div class="awea-nb-watermark" aria-hidden="true">{{{ number }}}</div>
					<# } #>

					<# if ( 'watermark' !== numStyle && number ) { #>
						<div class="awea-nb-badge-wrap">
							<span class="awea-nb-badge">{{{ number }}}</span>
						</div>
					<# } #>

					<div class="awea-nb-body">
						<# if ( tag ) { #>
							<span class="awea-nb-tag">{{{ tag }}}</span>
						<# } #>

						<# if ( title ) { #>
							<{{{ titleTag }}} class="awea-nb-title">{{{ title }}}</{{{ titleTag }}}>
						<# } #>

						<# if ( desc ) { #>
							<p class="awea-nb-desc">{{{ desc }}}</p>
						<# } #>

						<# if ( hasBtn ) { #>
							<div class="awea-nb-btn-wrap">
								<a href="{{ btnUrl }}" class="awea-nb-btn">
									<span>{{{ btnText }}}</span>
									<# if ( iconHTML && iconHTML.rendered ) { #>
										<span class="awea-nb-btn-ico" aria-hidden="true">{{{ iconHTML.value }}}</span>
									<# } #>
								</a>
							</div>
						<# } #>
					</div>
				</article>
			<# } ); #>
		</div>
		<?php
	}
}