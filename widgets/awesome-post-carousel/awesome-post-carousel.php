<?php
/**
 * Awesome Post Carousel Studio Widget (Zero-Shadow Architectural Edition).
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
		return [ 'awea', 'post', 'carousel', 'slider', 'blog', 'articles', 'feed' ];
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
			'awea_post_carousel_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_carousel_posts_per_page',
			[
				'label'   => esc_html__( 'Posts Count', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_post_carousel_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_orderby',
			[
				'label'   => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Date', 'awesome-widgets-elementor' ),
					'title'         => esc_html__( 'Title', 'awesome-widgets-elementor' ),
					'modified'      => esc_html__( 'Modified', 'awesome-widgets-elementor' ),
					'comment_count' => esc_html__( 'Comments', 'awesome-widgets-elementor' ),
					'rand'          => esc_html__( 'Random', 'awesome-widgets-elementor' ),
				],
			]
		);

		$cat_options = [];
		$categories  = get_categories( [ 'hide_empty' => false ] );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cat_options[ $cat->term_id ] = $cat->name;
			}
		}

		$this->add_control(
			'awea_post_carousel_include_categories',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_section_elements',
			[
				'label' => esc_html__( 'Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_carousel_show_category',
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
			'awea_post_carousel_show_date',
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
			'awea_post_carousel_show_reading_time',
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
			'awea_post_carousel_show_counter',
			[
				'label'        => esc_html__( 'Index Number (01, 02...)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_carousel_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. EXCERPT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_section_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_carousel_show_excerpt',
			[
				'label'        => esc_html__( 'Display Excerpt', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_carousel_excerpt_length',
			[
				'label'     => esc_html__( 'Word Length', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'min'       => 5,
				'max'       => 100,
				'condition' => [ 'awea_post_carousel_show_excerpt' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_section_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_carousel_show_button',
			[
				'label'        => esc_html__( 'Display Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_carousel_button_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Article', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_post_carousel_show_button' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. CAROUSEL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_section_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_slides_per_view',
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
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_slide_gap',
			[
				'label'          => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'range'          => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'        => [ 'unit' => 'px', 'size' => 24 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 20 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 16 ],
			]
		);

		$this->add_control(
			'awea_post_carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_carousel_autoplay',
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
			'awea_post_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'condition' => [ 'awea_post_carousel_autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 6. NAVIGATION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_carousel_arrows',
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
			'awea_post_carousel_dots',
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
			'awea_post_carousel_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_carousel_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_carousel_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_footer_divider',
			[
				'label'     => esc_html__( 'Footer Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_post_carousel_card_tabs' );

		$this->start_controls_tab(
			'awea_post_carousel_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_post_carousel_card_border',
				'selector'       => '{{WRAPPER}} .awea_post_carousel_card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_post_carousel_card_shadow',
				'selector' => '{{WRAPPER}} .awea_post_carousel_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_carousel_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_post_carousel_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_post_carousel_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_img_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/10' => '16:10',
					'16/9'  => '16:9',
					'4/3'   => '4:3',
					'1/1'   => '1:1',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_img_wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_img_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_carousel_img_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_carousel_img_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_carousel_img_wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE & META
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_style_badge',
			[
				'label'     => esc_html__( 'Category Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_carousel_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_carousel_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_carousel_badge_typo',
				'selector' => '{{WRAPPER}} .awea_post_carousel_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_carousel_style_meta',
			[
				'label' => esc_html__( 'Post Meta', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_post_carousel_meta_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_carousel_meta_typo',
				'selector' => '{{WRAPPER}} .awea_post_carousel_meta',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE & EXCERPT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_carousel_title_typo',
				'selector' => '{{WRAPPER}} .awea_post_carousel_title a',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->start_controls_tabs( 'awea_post_carousel_title_tabs' );

		$this->start_controls_tab(
			'awea_post_carousel_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_carousel_title_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_title_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_title a:hover, {{WRAPPER}} .awea_post_carousel_title a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_carousel_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_carousel_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_carousel_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_carousel_desc_typo',
				'selector' => '{{WRAPPER}} .awea_post_carousel_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. COUNTER & BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_style_counter',
			[
				'label'     => esc_html__( 'Index Number', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_carousel_show_counter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_carousel_counter_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_carousel_style_button',
			[
				'label'     => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_carousel_show_button' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_carousel_btn_typo',
				'selector' => '{{WRAPPER}} .awea_post_carousel_link',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->start_controls_tabs( 'awea_post_carousel_btn_tabs' );

		$this->start_controls_tab(
			'awea_post_carousel_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_carousel_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_carousel_btn_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_card:hover .awea_post_carousel_link, {{WRAPPER}} .awea_post_carousel_link:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_btn_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_card:hover .awea_post_carousel_link, {{WRAPPER}} .awea_post_carousel_link:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. NAVIGATION & DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_carousel_style_nav',
			[
				'label' => esc_html__( 'Navigation & Dots', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_post_carousel_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'condition' => [ 'awea_post_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_arrow_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_arrow_bg',
			[
				'label'     => esc_html__( 'Arrow Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => [ 'awea_post_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_arrow_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_arrow_hover_bg',
			[
				'label'     => esc_html__( 'Arrow Hover Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_post_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel_arrow_btn:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}}; color: #ffffff;',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_dot_color',
			[
				'label'     => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'separator' => 'before',
				'condition' => [ 'awea_post_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_carousel_dot_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_post_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$num_posts    = ! empty( $settings['awea_post_carousel_posts_per_page'] ) ? absint( $settings['awea_post_carousel_posts_per_page'] ) : 6;
		$order        = in_array( $settings['awea_post_carousel_order'] ?? 'DESC', [ 'ASC', 'DESC' ], true ) ? $settings['awea_post_carousel_order'] : 'DESC';
		$orderby      = $settings['awea_post_carousel_orderby'] ?? 'date';
		$categories   = $settings['awea_post_carousel_include_categories'] ?? [];
		$show_cat     = 'yes' === ( $settings['awea_post_carousel_show_category'] ?? 'no' );
		$show_date    = 'yes' === ( $settings['awea_post_carousel_show_date'] ?? 'no' );
		$show_read    = 'yes' === ( $settings['awea_post_carousel_show_reading_time'] ?? 'no' );
		$show_exc     = 'yes' === ( $settings['awea_post_carousel_show_excerpt'] ?? 'no' );
		$exc_len      = ! empty( $settings['awea_post_carousel_excerpt_length'] ) ? absint( $settings['awea_post_carousel_excerpt_length'] ) : 14;
		$show_btn     = 'yes' === ( $settings['awea_post_carousel_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_post_carousel_button_text'] ?? esc_html__( 'Read Article', 'awesome-widgets-elementor' );
		$show_counter = 'yes' === ( $settings['awea_post_carousel_show_counter'] ?? 'no' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_post_carousel_title_tag'] ?? 'h3' );

		$items_desktop = ! empty( $settings['awea_post_carousel_slides_per_view'] ) ? (int) $settings['awea_post_carousel_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_post_carousel_slides_per_view_tablet'] ) ? (int) $settings['awea_post_carousel_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_post_carousel_slides_per_view_mobile'] ) ? (int) $settings['awea_post_carousel_slides_per_view_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_post_carousel_slide_gap']['size'] ) && '' !== $settings['awea_post_carousel_slide_gap']['size'] ? (int) $settings['awea_post_carousel_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_post_carousel_slide_gap_tablet']['size'] ) && '' !== $settings['awea_post_carousel_slide_gap_tablet']['size'] ? (int) $settings['awea_post_carousel_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_post_carousel_slide_gap_mobile']['size'] ) && '' !== $settings['awea_post_carousel_slide_gap_mobile']['size'] ? (int) $settings['awea_post_carousel_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_post_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_post_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_post_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_post_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_post_carousel_autoplay_speed'] ) ? absint( $settings['awea_post_carousel_autoplay_speed'] ) : 5000;
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

		if ( ! $query->have_posts() ) {
			echo '<p class="awea_post_carousel_no_posts">' . esc_html__( 'No posts found matching your criteria.', 'awesome-widgets-elementor' ) . '</p>';
			return;
		}
		?>
		<div class="awea_post_carousel_wrap">
			<div class="awea_post_carousel owl-carousel"
				 id="awea_post_carousel_<?php echo esc_attr( $widget_id ); ?>"
				 data-awea_post_carousel_items_desktop="<?php echo esc_attr( (string) $items_desktop ); ?>"
				 data-awea_post_carousel_items_tablet="<?php echo esc_attr( (string) $items_tablet ); ?>"
				 data-awea_post_carousel_items_mobile="<?php echo esc_attr( (string) $items_mobile ); ?>"
				 data-awea_post_carousel_gap_desktop="<?php echo esc_attr( (string) $gap_desktop ); ?>"
				 data-awea_post_carousel_gap_tablet="<?php echo esc_attr( (string) $gap_tablet ); ?>"
				 data-awea_post_carousel_gap_mobile="<?php echo esc_attr( (string) $gap_mobile ); ?>"
				 data-awea_post_carousel_arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-awea_post_carousel_dots="<?php echo esc_attr( $dots ); ?>"
				 data-awea_post_carousel_loop="<?php echo esc_attr( $loop ); ?>"
				 data-awea_post_carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-awea_post_carousel_timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php
				$counter = 1;
				while ( $query->have_posts() ) :
					$query->the_post();
					$post_id      = get_the_ID();
					$content      = get_post_field( 'post_content', $post_id );
					$word_count   = str_word_count( wp_strip_all_tags( $content ) );
					$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
					$post_cats    = get_the_category( $post_id );
					$permalink    = get_the_permalink( $post_id );
					?>
					<div class="awea_post_carousel_slide">
						<article class="awea_post_carousel_card">

							<div class="awea_post_carousel_img_wrap">
								<?php if ( $show_cat && ! empty( $post_cats ) ) : ?>
									<span class="awea_post_carousel_badge"><?php echo esc_html( $post_cats[0]->name ); ?></span>
								<?php endif; ?>

								<a href="<?php echo esc_url( $permalink ); ?>" class="awea_post_carousel_img_link" aria-label="<?php the_title_attribute(); ?>">
									<?php if ( has_post_thumbnail( $post_id ) ) : ?>
										<?php echo get_the_post_thumbnail( $post_id, 'large', [ 'class' => 'awea_post_carousel_img', 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea_post_carousel_img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
									<?php endif; ?>
								</a>
							</div>

							<div class="awea_post_carousel_body">
								<?php if ( $show_date || $show_read ) : ?>
									<div class="awea_post_carousel_meta">
										<?php if ( $show_date ) : ?>
											<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>"><?php echo esc_html( get_the_date( 'M d, Y', $post_id ) ); ?></time>
										<?php endif; ?>

										<?php if ( $show_date && $show_read ) : ?>
											<span class="awea_post_carousel_meta_dot" aria-hidden="true">•</span>
										<?php endif; ?>

										<?php if ( $show_read ) : ?>
											<span>
												<?php
												/* translators: %d: estimated reading time in minutes */
												echo esc_html( sprintf( __( '%d MIN READ', 'awesome-widgets-elementor' ), $reading_time ) );
												?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_post_carousel_title">
									<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( $show_exc ) : ?>
									<p class="awea_post_carousel_desc">
										<?php echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), $exc_len, '...' ) ); ?>
									</p>
								<?php endif; ?>
							</div>

							<?php if ( ( $show_btn && ! empty( $btn_text ) ) || $show_counter ) : ?>
								<div class="awea_post_carousel_footer">
									<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
										<a href="<?php echo esc_url( $permalink ); ?>" class="awea_post_carousel_link">
											<span><?php echo esc_html( $btn_text ); ?></span>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
										</a>
									<?php endif; ?>

									<?php if ( $show_counter ) : ?>
										<span class="awea_post_carousel_num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $counter ) ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</article>
					</div>
					<?php
					$counter++;
				endwhile;
				wp_reset_postdata();
				?>

			</div>
		</div>

		<script>
		(function($) {
			function awea_post_carousel_init($scope) {
				var $carousel = $scope ? $scope.find('.awea_post_carousel') : $('#awea_post_carousel_<?php echo esc_js( $widget_id ); ?>');
				if (!$carousel.length || $carousel.data('aweaPostCarouselBound') === 1 || typeof $carousel.owlCarousel !== 'function') return;
				$carousel.data('aweaPostCarouselBound', 1);

				var itemsDesktop = parseInt($carousel.attr('data-awea_post_carousel_items_desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.attr('data-awea_post_carousel_items_tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.attr('data-awea_post_carousel_items_mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.attr('data-awea_post_carousel_gap_desktop'), 10);
				var gapTablet    = parseInt($carousel.attr('data-awea_post_carousel_gap_tablet'), 10);
				var gapMobile    = parseInt($carousel.attr('data-awea_post_carousel_gap_mobile'), 10);

				if (isNaN(gapDesktop)) gapDesktop = 24;
				if (isNaN(gapTablet)) gapTablet = 20;
				if (isNaN(gapMobile)) gapMobile = 16;

				var slideCount = $carousel.children('.awea_post_carousel_slide').length;
				var allowLoop  = ($carousel.attr('data-awea_post_carousel_loop') === 'yes') && (slideCount > itemsDesktop);

				function equalizeHeights() {
					requestAnimationFrame(function() {
						var maxHeight = 0;
						var $items = $carousel.find('.awea_post_carousel_card');
						$items.css('height', 'auto');
						$items.each(function() {
							var h = $(this).outerHeight();
							if (h > maxHeight) maxHeight = h;
						});
						if (maxHeight > 0) $items.css('height', maxHeight + 'px');
					});
				}

				$carousel.owlCarousel({
					rtl: document.dir === 'rtl',
					nav: $carousel.attr('data-awea_post_carousel_arrows') === 'yes',
					dots: $carousel.attr('data-awea_post_carousel_dots') === 'yes',
					loop: allowLoop,
					autoplay: $carousel.attr('data-awea_post_carousel_autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.attr('data-awea_post_carousel_timeout'), 10) || 5000,
					smartSpeed: 450,
					autoplayHoverPause: true,
					navText: [
						'<span class="awea_post_carousel_arrow_btn" aria-label="<?php echo esc_js( __( 'Previous', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-left" aria-hidden="true"></i></span>',
						'<span class="awea_post_carousel_arrow_btn" aria-label="<?php echo esc_js( __( 'Next', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>'
					],
					responsive: {
						0: { items: itemsMobile, margin: gapMobile },
						768: { items: itemsTablet, margin: gapTablet },
						1025: { items: itemsDesktop, margin: gapDesktop }
					},
					onInitialized: equalizeHeights,
					onResized: equalizeHeights,
					onRefreshed: equalizeHeights
				});
			}

			$(function() {
				awea_post_carousel_init(null);
			});

			if (!window.awea_post_carousel_hooked) {
				window.awea_post_carousel_hooked = true;
				$(window).on('elementor/frontend/init', function() {
					if (window.elementorFrontend && window.elementorFrontend.hooks) {
						window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-post-carousel.default', function($scope) {
							awea_post_carousel_init($scope);
						});
					}
				});
			}
		})(jQuery);
		</script>
		<?php
	}
}