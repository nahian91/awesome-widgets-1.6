<?php
/**
 * Awesome Image Box Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

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
			'awea_image_box_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_image_box_item_tabs' );

		// --- TAB 1: IMAGE ---
		$repeater->start_controls_tab(
			'awea_image_box_tab_image',
			[ 'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image_box_image',
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
			'awea_image_box_badge',
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
			'awea_image_box_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image_box_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_image_box_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: LINK ---
		$repeater->start_controls_tab(
			'awea_image_box_tab_button',
			[ 'label' => esc_html__( 'Link & Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image_box_btn_link',
			[
				'label'   => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_image_box_btn_show',
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
			'awea_image_box_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_image_box_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_image_box_btn_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_image_box_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_image_box_btn_icon_pos',
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
					'awea_image_box_btn_show'        => 'yes',
					'awea_image_box_btn_icon[value]!' => '',
				],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_image_box_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_image_box_item_badge_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_image_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_image_box_item_badge_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_image_box_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_image_box_item_border_color',
			[
				'label'     => esc_html__( 'Card Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_image_box_item_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_image_box_btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}'                      => '--awea_image_box_item_btn_bg: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_image_box_items',
			[
				'label'       => esc_html__( 'Cards List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_image_box_title }}}',
				'default'     => [
					[
						'awea_image_box_badge'    => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_image_box_title'    => esc_html__( 'Lumina Spatial Systems', 'awesome-widgets-elementor' ),
						'awea_image_box_desc'     => esc_html__( 'Clean architectural layout crafted for clarity, speed, and harmonic visual balance.', 'awesome-widgets-elementor' ),
						'awea_image_box_btn_text' => esc_html__( 'Explore Studio', 'awesome-widgets-elementor' ),
					],
					[
						'awea_image_box_badge'    => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
						'awea_image_box_title'    => esc_html__( 'Fluid Interaction', 'awesome-widgets-elementor' ),
						'awea_image_box_desc'     => esc_html__( 'Tactile micro-interactions engineered with smooth spring curves that feel crisp and effortless.', 'awesome-widgets-elementor' ),
						'awea_image_box_btn_text' => esc_html__( 'View Showcase', 'awesome-widgets-elementor' ),
					],
					[
						'awea_image_box_badge'    => esc_html__( 'System', 'awesome-widgets-elementor' ),
						'awea_image_box_title'    => esc_html__( 'Modular Precision', 'awesome-widgets-elementor' ),
						'awea_image_box_desc'     => esc_html__( 'Responsive grid primitives built to stay aligned across desktop, tablet, and mobile screens.', 'awesome-widgets-elementor' ),
						'awea_image_box_btn_text' => esc_html__( 'Read Specs', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_section_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_image_box_columns',
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
					'{{WRAPPER}} .awea_image_box_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_gap',
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
					'{{WRAPPER}} .awea_image_box_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_section_image_layout',
			[
				'label' => esc_html__( 'Image Setup', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_image_box_img_pos',
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
				'prefix_class' => 'awea_image_box_pos_',
			]
		);

		$this->add_responsive_control(
			'awea_image_box_img_width',
			[
				'label'      => esc_html__( 'Media Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 20, 'max' => 65 ],
					'px' => [ 'min' => 80, 'max' => 450 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 42 ],
				'condition'  => [ 'awea_image_box_img_pos!' => 'top' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_grid' => '--awea_image_box_media_w: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_image_box_img_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_image_box_img_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/9'  => '16:9 (Wide)',
					'16/10' => '16:10 (Editorial)',
					'4/3'   => '4:3 (Classic)',
					'1/1'   => '1:1 (Square)',
					'3/4'   => '3:4 (Portrait)',
					'auto'  => esc_html__( 'Auto (Original)', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_media' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_image_box_link_mode',
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
			'awea_image_box_title_tag',
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
			'awea_image_box_hover_zoom',
			[
				'label'        => esc_html__( 'Hover Lift & Zoom', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_image_box_motion_',
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
			'awea_image_box_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_box_align',
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
					'{{WRAPPER}} .awea_image_box_body'     => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .awea_image_box_btn_wrap' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '22',
					'right'    => '22',
					'bottom'   => '22',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_card_radius',
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
					'{{WRAPPER}} .awea_image_box_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_image_box_card_tabs' );

		$this->start_controls_tab(
			'awea_image_box_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_image_box_card_border',
				'selector'       => '{{WRAPPER}} .awea_image_box_card',
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
				'name'     => 'awea_image_box_card_shadow',
				'selector' => '{{WRAPPER}} .awea_image_box_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_image_box_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_image_box_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_image_box_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_box_img_radius',
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
					'{{WRAPPER}} .awea_image_box_media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_img_space',
			[
				'label'      => esc_html__( 'Spacing to Content', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_image_box_img_border',
				'selector' => '{{WRAPPER}} .awea_image_box_media',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_image_box_img_shadow',
				'selector' => '{{WRAPPER}} .awea_image_box_media',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_style_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_image_box_badge_pos',
			[
				'label'                => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'top-left',
				'options'              => [
					'top-left'     => esc_html__( 'Top Start', 'awesome-widgets-elementor' ),
					'top-right'    => esc_html__( 'Top End', 'awesome-widgets-elementor' ),
					'bottom-left'  => esc_html__( 'Bottom Start', 'awesome-widgets-elementor' ),
					'bottom-right' => esc_html__( 'Bottom End', 'awesome-widgets-elementor' ),
				],
				'selectors_dictionary' => [
					'top-left'     => 'top: 12px; inset-inline-start: 12px; inset-inline-end: auto; bottom: auto',
					'top-right'    => 'top: 12px; inset-inline-end: 12px; inset-inline-start: auto; bottom: auto',
					'bottom-left'  => 'bottom: 12px; inset-inline-start: 12px; top: auto; inset-inline-end: auto',
					'bottom-right' => 'bottom: 12px; inset-inline-end: 12px; top: auto; inset-inline-start: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_image_box_badge' => '{{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_image_box_badge_typo',
				'selector' => '{{WRAPPER}} .awea_image_box_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_image_box_badge_border',
				'selector'       => '{{WRAPPER}} .awea_image_box_badge',
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
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.16)' ],
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '5',
					'right'    => '12',
					'bottom'   => '5',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_badge_radius',
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
					'{{WRAPPER}} .awea_image_box_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_image_box_title_typo',
				'selector' => '{{WRAPPER}} .awea_image_box_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_image_box_title_tabs' );

		$this->start_controls_tab(
			'awea_image_box_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_title, {{WRAPPER}} .awea_image_box_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_image_box_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_title_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_card:hover .awea_image_box_title, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_title a' => 'color: {{VALUE}};',
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
			'awea_image_box_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_image_box_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_image_box_desc_typo',
				'selector' => '{{WRAPPER}} .awea_image_box_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_image_box_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_image_box_btn_typo',
				'selector' => '{{WRAPPER}} .awea_image_box_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_image_box_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_image_box_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_btn_padding',
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
					'{{WRAPPER}} .awea_image_box_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_box_btn_radius',
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
					'{{WRAPPER}} .awea_image_box_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_image_box_btn_tabs' );

		$this->start_controls_tab(
			'awea_image_box_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_image_box_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_btn'  => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .awea_image_box_grid' => '--awea_image_box_btn_bg: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_image_box_btn_border',
				'selector'       => '{{WRAPPER}} .awea_image_box_btn',
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
				'name'     => 'awea_image_box_btn_shadow',
				'selector' => '{{WRAPPER}} .awea_image_box_btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_image_box_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_image_box_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_btn:hover, {{WRAPPER}} .awea_image_box_btn:focus-visible, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_btn'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_image_box_btn:hover svg, {{WRAPPER}} .awea_image_box_btn:focus-visible svg, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_btn:hover, {{WRAPPER}} .awea_image_box_btn:focus-visible, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_image_box_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_image_box_btn:hover, {{WRAPPER}} .awea_image_box_btn:focus-visible, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_image_box_btn_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_image_box_btn:hover, {{WRAPPER}} .awea_image_box_btn:focus-visible, {{WRAPPER}} .awea_image_box_card:hover .awea_image_box_btn',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_image_box_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_image_box_title_tag'] ?? 'h3' );
		$link_mode = $settings['awea_image_box_link_mode'] ?? 'button';

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea_image_box_grid">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$card_key = 'awea_image_box_card_' . $id;
				$link_key = 'awea_image_box_link_' . $id;

				$this->remove_render_attribute( $card_key );
				$this->remove_render_attribute( $link_key );

				$title = $item['awea_image_box_title'] ?? '';
				$desc  = $item['awea_image_box_desc'] ?? '';
				$badge = $item['awea_image_box_badge'] ?? '';

				$url_data = ! empty( $item['awea_image_box_btn_link']['url'] ) ? $item['awea_image_box_btn_link'] : [ 'url' => '#' ];
				$has_url  = ! empty( $item['awea_image_box_btn_link']['url'] );

				$btn_show = 'yes' === ( $item['awea_image_box_btn_show'] ?? 'no' );
				$btn_text = $item['awea_image_box_btn_text'] ?? '';
				$btn_pos  = $item['awea_image_box_btn_icon_pos'] ?? 'right';
				$has_icon = ! empty( $item['awea_image_box_btn_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$img_item = $item['awea_image_box_image'] ?? [];
				$img_url  = ! empty( $img_item['url'] ) ? $img_item['url'] : Utils::get_placeholder_image_src();

				$img_data = [
					'awea_image_box_image'                     => $img_item,
					'awea_image_box_img_size_size'             => $settings['awea_image_box_img_size_size'] ?? 'large',
					'awea_image_box_img_size_custom_dimension' => $settings['awea_image_box_img_size_custom_dimension'] ?? [],
				];

				$img_html = ! empty( $img_item['id'] )
					? Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_image_box_img_size', 'awea_image_box_image' )
					: sprintf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img_url ), esc_attr( $title ) );

				$card_classes = [
					'awea_image_box_card',
					'elementor-repeater-item-' . $id,
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea_image_box_card_clickable';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_link_attributes( $link_key, $url_data );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea_image_box_cover_link" aria-label="<?php echo esc_attr( $title ); ?>"></a>
					<?php endif; ?>

					<div class="awea_image_box_media">
						<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea_image_box_badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea_image_box_body">
						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_image_box_title">
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
							<p class="awea_image_box_desc"><?php echo wp_kses_post( $desc ); ?></p>
						<?php endif; ?>

						<?php if ( $btn_show && ! empty( $btn_text ) ) : ?>
							<div class="awea_image_box_btn_wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea_image_box_btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea_image_box_btn">
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_icon ) : ?>
										<span class="awea_image_box_ico awea_image_box_ico_left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_image_box_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_icon ) : ?>
										<span class="awea_image_box_ico awea_image_box_ico_right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_image_box_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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
		if ( ! settings.awea_image_box_items || ! settings.awea_image_box_items.length ) {
			return;
		}
		var titleTag = elementor.helpers.validateHTMLTag( settings.awea_image_box_title_tag || 'h3' );
		var linkMode = settings.awea_image_box_link_mode || 'button';
		#>
		<div class="awea_image_box_grid">
			<# _.each( settings.awea_image_box_items, function( item, index ) {
				var id          = item._id || index;
				var title       = item.awea_image_box_title || '';
				var desc        = item.awea_image_box_desc || '';
				var badge       = item.awea_image_box_badge || '';
				var url         = ( item.awea_image_box_btn_link && item.awea_image_box_btn_link.url ) ? item.awea_image_box_btn_link.url : '';
				var href        = url || '#';
				var hasUrl      = !! url;
				var btnShow     = 'yes' === item.awea_image_box_btn_show;
				var btnText     = item.awea_image_box_btn_text || '';
				var btnPos      = item.awea_image_box_btn_icon_pos || 'right';
				var isCardLink  = ( 'card' === linkMode && hasUrl );
				var isTitleLink = ( 'title' === linkMode && hasUrl );
				var btnIconHTML = elementor.helpers.renderIcon( view, item.awea_image_box_btn_icon, { 'aria-hidden': true }, 'i', 'object' );
				var cardClass   = 'awea_image_box_card elementor-repeater-item-' + id + ( isCardLink ? ' awea_image_box_card_clickable' : '' );

				var imageObj = {
					id: item.awea_image_box_image ? item.awea_image_box_image.id : '',
					url: item.awea_image_box_image ? item.awea_image_box_image.url : '',
					size: settings.awea_image_box_img_size_size,
					dimension: settings.awea_image_box_img_size_custom_dimension,
					model: view.getEditModel()
				};
				var imageUrl = elementor.imagesManager.getImageUrl( imageObj ) || '<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>';
			#>
				<article class="{{ cardClass }}">
					<# if ( isCardLink ) { #>
						<a href="{{ href }}" class="awea_image_box_cover_link" aria-label="{{ title }}"></a>
					<# } #>

					<div class="awea_image_box_media">
						<img src="{{ imageUrl }}" alt="{{ title }}" />

						<# if ( badge ) { #>
							<span class="awea_image_box_badge">{{{ badge }}}</span>
						<# } #>
					</div>

					<div class="awea_image_box_body">
						<# if ( title ) { #>
							<{{{ titleTag }}} class="awea_image_box_title">
								<# if ( isTitleLink ) { #>
									<a href="{{ href }}">{{{ title }}}</a>
								<# } else { #>
									{{{ title }}}
								<# } #>
							</{{{ titleTag }}}>
						<# } #>

						<# if ( desc ) { #>
							<p class="awea_image_box_desc">{{{ desc }}}</p>
						<# } #>

						<# if ( btnShow && btnText ) { #>
							<div class="awea_image_box_btn_wrap">
								<# if ( isCardLink ) { #>
									<span class="awea_image_box_btn">
								<# } else { #>
									<a href="{{ href }}" class="awea_image_box_btn">
								<# } #>

									<# if ( 'left' === btnPos && btnIconHTML && btnIconHTML.rendered ) { #>
										<span class="awea_image_box_ico awea_image_box_ico_left" aria-hidden="true">{{{ btnIconHTML.value }}}</span>
									<# } #>

									<span>{{{ btnText }}}</span>

									<# if ( 'right' === btnPos && btnIconHTML && btnIconHTML.rendered ) { #>
										<span class="awea_image_box_ico awea_image_box_ico_right" aria-hidden="true">{{{ btnIconHTML.value }}}</span>
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