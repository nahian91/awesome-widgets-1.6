<?php
/**
 * Awesome Testimonials Carousel Studio Widget (Zero-Shadow Architectural Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Testimonials_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-testimonials-carousel';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'awea-icon eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'reviews', 'testimonials', 'carousel', 'slider', 'rating' ];
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
			'awea_testimonials_carousel_section_items',
			[
				'label' => esc_html__( 'Testimonials List', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_testimonials_carousel_item_tabs' );

		// --- TAB 1: REVIEW ---
		$repeater->start_controls_tab(
			'awea_testimonials_carousel_tab_review',
			[ 'label' => esc_html__( 'Review', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_rating',
			[
				'label'   => esc_html__( 'Rating Stars', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'0' => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'1' => '1 Star',
					'2' => '2 Stars',
					'3' => '3 Stars',
					'4' => '4 Stars',
					'5' => '5 Stars',
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_speech',
			[
				'label'       => esc_html__( 'Quote', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: AUTHOR ---
		$repeater->start_controls_tab(
			'awea_testimonials_carousel_tab_author',
			[ 'label' => esc_html__( 'Author', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_image',
			[
				'label'   => esc_html__( 'Avatar Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_name',
			[
				'label'       => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_desg',
			[
				'label'       => esc_html__( 'Role / Company', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_verified',
			[
				'label'        => esc_html__( 'Verified Customer', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_testimonials_carousel_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_item_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_carousel_item_beam',
			[
				'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea_testimonials_carousel_item_beam: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_testimonials_carousel_list',
			[
				'label'       => esc_html__( 'Reviews List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_testimonials_carousel_name }}} — {{{ awea_testimonials_carousel_desg }}}',
				'default'     => [
					[
						'awea_testimonials_carousel_name'   => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg'   => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'The architectural depth and kinetic physics transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => '5',
					],
					[
						'awea_testimonials_carousel_name'   => esc_html__( 'Maria Sauks', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg'   => esc_html__( 'Senior Engineer', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Its impressed me on multiple levels. Painless, pleasant, and most of all hassle free! Id be lost without it.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => '5',
					],
					[
						'awea_testimonials_carousel_name'   => esc_html__( 'Sarah Heinsed', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_desg'   => esc_html__( 'Product Strategist', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_speech' => esc_html__( 'Incredible craftsmanship and attention to detail. Our conversion rates jumped 32% since rollout.', 'awesome-widgets-elementor' ),
						'awea_testimonials_carousel_rating' => '5',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_section_settings',
			[
				'label' => esc_html__( 'Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_name_tag',
			[
				'label'   => esc_html__( 'Name HTML Tag', 'awesome-widgets-elementor' ),
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
			'awea_testimonials_carousel_show_quote_icon',
			[
				'label'        => esc_html__( 'Watermark Quote Icon', 'awesome-widgets-elementor' ),
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
			'awea_testimonials_carousel_section_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_slides_to_show',
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
			'awea_testimonials_carousel_slide_gap',
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
			'awea_testimonials_carousel_loop',
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
			'awea_testimonials_carousel_autoplay',
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
			'awea_testimonials_carousel_pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_testimonials_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_testimonials_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_animation_speed',
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
			'awea_testimonials_carousel_section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_show_arrows',
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
			'awea_testimonials_carousel_show_dots',
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

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_style_card',
			[
				'label' => esc_html__( 'Card Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '36', 'right' => '36', 'bottom' => '36', 'left' => '36', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_carousel_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_carousel_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_testimonials_carousel_card_state_tabs' );

		$this->start_controls_tab(
			'awea_testimonials_carousel_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_testimonials_carousel_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_testimonials_carousel_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_testimonials_carousel_card',
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
			'awea_testimonials_carousel_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_testimonials_carousel_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Kinetic Beam
		$this->add_control(
			'awea_testimonials_carousel_beam_heading',
			[
				'label'     => esc_html__( 'Kinetic Beam', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_enable_beam',
			[
				'label'        => esc_html__( 'Enable Beam', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_testimonials_carousel_beam_',
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_beam_color',
			[
				'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_card' => '--awea_testimonials_carousel_beam: {{VALUE}};',
				],
				'condition' => [ 'awea_testimonials_carousel_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STARS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_style_stars',
			[
				'label' => esc_html__( 'Rating Stars', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_star_size',
			[
				'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_carousel_stars i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_star_filled_color',
			[
				'label'     => esc_html__( 'Filled Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_stars .awea_testimonials_carousel_star_filled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_star_empty_color',
			[
				'label'     => esc_html__( 'Empty Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_stars .awea_testimonials_carousel_star_empty' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_style_speech',
			[
				'label' => esc_html__( 'Quote Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_speech_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_carousel_speech_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_testimonials_carousel_text',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. AUTHOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_style_author',
			[
				'label' => esc_html__( 'Author Footer', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_avatar_size',
			[
				'label'      => esc_html__( 'Avatar Photo Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_carousel_avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_carousel_name_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_testimonials_carousel_name',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_desg_color',
			[
				'label'     => esc_html__( 'Role Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_desg' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_carousel_desg_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_testimonials_carousel_desg',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. ARROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_carousel_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_testimonials_carousel_show_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_carousel_arrow_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_arrow_bg',
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
				'name'           => 'awea_testimonials_carousel_arrow_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea-carousel-arrow-border',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
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
			'awea_testimonials_carousel_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_testimonials_carousel_show_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_dots_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_wrap .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_carousel_dots_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_carousel_wrap .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['awea_testimonials_carousel_list'] ?? [];

		if ( empty( $items ) ) {
			return;
		}

		$items_desktop = ! empty( $settings['awea_testimonials_carousel_slides_to_show'] ) ? (int) $settings['awea_testimonials_carousel_slides_to_show'] : 3;
		$items_tablet  = ! empty( $settings['awea_testimonials_carousel_slides_to_show_tablet'] ) ? (int) $settings['awea_testimonials_carousel_slides_to_show_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_testimonials_carousel_slides_to_show_mobile'] ) ? (int) $settings['awea_testimonials_carousel_slides_to_show_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_testimonials_carousel_slide_gap']['size'] ) && '' !== $settings['awea_testimonials_carousel_slide_gap']['size'] ? (int) $settings['awea_testimonials_carousel_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_testimonials_carousel_slide_gap_tablet']['size'] ) && '' !== $settings['awea_testimonials_carousel_slide_gap_tablet']['size'] ? (int) $settings['awea_testimonials_carousel_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_testimonials_carousel_slide_gap_mobile']['size'] ) && '' !== $settings['awea_testimonials_carousel_slide_gap_mobile']['size'] ? (int) $settings['awea_testimonials_carousel_slide_gap_mobile']['size'] : 16;

		$show_arrows = ( 'yes' === ( $settings['awea_testimonials_carousel_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$show_dots   = ( 'yes' === ( $settings['awea_testimonials_carousel_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop        = ( 'yes' === ( $settings['awea_testimonials_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay    = ( 'yes' === ( $settings['awea_testimonials_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause       = ( 'yes' === ( $settings['awea_testimonials_carousel_pause_on_hover'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed  = ! empty( $settings['awea_testimonials_carousel_autoplay_speed'] ) ? (int) $settings['awea_testimonials_carousel_autoplay_speed'] : 5000;
		$anim_speed  = ! empty( $settings['awea_testimonials_carousel_animation_speed'] ) ? (int) $settings['awea_testimonials_carousel_animation_speed'] : 450;

		$has_beam  = 'yes' === ( $settings['awea_testimonials_carousel_enable_beam'] ?? 'no' );
		$has_quote = 'yes' === ( $settings['awea_testimonials_carousel_show_quote_icon'] ?? 'no' );
		$name_tag  = Utils::validate_html_tag( $settings['awea_testimonials_carousel_name_tag'] ?? 'h4' );
		$widget_id = $this->get_id();
		?>
		<div class="awea_testimonials_carousel_wrap" id="awea_testimonials_carousel_wrap_<?php echo esc_attr( $widget_id ); ?>">
			<div class="awea_testimonials_carousel owl-carousel"
				 id="awea_testimonials_carousel_<?php echo esc_attr( $widget_id ); ?>"
				 data-awea_testimonials_carousel_items_desktop="<?php echo esc_attr( (string) $items_desktop ); ?>"
				 data-awea_testimonials_carousel_items_tablet="<?php echo esc_attr( (string) $items_tablet ); ?>"
				 data-awea_testimonials_carousel_items_mobile="<?php echo esc_attr( (string) $items_mobile ); ?>"
				 data-awea_testimonials_carousel_gap_desktop="<?php echo esc_attr( (string) $gap_desktop ); ?>"
				 data-awea_testimonials_carousel_gap_tablet="<?php echo esc_attr( (string) $gap_tablet ); ?>"
				 data-awea_testimonials_carousel_gap_mobile="<?php echo esc_attr( (string) $gap_mobile ); ?>"
				 data-awea_testimonials_carousel_arrows="<?php echo esc_attr( $show_arrows ); ?>"
				 data-awea_testimonials_carousel_dots="<?php echo esc_attr( $show_dots ); ?>"
				 data-awea_testimonials_carousel_loop="<?php echo esc_attr( $loop ); ?>"
				 data-awea_testimonials_carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-awea_testimonials_carousel_pause="<?php echo esc_attr( $pause ); ?>"
				 data-awea_testimonials_carousel_speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-awea_testimonials_carousel_timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php
				foreach ( $items as $index => $item ) :
					$id          = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
					$avatar_item = $item['awea_testimonials_carousel_image'] ?? [];
					$avatar_url  = ! empty( $avatar_item['url'] ) ? $avatar_item['url'] : Utils::get_placeholder_image_src();
					$name        = ! empty( $item['awea_testimonials_carousel_name'] ) ? $item['awea_testimonials_carousel_name'] : esc_html__( 'Anonymous', 'awesome-widgets-elementor' );
					$desg        = $item['awea_testimonials_carousel_desg'] ?? '';
					$speech      = $item['awea_testimonials_carousel_speech'] ?? '';
					$rating      = isset( $item['awea_testimonials_carousel_rating'] ) ? absint( $item['awea_testimonials_carousel_rating'] ) : 5;
					$is_verified = 'yes' === ( $item['awea_testimonials_carousel_verified'] ?? 'no' );

					$card_classes = [ 'awea_testimonials_carousel_card', 'elementor-repeater-item-' . esc_attr( $id ) ];
					if ( $has_beam ) {
						$card_classes[] = 'awea_testimonials_carousel_has_beam';
					}
					?>
					<div class="awea_testimonials_carousel_slide">
						<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

							<?php if ( $has_quote ) : ?>
								<svg class="awea_testimonials_carousel_quote_brand" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
								</svg>
							<?php endif; ?>

							<?php if ( $rating > 0 ) : ?>
								<?php
								/* translators: %s: star rating value (e.g. 5) */
								$rating_label = sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating );
								?>
								<div class="awea_testimonials_carousel_stars" aria-label="<?php echo esc_attr( $rating_label ); ?>">
									<?php
									for ( $i = 1; $i <= 5; $i++ ) {
										$star_class = ( $i <= $rating ) ? 'fas fa-star awea_testimonials_carousel_star_filled' : 'far fa-star awea_testimonials_carousel_star_empty';
										echo '<i class="' . esc_attr( $star_class ) . '" aria-hidden="true"></i>';
									}
									?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $speech ) ) : ?>
								<blockquote class="awea_testimonials_carousel_text">
									&ldquo;<?php echo wp_kses_post( $speech ); ?>&rdquo;
								</blockquote>
							<?php endif; ?>

							<div class="awea_testimonials_carousel_footer">
								<?php if ( ! empty( $avatar_url ) ) : ?>
									<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="awea_testimonials_carousel_avatar" loading="lazy" />
								<?php endif; ?>
								
								<div class="awea_testimonials_carousel_meta">
									<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea_testimonials_carousel_name"><?php echo esc_html( $name ); ?></<?php Utils::print_validated_html_tag( $name_tag ); ?>>
									<?php if ( ! empty( $desg ) ) : ?>
										<cite class="awea_testimonials_carousel_desg"><?php echo esc_html( $desg ); ?></cite>
									<?php endif; ?>
								</div>

								<?php if ( $is_verified ) : ?>
									<div class="awea_testimonials_carousel_verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="20 6 9 17 4 12"></polyline>
										</svg>
									</div>
								<?php endif; ?>
							</div>

						</article>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<script>
		(function($) {
			function awea_testimonials_carousel_init(wrapper) {
				if (!wrapper || !$) return;
				var $carousel = $(wrapper).find('.awea_testimonials_carousel');
				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

				if ($carousel.hasClass('owl-loaded')) {
					$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
					$carousel.find('.owl-stage-outer').children().unwrap();
					$carousel.find('.owl-item').children().unwrap();
				}

				var itemsDesktop = parseInt($carousel.attr('data-awea_testimonials_carousel_items_desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.attr('data-awea_testimonials_carousel_items_tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.attr('data-awea_testimonials_carousel_items_mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.attr('data-awea_testimonials_carousel_gap_desktop'), 10);
				var gapTablet    = parseInt($carousel.attr('data-awea_testimonials_carousel_gap_tablet'), 10);
				var gapMobile    = parseInt($carousel.attr('data-awea_testimonials_carousel_gap_mobile'), 10);

				if (isNaN(gapDesktop)) gapDesktop = 24;
				if (isNaN(gapTablet)) gapTablet = 20;
				if (isNaN(gapMobile)) gapMobile = 16;

				var slideCount = $carousel.children('div').length;
				var loop       = $carousel.attr('data-awea_testimonials_carousel_loop') === 'yes';
				var allowLoop  = loop && (slideCount > itemsDesktop);

				function equalizeHeights() {
					requestAnimationFrame(function() {
						var maxHeight = 0;
						var $items = $carousel.find('.awea_testimonials_carousel_card');
						$items.css('height', 'auto');
						$items.each(function () {
							var h = $(this).outerHeight();
							if (h > maxHeight) maxHeight = h;
						});
						if (maxHeight > 0) $items.css('height', maxHeight + 'px');
					});
				}

				$carousel.owlCarousel({
					rtl: document.dir === 'rtl',
					nav: $carousel.attr('data-awea_testimonials_carousel_arrows') === 'yes',
					dots: $carousel.attr('data-awea_testimonials_carousel_dots') === 'yes',
					loop: allowLoop,
					autoplay: $carousel.attr('data-awea_testimonials_carousel_autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.attr('data-awea_testimonials_carousel_timeout'), 10) || 5000,
					smartSpeed: parseInt($carousel.attr('data-awea_testimonials_carousel_speed'), 10) || 450,
					autoplayHoverPause: $carousel.attr('data-awea_testimonials_carousel_pause') === 'yes',
					navText: [
						'<button type="button" class="awea_testimonials_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Previous', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>',
						'<button type="button" class="awea_testimonials_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Next', 'awesome-widgets-elementor' ) ); ?>"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>'
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
				var el = document.getElementById('awea_testimonials_carousel_wrap_<?php echo esc_js( $widget_id ); ?>');
				if (el) {
					awea_testimonials_carousel_init(el);
				}
			});

			if (!window.awea_testimonials_carousel_hooked) {
				window.awea_testimonials_carousel_hooked = true;
				$(window).on('elementor/frontend/init', function() {
					if (window.elementorFrontend && window.elementorFrontend.hooks) {
						window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-testimonials-carousel.default', function($scope) {
							var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_testimonials_carousel_wrap') : null;
							awea_testimonials_carousel_init(el);
						});
					}
				});
			}
		})(jQuery);
		</script>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		if ( ! settings.awea_testimonials_carousel_list || ! settings.awea_testimonials_carousel_list.length ) {
			return;
		}
		var hasQuote = 'yes' === settings.awea_testimonials_carousel_show_quote_icon;
		var nameTag  = elementor.helpers.validateHTMLTag( settings.awea_testimonials_carousel_name_tag || 'h4' );
		var hasBeam  = 'yes' === settings.awea_testimonials_carousel_enable_beam;
		var cardCls  = 'awea_testimonials_carousel_card' + ( hasBeam ? ' awea_testimonials_carousel_has_beam' : '' );
		#>
		<div class="awea_testimonials_carousel_wrap">
			<div class="awea_testimonials_carousel owl-carousel">
				<# _.each( settings.awea_testimonials_carousel_list, function( item, index ) {
					var id        = item._id || index;
					var rating    = parseInt( item.awea_testimonials_carousel_rating, 10 ) || 0;
					var speech    = item.awea_testimonials_carousel_speech || '';
					var name      = item.awea_testimonials_carousel_name || 'Anonymous';
					var desg      = item.awea_testimonials_carousel_desg || '';
					var verified  = 'yes' === item.awea_testimonials_carousel_verified;

					var imageObj = {
						id: item.awea_testimonials_carousel_image ? item.awea_testimonials_carousel_image.id : '',
						url: item.awea_testimonials_carousel_image ? item.awea_testimonials_carousel_image.url : '',
						size: 'thumbnail',
						dimension: [],
						model: view.getEditModel()
					};
					var avatarUrl = elementor.imagesManager.getImageUrl( imageObj ) || '<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>';
				#>
					<div class="awea_testimonials_carousel_slide">
						<article class="{{ cardCls }} elementor-repeater-item-{{ id }}">
							<# if ( hasQuote ) { #>
								<svg class="awea_testimonials_carousel_quote_brand" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
								</svg>
							<# } #>

							<# if ( rating > 0 ) { #>
								<div class="awea_testimonials_carousel_stars">
									<# for ( var i = 1; i <= 5; i++ ) { #>
										<i class="{{ i <= rating ? 'fas fa-star awea_testimonials_carousel_star_filled' : 'far fa-star awea_testimonials_carousel_star_empty' }}" aria-hidden="true"></i>
									<# } #>
								</div>
							<# } #>

							<# if ( speech ) { #>
								<blockquote class="awea_testimonials_carousel_text">&ldquo;{{{ speech }}}&rdquo;</blockquote>
							<# } #>

							<div class="awea_testimonials_carousel_footer">
								<# if ( avatarUrl ) { #>
									<img src="{{ avatarUrl }}" alt="{{ name }}" class="awea_testimonials_carousel_avatar" />
								<# } #>
								
								<div class="awea_testimonials_carousel_meta">
									<{{{ nameTag }}} class="awea_testimonials_carousel_name">{{{ name }}}</{{{ nameTag }}}>
									<# if ( desg ) { #>
										<cite class="awea_testimonials_carousel_desg">{{{ desg }}}</cite>
									<# } #>
								</div>

								<# if ( verified ) { #>
									<div class="awea_testimonials_carousel_verify" aria-hidden="true">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
											<polyline points="20 6 9 17 4 12"></polyline>
										</svg>
									</div>
								<# } #>
							</div>
						</article>
					</div>
				<# } ); #>
			</div>
		</div>
		<?php
	}
}