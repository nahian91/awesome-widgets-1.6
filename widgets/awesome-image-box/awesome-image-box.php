<?php
/**
 * Awesome Image Box Studio Widget (10/10 Flagship Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since 2.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;

class Widget_Awesome_Image_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-image-box';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'image box', 'grid', 'card', 'feature', 'media', 'horizontal' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS (REPEATER)
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

		// --- TAB 1: IMAGE ---
		$repeater->start_controls_tab(
			'awea_tab_image',
			[ 'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image',
			[
				'label'   => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_badge',
			[
				'label'       => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Featured', 'awesome-widgets-elementor' ),
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
				'default'     => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
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
				'default' => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: LINK & BUTTON ---
		$repeater->start_controls_tab(
			'awea_tab_button',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_btn_link',
			[
				'label'   => esc_html__( 'URL', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_btn_show',
			[
				'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_btn_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_btn_icon_pos',
			[
				'label'     => esc_html__( 'Icon Side', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_btn_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: HIGHLIGHT OVERRIDES ---
		$repeater->start_controls_tab(
			'awea_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_item_badge_bg',
			[
				'label'     => esc_html__( 'Badge Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-ib-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_border_color',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_btn_bg',
			[
				'label'     => esc_html__( 'Button Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-ib-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_items',
			[
				'label'       => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_title }}}',
				'default'     => [
					[
						'awea_badge'    => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_title'    => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
						'awea_desc'     => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
						'awea_btn_text' => esc_html__( 'Explore Studio', 'awesome-widgets-elementor' ),
					],
					[
						'awea_badge'    => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
						'awea_title'    => esc_html__( 'Fluid Interaction', 'awesome-widgets-elementor' ),
						'awea_desc'     => esc_html__( 'Tactile micro-interactions engineered with smooth spring curves that feel crisp and effortless.', 'awesome-widgets-elementor' ),
						'awea_btn_text' => esc_html__( 'View Showcase', 'awesome-widgets-elementor' ),
					],
					[
						'awea_badge'    => esc_html__( 'System', 'awesome-widgets-elementor' ),
						'awea_title'    => esc_html__( 'Modular Precision', 'awesome-widgets-elementor' ),
						'awea_desc'     => esc_html__( 'Responsive grid primitives built to stay aligned across desktop, tablet, and mobile screens.', 'awesome-widgets-elementor' ),
						'awea_btn_text' => esc_html__( 'Read Specs', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-ib-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_img_pos',
			[
				'label'        => esc_html__( 'Image Side', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'top',
				'toggle'       => false,
				'options'      => [
					'left'  => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-h-align-left' ],
					'top'   => [ 'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ), 'icon' => 'eicon-v-align-top' ],
					'right' => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-h-align-right' ],
				],
				'prefix_class' => 'awea-ib-pos-',
			]
		);

		$this->add_responsive_control(
			'awea_img_width',
			[
				'label'      => esc_html__( 'Image Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 20, 'max' => 65 ],
					'px' => [ 'min' => 80, 'max' => 450 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 42 ],
				'condition'  => [ 'awea_img_pos!' => 'top' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-media' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_img_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_img_ratio',
			[
				'label'     => esc_html__( 'Image Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/9'  => '16:9',
					'16/10' => '16:10',
					'4/3'   => '4:3',
					'1/1'   => '1:1',
					'3/4'   => '3:4',
					'auto'  => esc_html__( 'Auto', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-media' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_link_mode',
			[
				'label'   => esc_html__( 'Click Area', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'Button Only', 'awesome-widgets-elementor' ),
					'title'  => esc_html__( 'Title & Button', 'awesome-widgets-elementor' ),
					'card'   => esc_html__( 'Whole Card', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'   => esc_html__( 'Title Tag', 'awesome-widgets-elementor' ),
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
			'awea_hover_zoom',
			[
				'label'        => esc_html__( 'Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-ib-motion-',
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
				'label'     => esc_html__( 'Align', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card'     => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .awea-ib-btn-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '22', 'right' => '22', 'bottom' => '22', 'left' => '22', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-ib-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-ib-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
				],
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
					'{{WRAPPER}} .awea-ib-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_img_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_img_space',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_badge_pos',
			[
				'label'                => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'top-left',
				'options'              => [
					'top-left'     => esc_html__( 'Top Left', 'awesome-widgets-elementor' ),
					'top-right'    => esc_html__( 'Top Right', 'awesome-widgets-elementor' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'awesome-widgets-elementor' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'awesome-widgets-elementor' ),
				],
				'selectors_dictionary' => [
					'top-left'     => 'top: 12px; left: 12px; right: auto; bottom: auto;',
					'top-right'    => 'top: 12px; right: 12px; left: auto; bottom: auto;',
					'bottom-left'  => 'bottom: 12px; left: 12px; top: auto; right: auto;',
					'bottom-right' => 'bottom: 12px; right: 12px; top: auto; left: auto;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-ib-badge' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'awea_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_badge_typo',
				'selector' => '{{WRAPPER}} .awea-ib-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [ 'top' => '5', 'right' => '12', 'bottom' => '5', 'left' => '12', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
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
				'selector' => '{{WRAPPER}} .awea-ib-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_title_tabs' );

		$this->start_controls_tab(
			'awea_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-title, {{WRAPPER}} .awea-ib-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-card:hover .awea-ib-title, {{WRAPPER}} .awea-ib-card:hover .awea-ib-title a' => 'color: {{VALUE}};',
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
			'awea_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-ib-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_desc_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-ib-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [ 'top' => '11', 'right' => '20', 'bottom' => '11', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ib-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn_tabs' );

		$this->start_controls_tab(
			'awea_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn_border',
				'selector' => '{{WRAPPER}} .awea-ib-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ib-btn:hover, {{WRAPPER}} .awea-ib-card:hover .awea-ib-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
		$link_mode = $settings['awea_link_mode'] ?? 'button';

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-ib-grid">
			<?php foreach ( $items as $index => $item ) :
				$id          = $item['_id'] ?? $index;
				$card_key    = 'card_' . $id;
				$link_key    = 'link_' . $id;

				$title       = $item['awea_title'] ?? '';
				$desc        = $item['awea_desc'] ?? '';
				$badge       = $item['awea_badge'] ?? '';

				$url_data    = $item['awea_btn_link'] ?? [];
				$has_url     = ! empty( $url_data['url'] );

				$btn_show    = 'yes' === ( $item['awea_btn_show'] ?? 'no' );
				$btn_text    = $item['awea_btn_text'] ?? '';
				$btn_pos     = $item['awea_btn_icon_pos'] ?? 'right';
				$has_icon    = ! empty( $item['awea_btn_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$img_data = [
					'awea_image'                     => $item['awea_image'] ?? [],
					'awea_img_size_size'             => $settings['awea_img_size_size'] ?? 'large',
					'awea_img_size_custom_dimension' => $settings['awea_img_size_custom_dimension'] ?? [],
				];

				$card_classes = [
					'awea-ib-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea-ib-card-clickable';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );

				if ( $has_url ) {
					$this->add_link_attributes( $link_key, $url_data );
				}
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-ib-cover-link" aria-label="<?php echo esc_attr( $title ); ?>"></a>
					<?php endif; ?>

					<div class="awea-ib-media">
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_img_size', 'awea_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-ib-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea-ib-body">
						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-ib-title">
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
							<p class="awea-ib-desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( $btn_show && ! empty( $btn_text ) ) : ?>
							<div class="awea-ib-btn-wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea-ib-btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-ib-btn">
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_icon ) : ?>
										<span class="awea-ib-ico awea-ib-ico-left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_icon ) : ?>
										<span class="awea-ib-ico awea-ib-ico-right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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
}