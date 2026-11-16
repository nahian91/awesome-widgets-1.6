<?php
/**
 * Awesome Breadcrumb Studio Widget (Zero-Shadow Architectural Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since 2.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;

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
		return [ 'awea', 'breadcrumb', 'navigation', 'trail', 'header', 'page title', 'seo' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. BREADCRUMB
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_breadcrumb',
			[
				'label' => esc_html__( 'Breadcrumb', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_source',
			[
				'label'   => esc_html__( 'Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__( 'Automatic', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_home_label',
			[
				'label'     => esc_html__( 'Home Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Home', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_source' => 'dynamic' ],
			]
		);

		$this->add_control(
			'awea_home_icon',
			[
				'label'   => esc_html__( 'Home Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-home',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'awea_custom_title',
			[
				'label'       => esc_html__( 'Page Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_source' => 'custom' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_crumb_label',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Page', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_crumb_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_custom_crumbs',
			[
				'label'       => esc_html__( 'Trail Items', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_crumb_label }}}',
				'condition'   => [ 'awea_source' => 'custom' ],
				'default'     => [
					[
						'awea_crumb_label' => esc_html__( 'Home', 'awesome-widgets-elementor' ),
						'awea_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_crumb_label' => esc_html__( 'Services', 'awesome-widgets-elementor' ),
						'awea_crumb_url'   => [ 'url' => '#' ],
					],
					[
						'awea_crumb_label' => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
						'awea_crumb_url'   => [ 'url' => '' ],
					],
				],
			]
		);

		$this->add_control(
			'awea_show_title',
			[
				'label'        => esc_html__( 'Show Title', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Optional short context line...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_tag',
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
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_trail_pos',
			[
				'label'     => esc_html__( 'Trail Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Title', 'awesome-widgets-elementor' ),
					'below' => esc_html__( 'Below Title', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_sep_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'chevron',
				'options' => [
					'chevron' => esc_html__( 'Chevron ( › )', 'awesome-widgets-elementor' ),
					'slash'   => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'dot'     => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_sep_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_sep_type' => 'custom' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_align',
			[
				'label'                => esc_html__( 'Align', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea-bc-justify: flex-start; --awea-bc-ml: 0; --awea-bc-mr: auto;',
					'center' => 'text-align: center; --awea-bc-justify: center; --awea-bc-ml: auto; --awea-bc-mr: auto;',
					'right'  => 'text-align: right; --awea-bc-justify: flex-end; --awea-bc-ml: auto; --awea-bc-mr: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-bc-hero' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '76', 'right' => '24', 'bottom' => '76', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_border',
				'selector' => '{{WRAPPER}} .awea-bc-hero',
			]
		);

		$this->add_responsive_control(
			'awea_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BACKGROUND
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_background',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-bc-hero',
			]
		);

		$this->add_control(
			'awea_overlay_heading',
			[
				'label'     => esc_html__( 'Overlay', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_overlay',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-bc-hero::before',
			]
		);

		$this->add_responsive_control(
			'awea_overlay_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'   => [ 'size' => 0.65 ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-hero::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-bc-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-bc-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.72)',
				'condition' => [ 'awea_subtitle!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-bc-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_space',
			[
				'label'      => esc_html__( 'Space', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-header'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-nav-top' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TRAIL BAR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_trail',
			[
				'label' => esc_html__( 'Trail', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_trail_pill',
			[
				'label'        => esc_html__( 'Pill Box', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-bc-pill-',
			]
		);

		$this->add_control(
			'awea_pill_bg',
			[
				'label'     => esc_html__( 'Box Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.08)',
				'condition' => [ 'awea_trail_pill' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pill_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.14)',
				'condition' => [ 'awea_trail_pill' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pill_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [ 'top' => '8', 'right' => '18', 'bottom' => '8', 'left' => '18', 'unit' => 'px', 'isLinked' => false ],
				'condition'  => [ 'awea_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pill_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'condition'  => [ 'awea_trail_pill' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-bc-pill-yes .awea-bc-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_trail_typo',
				'selector' => '{{WRAPPER}} .awea-bc-list',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->start_controls_tabs( 'awea_trail_tabs' );

		$this->start_controls_tab(
			'awea_trail_link',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.74)',
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_trail_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_trail_current',
			[ 'label' => esc_html__( 'Current', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_current_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-bc-item.is-current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-sep'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-sep svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-bc-sep i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sep_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-bc-sep' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.38)',
				'selectors' => [
					'{{WRAPPER}} .awea-bc-sep'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-bc-sep svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build full WordPress dynamic breadcrumb trail (Pages, Posts, CPTs, Taxonomies, Archives).
	 */
	private function get_dynamic_breadcrumbs( $home_label ) {
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
			$blog_id    = get_option( 'page_for_posts' );
			$blog_title = $blog_id ? get_the_title( $blog_id ) : esc_html__( 'Blog', 'awesome-widgets-elementor' );
			$crumbs[]   = [ 'label' => $blog_title, 'url' => null ];
			return $crumbs;
		}

		if ( is_singular() ) {
			$post      = get_queried_object();
			$post_type = get_post_type( $post );

			if ( 'post' === $post_type ) {
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					$crumbs[] = [
						'label' => $cats[0]->name,
						'url'   => get_category_link( $cats[0]->term_id ),
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
			} else {
				$pto = get_post_type_object( $post_type );
				if ( $pto && ! empty( $pto->has_archive ) ) {
					$crumbs[] = [
						'label' => $pto->labels->name,
						'url'   => get_post_type_archive_link( $post_type ),
					];
				}
			}

			$crumbs[] = [ 'label' => get_the_title( $post->ID ), 'url' => null ];
		} elseif ( is_post_type_archive() ) {
			$crumbs[] = [ 'label' => post_type_archive_title( '', false ), 'url' => null ];
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term && ! is_wp_error( $term ) ) {
				$crumbs[] = [ 'label' => $term->name, 'url' => null ];
			}
		} elseif ( is_search() ) {
			$crumbs[] = [
				'label' => sprintf( esc_html__( 'Search: "%s"', 'awesome-widgets-elementor' ), get_search_query() ),
				'url'   => null,
			];
		} elseif ( is_author() ) {
			$crumbs[] = [
				'label' => get_the_author_meta( 'display_name', get_query_var( 'author' ) ),
				'url'   => null,
			];
		} elseif ( is_404() ) {
			$crumbs[] = [ 'label' => esc_html__( 'Page Not Found', 'awesome-widgets-elementor' ), 'url' => null ];
		} elseif ( is_archive() ) {
			$crumbs[] = [ 'label' => wp_strip_all_tags( get_the_archive_title() ), 'url' => null ];
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
		$sep_type      = $settings['awea_sep_type'] ?? 'chevron';
		$has_home_icon = ! empty( $settings['awea_home_icon']['value'] );
		$total_items   = count( $crumbs );
		?>
		<nav class="awea-bc-nav <?php echo esc_attr( $extra_class ); ?>" aria-label="<?php esc_attr_e( 'Breadcrumb', 'awesome-widgets-elementor' ); ?>">
			<ol class="awea-bc-list" itemscope itemtype="https://schema.org/BreadcrumbList">
				<?php foreach ( $crumbs as $index => $crumb ) :
					$is_last  = ( $index === $total_items - 1 );
					$position = $index + 1;
					$is_home  = ! empty( $crumb['is_home'] ) || 0 === $index;
					?>
					<li class="awea-bc-item <?php echo $is_last ? 'is-current' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<?php if ( ! empty( $crumb['url'] ) && ! $is_last ) : ?>
							<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item">
								<?php if ( $is_home && $has_home_icon ) : ?>
									<span class="awea-bc-home-ico" aria-hidden="true">
										<?php Icons_Manager::render_icon( $settings['awea_home_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>
								<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
							</a>
						<?php else : ?>
							<span class="awea-bc-text" aria-current="page" itemprop="name">
								<?php echo esc_html( $crumb['label'] ); ?>
							</span>
						<?php endif; ?>

						<meta itemprop="position" content="<?php echo esc_attr( (string) $position ); ?>" />

						<?php if ( ! $is_last ) : ?>
							<span class="awea-bc-sep" aria-hidden="true">
								<?php if ( 'chevron' === $sep_type ) : ?>
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
								<?php elseif ( 'slash' === $sep_type ) : ?>
									/
								<?php elseif ( 'dot' === $sep_type ) : ?>
									•
								<?php elseif ( 'custom' === $sep_type && ! empty( $settings['awea_sep_icon']['value'] ) ) : ?>
									<?php Icons_Manager::render_icon( $settings['awea_sep_icon'], [ 'aria-hidden' => 'true' ] ); ?>
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
		$settings   = $this->get_settings_for_display();
		$source     = $settings['awea_source'] ?? 'dynamic';
		$home_label = ! empty( $settings['awea_home_label'] ) ? $settings['awea_home_label'] : esc_html__( 'Home', 'awesome-widgets-elementor' );
		$show_title = 'yes' === ( $settings['awea_show_title'] ?? 'no' );
		$subtitle   = $settings['awea_subtitle'] ?? '';
		$title_tag  = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h1' );
		$trail_pos  = $settings['awea_trail_pos'] ?? 'below';

		if ( 'custom' === $source ) {
			$page_title   = $settings['awea_custom_title'] ?? '';
			$custom_items = $settings['awea_custom_crumbs'] ?? [];
			$crumbs       = [];

			foreach ( $custom_items as $idx => $item ) {
				$crumbs[] = [
					'label'   => $item['awea_crumb_label'] ?? '',
					'url'     => $item['awea_crumb_url']['url'] ?? '',
					'is_home' => ( 0 === $idx ),
				];
			}
		} else {
			if ( is_404() ) {
				$page_title = esc_html__( '404 — Page Not Found', 'awesome-widgets-elementor' );
			} elseif ( is_search() ) {
				$page_title = sprintf( esc_html__( 'Results for "%s"', 'awesome-widgets-elementor' ), get_search_query() );
			} elseif ( is_archive() ) {
				$page_title = wp_strip_all_tags( get_the_archive_title() );
			} else {
				$page_title = get_the_title();
			}
			$crumbs = $this->get_dynamic_breadcrumbs( $home_label );
		}
		?>
		<header class="awea-bc-hero">
			<div class="awea-bc-inner">

				<?php
				if ( $show_title && 'above' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings, 'awea-bc-nav-top' );
				}
				?>

				<?php if ( $show_title && ! empty( $page_title ) ) : ?>
					<div class="awea-bc-header">
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-bc-title">
							<?php echo esc_html( $page_title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

						<?php if ( ! empty( $subtitle ) ) : ?>
							<p class="awea-bc-subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				if ( ! $show_title || 'below' === $trail_pos ) {
					$this->render_trail( $crumbs, $settings );
				}
				?>

			</div>
		</header>
		<?php
	}
}