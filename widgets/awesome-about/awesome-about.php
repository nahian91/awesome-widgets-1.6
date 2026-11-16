<?php
/**
 * Awesome About Widget.
 * Architectural Editorial Layout with Floating Visuals & Micro-Interactions.
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
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_About extends Widget_Base {

	public function get_name() {
		return 'awesome-about';
	}

	public function get_title() {
		return esc_html__( 'About', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'about', 'company', 'agency', 'story', 'profile', 'features' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. MEDIA
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_about_images',
			[
				'label' => esc_html__( 'Media', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_main_image',
			[
				'label'   => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'awea_about_floating_image',
			[
				'label'   => esc_html__( 'Floating Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'awea_about_experience_badge',
			[
				'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_about_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_sub_heading',
			[
				'label'       => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_about_main_heading',
			[
				'label'   => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'The World Trusts Our Modern Digital Logistics.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_heading_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'awea_about_description',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'We engineer comprehensive design systems and high-throughput web applications that empower ambitious modern brands globally.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 3. FEATURES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_about_features',
			[
				'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_features = new Repeater();

		$repeater_features->add_control(
			'awea_feature_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater_features->add_control(
			'awea_feature_text',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_about_features_list',
			[
				'label'       => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_features->get_controls(),
				'default'     => [
					[ 'awea_feature_text' => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ) ],
					[ 'awea_feature_text' => esc_html__( 'Automated Compliance & Security', 'awesome-widgets-elementor' ) ],
					[ 'awea_feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ) ],
					[ 'awea_feature_text' => esc_html__( 'Global Freight Infrastructure', 'awesome-widgets-elementor' ) ],
				],
				'title_field' => '{{{ awea_feature_text }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 4. ACTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_about_buttons',
			[
				'label' => esc_html__( 'Actions', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_primary_btn',
			[
				'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_primary_btn_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Services', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_primary_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_primary_btn_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_show_primary_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_phone_cta',
			[
				'label'        => esc_html__( 'Show Phone', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_about_contact_label',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Inquiries:', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_phone_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_contact_number',
			[
				'label'     => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 234-5678',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_phone_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_contact_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18002345678',
				'default'     => [
					'url' => 'tel:+18002345678',
				],
				'condition'   => [ 'awea_show_phone_cta' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_image_position',
			[
				'label'        => esc_html__( 'Image Position', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'left',
				'prefix_class' => 'awea-about-pos-',
			]
		);

		$this->add_responsive_control(
			'awea_grid_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 20, 'max' => 140 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 70 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-master-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. MEDIA
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_images',
			[
				'label' => esc_html__( 'Media', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_main_image_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '80', 'right' => '24', 'bottom' => '24', 'left' => '80', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-image-frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_main_image_shadow',
				'selector' => '{{WRAPPER}} .awea-about-image-frame',
			]
		);

		// Floating Circle
		$this->add_control(
			'awea_heading_floating_style',
			[
				'label'     => esc_html__( 'Floating Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'awea_about_floating_image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'awea_floating_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [ 'px' => [ 'min' => 120, 'max' => 450 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 320 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-floating-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'awea_about_floating_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'awea_floating_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-floating-circle' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'awea_about_floating_image[url]!' => '',
				],
			]
		);

		// Badge
		$this->add_control(
			'awea_heading_badge_style',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'awea_about_experience_badge!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_badge_typography',
				'selector'  => '{{WRAPPER}} .awea-about-ribbon',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'condition' => [
					'awea_about_experience_badge!' => '',
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
					'{{WRAPPER}} .awea-about-ribbon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'awea_about_experience_badge!' => '',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-ribbon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'awea_about_experience_badge!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'awea_about_experience_badge!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Subheading
		$this->add_control(
			'awea_heading_sub_style',
			[
				'label'     => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'awea_about_sub_heading!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_subheading_typography',
				'selector'  => '{{WRAPPER}} .awea-about-label-group',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'condition' => [ 'awea_about_sub_heading!' => '' ],
			]
		);

		$this->add_control(
			'awea_subheading_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-label-group' => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-about-label-line'  => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_about_sub_heading!' => '' ],
			]
		);

		// Heading
		$this->add_control(
			'awea_heading_main_style',
			[
				'label'     => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_about_main_heading!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_heading_typography',
				'selector'  => '{{WRAPPER}} .awea-about-heading',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'condition' => [ 'awea_about_main_heading!' => '' ],
			]
		);

		$this->add_control(
			'awea_heading_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-heading' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_about_main_heading!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_heading_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_about_main_heading!' => '' ],
			]
		);

		// Description
		$this->add_control(
			'awea_heading_desc_style',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_about_description!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_desc_typography',
				'selector'  => '{{WRAPPER}} .awea-about-main-desc',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'condition' => [ 'awea_about_description!' => '' ],
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-main-desc' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_about_description!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_desc_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-main-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_about_description!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. FEATURES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_features',
			[
				'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_feature_columns',
			[
				'label'     => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-feature-box' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_feature_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-feature-box' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_feature_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-check-item i'   => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-about-check-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_feature_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-check-item i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-about-check-item svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_feature_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-check-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_feature_typography',
				'selector' => '{{WRAPPER}} .awea-about-check-item',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
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
				'condition' => [ 'awea_show_primary_btn' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typography',
				'selector' => '{{WRAPPER}} .awea-about-prime-btn',
			]
		);

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-prime-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-about-prime-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cta_button_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_cta_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_prime_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-prime-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_prime_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-prime-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_cta_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_prime_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-prime-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_prime_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-prime-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 6. PHONE (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_phone',
			[
				'label'     => esc_html__( 'Phone', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_phone_cta' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_icon_circle_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-about-icon-circle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_circle_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-about-icon-circle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_phone_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_phone_number_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-phone-number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_phone_number_typography',
				'selector' => '{{WRAPPER}} .awea-about-phone-number',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$main_img     = $settings['awea_about_main_image']['url'] ?? '';
		$circle_img   = $settings['awea_about_floating_image']['url'] ?? '';
		$badge_text   = $settings['awea_about_experience_badge'] ?? '';
		$sub_heading  = $settings['awea_about_sub_heading'] ?? '';
		$main_heading = $settings['awea_about_main_heading'] ?? '';
		$heading_tag  = Utils::validate_html_tag( $settings['awea_heading_tag'] ?? 'h2' );
		$description  = $settings['awea_about_description'] ?? '';
		$features     = $settings['awea_about_features_list'] ?? [];

		$show_btn     = 'yes' === ( $settings['awea_show_primary_btn'] ?? 'no' );
		$btn_text     = $settings['awea_primary_btn_text'] ?? '';
		$btn_link     = $settings['awea_primary_btn_url']['url'] ?? '';

		$show_phone   = 'yes' === ( $settings['awea_show_phone_cta'] ?? 'yes' );
		$phone_label  = $settings['awea_about_contact_label'] ?? '';
		$phone_num    = $settings['awea_about_contact_number'] ?? '';
		$phone_url    = $settings['awea_about_contact_url']['url'] ?? '';

		if ( $show_btn && ! empty( $btn_link ) ) {
			$this->add_link_attributes( 'awea_primary_btn', $settings['awea_primary_btn_url'] );
		}
		if ( $show_phone && ! empty( $phone_url ) ) {
			$this->add_link_attributes( 'awea_phone_call', $settings['awea_about_contact_url'] );
		}
		?>
		<section class="awea-about-master-grid">
			
			<!-- Visual Framing Column -->
			<div class="awea-about-visual-container">
				<?php if ( ! empty( $main_img ) ) : ?>
					<div class="awea-about-image-frame">
						<img src="<?php echo esc_url( $main_img ); ?>" alt="<?php echo esc_attr( $main_heading ); ?>" loading="lazy" />
					</div>
				<?php endif; ?>
				
				<?php if ( ! empty( $circle_img ) ) : ?>
					<div class="awea-about-floating-circle">
						<img src="<?php echo esc_url( $circle_img ); ?>" alt="<?php esc_attr_e( 'Feature Detail', 'awesome-widgets-elementor' ); ?>" loading="lazy" />
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $badge_text ) ) : ?>
					<div class="awea-about-ribbon">
						<span><?php echo esc_html( $badge_text ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Editorial Content Column -->
			<div class="awea-about-text-content">
				
				<?php if ( ! empty( $sub_heading ) ) : ?>
					<div class="awea-about-label-group">
						<span class="awea-about-label-line" aria-hidden="true"></span>
						<span class="awea-about-label-text"><?php echo esc_html( $sub_heading ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $main_heading ) ) : ?>
					<<?php Utils::print_validated_html_tag( $heading_tag ); ?> class="awea-about-heading"><?php echo esc_html( $main_heading ); ?></<?php Utils::print_validated_html_tag( $heading_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $description ) ) : ?>
					<div class="awea-about-main-desc">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<div class="awea-about-feature-box">
						<?php foreach ( $features as $item ) : ?>
							<div class="awea-about-check-item">
								<?php Icons_Manager::render_icon( $item['awea_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<span><?php echo esc_html( $item['awea_feature_text'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Dual Action Controls -->
				<?php if ( ( $show_btn && ! empty( $btn_text ) ) || ( $show_phone && ! empty( $phone_num ) ) ) : ?>
					<div class="awea-about-cta-wrapper">
						<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
							<a class="awea-about-prime-btn" <?php $this->print_render_attribute_string( 'awea_primary_btn' ); ?>>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<line x1="5" y1="12" x2="19" y2="12"></line>
									<polyline points="12 5 19 12 12 19"></polyline>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
							<a class="awea-about-phone-call" <?php $this->print_render_attribute_string( 'awea_phone_call' ); ?>>
								<div class="awea-about-icon-circle" aria-hidden="true">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
									</svg>
								</div>
								<div class="awea-about-phone-meta">
									<?php if ( ! empty( $phone_label ) ) : ?>
										<span class="awea-about-phone-label"><?php echo esc_html( $phone_label ); ?></span>
									<?php endif; ?>
									<span class="awea-about-phone-number"><?php echo esc_html( $phone_num ); ?></span>
								</div>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}