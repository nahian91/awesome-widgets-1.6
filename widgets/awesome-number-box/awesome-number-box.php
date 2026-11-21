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
			'awea_number_box_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_number_box_item_tabs' );

		// --- TAB 1: NUMBER ---
		$repeater->start_controls_tab(
			'awea_number_box_tab_number',
			[ 'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_number_box_number',
			[
				'label'       => esc_html__( 'Number / Step', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_number_box_tag',
			[
				'label'       => esc_html__( 'Eyebrow Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Phase 1', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_number_box_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_number_box_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_number_box_desc',
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
			'awea_number_box_tab_link',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_number_box_link_show',
			[
				'label'        => esc_html__( 'Display Link', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_number_box_link_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_number_box_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_number_box_link_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'awea_number_box_link_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_number_box_link_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_number_box_link_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_number_box_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_number_box_item_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_number_box_badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_number_box_watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_number_box_item_num_bg',
			[
				'label'     => esc_html__( 'Badge Background / Outline', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea_number_box_mode_badge {{CURRENT_ITEM}} .awea_number_box_badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea_number_box_mode_split {{CURRENT_ITEM}} .awea_number_box_badge'    => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea_number_box_mode_outlined {{CURRENT_ITEM}} .awea_number_box_badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_number_box_item_border',
			[
				'label'     => esc_html__( 'Card Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_number_box_items',
			[
				'label'       => esc_html__( 'Steps List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_number_box_number }}} — {{{ awea_number_box_title }}}',
				'default'     => [
					[
						'awea_number_box_number'    => '01',
						'awea_number_box_tag'       => esc_html__( 'Step One', 'awesome-widgets-elementor' ),
						'awea_number_box_title'     => esc_html__( 'Discovery & Strategy', 'awesome-widgets-elementor' ),
						'awea_number_box_desc'      => esc_html__( 'Comprehensive discovery sessions to align goals, user flows, and core system requirements.', 'awesome-widgets-elementor' ),
						'awea_number_box_link_text' => esc_html__( 'Explore Phase', 'awesome-widgets-elementor' ),
					],
					[
						'awea_number_box_number'    => '02',
						'awea_number_box_tag'       => esc_html__( 'Step Two', 'awesome-widgets-elementor' ),
						'awea_number_box_title'     => esc_html__( 'Architecture & Build', 'awesome-widgets-elementor' ),
						'awea_number_box_desc'      => esc_html__( 'Modular design systems engineered for speed, accessibility, and effortless scalability.', 'awesome-widgets-elementor' ),
						'awea_number_box_link_text' => esc_html__( 'View Process', 'awesome-widgets-elementor' ),
					],
					[
						'awea_number_box_number'    => '03',
						'awea_number_box_tag'       => esc_html__( 'Step Three', 'awesome-widgets-elementor' ),
						'awea_number_box_title'     => esc_html__( 'Launch & Scale', 'awesome-widgets-elementor' ),
						'awea_number_box_desc'      => esc_html__( 'Seamless deployment with automated quality checks and real-time performance telemetry.', 'awesome-widgets-elementor' ),
						'awea_number_box_link_text' => esc_html__( 'See Results', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_number_box_section_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_number_box_columns',
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
					'{{WRAPPER}} .awea_number_box_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_gap',
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
					'{{WRAPPER}} .awea_number_box_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_number_box_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_number_box_num_style',
			[
				'label'        => esc_html__( 'Number Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'badge',
				'options'      => [
					'badge'     => esc_html__( 'Solid Badge', 'awesome-widgets-elementor' ),
					'outlined'  => esc_html__( 'Outlined Badge', 'awesome-widgets-elementor' ),
					'watermark' => esc_html__( 'Ghost Watermark', 'awesome-widgets-elementor' ),
					'split'     => esc_html__( 'Split Side Badge', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_number_box_mode_',
			]
		);

		$this->add_control(
			'awea_number_box_auto_index',
			[
				'label'        => esc_html__( 'Auto Numbering (01, 02...)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_number_box_hover_lift',
			[
				'label'        => esc_html__( 'Hover Card Lift', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_number_box_motion_',
			]
		);

		$this->add_control(
			'awea_number_box_title_tag',
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
			'awea_number_box_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_number_box_align',
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
				'condition'            => [ 'awea_number_box_num_style!' => 'split' ],
				'selectors_dictionary' => [
					'left'   => 'start; align-items: flex-start; --awea_number_box_wm_start: auto; --awea_number_box_wm_end: 16px; --awea_number_box_btn_align: flex-start',
					'center' => 'center; align-items: center; --awea_number_box_wm_start: auto; --awea_number_box_wm_end: 16px; --awea_number_box_btn_align: center',
					'right'  => 'end; align-items: flex-end; --awea_number_box_wm_start: 16px; --awea_number_box_wm_end: auto; --awea_number_box_btn_align: flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_number_box_card' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_card_padding',
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
					'{{WRAPPER}} .awea_number_box_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_card_radius',
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
					'{{WRAPPER}} .awea_number_box_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_number_box_card_tabs' );

		$this->start_controls_tab(
			'awea_number_box_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_number_box_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_number_box_card_border',
				'selector'       => '{{WRAPPER}} .awea_number_box_card',
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
				'name'     => 'awea_number_box_card_shadow',
				'selector' => '{{WRAPPER}} .awea_number_box_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_number_box_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_number_box_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_number_box_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_number_box_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. NUMBER BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_number_box_style_badge',
			[
				'label'     => esc_html__( 'Number Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_number_box_num_style!' => 'watermark' ],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_badge_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 54 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_badge_gap',
			[
				'label'      => esc_html__( 'Spacing to Content', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_badge_radius',
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
					'{{WRAPPER}} .awea_number_box_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_box_badge_typo',
				'selector' => '{{WRAPPER}} .awea_number_box_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->start_controls_tabs( 'awea_number_box_badge_tabs' );

		$this->start_controls_tab(
			'awea_number_box_badge_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_number_box_badge_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_number_box_num_style!' => 'outlined' ],
				'selectors' => [
					'{{WRAPPER}}.awea_number_box_mode_badge .awea_number_box_badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.awea_number_box_mode_split .awea_number_box_badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_badge_outline_color',
			[
				'label'     => esc_html__( 'Outline Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_number_box_num_style' => 'outlined' ],
				'selectors' => [
					'{{WRAPPER}}.awea_number_box_mode_outlined .awea_number_box_badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_number_box_badge_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_number_box_badge_color_hover',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card:hover .awea_number_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_badge_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card:hover .awea_number_box_badge' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
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
			'awea_number_box_style_watermark',
			[
				'label'     => esc_html__( 'Watermark Number', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_number_box_num_style' => 'watermark' ],
			]
		);

		$this->add_control(
			'awea_number_box_wm_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_wm_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.02, 'max' => 0.35, 'step' => 0.01 ],
				],
				'default'   => [ 'size' => 0.08 ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_watermark' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_wm_size',
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
					'{{WRAPPER}} .awea_number_box_watermark' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TAG, TITLE & DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_number_box_style_tag',
			[
				'label' => esc_html__( 'Eyebrow Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_box_tag_typo',
				'selector' => '{{WRAPPER}} .awea_number_box_tag',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_number_box_tag_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_tag_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_number_box_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_box_title_typo',
				'selector' => '{{WRAPPER}} .awea_number_box_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_number_box_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_card:hover .awea_number_box_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_number_box_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_box_desc_typo',
				'selector' => '{{WRAPPER}} .awea_number_box_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_number_box_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. LINK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_number_box_style_link',
			[
				'label' => esc_html__( 'Action Link', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_box_link_typo',
				'selector' => '{{WRAPPER}} .awea_number_box_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_number_box_link_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_number_box_btn_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_number_box_btn_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_number_box_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_box_link_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_number_box_btn:hover, {{WRAPPER}} .awea_number_box_btn:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_number_box_btn:hover svg, {{WRAPPER}} .awea_number_box_btn:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$items      = $settings['awea_number_box_items'] ?? [];
		$num_style  = $settings['awea_number_box_num_style'] ?? 'badge';
		$auto_index = 'yes' === ( $settings['awea_number_box_auto_index'] ?? '' );
		$title_tag  = Utils::validate_html_tag( $settings['awea_number_box_title_tag'] ?? 'h3' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea_number_box_grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$link_key = 'awea_number_box_link_' . $id;

				$number   = $auto_index ? str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) : ( $item['awea_number_box_number'] ?? '01' );
				$tag      = $item['awea_number_box_tag'] ?? '';
				$title    = $item['awea_number_box_title'] ?? '';
				$desc     = $item['awea_number_box_desc'] ?? '';

				$show_btn = 'yes' === ( $item['awea_number_box_link_show'] ?? 'no' );
				$btn_text = $item['awea_number_box_link_text'] ?? '';
				$has_btn  = $show_btn && ! empty( $btn_text );
				$has_ico  = ! empty( $item['awea_number_box_link_icon']['value'] );

				$this->remove_render_attribute( $link_key );
				if ( $has_btn ) {
					$btn_url = ! empty( $item['awea_number_box_link_url']['url'] ) ? $item['awea_number_box_link_url'] : [ 'url' => '#' ];
					$this->add_link_attributes( $link_key, $btn_url );
					$this->add_render_attribute( $link_key, 'class', 'awea_number_box_btn' );
				}
				?>
				<article class="awea_number_box_card elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

					<?php if ( 'watermark' === $num_style && ! empty( $number ) ) : ?>
						<div class="awea_number_box_watermark" aria-hidden="true"><?php echo esc_html( $number ); ?></div>
					<?php endif; ?>

					<?php if ( 'watermark' !== $num_style && ! empty( $number ) ) : ?>
						<div class="awea_number_box_badge_wrap">
							<span class="awea_number_box_badge"><?php echo esc_html( $number ); ?></span>
						</div>
					<?php endif; ?>

					<div class="awea_number_box_body">
						<?php if ( ! empty( $tag ) ) : ?>
							<span class="awea_number_box_tag"><?php echo esc_html( $tag ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_number_box_title">
								<?php echo esc_html( $title ); ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea_number_box_desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( $has_btn ) : ?>
							<div class="awea_number_box_btn_wrap">
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<span><?php echo esc_html( $btn_text ); ?></span>
									<?php if ( $has_ico ) : ?>
										<span class="awea_number_box_btn_ico" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_number_box_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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
		if ( ! settings.awea_number_box_items || ! settings.awea_number_box_items.length ) {
			return;
		}
		var numStyle  = settings.awea_number_box_num_style || 'badge';
		var autoIndex = 'yes' === settings.awea_number_box_auto_index;
		var titleTag  = elementor.helpers.validateHTMLTag( settings.awea_number_box_title_tag || 'h3' );
		#>
		<div class="awea_number_box_grid">
			<# _.each( settings.awea_number_box_items, function( item, index ) {
				var id       = item._id || index;
				var autoNum  = ( index + 1 < 10 ? '0' : '' ) + ( index + 1 );
				var number   = autoIndex ? autoNum : ( item.awea_number_box_number || '01' );
				var tag      = item.awea_number_box_tag || '';
				var title    = item.awea_number_box_title || '';
				var desc     = item.awea_number_box_desc || '';
				var showBtn  = 'yes' === item.awea_number_box_link_show;
				var btnText  = item.awea_number_box_link_text || '';
				var hasBtn   = showBtn && !! btnText;
				var btnUrl   = ( item.awea_number_box_link_url && item.awea_number_box_link_url.url ) ? item.awea_number_box_link_url.url : '#';
				var iconHTML = elementor.helpers.renderIcon( view, item.awea_number_box_link_icon, { 'aria-hidden': true }, 'i', 'object' );
			#>
				<article class="awea_number_box_card elementor-repeater-item-{{ id }}">
					<# if ( 'watermark' === numStyle && number ) { #>
						<div class="awea_number_box_watermark" aria-hidden="true">{{{ number }}}</div>
					<# } #>

					<# if ( 'watermark' !== numStyle && number ) { #>
						<div class="awea_number_box_badge_wrap">
							<span class="awea_number_box_badge">{{{ number }}}</span>
						</div>
					<# } #>

					<div class="awea_number_box_body">
						<# if ( tag ) { #>
							<span class="awea_number_box_tag">{{{ tag }}}</span>
						<# } #>

						<# if ( title ) { #>
							<{{{ titleTag }}} class="awea_number_box_title">{{{ title }}}</{{{ titleTag }}}>
						<# } #>

						<# if ( desc ) { #>
							<p class="awea_number_box_desc">{{{ desc }}}</p>
						<# } #>

						<# if ( hasBtn ) { #>
							<div class="awea_number_box_btn_wrap">
								<a href="{{ btnUrl }}" class="awea_number_box_btn">
									<span>{{{ btnText }}}</span>
									<# if ( iconHTML && iconHTML.rendered ) { #>
										<span class="awea_number_box_btn_ico" aria-hidden="true">{{{ iconHTML.value }}}</span>
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