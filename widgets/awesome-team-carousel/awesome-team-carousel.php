<?php
/**
 * Awesome Team Carousel Studio Widget (Zero-Shadow Architectural Edition).
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Team_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-team-carousel';
	}

	public function get_title() {
		return esc_html__( 'Team Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'awea-icon eicon-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'team', 'carousel', 'slider', 'member', 'profile' ];
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
			'awea_team_carousel_section_items',
			[
				'label' => esc_html__( 'Team Members', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_team_carousel_member_tabs' );

		// --- TAB 1: PROFILE ---
		$repeater->start_controls_tab(
			'awea_team_carousel_tab_profile',
			[ 'label' => esc_html__( 'Profile', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_team_carousel_image',
			[
				'label'   => esc_html__( 'Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_team_carousel_name',
			[
				'label'       => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_team_carousel_role',
			[
				'label'       => esc_html__( 'Role', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_team_carousel_bio',
			[
				'label'   => esc_html__( 'Bio', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Pioneering clean architectural design systems and kinetic user interfaces.', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: SOCIALS ---
		$repeater->start_controls_tab(
			'awea_team_carousel_tab_socials',
			[ 'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_team_carousel_ln_url',
			[
				'label'       => esc_html__( 'LinkedIn URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://linkedin.com/in/username',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_team_carousel_tw_url',
			[
				'label'       => esc_html__( 'X (Twitter) URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://x.com/username',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_team_carousel_fb_url',
			[
				'label'       => esc_html__( 'Facebook URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://facebook.com/username',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_team_carousel_insta_url',
			[
				'label'       => esc_html__( 'Instagram URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://instagram.com/username',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_team_carousel_members',
			[
				'label'       => esc_html__( 'Members List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_team_carousel_name }}} — {{{ awea_team_carousel_role }}}',
				'default'     => [
					[
						'awea_team_carousel_name'    => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
						'awea_team_carousel_role'    => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
						'awea_team_carousel_bio'     => esc_html__( 'Pioneering clean architectural design systems and kinetic interfaces.', 'awesome-widgets-elementor' ),
						'awea_team_carousel_ln_url'  => [ 'url' => '#' ],
						'awea_team_carousel_tw_url'  => [ 'url' => '#' ],
						'awea_team_carousel_fb_url'  => [ 'url' => '#' ],
					],
					[
						'awea_team_carousel_name'      => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_team_carousel_role'      => esc_html__( 'Senior Product Designer', 'awesome-widgets-elementor' ),
						'awea_team_carousel_bio'       => esc_html__( 'Specializing in design tokens, accessible color theory, and user journeys.', 'awesome-widgets-elementor' ),
						'awea_team_carousel_ln_url'    => [ 'url' => '#' ],
						'awea_team_carousel_tw_url'    => [ 'url' => '#' ],
						'awea_team_carousel_insta_url' => [ 'url' => '#' ],
					],
					[
						'awea_team_carousel_name'    => esc_html__( 'Julian Szekeres', 'awesome-widgets-elementor' ),
						'awea_team_carousel_role'    => esc_html__( 'Core Systems Engineer', 'awesome-widgets-elementor' ),
						'awea_team_carousel_bio'     => esc_html__( 'Optimizing micro-service pipelines and real-time state hydration routines.', 'awesome-widgets-elementor' ),
						'awea_team_carousel_ln_url'  => [ 'url' => '#' ],
						'awea_team_carousel_tw_url'  => [ 'url' => '#' ],
						'awea_team_carousel_fb_url'  => [ 'url' => '#' ],
					],
					[
						'awea_team_carousel_name'      => esc_html__( 'Clara Lindqvist', 'awesome-widgets-elementor' ),
						'awea_team_carousel_role'      => esc_html__( 'Head of Brand Strategy', 'awesome-widgets-elementor' ),
						'awea_team_carousel_bio'       => esc_html__( 'Crafting cohesive visual identities and editorial storytelling across platforms.', 'awesome-widgets-elementor' ),
						'awea_team_carousel_ln_url'    => [ 'url' => '#' ],
						'awea_team_carousel_insta_url' => [ 'url' => '#' ],
						'awea_team_carousel_fb_url'    => [ 'url' => '#' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_section_settings',
			[
				'label' => esc_html__( 'Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_team_carousel_img_size',
				'default' => 'large',
			]
		);

		$this->add_control(
			'awea_team_carousel_name_tag',
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
			'awea_team_carousel_social_visible',
			[
				'label'        => esc_html__( 'Always Show Social Dock', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SLIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_section_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_slides_to_show',
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
			'awea_team_carousel_slide_gap',
			[
				'label'      => esc_html__( 'Slide Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_team_carousel_loop',
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
			'awea_team_carousel_autoplay',
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
			'awea_team_carousel_pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_team_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_team_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'condition' => [ 'awea_team_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_team_carousel_animation_speed',
			[
				'label'   => esc_html__( 'Transition Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 100,
				'max'     => 2000,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. NAVIGATION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_section_navigation',
			[
				'label' => esc_html__( 'Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_team_carousel_show_arrows',
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
			'awea_team_carousel_show_dots',
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
			'awea_team_carousel_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_master_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_master_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_team_carousel_card_tabs' );

		$this->start_controls_tab(
			'awea_team_carousel_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#090d16',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_master_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_team_carousel_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_team_carousel_master_card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.08)' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_team_carousel_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_master_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_master_card:hover' => 'border-color: {{VALUE}};',
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
			'awea_team_carousel_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1',
					'4/5'  => '4:5',
					'3/4'  => '3:4',
					'16/9' => '16:9',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_img_container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_photo_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_img_container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. DOCK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_dock',
			[
				'label' => esc_html__( 'Content Dock', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_team_carousel_dock_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.76)',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_info_panel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_team_carousel_dock_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_team_carousel_info_panel',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.14)' ],
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_dock_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_info_panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_dock_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_info_panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_title',
			[
				'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_team_carousel_name_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_team_carousel_name_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_team_carousel_name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. ROLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_role',
			[
				'label' => esc_html__( 'Role', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_team_carousel_role_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_team_carousel_role_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_team_carousel_role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BIO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_bio',
			[
				'label' => esc_html__( 'Bio', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_team_carousel_bio_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.75)',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_team_carousel_bio_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_team_carousel_bio',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. SOCIALS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_socials',
			[
				'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_soc_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 28, 'max' => 54 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 36 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_social_btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_soc_icon_size',
			[
				'label'      => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 26 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_social_btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_soc_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_social_dock' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_soc_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '10', 'right' => '10', 'bottom' => '10', 'left' => '10', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_social_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_team_carousel_soc_tabs' );

		$this->start_controls_tab(
			'awea_team_carousel_soc_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_soc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_social_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_soc_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_social_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_team_carousel_soc_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_soc_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_social_btn:hover, {{WRAPPER}} .awea_team_carousel_social_btn:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_team_carousel_social_btn:hover svg, {{WRAPPER}} .awea_team_carousel_social_btn:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_soc_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_social_btn:hover, {{WRAPPER}} .awea_team_carousel_social_btn:focus-visible' => 'background-color: var(--awea_team_carousel_social_brand, {{VALUE}}) !important; border-color: transparent !important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 8. ARROWS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_team_carousel_show_arrows' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_team_carousel_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_team_carousel_arrow_border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_team_carousel_arrow_tabs' );

		$this->start_controls_tab(
			'awea_team_carousel_arrow_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_arrow_border' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_arrow_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_arrow_border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_team_carousel_arrow_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_team_carousel_arrow_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_arrow_border:hover, {{WRAPPER}} .owl-nav button:focus-visible .awea_team_carousel_arrow_border' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_arrow_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel_arrow_border:hover, {{WRAPPER}} .owl-nav button:focus-visible .awea_team_carousel_arrow_border' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_team_carousel_arrow_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_team_carousel_arrow_border',
				'separator'      => 'before',
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
		   STYLE: 9. DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_team_carousel_style_dots',
			[
				'label'     => esc_html__( 'Dots', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_team_carousel_show_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_team_carousel_dots_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_team_carousel_dots_active_color',
			[
				'label'     => esc_html__( 'Active', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_team_carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Return crisp inline SVG markup for each social network.
	 */
	private function get_social_svg( $network ) {
		switch ( $network ) {
			case 'ln':
				return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>';
			case 'tw':
				return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
			case 'fb':
				return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>';
			case 'insta':
				return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>';
		}
		return '';
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$members       = $settings['awea_team_carousel_members'] ?? [];
		$items_desktop = ! empty( $settings['awea_team_carousel_slides_to_show'] ) ? (int) $settings['awea_team_carousel_slides_to_show'] : 3;
		$items_tablet  = ! empty( $settings['awea_team_carousel_slides_to_show_tablet'] ) ? (int) $settings['awea_team_carousel_slides_to_show_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_team_carousel_slides_to_show_mobile'] ) ? (int) $settings['awea_team_carousel_slides_to_show_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_team_carousel_slide_gap']['size'] ) && '' !== $settings['awea_team_carousel_slide_gap']['size'] ? (int) $settings['awea_team_carousel_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_team_carousel_slide_gap_tablet']['size'] ) && '' !== $settings['awea_team_carousel_slide_gap_tablet']['size'] ? (int) $settings['awea_team_carousel_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_team_carousel_slide_gap_mobile']['size'] ) && '' !== $settings['awea_team_carousel_slide_gap_mobile']['size'] ? (int) $settings['awea_team_carousel_slide_gap_mobile']['size'] : 16;

		$show_arrows = ( 'yes' === ( $settings['awea_team_carousel_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$show_dots   = ( 'yes' === ( $settings['awea_team_carousel_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop        = ( 'yes' === ( $settings['awea_team_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay    = ( 'yes' === ( $settings['awea_team_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause       = ( 'yes' === ( $settings['awea_team_carousel_pause_on_hover'] ?? 'no' ) ) ? 'yes' : 'no';
		$auto_speed  = ! empty( $settings['awea_team_carousel_autoplay_speed'] ) ? (int) $settings['awea_team_carousel_autoplay_speed'] : 5000;
		$anim_speed  = ! empty( $settings['awea_team_carousel_animation_speed'] ) ? (int) $settings['awea_team_carousel_animation_speed'] : 450;

		$always_visible = ( 'yes' === ( $settings['awea_team_carousel_social_visible'] ?? 'no' ) );
		$name_tag       = Utils::validate_html_tag( $settings['awea_team_carousel_name_tag'] ?? 'h3' );
		$widget_id      = $this->get_id();

		if ( empty( $members ) ) {
			return;
		}

		$card_classes = [ 'awea_team_carousel_master_card' ];
		if ( $always_visible ) {
			$card_classes[] = 'awea_team_carousel_social_always_visible';
		}
		?>
		<div class="awea_team_carousel_wrapper" id="awea_team_carousel_wrap_<?php echo esc_attr( $widget_id ); ?>">
			<div class="awea_team_carousel owl-carousel"
				 id="awea_team_carousel_<?php echo esc_attr( $widget_id ); ?>"
				 data-awea_team_carousel_items_desktop="<?php echo esc_attr( (string) $items_desktop ); ?>"
				 data-awea_team_carousel_items_tablet="<?php echo esc_attr( (string) $items_tablet ); ?>"
				 data-awea_team_carousel_items_mobile="<?php echo esc_attr( (string) $items_mobile ); ?>"
				 data-awea_team_carousel_gap_desktop="<?php echo esc_attr( (string) $gap_desktop ); ?>"
				 data-awea_team_carousel_gap_tablet="<?php echo esc_attr( (string) $gap_tablet ); ?>"
				 data-awea_team_carousel_gap_mobile="<?php echo esc_attr( (string) $gap_mobile ); ?>"
				 data-awea_team_carousel_arrows="<?php echo esc_attr( $show_arrows ); ?>"
				 data-awea_team_carousel_dots="<?php echo esc_attr( $show_dots ); ?>"
				 data-awea_team_carousel_loop="<?php echo esc_attr( $loop ); ?>"
				 data-awea_team_carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-awea_team_carousel_pause="<?php echo esc_attr( $pause ); ?>"
				 data-awea_team_carousel_speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-awea_team_carousel_timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php foreach ( $members as $index => $member ) :
					$id        = ! empty( $member['_id'] ) ? sanitize_html_class( $member['_id'] ) : $index;
					$img_item  = $member['awea_team_carousel_image'] ?? [];
					$image_url = ! empty( $img_item['url'] ) ? $img_item['url'] : Utils::get_placeholder_image_src();
					$name      = $member['awea_team_carousel_name'] ?? '';
					$role      = $member['awea_team_carousel_role'] ?? '';
					$bio       = $member['awea_team_carousel_bio'] ?? '';

					$img_data = [
						'awea_team_carousel_image'            => $img_item,
						'awea_team_carousel_img_size_size'    => $settings['awea_team_carousel_img_size_size'] ?? 'large',
						'awea_team_carousel_img_size_custom_dimension' => $settings['awea_team_carousel_img_size_custom_dimension'] ?? [],
					];

					$img_html = ! empty( $img_item['id'] )
						? Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_team_carousel_img_size', 'awea_team_carousel_image' )
						: sprintf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $image_url ), esc_attr( $name ) );

					$socials = [];
					$brands  = [
						'ln'    => [ 'title' => 'LinkedIn', 'brand' => '#0a66c2' ],
						'tw'    => [ 'title' => 'X', 'brand' => '#000000' ],
						'fb'    => [ 'title' => 'Facebook', 'brand' => '#1877f2' ],
						'insta' => [ 'title' => 'Instagram', 'brand' => '#e4405f' ],
					];
					foreach ( $brands as $soc_key => $meta ) {
						$url_data = $member[ 'awea_team_carousel_' . $soc_key . '_url' ] ?? [];
						if ( ! empty( $url_data['url'] ) ) {
							$soc_key_id = 'awea_team_carousel_soc_' . $id . '_' . $soc_key;
							$this->remove_render_attribute( $soc_key_id );
							$this->add_link_attributes( $soc_key_id, $url_data );
							$this->add_render_attribute( $soc_key_id, 'class', 'awea_team_carousel_social_btn' );
							$this->add_render_attribute( $soc_key_id, 'aria-label', esc_attr( trim( $name . ' — ' . $meta['title'], ' —' ) ) );
							$this->add_render_attribute( $soc_key_id, 'style', '--awea_team_carousel_social_brand: ' . esc_attr( $meta['brand'] ) . ';' );

							$socials[] = [
								'key' => $soc_key_id,
								'svg' => $this->get_social_svg( $soc_key ),
							];
						}
					}
					?>
					<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?> elementor-repeater-item-<?php echo esc_attr( $id ); ?>">
						<div class="awea_team_carousel_img_container">
							<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<div class="awea_team_carousel_scrim" aria-hidden="true"></div>
						</div>

						<div class="awea_team_carousel_info_panel">
							<?php if ( ! empty( $name ) ) : ?>
								<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea_team_carousel_name">
									<?php echo esc_html( $name ); ?>
								</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $role ) ) : ?>
								<span class="awea_team_carousel_role"><?php echo esc_html( $role ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $bio ) ) : ?>
								<p class="awea_team_carousel_bio"><?php echo esc_html( $bio ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $socials ) ) : ?>
								<div class="awea_team_carousel_social_dock">
									<?php foreach ( $socials as $soc ) : ?>
										<a <?php $this->print_render_attribute_string( $soc['key'] ); ?>>
											<?php echo $soc['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		(function($) {
			function awea_team_carousel_mount(wrapper) {
				if (!wrapper || !$) return;
				var $carousel = $(wrapper).find('.awea_team_carousel');
				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

				if ($carousel.hasClass('owl-loaded')) {
					$carousel.trigger('destroy.owl.carousel').removeClass('owl-loaded');
					$carousel.find('.owl-stage-outer').children().unwrap();
					$carousel.find('.owl-item').children().unwrap();
				}

				var itemsDesktop = parseInt($carousel.attr('data-awea_team_carousel_items_desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.attr('data-awea_team_carousel_items_tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.attr('data-awea_team_carousel_items_mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.attr('data-awea_team_carousel_gap_desktop'), 10);
				var gapTablet    = parseInt($carousel.attr('data-awea_team_carousel_gap_tablet'), 10);
				var gapMobile    = parseInt($carousel.attr('data-awea_team_carousel_gap_mobile'), 10);

				if (isNaN(gapDesktop)) gapDesktop = 24;
				if (isNaN(gapTablet)) gapTablet = 20;
				if (isNaN(gapMobile)) gapMobile = 16;

				var slideCount = $carousel.children('article').length;
				var loop       = $carousel.attr('data-awea_team_carousel_loop') === 'yes';
				var allowLoop  = loop && (slideCount > itemsDesktop);

				$carousel.owlCarousel({
					rtl: document.dir === 'rtl',
					nav: $carousel.attr('data-awea_team_carousel_arrows') === 'yes',
					dots: $carousel.attr('data-awea_team_carousel_dots') === 'yes',
					loop: allowLoop,
					autoplay: $carousel.attr('data-awea_team_carousel_autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.attr('data-awea_team_carousel_timeout'), 10) || 5000,
					smartSpeed: parseInt($carousel.attr('data-awea_team_carousel_speed'), 10) || 450,
					autoplayHoverPause: $carousel.attr('data-awea_team_carousel_pause') === 'yes',
					navText: [
						'<button type="button" class="awea_team_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Previous', 'awesome-widgets-elementor' ) ); ?>"><span aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></span></button>',
						'<button type="button" class="awea_team_carousel_arrow_border" aria-label="<?php echo esc_js( __( 'Next', 'awesome-widgets-elementor' ) ); ?>"><span aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>'
					],
					responsive: {
						0: { items: itemsMobile, margin: gapMobile },
						768: { items: itemsTablet, margin: gapTablet },
						1025: { items: itemsDesktop, margin: gapDesktop }
					}
				});
			}

			$(function() {
				var el = document.getElementById('awea_team_carousel_wrap_<?php echo esc_js( $widget_id ); ?>');
				awea_team_carousel_mount(el);
			});

			if (!window.awea_team_carousel_hooked) {
				window.awea_team_carousel_hooked = true;
				$(window).on('elementor/frontend/init', function() {
					if (window.elementorFrontend && window.elementorFrontend.hooks) {
						window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-team-carousel.default', function($scope) {
							var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_team_carousel_wrapper') : null;
							awea_team_carousel_mount(el);
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
		if ( ! settings.awea_team_carousel_members || ! settings.awea_team_carousel_members.length ) {
			return;
		}
		var nameTag   = elementor.helpers.validateHTMLTag( settings.awea_team_carousel_name_tag || 'h3' );
		var alwaysVis = 'yes' === settings.awea_team_carousel_social_visible;
		var cardClass = 'awea_team_carousel_master_card' + ( alwaysVis ? ' awea_team_carousel_social_always_visible' : '' );
		#>
		<div class="awea_team_carousel_wrapper">
			<div class="awea_team_carousel owl-carousel">
				<# _.each( settings.awea_team_carousel_members, function( member, index ) {
					var id    = member._id || index;
					var name  = member.awea_team_carousel_name || '';
					var role  = member.awea_team_carousel_role || '';
					var bio   = member.awea_team_carousel_bio || '';

					var imageObj = {
						id: member.awea_team_carousel_image ? member.awea_team_carousel_image.id : '',
						url: member.awea_team_carousel_image ? member.awea_team_carousel_image.url : '',
						size: settings.awea_team_carousel_img_size_size,
						dimension: settings.awea_team_carousel_img_size_custom_dimension,
						model: view.getEditModel()
					};
					var imageUrl = elementor.imagesManager.getImageUrl( imageObj ) || '<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>';

					var socials = [];
					var brands  = {
						'ln': '#0a66c2',
						'tw': '#000000',
						'fb': '#1877f2',
						'insta': '#e4405f'
					};
					_.each( brands, function( hex, key ) {
						var urlObj = member[ 'awea_team_carousel_' + key + '_url' ];
						if ( urlObj && urlObj.url ) {
							socials.push( { href: urlObj.url, brand: hex } );
						}
					} );
				#>
					<article class="{{ cardClass }} elementor-repeater-item-{{ id }}">
						<div class="awea_team_carousel_img_container">
							<img src="{{ imageUrl }}" alt="{{ name }}" />
							<div class="awea_team_carousel_scrim" aria-hidden="true"></div>
						</div>

						<div class="awea_team_carousel_info_panel">
							<# if ( name ) { #>
								<{{{ nameTag }}} class="awea_team_carousel_name">{{{ name }}}</{{{ nameTag }}}>
							<# } #>

							<# if ( role ) { #>
								<span class="awea_team_carousel_role">{{{ role }}}</span>
							<# } #>

							<# if ( bio ) { #>
								<p class="awea_team_carousel_bio">{{{ bio }}}</p>
							<# } #>

							<# if ( socials.length ) { #>
								<div class="awea_team_carousel_social_dock">
									<# _.each( socials, function( soc ) { #>
										<a href="{{ soc.href }}" class="awea_team_carousel_social_btn" style="--awea_team_carousel_social_brand: {{ soc.brand }};">
											<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14z"/></svg>
										</a>
									<# } ); #>
								</div>
							<# } #>
						</div>
					</article>
				<# } ); #>
			</div>
		</div>
		<?php
	}
}