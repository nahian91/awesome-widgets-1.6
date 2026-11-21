<?php
/**
 * Awesome Product Category Carousel Widget.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Product_Category_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-carousel';
	}

	public function get_title() {
		return esc_html__( 'Category Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-nested-carousel';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'category', 'categories', 'carousel', 'slider' ];
	}

	protected function register_controls() {
		$this->register_content_controls();$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$categories = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				foreach ( $categories as $cat ) {$cat_options[ $cat->term_id ] =$cat->name;
				}
			}
		}

		$this->add_control(
			'awea_product_cat_carousel_include_categories',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Leave empty to display all categories.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_parent_only',
			[
				'label'        => esc_html__( 'Top-Level Parents Only', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_hide_empty',
			[
				'label'        => esc_html__( 'Hide Empty', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_orderby',
			[
				'label'   => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => esc_html__( 'Name', 'awesome-widgets-elementor' ),
					'id'    => esc_html__( 'ID', 'awesome-widgets-elementor' ),
					'count' => esc_html__( 'Count', 'awesome-widgets-elementor' ),
					'rand'  => esc_html__( 'Random', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_settings',
			[
				'label' => esc_html__( 'Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_show_count',
			[
				'label'        => esc_html__( 'Show Product Count', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SLIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_slides_per_view',
			[
				'label'          => esc_html__( 'Slides Per View', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_slide_gap',
			[
				'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_product_cat_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_product_cat_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_transition_speed',
			[
				'label'   => esc_html__( 'Transition Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 50,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. NAVIGATION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_arrows',
			[
				'label'        => esc_html__( 'Show Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_dots',
			[
				'label'        => esc_html__( 'Show Dots', 'awesome-widgets-elementor' ),
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
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_card_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/5'  => '4:5 (Portrait)',
					'3/4'  => '3:4 (Classic)',
					'16/9' => '16:9 (Wide)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_card' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_card_radius',
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
					'{{WRAPPER}} .awea_product_cat_carousel_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_cat_carousel_card_tabs' );

		$this->start_controls_tab(
			'awea_product_cat_carousel_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_cat_carousel_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_cat_carousel_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_cat_carousel_card',
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
					'color'  => [ 'default' => 'rgba(15, 23, 42, 0.08)' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_cat_carousel_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_cat_carousel_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. DOCK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_style_dock',
			[
				'label' => esc_html__( 'Content Dock', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_dock_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_dock_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '14',
					'right'    => '18',
					'bottom'   => '14',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_cat_carousel_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_dock_radius',
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
					'{{WRAPPER}} .awea_product_cat_carousel_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_cat_carousel_dock_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_cat_carousel_content',
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
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.12)' ],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_style_text',
			[
				'label' => esc_html__( 'Category Title & Count', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_title_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_cat_carousel_title_typo',
				'selector' => '{{WRAPPER}} .awea_product_cat_carousel_link',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_count_color',
			[
				'label'     => esc_html__( 'Count Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_count' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_product_cat_carousel_show_count' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_product_cat_carousel_count_typo',
				'selector'  => '{{WRAPPER}} .awea_product_cat_carousel_count',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'condition' => [ 'awea_product_cat_carousel_show_count' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. ARROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_product_cat_carousel_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_carousel_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_cat_carousel_arrow_btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_arrow_btn i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel_arrow_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_cat_carousel_arrow_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_cat_carousel_arrow_border',
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

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_carousel_section_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_product_cat_carousel_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_dots_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_cat_carousel_dots_active_color',
			[
				'label'     => esc_html__( 'Active', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea_product_cat_carousel_notice_error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Category Carousel widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$categories = $settings['awea_product_cat_carousel_include_categories'] ?? [];
		$parent_only = 'yes' === ( $settings['awea_product_cat_carousel_parent_only'] ?? 'no' );
		$hide_empty = 'yes' === ( $settings['awea_product_cat_carousel_hide_empty'] ?? 'no' );
		$show_count = 'yes' === ( $settings['awea_product_cat_carousel_show_count'] ?? 'no' );

		$items_desktop = ! empty( $settings['awea_product_cat_carousel_slides_per_view'] ) ? (int) $settings['awea_product_cat_carousel_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_product_cat_carousel_slides_per_view_tablet'] ) ? (int) $settings['awea_product_cat_carousel_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_product_cat_carousel_slides_per_view_mobile'] ) ? (int) $settings['awea_product_cat_carousel_slides_per_view_mobile'] : 1;

		$gap_desktop   = isset( $settings['awea_product_cat_carousel_slide_gap']['size'] ) ? (int) $settings['awea_product_cat_carousel_slide_gap']['size'] : 24;
		$gap_tablet    = isset( $settings['awea_product_cat_carousel_slide_gap_tablet']['size'] ) ? (int) $settings['awea_product_cat_carousel_slide_gap_tablet']['size'] : 20;
		$gap_mobile    = isset( $settings['awea_product_cat_carousel_slide_gap_mobile']['size'] ) ? (int) $settings['awea_product_cat_carousel_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_product_cat_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_product_cat_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_product_cat_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_product_cat_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause      = ( 'yes' === ( $settings['awea_product_cat_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_product_cat_carousel_autoplay_speed'] ) ? absint( $settings['awea_product_cat_carousel_autoplay_speed'] ) : 5000;
		$anim_speed = ! empty( $settings['awea_product_cat_carousel_transition_speed'] ) ? absint( $settings['awea_product_cat_carousel_transition_speed'] ) : 450;
		$widget_id  = $this->get_id();

		$args = [
			'taxonomy'   => 'product_cat',
			'hide_empty' => $hide_empty,
			'orderby'    => $settings['awea_product_cat_carousel_orderby'] ?? 'name',
			'order'      => $settings['awea_product_cat_carousel_order'] ?? 'ASC',
		];

		if ( $parent_only ) {
			$args['parent'] = 0;
		}

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['include'] = array_map( 'absint', $categories );
		}

		$product_categories = get_terms( $args );

		if ( empty( $product_categories ) || is_wp_error( $product_categories ) ) {
			return;
		}
		?>
		<div class="awea_product_cat_carousel_wrap">
			<div class="awea_product_cat_carousel owl-carousel"
				 id="awea_product_cat_carousel_<?php echo esc_attr( $widget_id ); ?>"
				 data-awea_product_cat_carousel_items_desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-awea_product_cat_carousel_items_tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-awea_product_cat_carousel_items_mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-awea_product_cat_carousel_gap_desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-awea_product_cat_carousel_gap_tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-awea_product_cat_carousel_gap_mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-awea_product_cat_carousel_arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-awea_product_cat_carousel_dots="<?php echo esc_attr( $dots ); ?>"
				 data-awea_product_cat_carousel_loop="<?php echo esc_attr( $loop ); ?>"
				 data-awea_product_cat_carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-awea_product_cat_carousel_pause="<?php echo esc_attr( $pause ); ?>"
				 data-awea_product_cat_carousel_speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-awea_product_cat_carousel_timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php foreach ( $product_categories as $category ) :
					$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
					$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
					$term_link    = get_term_link( $category );
					if ( is_wp_error( $term_link ) ) {
						continue;
					}
					?>
					<div class="awea_product_cat_carousel_slide">
						<article class="awea_product_cat_carousel_card">

							<a href="<?php echo esc_url( $term_link ); ?>" class="awea_product_cat_carousel_img_link" aria-label="<?php echo esc_attr( $category->name ); ?>">
								<?php if ( ! empty( $image_url ) ) : ?>
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy" />
								<?php endif; ?>
							</a>

							<div class="awea_product_cat_carousel_content">
								<a href="<?php echo esc_url( $term_link ); ?>" class="awea_product_cat_carousel_link">
									<?php echo esc_html( $category->name ); ?>
								</a>
								<?php if ( $show_count ) : ?>
									<span class="awea_product_cat_carousel_count">(<?php echo esc_html( (string) $category->count ); ?>)</span>
								<?php endif; ?>
							</div>

						</article>
					</div>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		if (typeof jQuery !== 'undefined') {
			jQuery(window).on('elementor/frontend/init', function () {
				elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-category-carousel.default', function ($scope) {
					var $carousel = $scope.find('.awea_product_cat_carousel');
					if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

					if ($carousel.hasClass('owl-loaded')) {
						$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
						$carousel.find('.owl-stage-outer').children().unwrap();
					}

					var itemsDesktop = parseInt($carousel.attr('data-awea_product_cat_carousel_items_desktop'), 10) || 3;
					var itemsTablet  = parseInt($carousel.attr('data-awea_product_cat_carousel_items_tablet'), 10) || 2;
					var itemsMobile  = parseInt($carousel.attr('data-awea_product_cat_carousel_items_mobile'), 10) || 1;
					var gapDesktop   = parseInt($carousel.attr('data-awea_product_cat_carousel_gap_desktop'), 10) || 24;
					var gapTablet    = parseInt($carousel.attr('data-awea_product_cat_carousel_gap_tablet'), 10) || 20;
					var gapMobile    = parseInt($carousel.attr('data-awea_product_cat_carousel_gap_mobile'), 10) || 16;

					$carousel.owlCarousel({
						rtl: document.dir === 'rtl',
						nav: $carousel.attr('data-awea_product_cat_carousel_arrows') === 'yes',
						dots: $carousel.attr('data-awea_product_cat_carousel_dots') === 'yes',
						loop: $carousel.attr('data-awea_product_cat_carousel_loop') === 'yes',
						autoplay: $carousel.attr('data-awea_product_cat_carousel_autoplay') === 'yes',
						autoplayTimeout: parseInt($carousel.attr('data-awea_product_cat_carousel_timeout'), 10) || 5000,
						smartSpeed: parseInt($carousel.attr('data-awea_product_cat_carousel_speed'), 10) || 450,
						autoplayHoverPause: $carousel.attr('data-awea_product_cat_carousel_pause') === 'yes',
						navText: [
							'<div class="awea_product_cat_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Previous', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>',
							'<div class="awea_product_cat_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Next', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-right" aria-hidden="true"></i></div>'
						],
						responsive: {
							0: { items: itemsMobile, margin: gapMobile },
							768: { items: itemsTablet, margin: gapTablet },
							1025: { items: itemsDesktop, margin: gapDesktop }
						}
					});
				});
			});
		}
		</script>
		<?php
	}
}