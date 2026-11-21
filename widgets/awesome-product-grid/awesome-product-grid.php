<?php
/**
 * Awesome Product Grid Widget.
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

class Widget_Awesome_Product_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Grid', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product grid', 'shop', 'store', 'catalog' ];
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
			'awea_product_grid_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_grid_query_type',
			[
				'label'   => esc_html__( 'Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'latest',
				'options' => [
					'latest'   => esc_html__( 'Latest Products', 'awesome-widgets-elementor' ),
					'manual'   => esc_html__( 'Manual Selection', 'awesome-widgets-elementor' ),
					'category' => esc_html__( 'By Category', 'awesome-widgets-elementor' ),
				],
			]
		);

		$product_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$all_prods = get_posts(
				[
					'post_type'      => 'product',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
				]
			);
			foreach ( $all_prods as $p ) {
				$product_options[ $p->ID ] = $p->post_title;
			}
		}

		$this->add_control(
			'awea_product_grid_manual_product_ids',
			[
				'label'       => esc_html__( 'Products', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $product_options,
				'condition'   => [ 'awea_product_grid_query_type' => 'manual' ],
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$terms = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$cat_options[ $term->slug ] = $term->name;
				}
			}
		}

		$this->add_control(
			'awea_product_grid_product_categories',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'condition'   => [ 'awea_product_grid_query_type' => 'category' ],
			]
		);

		$this->add_control(
			'awea_product_grid_product_number',
			[
				'label'     => esc_html__( 'Count', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'max'       => 50,
				'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_product_grid_product_orderby',
			[
				'label'     => esc_html__( 'Sort', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => [
					'date'  => esc_html__( 'Date Created', 'awesome-widgets-elementor' ),
					'title' => esc_html__( 'Product Title', 'awesome-widgets-elementor' ),
					'price' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
					'rand'  => esc_html__( 'Random Order', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
			]
		);

		$this->add_control(
			'awea_product_grid_product_order',
			[
				'label'     => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'DESC',
				'options'   => [
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_section_elements',
			[
				'label' => esc_html__( 'Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_product_grid_show_sale_badge',
			[
				'label'        => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_grid_show_category',
			[
				'label'        => esc_html__( 'Category', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_grid_title_tag',
			[
				'label'     => esc_html__( 'Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
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
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_product_grid_columns',
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
					'{{WRAPPER}} .awea_product_grid_row' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_grid_grid_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_grid_row' => 'gap: {{SIZE}}{{UNIT}};',
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
			'awea_product_grid_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_grid_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'size' => 24, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_grid_card, {{WRAPPER}} .awea_product_grid_card::after' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_grid_card_tabs' );

		$this->start_controls_tab(
			'awea_product_grid_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_grid_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_grid_card',
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
				'name'     => 'awea_product_grid_card_shadow',
				'label'    => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_grid_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_grid_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_grid_card_border_hover',
			[
				'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_product_grid_card_shadow_hover',
				'label'    => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_grid_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Kinetic Beam
		$this->add_control(
			'awea_product_grid_heading_beam',
			[
				'label'     => esc_html__( 'Beam', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_product_grid_enable_beam',
			[
				'label'        => esc_html__( 'Enable', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_product_grid_beam_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_card' => '--awea_product_grid_beam_color: {{VALUE}};',
				],
				'condition' => [ 'awea_product_grid_enable_beam' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_product_grid_beam_speed',
			[
				'label'      => esc_html__( 'Speed', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_grid_card' => '--awea_product_grid_beam_speed: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_product_grid_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_grid_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1/1',
				'options'   => [
					'1/1'  => '1:1',
					'4/5'  => '4:5',
					'3/4'  => '3:4',
					'16/9' => '16:9',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_image_container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_grid_image_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_image_container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_product_grid_show_sale_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_grid_sale_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_badge_sale' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_grid_sale_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ef4444',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_badge_sale' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_grid_sale_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_grid_badge_sale',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_style_text',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Category / Brand
		$this->add_control(
			'awea_product_grid_heading_cat',
			[
				'label'     => esc_html__( 'Category', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_product_grid_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_product_grid_brand_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_brand' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_product_grid_show_category' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_product_grid_brand_typo',
				'label'     => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector'  => '{{WRAPPER}} .awea_product_grid_brand',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'condition' => [ 'awea_product_grid_show_category' => 'yes' ],
			]
		);

		// Title
		$this->add_control(
			'awea_product_grid_heading_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_product_grid_title_tabs' );

		$this->start_controls_tab(
			'awea_product_grid_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_product_name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_grid_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_title_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_card:hover .awea_product_grid_product_name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_grid_title_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_grid_product_name a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. PRICE & BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_grid_style_button',
			[
				'label' => esc_html__( 'Price & Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_grid_current_price_color',
			[
				'label'     => esc_html__( 'Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_current_price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_grid_price_typo',
				'label'    => esc_html__( 'Price Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_grid_current_price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_grid_btn_tabs' );

		$this->start_controls_tab(
			'awea_product_grid_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_buy_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_grid_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_buy_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_grid_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_grid_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_buy_btn:hover, {{WRAPPER}} .awea_product_grid_buy_btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_product_grid_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_grid_buy_btn:hover, {{WRAPPER}} .awea_product_grid_buy_btn:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea_product_grid_notice_error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Grid widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$query_type = $settings['awea_product_grid_query_type'] ?? 'latest';
		$title_tag  = Utils::validate_html_tag( $settings['awea_product_grid_title_tag'] ?? 'h3' );
		$has_beam   = ( 'yes' === ( $settings['awea_product_grid_enable_beam'] ?? 'no' ) );
		$show_sale  = ( 'yes' === ( $settings['awea_product_grid_show_sale_badge'] ?? 'no' ) );
		$show_cat   = ( 'yes' === ( $settings['awea_product_grid_show_category'] ?? 'no' ) );

		$args = [
			'post_type'   => 'product',
			'post_status' => 'publish',
		];

		if ( 'manual' === $query_type && ! empty( $settings['awea_product_grid_manual_product_ids'] ) ) {
			$args['post__in']       = array_map( 'absint', $settings['awea_product_grid_manual_product_ids'] );
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = -1;
		} else {
			$args['posts_per_page'] = ! empty( $settings['awea_product_grid_product_number'] ) ? absint( $settings['awea_product_grid_product_number'] ) : 6;
			$args['order']          = $settings['awea_product_grid_product_order'] ?? 'DESC';
			$args['orderby']        = $settings['awea_product_grid_product_orderby'] ?? 'date';

			if ( 'category' === $query_type && ! empty( $settings['awea_product_grid_product_categories'] ) ) {
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $settings['awea_product_grid_product_categories'],
					],
				];
			}
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

		$card_classes_base = [ 'awea_product_grid_card' ];
		if ( $has_beam ) {
			$card_classes_base[] = 'awea_product_grid_has_beam';
		}
		?>
		<div class="awea_product_grid_wrap">
			<div class="awea_product_grid_row" role="list">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$product_id = get_the_ID();
					$product    = wc_get_product( $product_id );
					if ( ! $product ) {
						continue;
					}

					$in_cart      = isset( $cart_product_ids[ $product_id ] );
					$supports_ajx = $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock();
					$btn_classes  = [ 'awea_product_grid_buy_btn', 'awea_product_grid_add_cart', 'product_type_' . $product->get_type() ];
					if ( $supports_ajx ) {
						$btn_classes[] = 'ajax_add_to_cart';
						$btn_classes[] = 'add_to_cart_button';
					}

					$card_classes = $card_classes_base;
					if ( $in_cart ) {
						$card_classes[] = 'awea_product_grid_in_cart';
					}
					?>
					<div class="awea_product_grid_item" role="listitem">
						<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

							<?php if ( $show_sale && $product->is_on_sale() ) : ?>
								<span class="awea_product_grid_badge_sale"><?php esc_html_e( 'SALE', 'awesome-widgets-elementor' ); ?></span>
							<?php endif; ?>

							<div class="awea_product_grid_image_container">
								<a href="<?php echo esc_url( get_the_permalink() ); ?>" aria-label="<?php the_title_attribute(); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'woocommerce_thumbnail', [ 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
									<?php endif; ?>
								</a>
							</div>

							<div class="awea_product_grid_post_content">
								<?php if ( $show_cat ) : ?>
									<p class="awea_product_grid_brand">
										<?php echo esc_html( wp_strip_all_tags( wc_get_product_category_list( $product_id, ', ', '', '' ) ) ); ?>
									</p>
								<?php endif; ?>

								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_product_grid_product_name">
									<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
							</div>

							<div class="awea_product_grid_footer">
								<div class="awea_product_grid_pricing">
									<?php if ( $product->is_on_sale() ) : ?>
										<span class="awea_product_grid_old_price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
									<?php endif; ?>
									<span class="awea_product_grid_current_price"><?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?></span>
								</div>

								<div class="awea_product_grid_action_container">
									<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
									   data-product_id="<?php echo esc_attr( (string) $product_id ); ?>"
									   data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
									   data-quantity="1"
									   class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>"
									   aria-label="<?php esc_attr_e( 'Add to Cart', 'awesome-widgets-elementor' ); ?>"
									   rel="nofollow">
										<i class="fas fa-shopping-bag" aria-hidden="true"></i>
										<span class="awea_product_grid_btn_label"><?php echo esc_html( $product->add_to_cart_text() ); ?></span>
									</a>

									<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" 
									   class="awea_product_grid_buy_btn awea_product_grid_view_cart"
									   aria-label="<?php esc_attr_e( 'View Cart', 'awesome-widgets-elementor' ); ?>">
										<i class="fas fa-check" aria-hidden="true"></i>
										<span class="awea_product_grid_btn_label"><?php esc_html_e( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
									</a>
								</div>
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
		if (typeof jQuery !== 'undefined' && !window.__awea_product_grid_bound) {
			window.__awea_product_grid_bound = true;
			jQuery(function($) {
				$(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
					if ($button && $button.length) {
						$button.closest('.awea_product_grid_card').addClass('awea_product_grid_in_cart');
					}
				});
			});
		}
		</script>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var titleTag = elementor.helpers.validateHTMLTag( settings.awea_product_grid_title_tag || 'h3' );
		var hasBeam  = 'yes' === settings.awea_product_grid_enable_beam;
		var showSale = 'yes' === settings.awea_product_grid_show_sale_badge;
		var showCat  = 'yes' === settings.awea_product_grid_show_category;
		var cardCls  = 'awea_product_grid_card' + ( hasBeam ? ' awea_product_grid_has_beam' : '' );
		#>
		<div class="awea_product_grid_wrap">
			<div class="awea_product_grid_row" role="list">
				<div class="awea_product_grid_item" role="listitem">
					<article class="{{ cardCls }}">
						<# if ( showSale ) { #>
							<span class="awea_product_grid_badge_sale"><?php esc_html_e( 'SALE', 'awesome-widgets-elementor' ); ?></span>
						<# } #>

						<div class="awea_product_grid_image_container">
							<a href="#">
								<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="Sample Product" loading="lazy" />
							</a>
						</div>

						<div class="awea_product_grid_post_content">
							<# if ( showCat ) { #>
								<p class="awea_product_grid_brand"><?php esc_html_e( 'Category', 'awesome-widgets-elementor' ); ?></p>
							<# } #>

							<{{{ titleTag }}} class="awea_product_grid_product_name">
								<a href="#"><?php esc_html_e( 'Sample WooCommerce Product', 'awesome-widgets-elementor' ); ?></a>
							</{{{ titleTag }}}>
						</div>

						<div class="awea_product_grid_footer">
							<div class="awea_product_grid_pricing">
								<span class="awea_product_grid_current_price">$49.00</span>
							</div>

							<div class="awea_product_grid_action_container">
								<a href="#" class="awea_product_grid_buy_btn">
									<i class="fas fa-shopping-bag" aria-hidden="true"></i>
									<span class="awea_product_grid_btn_label"><?php esc_html_e( 'Add to cart', 'awesome-widgets-elementor' ); ?></span>
								</a>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
		<?php
	}
}