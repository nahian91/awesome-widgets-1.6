<?php
/**
 * Awesome Product Carousel Widget.
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

class Widget_Awesome_Product_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-product-carousel';
	}

	public function get_title() {
		return esc_html__( 'Product Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-carousel-loop';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product', 'carousel', 'slider', 'shop' ];
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
		   CONTENT: 1. QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_carousel_post_count',
			[
				'label'   => esc_html__( 'Products Count', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
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
				foreach ( $categories as $cat ) {
					$cat_options[ $cat->term_id ] = $cat->name;
				}
			}
		}

		$this->add_control(
			'awea_product_carousel_categories',
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
			'awea_product_carousel_orderby',
			[
				'label'   => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'       => esc_html__( 'Date', 'awesome-widgets-elementor' ),
					'title'      => esc_html__( 'Title', 'awesome-widgets-elementor' ),
					'price'      => esc_html__( 'Price', 'awesome-widgets-elementor' ),
					'popularity' => esc_html__( 'Popularity', 'awesome-widgets-elementor' ),
					'rating'     => esc_html__( 'Rating', 'awesome-widgets-elementor' ),
					'rand'       => esc_html__( 'Random', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_section_elements',
			[
				'label' => esc_html__( 'Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_carousel_show_sale',
			[
				'label'        => esc_html__( 'Sale Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_carousel_show_rating',
			[
				'label'        => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_carousel_show_stock',
			[
				'label'        => esc_html__( 'Stock Status', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_product_carousel_title_tag',
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

		/* ==========================================================================
		   CONTENT: 3. SLIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_section_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_slides_per_view',
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
			'awea_product_carousel_slide_gap',
			[
				'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_product_carousel_loop',
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
			'awea_product_carousel_autoplay',
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
			'awea_product_carousel_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_product_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_product_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_carousel_transition_speed',
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
			'awea_product_carousel_section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_carousel_arrows',
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
			'awea_product_carousel_dots',
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
			'awea_product_carousel_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_carousel_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_card_radius',
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
					'{{WRAPPER}} .awea_product_carousel_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_carousel_card_tabs' );

		$this->start_controls_tab(
			'awea_product_carousel_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_carousel_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_carousel_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_carousel_card',
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
				'name'     => 'awea_product_carousel_card_shadow',
				'selector' => '{{WRAPPER}} .awea_product_carousel_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_carousel_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_carousel_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_product_carousel_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_product_carousel_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1/1',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/5'  => '4:5 (Portrait)',
					'3/4'  => '3:4 (Classic)',
					'16/9' => '16:9 (Wide)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_img_wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_image_radius',
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
					'{{WRAPPER}} .awea_product_carousel_img_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_style_text',
			[
				'label' => esc_html__( 'Title & Price', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_carousel_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_title_hover',
			[
				'label'     => esc_html__( 'Title Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card:hover .awea_product_carousel_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_carousel_title_typo',
				'selector' => '{{WRAPPER}} .awea_product_carousel_title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_price_color',
			[
				'label'     => esc_html__( 'Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_price, {{WRAPPER}} .awea_product_carousel_price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_carousel_price_typo',
				'selector' => '{{WRAPPER}} .awea_product_carousel_price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_style_button',
			[
				'label' => esc_html__( 'Cart Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_carousel_btn_typo',
				'selector' => '{{WRAPPER}} .awea_product_carousel_cart_btn',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_carousel_btn_state_tabs' );

		$this->start_controls_tab(
			'awea_product_carousel_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_carousel_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_cart_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_cart_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_carousel_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_carousel_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card:hover .awea_product_carousel_cart_btn, {{WRAPPER}} .awea_product_carousel_cart_btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_card:hover .awea_product_carousel_cart_btn, {{WRAPPER}} .awea_product_carousel_cart_btn:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_product_carousel_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '12',
					'right'    => '24',
					'bottom'   => '12',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_carousel_cart_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_btn_radius',
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
					'{{WRAPPER}} .awea_product_carousel_cart_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. ARROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_section_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_product_carousel_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_product_carousel_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_carousel_arrow_border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_arrow_border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel_arrow_border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_carousel_arrow_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_carousel_arrow_border',
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
		   STYLE: 6. DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_carousel_section_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_product_carousel_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_carousel_dots_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_carousel_dots_active_color',
			[
				'label'     => esc_html__( 'Active', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea_product_carousel_notice_error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Carousel widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings     = $this->get_settings_for_display();
		$num_products = ! empty( $settings['awea_product_carousel_post_count'] ) ? absint( $settings['awea_product_carousel_post_count'] ) : 8;
		$order        = $settings['awea_product_carousel_order'] ?? 'DESC';
		$orderby      = $settings['awea_product_carousel_orderby'] ?? 'date';
		$categories   = $settings['awea_product_carousel_categories'] ?? [];
		$title_tag    = Utils::validate_html_tag( $settings['awea_product_carousel_title_tag'] ?? 'h3' );
		$show_sale    = 'yes' === ( $settings['awea_product_carousel_show_sale'] ?? 'no' );
		$show_rating  = 'yes' === ( $settings['awea_product_carousel_show_rating'] ?? 'no' );
		$show_stock   = 'yes' === ( $settings['awea_product_carousel_show_stock'] ?? 'no' );

		$items_desktop = ! empty( $settings['awea_product_carousel_slides_per_view'] ) ? (int) $settings['awea_product_carousel_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_product_carousel_slides_per_view_tablet'] ) ? (int) $settings['awea_product_carousel_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_product_carousel_slides_per_view_mobile'] ) ? (int) $settings['awea_product_carousel_slides_per_view_mobile'] : 1;

		$gap_desktop   = isset( $settings['awea_product_carousel_slide_gap']['size'] ) ? (int) $settings['awea_product_carousel_slide_gap']['size'] : 24;
		$gap_tablet    = isset( $settings['awea_product_carousel_slide_gap_tablet']['size'] ) ? (int) $settings['awea_product_carousel_slide_gap_tablet']['size'] : 20;
		$gap_mobile    = isset( $settings['awea_product_carousel_slide_gap_mobile']['size'] ) ? (int) $settings['awea_product_carousel_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_product_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_product_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_product_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_product_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause      = ( 'yes' === ( $settings['awea_product_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_product_carousel_autoplay_speed'] ) ? absint( $settings['awea_product_carousel_autoplay_speed'] ) : 5000;
		$anim_speed = ! empty( $settings['awea_product_carousel_transition_speed'] ) ? absint( $settings['awea_product_carousel_transition_speed'] ) : 450;
		$widget_id  = $this->get_id();

		$args = [
			'posts_per_page'      => $num_products,
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		];

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			$args['tax_query'] = [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => array_map( 'absint', $categories ),
				],
			];
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			return;
		}

		$cart_product_ids = [];
		if ( WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $cart_item ) {
				$cart_product_ids[ (int) $cart_item['product_id'] ] = true;
			}
		}
		?>
		<div class="awea_product_carousel_wrap">
			<div class="awea_product_carousel owl-carousel"
				 id="awea_product_carousel_<?php echo esc_attr( $widget_id ); ?>"
				 data-awea_product_carousel_items_desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-awea_product_carousel_items_tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-awea_product_carousel_items_mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-awea_product_carousel_gap_desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-awea_product_carousel_gap_tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-awea_product_carousel_gap_mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-awea_product_carousel_arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-awea_product_carousel_dots="<?php echo esc_attr( $dots ); ?>"
				 data-awea_product_carousel_loop="<?php echo esc_attr( $loop ); ?>"
				 data-awea_product_carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-awea_product_carousel_pause="<?php echo esc_attr( $pause ); ?>"
				 data-awea_product_carousel_speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-awea_product_carousel_timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$product_id = get_the_ID();
					$product    = wc_get_product( $product_id );
					if ( ! $product ) {
						continue;
					}
					$is_on_sale   = $product->is_on_sale();
					$in_cart      = isset( $cart_product_ids[ $product_id ] );
					$supports_ajx = $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock();
					$btn_classes  = [ 'awea_product_carousel_cart_btn', 'awea_product_carousel_add_cart', 'product_type_' . $product->get_type() ];
					if ( $supports_ajx ) {
						$btn_classes[] = 'ajax_add_to_cart';
						$btn_classes[] = 'add_to_cart_button';
					}

					$card_classes = [ 'awea_product_carousel_card' ];
					if ( $in_cart ) {
						$card_classes[] = 'awea_product_carousel_in_cart';
					}
					?>
					<div class="awea_product_carousel_slide">
						<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

							<div class="awea_product_carousel_img_wrap">
								<?php if ( $show_sale && $is_on_sale ) : ?>
									<span class="awea_product_carousel_sale_badge"><?php esc_html_e( 'Sale', 'awesome-widgets-elementor' ); ?></span>
								<?php endif; ?>

								<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea_product_carousel_img_link" aria-label="<?php the_title_attribute(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'woocommerce_thumbnail', [ 'class' => 'awea_product_carousel_img', 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea_product_carousel_img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
									<?php endif; ?>
								</a>
							</div>

							<div class="awea_product_carousel_body">
								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_product_carousel_title">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( $show_rating && function_exists( 'wc_get_rating_html' ) && $product->get_average_rating() > 0 ) : ?>
									<div class="awea_product_carousel_rating">
										<?php echo $product->get_image_id() ? wc_get_rating_html( $product->get_average_rating() ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								<?php endif; ?>

								<?php if ( $show_stock ) :
									$stock_html = $product->is_in_stock() ? '<span class="awea_in_stock">' . esc_html__( 'In Stock', 'awesome-widgets-elementor' ) . '</span>' : '<span class="awea_out_stock">' . esc_html__( 'Out of Stock', 'awesome-widgets-elementor' ) . '</span>';
									?>
									<div class="awea_product_carousel_stock"><?php echo $stock_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
								<?php endif; ?>

								<div class="awea_product_carousel_price">
									<?php echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							</div>

							<div class="awea_product_carousel_footer">
								<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" 
								   class="awea_product_carousel_cart_btn awea_product_carousel_view_cart"
								   aria-label="<?php esc_attr_e( 'View Cart', 'awesome-widgets-elementor' ); ?>">
									<i class="fas fa-check" aria-hidden="true"></i>
									<span><?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
								</a>

								<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
								   class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" 
								   data-product_id="<?php echo esc_attr( (string) $product_id ); ?>" 
								   data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
								   data-quantity="1" 
								   aria-label="<?php esc_attr_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?>"
								   rel="nofollow">
									<i class="fas fa-shopping-bag" aria-hidden="true"></i>
									<span><?php echo esc_html( $product->add_to_cart_text() ); ?></span>
								</a>
							</div>

						</article>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>

			</div>
		</div>

		<script>
		if (typeof jQuery !== 'undefined') {
			jQuery(window).on('elementor/frontend/init', function () {
				elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-carousel.default', function ($scope, $) {
					var $carousel = $scope.find('.awea_product_carousel');
					if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

					if ($carousel.hasClass('owl-loaded')) {
						$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
						$carousel.find('.owl-stage-outer').children().unwrap();
					}

					var itemsDesktop = parseInt($carousel.attr('data-awea_product_carousel_items_desktop'), 10) || 3;
					var itemsTablet  = parseInt($carousel.attr('data-awea_product_carousel_items_tablet'), 10) || 2;
					var itemsMobile  = parseInt($carousel.attr('data-awea_product_carousel_items_mobile'), 10) || 1;
					var gapDesktop   = parseInt($carousel.attr('data-awea_product_carousel_gap_desktop'), 10) || 24;
					var gapTablet    = parseInt($carousel.attr('data-awea_product_carousel_gap_tablet'), 10) || 20;
					var gapMobile    = parseInt($carousel.attr('data-awea_product_carousel_gap_mobile'), 10) || 16;

					$carousel.owlCarousel({
						rtl: document.dir === 'rtl',
						nav: $carousel.attr('data-awea_product_carousel_arrows') === 'yes',
						dots: $carousel.attr('data-awea_product_carousel_dots') === 'yes',
						loop: $carousel.attr('data-awea_product_carousel_loop') === 'yes',
						autoplay: $carousel.attr('data-awea_product_carousel_autoplay') === 'yes',
						autoplayTimeout: parseInt($carousel.attr('data-awea_product_carousel_timeout'), 10) || 5000,
						smartSpeed: parseInt($carousel.attr('data-awea_product_carousel_speed'), 10) || 450,
						autoplayHoverPause: $carousel.attr('data-awea_product_carousel_pause') === 'yes',
						navText: [
							'<div class="awea_product_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Previous', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-left" aria-hidden="true"></i></div>',
							'<div class="awea_product_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Next', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-right" aria-hidden="true"></i></div>'
						],
						responsive: {
							0: { items: itemsMobile, margin: gapMobile },
							768: { items: itemsTablet, margin: gapTablet },
							1025: { items: itemsDesktop, margin: gapDesktop }
						}
					});
				});
			});

			if (!window.__awea_product_carousel_bound) {
				window.__awea_product_carousel_bound = true;
				jQuery(function($) {
					$(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
						if ($button && $button.length) {
							$button.closest('.awea_product_carousel_card').addClass('awea_product_carousel_in_cart');
						}
					});
				});
			}
		}
		</script>
		<?php
	}
}