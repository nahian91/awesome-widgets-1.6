<?php
/**
 * About Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		return [ 'awea', 'about', 'company', 'agency', 'story', 'profile', 'overview' ];
	}

	public function get_style_depends() {
		return [ 'awea-about' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* -------------------------------------------------------------------------
		   1. Images
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_media',
			[
				'label' => esc_html__( 'Images', 'awesome-widgets-elementor' ),
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_about_main_image_size',
				'default'   => 'large',
				'condition' => [
					'awea_about_main_image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'awea_about_float_image',
			[
				'label'     => esc_html__( 'Floating Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_about_float_image_size',
				'default'   => 'medium',
				'condition' => [
					'awea_about_float_image[url]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   2. Badge
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_badge_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-award',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'awea_about_badge_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'e.g. Since 1998', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Content
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_subheading',
			[
				'label'       => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_about_heading',
			[
				'label'       => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'The World Trusts Our Modern Digital Logistics.', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Supports <span>, <strong>, <em>, and <br> tags for highlighted words.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_about_heading_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
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

		/* -------------------------------------------------------------------------
		   4. Highlights
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_features',
			[
				'label' => esc_html__( 'Highlights', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_about_feature_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_about_feature_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
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
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_about_feature_text }}}',
				'default'     => [
					[
						'awea_about_feature_text' => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
						'awea_about_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_about_feature_text' => esc_html__( 'Automated Compliance & Security', 'awesome-widgets-elementor' ),
						'awea_about_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_about_feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ),
						'awea_about_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
					[
						'awea_about_feature_text' => esc_html__( 'Global Freight Infrastructure', 'awesome-widgets-elementor' ),
						'awea_about_feature_icon' => [ 'value' => 'fas fa-check-circle', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   5. Button
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_actions',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_show_btn',
			[
				'label'        => esc_html__( 'Display Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_about_btn_text',
			[
				'label'     => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Services', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_about_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_btn_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [
					'url' => '#',
				],
				'condition' => [ 'awea_about_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_btn_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_about_show_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_btn_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'row-reverse' => [
						'title' => esc_html__( 'Before', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'row'         => [
						'title' => esc_html__( 'After', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'row',
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn' => 'flex-direction: {{VALUE}};',
				],
				'condition' => [
					'awea_about_show_btn'        => 'yes',
					'awea_about_btn_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   6. Contact
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_section_contact',
			[
				'label' => esc_html__( 'Contact', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_show_phone',
			[
				'label'        => esc_html__( 'Display Contact', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_about_phone_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-phone-alt',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_about_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_phone_label',
			[
				'label'     => esc_html__( 'Caption', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Direct Inquiries:', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_about_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_phone_num',
			[
				'label'     => esc_html__( 'Number / Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '+1 (800) 234-5678',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_about_show_phone' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_about_phone_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'tel:+18002345678',
				'default'     => [
					'url' => 'tel:+18002345678',
				],
				'condition'   => [ 'awea_about_show_phone' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* -------------------------------------------------------------------------
		   1. Layout
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_about_image_pos',
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
				'prefix_class' => 'awea_about_pos_',
			]
		);

		$this->add_responsive_control(
			'awea_about_vertical_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start'  => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'end'    => [
						'title' => esc_html__( 'Bottom', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea_about_grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_grid_gap',
			[
				'label'      => esc_html__( 'Column Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem', 'vw' ],
				'range'      => [
					'px'  => [ 'min' => 16, 'max' => 140 ],
					'rem' => [ 'min' => 1, 'max' => 9 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   2. Main Image
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_media',
			[
				'label'     => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_main_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_about_main_img_width',
			[
				'label'      => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 50, 'max' => 100 ],
					'px' => [ 'min' => 200, 'max' => 800 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 92 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_main_img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_main_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4 / 5',
				'options'   => [
					'auto'    => 'Auto (Original)',
					'1 / 1'   => '1:1 (Square)',
					'4 / 5'   => '4:5 (Portrait)',
					'3 / 4'   => '3:4 (Classic)',
					'4 / 3'   => '4:3 (Landscape)',
					'16 / 10' => '16:10 (Wide)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_about_main_img' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_about_main_img_border',
				'selector' => '{{WRAPPER}} .awea_about_main_img',
			]
		);

		$this->add_responsive_control(
			'awea_about_main_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '64',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '64',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_main_img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_about_main_img_shadow',
				'selector' => '{{WRAPPER}} .awea_about_main_img',
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   3. Floating Image
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_float_media',
			[
				'label'     => esc_html__( 'Floating Image', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_float_image[url]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_img_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => 20, 'max' => 60 ],
					'px' => [ 'min' => 80, 'max' => 360 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_float_img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1 / 1',
				'options'   => [
					'1 / 1' => '1:1 (Circle / Square)',
					'4 / 5' => '4:5 (Portrait)',
					'4 / 3' => '4:3 (Landscape)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_about_float_img' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_offset_y',
			[
				'label'      => esc_html__( 'Bottom Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -15, 'max' => 60 ],
					'px' => [ 'min' => -60, 'max' => 200 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_float_img' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_offset_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -15, 'max' => 50 ],
					'px' => [ 'min' => -60, 'max' => 150 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_float_img' => 'inset-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_float_img' => 'border-style: solid; border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_about_float_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_about_float_img' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_float_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_float_img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_about_float_img_shadow',
				'selector' => '{{WRAPPER}} .awea_about_float_img',
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   4. Badge
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_badge_text!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_about_badge_offset_y',
			[
				'label'      => esc_html__( 'Top Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -10, 'max' => 80 ],
					'px' => [ 'min' => -40, 'max' => 300 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_badge_offset_x',
			[
				'label'      => esc_html__( 'Horizontal Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'%'  => [ 'min' => -15, 'max' => 60 ],
					'px' => [ 'min' => -60, 'max' => 200 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_badge' => 'inset-inline-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_about_badge_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_about_badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_badge svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_badge_typo',
				'selector' => '{{WRAPPER}} .awea_about_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_about_badge_border',
				'selector' => '{{WRAPPER}} .awea_about_badge',
			]
		);

		$this->add_responsive_control(
			'awea_about_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_badge_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_about_badge_shadow',
				'selector' => '{{WRAPPER}} .awea_about_badge',
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   5. Subheading
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_subheading',
			[
				'label'     => esc_html__( 'Subheading', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_subheading!' => '' ],
			]
		);

		$this->add_control(
			'awea_about_sub_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_sub'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_line' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_sub_line_width',
			[
				'label'      => esc_html__( 'Accent Line Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 80 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_sub_typo',
				'selector' => '{{WRAPPER}} .awea_about_sub',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_about_sub_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   6. Heading
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_heading',
			[
				'label'     => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_heading!' => '' ],
			]
		);

		$this->add_control(
			'awea_about_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_title_highlight_color',
			[
				'label'       => esc_html__( 'Highlight (<span>) Color', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'global'      => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'description' => esc_html__( 'Applies to text wrapped inside <span> tags in the Heading.', 'awesome-widgets-elementor' ),
				'selectors'   => [
					'{{WRAPPER}} .awea_about_title span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_title_typo',
				'selector' => '{{WRAPPER}} .awea_about_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_about_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   7. Description
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_description',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_description!' => '' ],
			]
		);

		$this->add_control(
			'awea_about_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_desc_typo',
				'selector' => '{{WRAPPER}} .awea_about_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_about_desc_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   8. Highlights
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_features',
			[
				'label'     => esc_html__( 'Highlights', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_features_list!' => [] ],
			]
		);

		$this->add_responsive_control(
			'awea_about_feat_cols',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea_about_feats' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_feat_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 40 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_feats' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_about_feat_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_feat' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_feat_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_feat_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_feat_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_feat_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_feat_icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_about_feat_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_feat_typo',
				'selector' => '{{WRAPPER}} .awea_about_feat',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_about_feat_bottom_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_feats' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   9. Button
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_cta',
			[
				'label'     => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_show_btn' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_btn_typo',
				'selector' => '{{WRAPPER}} .awea_about_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_about_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_btn_icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_about_btn_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_about_tabs_btn_style' );

		$this->start_controls_tab(
			'awea_about_tab_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_about_btn_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_about_btn_shadow',
				'selector' => '{{WRAPPER}} .awea_about_btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_about_tab_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_about_btn_hover_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn:hover, {{WRAPPER}} .awea_about_btn:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_btn:hover svg, {{WRAPPER}} .awea_about_btn:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_btn_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn:hover, {{WRAPPER}} .awea_about_btn:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_btn_hover_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_btn:hover, {{WRAPPER}} .awea_about_btn:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_about_btn_hover_shadow',
				'selector' => '{{WRAPPER}} .awea_about_btn:hover, {{WRAPPER}} .awea_about_btn:focus-visible',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_about_btn_border',
				'selector'       => '{{WRAPPER}} .awea_about_btn',
				'separator'      => 'before',
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

		$this->add_responsive_control(
			'awea_about_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* -------------------------------------------------------------------------
		   10. Contact
		   ------------------------------------------------------------------------- */
		$this->start_controls_section(
			'awea_about_style_contact',
			[
				'label'     => esc_html__( 'Contact', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_about_show_phone' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_about_actions_gap',
			[
				'label'      => esc_html__( 'Gap From Button', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_about_show_btn' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_about_phone_box_size',
			[
				'label'      => esc_html__( 'Icon Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 72 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 46 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_phone_ico' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_phone_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 17 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_phone_ico'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_about_phone_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_about_phone_icon_radius',
			[
				'label'      => esc_html__( 'Icon Box Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_about_phone_ico' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_about_tabs_phone_icon_style' );

		$this->start_controls_tab(
			'awea_about_tab_phone_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_about_phone_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_ico'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_phone_ico svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_phone_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_ico' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_phone_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_ico' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_about_tab_phone_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_about_phone_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_link:hover .awea_about_phone_ico, {{WRAPPER}} .awea_about_phone_link:focus-visible .awea_about_phone_ico'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_about_phone_link:hover .awea_about_phone_ico svg, {{WRAPPER}} .awea_about_phone_link:focus-visible .awea_about_phone_ico svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_about_phone_icon_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_link:hover .awea_about_phone_ico, {{WRAPPER}} .awea_about_phone_link:focus-visible .awea_about_phone_ico' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'awea_about_phone_lbl_color',
			[
				'label'     => esc_html__( 'Caption Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_lbl' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_phone_lbl_typo',
				'label'    => esc_html__( 'Caption Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_about_phone_lbl',
			]
		);

		$this->add_control(
			'awea_about_phone_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_about_phone_num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_about_phone_num_typo',
				'label'    => esc_html__( 'Number Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_about_phone_num',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$badge       = $settings['awea_about_badge_text'] ?? '';
		$subheading  = $settings['awea_about_subheading'] ?? '';
		$heading     = $settings['awea_about_heading'] ?? '';
		$heading_tag = Utils::validate_html_tag( $settings['awea_about_heading_tag'] ?? 'h2' );
		$desc        = $settings['awea_about_description'] ?? '';
		$features    = $settings['awea_about_features_list'] ?? [];

		$show_btn   = 'yes' === ( $settings['awea_about_show_btn'] ?? 'no' );
		$btn_text   = $settings['awea_about_btn_text'] ?? '';
		$show_phone = 'yes' === ( $settings['awea_about_show_phone'] ?? 'no' );
		$phone_lbl  = $settings['awea_about_phone_label'] ?? '';
		$phone_num  = $settings['awea_about_phone_num'] ?? '';

		$has_main_img  = ! empty( $settings['awea_about_main_image']['url'] );
		$has_float_img = ! empty( $settings['awea_about_float_image']['url'] );

		if ( $show_btn ) {
			$this->remove_render_attribute( 'awea_about_btn' );
			$btn_link = ! empty( $settings['awea_about_btn_link']['url'] ) ? $settings['awea_about_btn_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_about_btn', $btn_link );
			$this->add_render_attribute( 'awea_about_btn', 'class', 'awea_about_btn' );
		}

		if ( $show_phone && ! empty( $phone_num ) ) {
			$this->remove_render_attribute( 'awea_about_phone' );
			$phone_url = $settings['awea_about_phone_url'] ?? [];
			if ( empty( $phone_url['url'] ) ) {
				$clean_tel        = preg_replace( '/[^0-9+]/', '', $phone_num );
				$phone_url['url'] = $clean_tel ? 'tel:' . $clean_tel : '#';
			}
			$this->add_link_attributes( 'awea_about_phone', $phone_url );
			$this->add_render_attribute( 'awea_about_phone', 'class', 'awea_about_phone_link' );
		}
		?>
		<section class="awea_about_grid">

			<?php if ( $has_main_img || $has_float_img || ! empty( $badge ) ) : ?>
				<div class="awea_about_visual">
					<?php if ( $has_main_img ) : ?>
						<div class="awea_about_main_img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_about_main_image_size', 'awea_about_main_image' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $has_float_img ) : ?>
						<div class="awea_about_float_img">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_about_float_image_size', 'awea_about_float_image' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $badge ) ) : ?>
						<div class="awea_about_badge">
							<?php if ( ! empty( $settings['awea_about_badge_icon']['value'] ) ) : ?>
								<span class="awea_about_badge_icon" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_about_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
							<span><?php echo esc_html( $badge ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="awea_about_content">
				<?php if ( ! empty( $subheading ) ) : ?>
					<div class="awea_about_sub">
						<span class="awea_about_line" aria-hidden="true"></span>
						<span><?php echo esc_html( $subheading ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $heading ) ) : ?>
					<<?php Utils::print_validated_html_tag( $heading_tag ); ?> class="awea_about_title">
						<?php echo wp_kses( $heading, [ 'br' => [], 'span' => [ 'class' => [] ], 'strong' => [], 'em' => [] ] ); ?>
					</<?php Utils::print_validated_html_tag( $heading_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $desc ) ) : ?>
					<div class="awea_about_desc">
						<?php echo wp_kses_post( $desc ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<ul class="awea_about_feats">
						<?php foreach ( $features as $feat ) : ?>
							<?php if ( ! empty( $feat['awea_about_feature_text'] ) ) : ?>
								<li class="awea_about_feat">
									<?php if ( ! empty( $feat['awea_about_feature_icon']['value'] ) ) : ?>
										<span class="awea_about_feat_icon" aria-hidden="true">
											<?php Icons_Manager::render_icon( $feat['awea_about_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
									<span><?php echo esc_html( $feat['awea_about_feature_text'] ); ?></span>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ( $show_btn && ! empty( $btn_text ) ) || ( $show_phone && ! empty( $phone_num ) ) ) : ?>
					<div class="awea_about_actions">
						<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'awea_about_btn' ); ?>>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<?php if ( ! empty( $settings['awea_about_btn_icon']['value'] ) ) : ?>
									<span class="awea_about_btn_icon" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_about_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ( $show_phone && ! empty( $phone_num ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'awea_about_phone' ); ?>>
								<?php if ( ! empty( $settings['awea_about_phone_icon']['value'] ) ) : ?>
									<span class="awea_about_phone_ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_about_phone_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span class="awea_about_phone_meta">
									<?php if ( ! empty( $phone_lbl ) ) : ?>
										<span class="awea_about_phone_lbl"><?php echo esc_html( $phone_lbl ); ?></span>
									<?php endif; ?>
									<span class="awea_about_phone_num"><?php echo esc_html( $phone_num ); ?></span>
								</span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</section>
		<?php
	}
}