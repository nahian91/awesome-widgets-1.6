<?php
/**
 * Awesome Post Carousel Studio Widget.
 * Architectural Editorial Post Feed with Dynamic Slider & Reading Time Metrics.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Post_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-post-carousel';
	}

	public function get_title() {
		return esc_html__( 'Post Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'post', 'carousel', 'slider', 'blog', 'articles', 'feed', 'query' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_posts_per_page',
			[
				'label'   => esc_html__( 'Posts Count', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_post_order',
			[
				'label'   => esc_html__( 'Direction', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending (Newest)', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Ascending (Oldest)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_post_orderby',
			[
				'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Date', 'awesome-widgets-elementor' ),
					'title'         => esc_html__( 'Title', 'awesome-widgets-elementor' ),
					'modified'      => esc_html__( 'Last Modified', 'awesome-widgets-elementor' ),
					'comment_count' => esc_html__( 'Comment Count', 'awesome-widgets-elementor' ),
					'rand'          => esc_html__( 'Random', 'awesome-widgets-elementor' ),
					'ID'            => esc_html__( 'Post ID', 'awesome-widgets-elementor' ),
				],
			]
		);

		// Fetch Categories
		$cat_options = [];
		$categories  = get_categories( [ 'hide_empty' => false ] );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cat_options[ $cat->term_id ] = $cat->name;
			}
		}

		$this->add_control(
			'awea_include_categories',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Leave empty to display posts from all categories.', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. CARD ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_meta_visibility',
			[
				'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_category',
			[
				'label'        => esc_html__( 'Category Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_date',
			[
				'label'        => esc_html__( 'Publish Date', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_reading_time',
			[
				'label'        => esc_html__( 'Reading Time', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_excerpt',
			[
				'label'        => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'min'       => 5,
				'max'       => 100,
				'condition' => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_button',
			[
				'label'        => esc_html__( 'Action Link', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_button_text',
			[
				'label'     => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Article', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_counter',
			[
				'label'        => esc_html__( 'Numeric Index', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
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
		   CONTENT TAB: 3. CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_slides_per_view',
			[
				'label'          => esc_html__( 'Slides Per View', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1 Item',
					'2' => '2 Items',
					'3' => '3 Items',
					'4' => '4 Items',
					'5' => '5 Items',
				],
			]
		);

		$this->add_responsive_control(
			'awea_slide_gap',
			[
				'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_carousel_arrows',
			[
				'label'        => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_carousel_dots',
			[
				'label'        => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_loop',
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
			'awea_carousel_autoplay',
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
			'awea_carousel_pause',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_carousel_transition_speed',
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
		   STYLE TAB: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-blog-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/10' => '16:10',
					'16/9'  => '16:9',
					'4/3'   => '4:3',
					'1/1'   => '1:1',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. BADGE (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_category',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cat_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cat_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cat_typo',
				'selector' => '{{WRAPPER}} .awea-blog-badge',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_cat_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'top' => '6', 'right' => '14', 'bottom' => '6', 'left' => '14', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cat_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta
		$this->add_control(
			'awea_heading_meta',
			[
				'label' => esc_html__( 'Meta', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_meta_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_meta_typo',
				'selector' => '{{WRAPPER}} .awea-blog-meta',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_meta_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Title
		$this->add_control(
			'awea_heading_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_title_color_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_title_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_title_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-blog-title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Excerpt
		$this->add_control(
			'awea_heading_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_exc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-desc' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_exc_typo',
				'selector'  => '{{WRAPPER}} .awea-blog-desc',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'condition' => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_exc_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 5. BUTTON (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_button',
			[
				'label'     => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-blog-link',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_btn_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_btn_border',
				'selector' => '{{WRAPPER}} .awea-blog-link',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_btn_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '10', 'right' => '20', 'bottom' => '10', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 6. COUNTER (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_counter',
			[
				'label'     => esc_html__( 'Counter', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_counter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_counter_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_counter_typo',
				'selector' => '{{WRAPPER}} .awea-blog-num',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 7. ARROWS (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_carousel_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_arrow_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_arrow_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_arrow_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_arrow_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_arrow_border',
				'selector' => '{{WRAPPER}} .awea-carousel-arrow-border',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_arrow_shadow',
				'selector' => '{{WRAPPER}} .awea-carousel-arrow-border',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_arrow_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_arrow_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_arrow_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_arrow_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 8. DOTS (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_carousel_dots' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_dots_size',
			[
				'label'      => esc_html__( 'Diameter', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_dots_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_dots_margin_top',
			[
				'label'      => esc_html__( 'Top Margin', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_dots_color',
			[
				'label'     => esc_html__( 'Inactive Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dots_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$num_posts    = ! empty( $settings['awea_posts_per_page'] ) ? absint( $settings['awea_posts_per_page'] ) : 6;
		$order        = $settings['awea_post_order'] ?? 'DESC';
		$orderby      = $settings['awea_post_orderby'] ?? 'date';
		$categories   = $settings['awea_include_categories'] ?? [];
		$show_cat     = 'yes' === ( $settings['awea_show_category'] ?? 'no' );
		$show_date    = 'yes' === ( $settings['awea_show_date'] ?? 'no' );
		$show_read    = 'yes' === ( $settings['awea_show_reading_time'] ?? 'no' );
		$show_exc     = 'yes' === ( $settings['awea_show_excerpt'] ?? 'no' );
		$exc_len      = ! empty( $settings['awea_excerpt_length'] ) ? absint( $settings['awea_excerpt_length'] ) : 14;
		$show_btn     = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_button_text'] ?? esc_html__( 'Read Article', 'awesome-widgets-elementor' );
		$show_counter = 'yes' === ( $settings['awea_show_counter'] ?? 'no' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );

		$items_desktop = ! empty( $settings['awea_slides_per_view'] ) ? (int) $settings['awea_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_slides_per_view_tablet'] ) ? (int) $settings['awea_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_slides_per_view_mobile'] ) ? (int) $settings['awea_slides_per_view_mobile'] : 1;

		$gap_desktop   = isset( $settings['awea_slide_gap']['size'] ) ? (int) $settings['awea_slide_gap']['size'] : 24;
		$gap_tablet    = isset( $settings['awea_slide_gap_tablet']['size'] ) ? (int) $settings['awea_slide_gap_tablet']['size'] : 20;
		$gap_mobile    = isset( $settings['awea_slide_gap_mobile']['size'] ) ? (int) $settings['awea_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause      = ( 'yes' === ( $settings['awea_carousel_pause'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_carousel_autoplay_speed'] ) ? absint( $settings['awea_carousel_autoplay_speed'] ) : 5000;
		$anim_speed = ! empty( $settings['awea_carousel_transition_speed'] ) ? absint( $settings['awea_carousel_transition_speed'] ) : 450;
		$widget_id  = $this->get_id();

		$args = [
			'posts_per_page'      => $num_posts,
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
		];

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['category__in'] = array_map( 'absint', $categories );
		}

		$query = new \WP_Query( $args );
		?>
		<div class="awea-post-carousel-wrap">
			<div class="awea-post-carousel owl-carousel"
				 id="awea-carousel-<?php echo esc_attr( $widget_id ); ?>"
				 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-dots="<?php echo esc_attr( $dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php
				if ( $query->have_posts() ) :
					$counter = 1;
					while ( $query->have_posts() ) :
						$query->the_post();
						$content      = get_post_field( 'post_content', get_the_ID() );
						$word_count   = str_word_count( wp_strip_all_tags( $content ) );
						$reading_time = max( 1, ceil( $word_count / 200 ) );
						$post_cats    = get_the_category();
						?>
						<div class="awea-post-slide">
							<article class="awea-blog-card">
								
								<!-- Featured Image Frame -->
								<div class="awea-blog-img-wrap">
									<?php if ( $show_cat && ! empty( $post_cats ) ) : ?>
										<span class="awea-blog-badge"><?php echo esc_html( $post_cats[0]->name ); ?></span>
									<?php endif; ?>

									<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-blog-img-link" aria-label="<?php the_title_attribute(); ?>">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large', [ 'class' => 'awea-blog-img', 'loading' => 'lazy' ] ); ?>
										<?php else : ?>
											<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea-blog-img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
										<?php endif; ?>
									</a>
								</div>

								<!-- Body Content -->
								<div class="awea-blog-body">
									<?php if ( $show_date || $show_read ) : ?>
										<div class="awea-blog-meta">
											<?php if ( $show_date ) : ?>
												<span><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></span>
											<?php endif; ?>

											<?php if ( $show_date && $show_read ) : ?>
												<span class="awea-meta-dot" aria-hidden="true">•</span>
											<?php endif; ?>

											<?php if ( $show_read ) : ?>
												<span><?php echo esc_html( sprintf( __( '%d MIN READ', 'awesome-widgets-elementor' ), $reading_time ) ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-blog-title">
										<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
									</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

									<?php if ( $show_exc ) : ?>
										<p class="awea-blog-desc">
											<?php echo esc_html( wp_trim_words( get_the_excerpt(), $exc_len, '...' ) ); ?>
										</p>
									<?php endif; ?>
								</div>

								<!-- Card Footer Lockup -->
								<?php if ( ( $show_btn && ! empty( $btn_text ) ) || $show_counter ) : ?>
									<div class="awea-blog-footer">
										<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
											<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-blog-link">
												<span><?php echo esc_html( $btn_text ); ?></span>
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
											</a>
										<?php endif; ?>

										<?php if ( $show_counter ) : ?>
											<span class="awea-blog-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $counter ) ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							</article>
						</div>
						<?php
						$counter++;
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="awea-no-posts"><?php esc_html_e( 'No posts found matching your criteria.', 'awesome-widgets-elementor' ); ?></p>
				<?php endif; ?>

			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-post-carousel.default', function ($scope, $) {
				var $carousel = $scope.find('.awea-post-carousel');

				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') {
					return;
				}

				var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;

				var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10);
				var gapTablet    = parseInt($carousel.data('gap-tablet'), 10);
				var gapMobile    = parseInt($carousel.data('gap-mobile'), 10);

				if (isNaN(gapDesktop)) gapDesktop = 24;
				if (isNaN(gapTablet)) gapTablet = 20;
				if (isNaN(gapMobile)) gapMobile = 16;

				var showArrows  = $carousel.data('arrows') === 'yes';
				var showDots    = $carousel.data('dots') === 'yes';
				var loop        = $carousel.data('loop') === 'yes';
				var autoplay    = $carousel.data('autoplay') === 'yes';
				var pauseHover  = $carousel.data('pause') === 'yes';
				var autoDelay   = parseInt($carousel.data('timeout'), 10) || 5000;
				var animSpeed   = parseInt($carousel.data('speed'), 10) || 450;

				$carousel.owlCarousel({
					nav: showArrows,
					dots: showDots,
					loop: loop,
					autoplay: autoplay,
					autoplayTimeout: autoDelay,
					smartSpeed: animSpeed,
					autoplayHoverPause: pauseHover,
					navText: [
						'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
						'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
					],
					responsive: {
						0: {
							items: itemsMobile,
							margin: gapMobile
						},
						768: {
							items: itemsTablet,
							margin: gapTablet
						},
						1025: {
							items: itemsDesktop,
							margin: gapDesktop
						}
					},
					onInitialized: equalizeHeights,
					onResized: equalizeHeights,
					onRefreshed: equalizeHeights
				});

				function equalizeHeights() {
					setTimeout(function() {
						var maxHeight = 0;
						var items = $carousel.find('.awea-blog-card');
						
						items.css('height', 'auto'); 
						items.each(function () {
							var currentHeight = $(this).outerHeight();
							if (currentHeight > maxHeight) {
								maxHeight = currentHeight;
							}
						});
						
						if (maxHeight > 0) {
							items.css('height', maxHeight + 'px');
						}
					}, 100);
				}
			});
		});
		</script>
		<?php
	}
}