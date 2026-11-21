<?php
/**
 * Awesome Filter Gallery Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Filter_Gallery extends Widget_Base {

	public function get_name() {
		return 'awesome-filter-gallery';
	}

	public function get_title() {
		return esc_html__( 'Filter Gallery', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'filter', 'gallery', 'portfolio', 'grid', 'lightbox' ];
	}

	protected function register_controls() {
		$this->register_content_controls();$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. FILTER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_section_filter',
			[
				'label' => esc_html__( 'Filter Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_filter_gallery_show_filter',
			[
				'label'        => esc_html__( 'Display Filter Tabs', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_filter_gallery_all_label',
			[
				'label'     => esc_html__( 'All Tab Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'All Works', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_filter_gallery_show_filter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_filter_gallery_show_counter',
			[
				'label'        => esc_html__( 'Show Item Count', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_filter_gallery_show_filter' => 'yes' ],
			]
		);

		$cat_repeater = new Repeater();

		$cat_repeater->add_control(
			'awea_filter_gallery_cat_name',
			[
				'label'       => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_filter_gallery_categories',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cat_repeater->get_controls(),
				'default'     => [
					[ 'awea_filter_gallery_cat_name' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ) ],
					[ 'awea_filter_gallery_cat_name' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ) ],
					[ 'awea_filter_gallery_cat_name' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ) ],
					[ 'awea_filter_gallery_cat_name' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ) ],
				],
				'title_field' => '{{{ awea_filter_gallery_cat_name }}}',
				'condition'   => [ 'awea_filter_gallery_show_filter' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_filter_align',
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
					'{{WRAPPER}} .awea_filter_gallery_nav_wrapper' => 'justify-content: {{VALUE}};',
				],
				'condition' => [ 'awea_filter_gallery_show_filter' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_section_items',
			[
				'label' => esc_html__( 'Gallery Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$item_repeater = new Repeater();

		$item_repeater->add_control(
			'awea_filter_gallery_item_image',
			[
				'label'   => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$item_repeater->add_control(
			'awea_filter_gallery_item_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Project Showcase', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_filter_gallery_item_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Concept', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_filter_gallery_item_category',
			[
				'label'       => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Comma-separated (e.g. Architecture, Minimalism)', 'awesome-widgets-elementor' ),
				'default'     => 'Architecture',
				'label_block' => true,
			]
		);

		$item_repeater->add_control(
			'awea_filter_gallery_item_link',
			[
				'label'       => esc_html__( 'Project Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_filter_gallery_items',
			[
				'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $item_repeater->get_controls(),
				'title_field' => '{{{ awea_filter_gallery_item_title }}}',
				'default'     => [
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Tokyo Cyberpunk', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Alpine Serenity', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Landscape',
					],
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Vogue Monolith', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Portraits',
					],
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Bauhaus Geometry', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Nordic Fjords', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Landscape',
					],
					[
						'awea_filter_gallery_item_title'    => esc_html__( 'Minimal Silhouette', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_subtitle' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ),
						'awea_filter_gallery_item_category' => 'Portraits, Minimalism',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_section_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_columns',
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
					'{{WRAPPER}} .awea_filter_gallery_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_filter_gallery_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. MEDIA
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_section_media',
			[
				'label' => esc_html__( 'Media & Ratio', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/3',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/3'  => '4:3 (Classic)',
					'16/9' => '16:9 (Wide)',
					'3/4'  => '3:4 (Portrait)',
					'auto' => esc_html__( 'Auto (Original)', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_thumb' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_filter_gallery_image_size',
				'default' => 'large',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_section_settings',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_filter_gallery_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
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
			'awea_filter_gallery_lightbox',
			[
				'label'        => esc_html__( 'Enable Lightbox', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_filter_gallery_link_title',
			[
				'label'        => esc_html__( 'Link Card Title to Project URL', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. FILTER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_style_filter',
			[
				'label'     => esc_html__( 'Filter Tabs', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_filter_gallery_show_filter' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_filter_gallery_nav_typo',
				'selector' => '{{WRAPPER}} .awea_filter_gallery_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_nav_padding',
			[
				'label'      => esc_html__( 'Tab Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '8',
					'right'    => '18',
					'bottom'   => '8',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_filter_gallery_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_nav_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_filter_gallery_nav_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_filter_gallery_nav_bg',
			[
				'label'     => esc_html__( 'Track Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_nav_track' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_filter_gallery_nav_border',
				'selector' => '{{WRAPPER}} .awea_filter_gallery_nav_track',
			]
		);

		$this->add_control(
			'awea_filter_gallery_pill_bg',
			[
				'label'     => esc_html__( 'Active Pill Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_pill_indicator' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_filter_gallery_nav_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_filter_gallery_nav_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_filter_gallery_nav_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_filter_gallery_nav_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_filter_gallery_nav_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_btn:hover, {{WRAPPER}} .awea_filter_gallery_btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active
		$this->start_controls_tab(
			'awea_filter_gallery_nav_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_filter_gallery_nav_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_btn.awea_filter_gallery_is_active, {{WRAPPER}} .awea_filter_gallery_btn.awea_filter_gallery_is_active:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_card_radius',
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
					'{{WRAPPER}} .awea_filter_gallery_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_body_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea_filter_gallery_body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_filter_gallery_card_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_filter_gallery_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_filter_gallery_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_filter_gallery_card_border',
				'selector'       => '{{WRAPPER}} .awea_filter_gallery_card',
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
				'name'     => 'awea_filter_gallery_card_shadow',
				'selector' => '{{WRAPPER}} .awea_filter_gallery_card',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_filter_gallery_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_filter_gallery_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_filter_gallery_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_filter_gallery_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_filter_gallery_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE & SUBTITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_filter_gallery_style_title',
			[
				'label' => esc_html__( 'Title & Subtitle', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_filter_gallery_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_filter_gallery_subtitle_typo',
				'label'    => esc_html__( 'Subtitle Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_filter_gallery_subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_filter_gallery_subtitle_space',
			[
				'label'      => esc_html__( 'Subtitle Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_filter_gallery_subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_filter_gallery_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_title, {{WRAPPER}} .awea_filter_gallery_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_filter_gallery_title_hover_color',
			[
				'label'     => esc_html__( 'Title Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_filter_gallery_card:hover .awea_filter_gallery_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_filter_gallery_title_typo',
				'label'    => esc_html__( 'Title Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_filter_gallery_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$items      = $settings['awea_filter_gallery_items'] ?? [];
		$categories = $settings['awea_filter_gallery_categories'] ?? [];
		$show_menu  = 'yes' === ( $settings['awea_filter_gallery_show_filter'] ?? 'no' );
		$show_count = 'yes' === ( $settings['awea_filter_gallery_show_counter'] ?? 'no' );
		$lightbox   = 'yes' === ( $settings['awea_filter_gallery_lightbox'] ?? 'yes' );
		$link_title = 'yes' === ( $settings['awea_filter_gallery_link_title'] ?? 'yes' );
		$all_label  = ! empty( $settings['awea_filter_gallery_all_label'] ) ? $settings['awea_filter_gallery_all_label'] : esc_html__( 'All Works', 'awesome-widgets-elementor' );
		$title_tag  = Utils::validate_html_tag( $settings['awea_filter_gallery_title_tag'] ?? 'h4' );
		$widget_id  = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}

		// Compute unique category counts per item.
		$cat_counts = [ '*' => count( $items ) ];
		foreach ( $items as $item ) {
			$raw_cats   = explode( ',', $item['awea_filter_gallery_item_category'] ?? '' );
			$item_slugs = [];
			foreach ( $raw_cats as $rc ) {
				$slug = sanitize_title( trim( $rc ) );
				if ( '' !== $slug ) {
					$item_slugs[ $slug ] = true;
				}
			}
			foreach ( array_keys( $item_slugs ) as $slug ) {
				$cat_counts[ $slug ] = ( $cat_counts[ $slug ] ?? 0 ) + 1;
			}
		}
		?>
		<div class="awea_filter_gallery_root" id="awea_filter_gallery_<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( $show_menu ) : ?>
				<div class="awea_filter_gallery_nav_wrapper">
					<div class="awea_filter_gallery_nav_track" role="tablist">
						<span class="awea_filter_gallery_pill_indicator" aria-hidden="true"></span>

						<button type="button" class="awea_filter_gallery_btn awea_filter_gallery_is_active" data-awea_filter_gallery_filter="*" role="tab" aria-selected="true">
							<span><?php echo esc_html( $all_label ); ?></span>
							<?php if ( $show_count ) : ?>
								<span class="awea_filter_gallery_counter"><?php echo esc_html( (string) $cat_counts['*'] ); ?></span>
							<?php endif; ?>
						</button>

						<?php foreach ( $categories as $cat ) :
							$cat_raw  = $cat['awea_filter_gallery_cat_name'] ?? '';
							$cat_slug = sanitize_title( $cat_raw );
							if ( empty( $cat_slug ) ) {
								continue;
							}
							$count = $cat_counts[ $cat_slug ] ?? 0;
							?>
							<button type="button" class="awea_filter_gallery_btn" data-awea_filter_gallery_filter=".awea_filter_gallery_cat_<?php echo esc_attr( $cat_slug ); ?>" role="tab" aria-selected="false">
								<span><?php echo esc_html( $cat_raw ); ?></span>
								<?php if ( $show_count ) : ?>
									<span class="awea_filter_gallery_counter"><?php echo esc_html( (string) $count ); ?></span>
								<?php endif; ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="awea_filter_gallery_grid">
				<?php foreach ( $items as $index => $item ) :
					$id         = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
					$img_data   = $item['awea_filter_gallery_item_image'] ?? [];
					$img_url    = ! empty( $img_data['url'] ) ? $img_data['url'] : Utils::get_placeholder_image_src();
					$title      = $item['awea_filter_gallery_item_title'] ?? '';
					$subtitle   = $item['awea_filter_gallery_item_subtitle'] ?? '';
					$custom_url = $item['awea_filter_gallery_item_link']['url'] ?? '';

					$raw_cats    = explode( ',', $item['awea_filter_gallery_item_category'] ?? '' );
					$cat_classes = [];
					foreach ( $raw_cats as $rc ) {
						$slug = sanitize_title( trim( $rc ) );
						if ( ! empty( $slug ) ) {
							$cat_classes[] = 'awea_filter_gallery_cat_' . $slug;
						}
					}
					$class_string = implode( ' ', array_unique( $cat_classes ) );

					$lightbox_url = '';
					if ( $lightbox ) {
						$lightbox_url = Group_Control_Image_Size::get_attachment_image_src( $img_data['id'] ?? '', 'full', $settings ) ?: $img_url;
					}

					$link_key       = 'awea_filter_gallery_link_' . $id;
					$title_link_key = 'awea_filter_gallery_title_link_' . $id;
					if ( ! empty( $custom_url ) ) {
						$this->remove_render_attribute( $link_key );
						$this->add_link_attributes( $link_key, $item['awea_filter_gallery_item_link'] );
						$this->add_render_attribute( $link_key, 'class', 'awea_filter_gallery_action_btn' );
						$this->add_render_attribute( $link_key, 'aria-label', $title );

						$this->remove_render_attribute( $title_link_key );
						$this->add_link_attributes( $title_link_key, $item['awea_filter_gallery_item_link'] );
					}
					?>
					<div class="awea_filter_gallery_item <?php echo esc_attr( $class_string ); ?>">
						<article class="awea_filter_gallery_card elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

							<div class="awea_filter_gallery_thumb">
								<?php
								if ( ! empty( $img_data['id'] ) ) {
									echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_filter_gallery_image_size', 'awea_filter_gallery_item_image' );
								} else {
									printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img_url ), esc_attr( $title ) );
								}
								?>

								<?php if ( $lightbox || ! empty( $custom_url ) ) : ?>
									<div class="awea_filter_gallery_actions">
										<?php if ( $lightbox ) : ?>
											<a href="<?php echo esc_url( $lightbox_url ); ?>"
											   class="awea_filter_gallery_action_btn elementor-lightbox"
											   data-elementor-open-lightbox="yes"
											   data-elementor-lightbox-slideshow="awea_filter_gallery_<?php echo esc_attr( $widget_id ); ?>"
											   title="<?php echo esc_attr( $title ); ?>"
											   aria-label="<?php esc_attr_e( 'View Full Image', 'awesome-widgets-elementor' ); ?>">
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
											</a>
										<?php endif; ?>

										<?php if ( ! empty( $custom_url ) ) : ?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
												<svg class="awea_filter_gallery_arrow_svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
								<div class="awea_filter_gallery_body">
									<?php if ( ! empty( $subtitle ) ) : ?>
										<span class="awea_filter_gallery_subtitle"><?php echo esc_html( $subtitle ); ?></span>
									<?php endif; ?>

									<?php if ( ! empty( $title ) ) : ?>
										<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_filter_gallery_title">
											<?php if ( $link_title && ! empty( $custom_url ) ) : ?>
												<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php echo esc_html( $title ); ?></a>
											<?php else : ?>
												<?php echo esc_html( $title ); ?>
											<?php endif; ?>
										</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</article>
					</div>
				<?php endforeach; ?>
			</div>

		</div>

		<script>
		(function() {
			function awea_filter_gallery_bind(scope) {
				if (!scope || scope.dataset.aweaFilterGalleryBound === '1') return;
				scope.dataset.aweaFilterGalleryBound = '1';

				var indicator = scope.querySelector('.awea_filter_gallery_pill_indicator');
				var buttons   = scope.querySelectorAll('.awea_filter_gallery_btn');
				var items     = Array.from(scope.querySelectorAll('.awea_filter_gallery_item'));

				function updateIndicator(activeBtn) {
					if (!indicator || !activeBtn) return;
					indicator.style.width   = activeBtn.offsetWidth + 'px';
					indicator.style.height  = activeBtn.offsetHeight + 'px';
					indicator.style.left    = activeBtn.offsetLeft + 'px';
					indicator.style.top     = activeBtn.offsetTop + 'px';
					indicator.style.opacity = '1';
				}

				var defaultActive = scope.querySelector('.awea_filter_gallery_btn.awea_filter_gallery_is_active');
				if (defaultActive) {
					requestAnimationFrame(function() { updateIndicator(defaultActive); });
				}

				buttons.forEach(function(btn) {
					btn.addEventListener('click', function() {
						if (this.classList.contains('awea_filter_gallery_is_active')) return;

						buttons.forEach(function(b) {
							b.classList.remove('awea_filter_gallery_is_active');
							b.setAttribute('aria-selected', 'false');
						});
						this.classList.add('awea_filter_gallery_is_active');
						this.setAttribute('aria-selected', 'true');
						updateIndicator(this);

						var filterVal = this.getAttribute('data-awea_filter_gallery_filter');

						items.forEach(function(item) {
							var matches = (filterVal === '*' || item.matches(filterVal));
							if (matches) {
								clearTimeout(item.__aweaHideTimer);
								item.style.display = '';
								item.classList.remove('awea_filter_gallery_fading_out');
								item.classList.add('awea_filter_gallery_fading_in');
							} else {
								item.classList.remove('awea_filter_gallery_fading_in');
								item.classList.add('awea_filter_gallery_fading_out');
								clearTimeout(item.__aweaHideTimer);
								item.__aweaHideTimer = setTimeout(function() {
									if (item.classList.contains('awea_filter_gallery_fading_out')) {
										item.style.display = 'none';
									}
								}, 300);
							}
						});
					});
				});

				if ('ResizeObserver' in window) {
					var ro = new ResizeObserver(function() {
						if (!document.body.contains(scope)) {
							ro.disconnect();
							return;
						}
						var currentActive = scope.querySelector('.awea_filter_gallery_btn.awea_filter_gallery_is_active');
						if (currentActive) updateIndicator(currentActive);
					});
					ro.observe(scope);
				} else {
					window.addEventListener('resize', function() {
						var currentActive = scope.querySelector('.awea_filter_gallery_btn.awea_filter_gallery_is_active');
						if (currentActive) updateIndicator(currentActive);
					});
				}
			}

			function awea_filter_gallery_init() {
				awea_filter_gallery_bind(document.getElementById('awea_filter_gallery_<?php echo esc_js( $widget_id ); ?>'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_filter_gallery_init);
			} else {
				awea_filter_gallery_init();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.awea_filter_gallery_hooked) {
				window.awea_filter_gallery_hooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-filter-gallery.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_filter_gallery_root') : null;
					awea_filter_gallery_bind(el);
				});
			}
		})();
		</script>
		<?php
	}
}