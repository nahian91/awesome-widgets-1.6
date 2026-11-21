<?php
/**
 * Awesome Breadcrumb Widget.
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
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Breadcumb extends Widget_Base {

	public function get_name() {
		return 'awesome-breadcumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'breadcrumb', 'breadcumb', 'navigation', 'trail', 'header', 'page title', 'seo' ];
	}

	public function get_style_depends() {
		return [ 'awea-breadcrumb' ];
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
		   CONTENT: 1. TRAIL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_section_trail',
			[
				'label' => esc_html__( 'Trail', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_breadcrumb_source',
			[
				'label'   => esc_html__( 'Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__( 'Automatic (Dynamic)', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom List', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_home_mode',
			[
				'label'   => esc_html__( 'Home Display', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => esc_html__( 'Icon & Text', 'awesome-widgets-elementor' ),
					'icon' => esc_html__( 'Icon Only', 'awesome-widgets-elementor' ),
					'text' => esc_html__( 'Text Only', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_home_label',
			[
				'label'     => esc_html__( 'Home Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Home', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'awea_breadcrumb_source'     => 'dynamic',
					'awea_breadcrumb_home_mode!' => 'icon',
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_home_icon',
			[
				'label'       => esc_html__( 'Home Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'awea_breadcrumb_home_mode!' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_show_current_crumb',
			[
				'label'        => esc_html__( 'Show Current Page', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_breadcrumb_source' => 'dynamic' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_breadcrumb_crumb_label',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Page', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_breadcrumb_crumb_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_breadcrumb_custom_crumbs',
			[
				'label'       => esc_html__( 'Trail Items', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_breadcrumb_crumb_label }}}',
				'condition'   => [ 'awea_breadcrumb_source' => 'custom' ],
				'default'     => [
					[
						'awea_breadcrumb_crumb_label' => esc_html__( 'Home', 'awesome-widgets-elementor' ),
						'awea_breadcrumb_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_breadcrumb_crumb_label' => esc_html__( 'Services', 'awesome-widgets-elementor' ),
						'awea_breadcrumb_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_breadcrumb_crumb_label' => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
						'awea_breadcrumb_crumb_url'   => [ 'url' => '' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_section_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_breadcrumb_show_title',
			[
				'label'        => esc_html__( 'Display Page Title', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_breadcrumb_custom_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [
					'awea_breadcrumb_source'     => 'custom',
					'awea_breadcrumb_show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Optional short context line...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_breadcrumb_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_breadcrumb_title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h1',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'span' => 'span',
					'div'  => 'div',
				],
				'condition' => [ 'awea_breadcrumb_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_breadcrumb_trail_pos',
			[
				'label'     => esc_html__( 'Trail Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Title', 'awesome-widgets-elementor' ),
					'below' => esc_html__( 'Below Title', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_breadcrumb_show_title' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_section_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_breadcrumb_sep_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'chevron',
				'options' => [
					'chevron' => esc_html__( 'Chevron', 'awesome-widgets-elementor' ),
					'slash'   => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'dot'     => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'dash'    => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_sep_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_breadcrumb_sep_type' => 'custom' ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'   => 'start; --awea_breadcrumb_justify: flex-start; --awea_breadcrumb_ml: 0; --awea_breadcrumb_mr: auto',
					'center' => 'center; --awea_breadcrumb_justify: center; --awea_breadcrumb_ml: auto; --awea_breadcrumb_mr: auto',
					'right'  => 'end; --awea_breadcrumb_justify: flex-end; --awea_breadcrumb_ml: auto; --awea_breadcrumb_mr: 0',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_breadcrumb_hero'  => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_inner' => 'align-items: var(--awea_breadcrumb_justify);',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_min_height',
			[
				'label'      => esc_html__( 'Min Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 60, 'max' => 700 ],
					'vh' => [ 'min' => 10, 'max' => 80 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_hero' => 'min-height: {{SIZE}}{{UNIT}}; display: flex; align-items: center;',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_max_width',
			[
				'label'      => esc_html__( 'Container Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '76',
					'right'    => '24',
					'bottom'   => '76',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_breadcrumb_border',
				'selector' => '{{WRAPPER}} .awea_breadcrumb_hero',
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_breadcrumb_shadow',
				'selector' => '{{WRAPPER}} .awea_breadcrumb_hero',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BACKGROUND
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_background',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_breadcrumb_banner_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea_breadcrumb_hero',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_overlay',
			[
				'label' => esc_html__( 'Overlay', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_breadcrumb_banner_overlay',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea_breadcrumb_hero::before',
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_overlay_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'   => [ 'size' => 0.65 ],
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_hero::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_breadcrumb_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_breadcrumb_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_breadcrumb_title_typo',
				'selector' => '{{WRAPPER}} .awea_breadcrumb_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_title_space',
			[
				'label'      => esc_html__( 'Gap to Trail', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_inner' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. SUBTITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_subtitle',
			[
				'label'     => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_breadcrumb_show_title' => 'yes',
					'awea_breadcrumb_subtitle!'  => '',
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.72)',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_breadcrumb_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea_breadcrumb_subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_subtitle_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 240, 'max' => 1100 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 640 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_subtitle_space',
			[
				'label'      => esc_html__( 'Top Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. TRAIL CONTAINER (PILL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_pill',
			[
				'label' => esc_html__( 'Trail Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_breadcrumb_trail_pill',
			[
				'label'        => esc_html__( 'Pill Backdrop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_breadcrumb_pill_',
			]
		);

		$this->add_control(
			'awea_breadcrumb_pill_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.08)',
				'condition' => [ 'awea_breadcrumb_trail_pill' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea_breadcrumb_pill_yes .awea_breadcrumb_list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_breadcrumb_pill_border',
				'selector'       => '{{WRAPPER}}.awea_breadcrumb_pill_yes .awea_breadcrumb_list',
				'condition'      => [ 'awea_breadcrumb_trail_pill' => 'yes' ],
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
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.14)' ],
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_pill_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '8',
					'right'    => '18',
					'bottom'   => '8',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'condition'  => [ 'awea_breadcrumb_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea_breadcrumb_pill_yes .awea_breadcrumb_list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_pill_radius',
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
				'condition'  => [ 'awea_breadcrumb_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea_breadcrumb_pill_yes .awea_breadcrumb_list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. TRAIL LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_trail',
			[
				'label' => esc_html__( 'Trail Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_breadcrumb_trail_typo',
				'selector' => '{{WRAPPER}} .awea_breadcrumb_list',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->start_controls_tabs( 'awea_breadcrumb_trail_tabs' );

		$this->start_controls_tab(
			'awea_breadcrumb_trail_link',
			[ 'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_breadcrumb_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.74)',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_item a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_item a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_breadcrumb_trail_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_breadcrumb_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_item a:hover, {{WRAPPER}} .awea_breadcrumb_item a:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_item a:hover svg, {{WRAPPER}} .awea_breadcrumb_item a:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_breadcrumb_trail_current',
			[ 'label' => esc_html__( 'Current', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_breadcrumb_current_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_item.awea_breadcrumb_is_current'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_item.awea_breadcrumb_is_current svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_breadcrumb_home_icon_size',
			[
				'label'      => esc_html__( 'Home Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_home_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_breadcrumb_home_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_home_icon_gap',
			[
				'label'      => esc_html__( 'Home Icon Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 16 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_item a, {{WRAPPER}} .awea_breadcrumb_text' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 8. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_breadcrumb_style_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_sep'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_breadcrumb_sep svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_breadcrumb_sep i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_breadcrumb_sep_gap',
			[
				'label'      => esc_html__( 'Horizontal Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_breadcrumb_sep' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_breadcrumb_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.38)',
				'selectors' => [
					'{{WRAPPER}} .awea_breadcrumb_sep'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_sep svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_breadcrumb_sep i'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build full WordPress dynamic breadcrumb trail (Pages, Posts, CPTs, Taxonomies, WooCommerce, Archives).
	 */
	private function get_dynamic_breadcrumbs( $home_label, $include_current = true ) {
		$crumbs   = [];
		$crumbs[] = [
			'label'   => $home_label,
			'url'     => home_url( '/' ),
			'is_home' => true,
		];

		if ( is_front_page() ) {
			return $crumbs;
		}

		if ( is_home() ) {
			$blog_id    = (int) get_option( 'page_for_posts' );
			$blog_title = $blog_id ? get_the_title( $blog_id ) : esc_html__( 'Blog', 'awesome-widgets-elementor' );
			if ( $include_current ) {
				$crumbs[] = [ 'label' => $blog_title, 'url' => null ];
			}
			return $crumbs;
		}

		// WooCommerce Shop & Product support.
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( $shop_id > 0 && ! is_shop() ) {
				$crumbs[] = [
					'label' => get_the_title( $shop_id ),
					'url'   => get_permalink( $shop_id ),
				];
			}
		}

		if ( is_singular() ) {
			$post      = get_queried_object();
			$post_type = get_post_type( $post );

			if ( 'post' === $post_type ) {
				$blog_id = (int) get_option( 'page_for_posts' );
				if ( $blog_id > 0 ) {
					$crumbs[] = [
						'label' => get_the_title( $blog_id ),
						'url'   => get_permalink( $blog_id ),
					];
				}
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					$primary_cat = $cats[0];
					if ( $primary_cat->parent ) {
						$cat_ancestors = array_reverse( get_ancestors( $primary_cat->term_id, 'category' ) );
						foreach ( $cat_ancestors as $cat_id ) {
							$ancestor_term = get_term( $cat_id, 'category' );
							if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
								$crumbs[] = [
									'label' => $ancestor_term->name,
									'url'   => get_category_link( $ancestor_term->term_id ),
								];
							}
						}
					}
					$crumbs[] = [
						'label' => $primary_cat->name,
						'url'   => get_category_link( $primary_cat->term_id ),
					];
				}
			} elseif ( 'page' === $post_type ) {
				if ( $post->post_parent ) {
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
					foreach ( $ancestors as $ancestor_id ) {
						$crumbs[] = [
							'label' => get_the_title( $ancestor_id ),
							'url'   => get_permalink( $ancestor_id ),
						];
					}
				}
			} elseif ( 'product' === $post_type ) {
				$product_cats = get_the_terms( $post->ID, 'product_cat' );
				if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
					$primary_cat = $product_cats[0];
					if ( $primary_cat->parent ) {
						$cat_ancestors = array_reverse( get_ancestors( $primary_cat->term_id, 'product_cat' ) );
						foreach ( $cat_ancestors as $cat_id ) {
							$ancestor_term = get_term( $cat_id, 'product_cat' );
							if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
								$crumbs[] = [
									'label' => $ancestor_term->name,
									'url'   => get_term_link( $ancestor_term ),
								];
							}
						}
					}
					$crumbs[] = [
						'label' => $primary_cat->name,
						'url'   => get_term_link( $primary_cat ),
					];
				}
			} else {
				$pto = get_post_type_object( $post_type );
				if ( $pto && ! empty( $pto->has_archive ) ) {
					$crumbs[] = [
						'label' => $pto->labels->name,
						'url'   => get_post_type_archive_link( $post_type ),
					];
				}
			}

			if ( $include_current ) {
				$crumbs[] = [ 'label' => get_the_title( $post->ID ), 'url' => null ];
			}
		} elseif ( is_post_type_archive() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => post_type_archive_title( '', false ), 'url' => null ];
			}
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term && ! is_wp_error( $term ) ) {
				if ( ! empty( $term->parent ) ) {
					$term_ancestors = array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) );
					foreach ( $term_ancestors as $ancestor_id ) {
						$ancestor = get_term( $ancestor_id, $term->taxonomy );
						if ( $ancestor && ! is_wp_error( $ancestor ) ) {
							$crumbs[] = [
								'label' => $ancestor->name,
								'url'   => get_term_link( $ancestor ),
							];
						}
					}
				}
				if ( $include_current ) {
					$crumbs[] = [ 'label' => $term->name, 'url' => null ];
				}
			}
		} elseif ( is_search() ) {
			if ( $include_current ) {
				$crumbs[] = [
					/* translators: %s: search query string */
					'label' => sprintf( esc_html__( 'Search: "%s"', 'awesome-widgets-elementor' ), get_search_query() ),
					'url'   => null,
				];
			}
		} elseif ( is_author() ) {
			if ( $include_current ) {
				$crumbs[] = [
					'label' => get_the_author_meta( 'display_name', get_query_var( 'author' ) ),
					'url'   => null,
				];
			}
		} elseif ( is_date() ) {
			if ( is_year() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => null ];
			} elseif ( is_month() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => get_year_link( get_the_time( 'Y' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'F' ), 'url' => null ];
			} elseif ( is_day() ) {
				$crumbs[] = [ 'label' => get_the_date( 'Y' ), 'url' => get_year_link( get_the_time( 'Y' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'F' ), 'url' => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ];
				$crumbs[] = [ 'label' => get_the_date( 'd' ), 'url' => null ];
			}
		} elseif ( is_404() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => esc_html__( 'Page Not Found', 'awesome-widgets-elementor' ), 'url' => null ];
			}
		} elseif ( is_archive() ) {
			if ( $include_current ) {
				$crumbs[] = [ 'label' => wp_strip_all_tags( get_the_archive_title() ), 'url' => null ];
			}
		}

		return $crumbs;
	}

	/**
	 * Render breadcrumb navigation trail.
	 */
	protected function render_trail( $crumbs, $settings, $extra_class = '' ) {
		if ( empty( $crumbs ) ) {
			return;
		}
		global $wp;
		$sep_type        = $settings['awea_breadcrumb_sep_type'] ?? 'chevron';
		$home_mode       = $settings['awea_breadcrumb_home_mode'] ?? 'both';
		$has_home_icon   = ( 'text' !== $home_mode ) && ! empty( $settings['awea_breadcrumb_home_icon']['value'] );
		$show_home_label = ( 'icon' !== $home_mode );
		$total_items     = count( $crumbs );
		$current_url     = home_url( add_query_arg( [], $wp->request ?? '' ) );
		?>
		<nav class="awea_breadcrumb_nav <?php echo esc_attr( $extra_class ); ?>" aria-label="<?php esc_attr_e( 'Breadcrumb', 'awesome-widgets-elementor' ); ?>">
			<ol class="awea_breadcrumb_list" itemscope itemtype="https://schema.org/BreadcrumbList">
				<?php foreach ( $crumbs as $index => $crumb ) :
					$is_last  = ( $index === $total_items - 1 );
					$position = $index + 1;
					$is_home  = ! empty( $crumb['is_home'] ) || 0 === $index;
					$link_key = 'awea_breadcrumb_link_' . $index;

					$this->remove_render_attribute( $link_key );

					$has_url = ! empty( $crumb['url'] ) && ( ! $is_last || ( 1 === $total_items && $is_home ) );
					if ( $has_url ) {
						if ( ! empty( $crumb['link_data'] ) && is_array( $crumb['link_data'] ) ) {
							$this->add_link_attributes( $link_key, $crumb['link_data'] );
						} else {
							$this->add_render_attribute( $link_key, 'href', esc_url( $crumb['url'] ) );
						}
						$this->add_render_attribute( $link_key, 'itemprop', 'item' );
					}

					$is_current_item = $is_last && ! $has_url;
					?>
					<li class="awea_breadcrumb_item <?php echo $is_current_item ? 'awea_breadcrumb_is_current' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<?php if ( $has_url ) : ?>
							<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<?php if ( $is_home && $has_home_icon ) : ?>
									<span class="awea_breadcrumb_home_ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_breadcrumb_home_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<?php if ( ! $is_home || $show_home_label ) : ?>
									<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
								<?php else : ?>
									<span class="elementor-screen-only" itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
								<?php endif; ?>
							</a>
						<?php else : ?>
							<span class="awea_breadcrumb_text" <?php echo $is_current_item ? 'aria-current="page"' : ''; ?>>
								<?php if ( $is_home && $has_home_icon ) : ?>
									<span class="awea_breadcrumb_home_ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_breadcrumb_home_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<?php if ( ! $is_home || $show_home_label ) : ?>
									<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
								<?php else : ?>
									<span class="elementor-screen-only" itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
								<?php endif; ?>
							</span>
							<?php if ( $is_current_item ) : ?>
								<link itemprop="item" href="<?php echo esc_url( $current_url ); ?>" />
							<?php endif; ?>
						<?php endif; ?>

						<meta itemprop="position" content="<?php echo esc_attr( (string) $position ); ?>" />

						<?php if ( ! $is_last ) : ?>
							<span class="awea_breadcrumb_sep" aria-hidden="true">
								<?php if ( 'chevron' === $sep_type ) : ?>
									<svg class="awea_breadcrumb_sep_chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
								<?php elseif ( 'slash' === $sep_type ) : ?>
									/
								<?php elseif ( 'dot' === $sep_type ) : ?>
									&bull;
								<?php elseif ( 'dash' === $sep_type ) : ?>
									&mdash;
								<?php elseif ( 'custom' === $sep_type && ! empty( $settings['awea_breadcrumb_sep_icon']['value'] ) ) : ?>
									<?php Icons_Manager::render_icon( $settings['awea_breadcrumb_sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php endif; ?>
							</span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</nav>
		<?php
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$source          = $settings['awea_breadcrumb_source'] ?? 'dynamic';
		$home_label      = ! empty( $settings['awea_breadcrumb_home_label'] ) ? $settings['awea_breadcrumb_home_label'] : esc_html__( 'Home', 'awesome-widgets-elementor' );
		$include_current = 'yes' === ( $settings['awea_breadcrumb_show_current_crumb'] ?? 'yes' );
		$show_title      = 'yes' === ( $settings['awea_breadcrumb_show_title'] ?? 'no' );
		$subtitle        = $settings['awea_breadcrumb_subtitle'] ?? '';
		$title_tag       = Utils::validate_html_tag( $settings['awea_breadcrumb_title_tag'] ?? 'h1' );
		$trail_pos       = $settings['awea_breadcrumb_trail_pos'] ?? 'below';

		if ( 'custom' === $source ) {
			$page_title   = $settings['awea_breadcrumb_custom_title'] ?? '';
			$custom_items = array_values(
				array_filter(
					$settings['awea_breadcrumb_custom_crumbs'] ?? [],
					static function ( $item ) {
						return ! empty( $item['awea_breadcrumb_crumb_label'] );
					}
				)
			);
			$crumbs       = [];
			$last_idx     = count( $custom_items ) - 1;

			foreach ( $custom_items as $idx => $item ) {
				$is_last_item = ( $idx === $last_idx );
				$crumbs[]     = [
					'label'     => $item['awea_breadcrumb_crumb_label'],
					'url'       => $is_last_item ? '' : ( $item['awea_breadcrumb_crumb_url']['url'] ?? '' ),
					'link_data' => $is_last_item ? [] : ( $item['awea_breadcrumb_crumb_url'] ?? [] ),
					'is_home'   => ( 0 === $idx ),
				];
			}
		} else {
			if ( is_404() ) {
				$page_title = esc_html__( 'Page Not Found', 'awesome-widgets-elementor' );
			} elseif ( is_search() ) {
				/* translators: %s: search query */
				$page_title = sprintf( esc_html__( 'Results for "%s"', 'awesome-widgets-elementor' ), get_search_query() );
			} elseif ( is_front_page() && is_home() ) {
				$page_title = get_bloginfo( 'name' );
			} elseif ( is_home() ) {
				$blog_id    = (int) get_option( 'page_for_posts' );
				$page_title = $blog_id ? get_the_title( $blog_id ) : esc_html__( 'Blog', 'awesome-widgets-elementor' );
			} elseif ( is_archive() ) {
				$page_title = wp_strip_all_tags( get_the_archive_title() );
			} else {
				$page_title = get_the_title();
			}
			$crumbs = $this->get_dynamic_breadcrumbs( $home_label, $include_current );
		}
		?>
		<section class="awea_breadcrumb_hero" aria-label="<?php esc_attr_e( 'Page Header', 'awesome-widgets-elementor' ); ?>">
			<div class="awea_breadcrumb_inner">

				<?php
				if ( $show_title && 'above' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings, 'awea_breadcrumb_nav_top' );
				}
				?>

				<?php if ( $show_title && ! empty( $page_title ) ) : ?>
					<div class="awea_breadcrumb_header">
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_breadcrumb_title">
							<?php echo esc_html( $page_title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

						<?php if ( ! empty( $subtitle ) ) : ?>
							<p class="awea_breadcrumb_subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				if ( ! $show_title || 'below' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings );
				}
				?>

			</div>
		</section>
		<?php
	}
}