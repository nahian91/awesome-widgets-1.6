<?php
/**
 * Awesome Navigation Menu Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   1.8.0
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

if ( ! class_exists( __NAMESPACE__ . '\AWEA_Nav_Menu_Walker' ) ) {
	/**
	 * Custom Menu Walker to natively append submenu indicators and ARIA attributes.
	 */
	class AWEA_Nav_Menu_Walker extends \Walker_Nav_Menu {
		private $show_indicator;

		public function __construct( $show_indicator = true ) {
			$this->show_indicator = (bool) $show_indicator;
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$classes   = empty( $item->classes ) ? [] : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$has_children = in_array( 'menu-item-has-children', $classes, true );

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$item_id = $item_id ? ' id="' . esc_attr( $item_id ) . '"' : '';

			$output .= '<li' . $item_id . $class_names . '>';

			$atts           = [];
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

			if ( $has_children ) {
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
			}

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output  = $args->before ?? '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= '<span class="awea_nav_menu_label">' . ( $args->link_before ?? '' ) . wp_kses_post( $title ) . ( $args->link_after ?? '' ) . '</span>';

			if ( $has_children && $this->show_indicator ) {
				$item_output .= '<span class="awea_nav_menu_sub_indicator" aria-hidden="true">';
				$item_output .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';
				$item_output .= '</span>';
			}

			$item_output .= '</a>';
			$item_output .= $args->after ?? '';

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}

class Widget_Awesome_Nav_Menu extends Widget_Base {

	public function get_name() {
		return 'awesome-nav-menu';
	}

	public function get_title() {
		return esc_html__( 'Nav Menu', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'awesome-header-footer' ];
	}

	public function get_keywords() {
		return [ 'awea', 'nav', 'menu', 'navigation', 'header', 'navbar', 'links', 'mobile' ];
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
		   CONTENT TAB: 1. MENU
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_section_content',
			[
				'label' => esc_html__( 'Menu', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$menus        = wp_get_nav_menus();
		$menu_options = [];
		if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
			foreach ( $menus as $menu ) {
				$menu_options[ $menu->term_id ] = $menu->name;
			}
		}

		$this->add_control(
			'awea_nav_menu_selected',
			[
				'label'       => esc_html__( 'Select Menu', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $menu_options,
				'default'     => ! empty( $menu_options ) ? array_key_first( $menu_options ) : '',
				'description' => empty( $menu_options ) ? esc_html__( 'Create a menu in Appearance > Menus.', 'awesome-widgets-elementor' ) : '',
			]
		);

		$this->add_control(
			'awea_nav_menu_show_indicator',
			[
				'label'        => esc_html__( 'Submenu Indicator', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_nav_menu_has_indicator_',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_layout',
			[
				'label'                => esc_html__( 'Direction', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'row'    => [
						'title' => esc_html__( 'Horizontal', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__( 'Vertical', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-ellipsis-v',
					],
				],
				'default'              => 'row',
				'prefix_class'         => 'awea_nav_menu_layout_',
				'selectors_dictionary' => [
					'row'    => 'flex-direction: row; align-items: center;',
					'column' => 'flex-direction: column; align-items: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_nav_menu_list' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'    => [
						'title' => esc_html__( 'Start', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'      => [
						'title' => esc_html__( 'End', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Space Between', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_pointer_style',
			[
				'label'        => esc_html__( 'Active / Hover Pointer', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'      => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Underline Bar', 'awesome-widgets-elementor' ),
					'dot'       => esc_html__( 'Accent Dot', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_nav_menu_pointer_',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 3. MOBILE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_section_mobile',
			[
				'label' => esc_html__( 'Mobile Drawer', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_nav_menu_breakpoint',
			[
				'label'        => esc_html__( 'Breakpoint', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'mobile',
				'options'      => [
					'none'   => esc_html__( 'None (Always Expanded)', 'awesome-widgets-elementor' ),
					'tablet' => esc_html__( 'Tablet (≤ 1024px)', 'awesome-widgets-elementor' ),
					'mobile' => esc_html__( 'Mobile (≤ 767px)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_nav_menu_breakpoint_',
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_toggle_align',
			[
				'label'     => esc_html__( 'Toggle Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'flex-end',
				'condition' => [
					'awea_nav_menu_breakpoint!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_toggle_wrapper' => 'justify-content: {{VALUE}};',
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
		   STYLE TAB: 1. MENU
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_main',
			[
				'label' => esc_html__( 'Top-Level Menu', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nav_menu_typography',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'selector' => '{{WRAPPER}} .awea_nav_menu_list > li > a',
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_item_spacing',
			[
				'label'      => esc_html__( 'Gap Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '8',
					'right'    => '16',
					'bottom'   => '8',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_item_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_pointer_color',
			[
				'label'     => esc_html__( 'Pointer Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_nav_menu_pointer_style!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nav_menu_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_nav_menu_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_bg_color',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_nav_menu_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a:hover, {{WRAPPER}} .awea_nav_menu_list > li:hover > a, {{WRAPPER}} .awea_nav_menu_list > li > a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li > a:hover, {{WRAPPER}} .awea_nav_menu_list > li:hover > a, {{WRAPPER}} .awea_nav_menu_list > li > a:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active
		$this->start_controls_tab(
			'awea_nav_menu_tab_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_color_active',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li.current-menu-item > a, {{WRAPPER}} .awea_nav_menu_list > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_bg_active',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list > li.current-menu-item > a, {{WRAPPER}} .awea_nav_menu_list > li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. INDICATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_indicator',
			[
				'label'     => esc_html__( 'Submenu Indicator', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nav_menu_show_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_indicator_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 24 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_sub_indicator'     => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_nav_menu_sub_indicator svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_indicator_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list li > a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_indicator_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_sub_indicator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_indicator_hover_color',
			[
				'label'     => esc_html__( 'Hover & Active Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list li:hover > a .awea_nav_menu_sub_indicator, {{WRAPPER}} .awea_nav_menu_list li > a:focus-visible .awea_nav_menu_sub_indicator, {{WRAPPER}} .awea_nav_menu_list li.current-menu-item > a .awea_nav_menu_sub_indicator, {{WRAPPER}} .awea_nav_menu_list li.current-menu-ancestor > a .awea_nav_menu_sub_indicator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. DROPDOWN
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_dropdown',
			[
				'label' => esc_html__( 'Dropdown Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_submenu_width',
			[
				'label'      => esc_html__( 'Min Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 150, 'max' => 400 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 220,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_submenu_offset',
			[
				'label'      => esc_html__( 'Offset Distance', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_submenu_offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_submenu_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_submenu_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_submenu_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_nav_menu_submenu_border',
				'selector' => '{{WRAPPER}} .awea_nav_menu_list ul.sub-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nav_menu_submenu_shadow',
				'selector' => '{{WRAPPER}} .awea_nav_menu_list ul.sub-menu',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. SUBMENU
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_submenu_links',
			[
				'label' => esc_html__( 'Submenu Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nav_menu_submenu_typography',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
				'selector' => '{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a',
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_subitem_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '10',
					'right'    => '16',
					'bottom'   => '10',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_subitem_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_subitem_divider',
			[
				'label'     => esc_html__( 'Item Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li:not(:last-child)' => 'border-bottom: 1px solid {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nav_menu_subitem_tabs' );

		$this->start_controls_tab(
			'awea_nav_menu_subitem_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_subitem_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_subitem_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nav_menu_subitem_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_subitem_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a:hover, {{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_subitem_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a:hover, {{WRAPPER}} .awea_nav_menu_list ul.sub-menu li a:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nav_menu_subitem_tab_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_subitem_active_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li.current-menu-item > a, {{WRAPPER}} .awea_nav_menu_list ul.sub-menu li.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_subitem_active_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_list ul.sub-menu li.current-menu-item > a, {{WRAPPER}} .awea_nav_menu_list ul.sub-menu li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 5. TOGGLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_toggle',
			[
				'label'     => esc_html__( 'Mobile Toggle', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nav_menu_breakpoint!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_toggle_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 32, 'max' => 64 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_toggle_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 14, 'max' => 36 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_nav_menu_toggle_border',
				'selector' => '{{WRAPPER}} .awea_nav_menu_toggle_btn',
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_toggle_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nav_menu_toggle_state_tabs' );

		$this->start_controls_tab(
			'awea_nav_menu_toggle_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_toggle_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn svg' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_toggle_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nav_menu_toggle_tab_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_menu_toggle_active_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn[aria-expanded="true"] svg' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_toggle_active_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_toggle_btn[aria-expanded="true"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 6. DRAWER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nav_menu_style_drawer',
			[
				'label'     => esc_html__( 'Mobile Drawer', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nav_menu_breakpoint!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_drawer_offset',
			[
				'label'      => esc_html__( 'Top Offset', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 40 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_drawer_offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_drawer_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_drawer_bg: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_drawer_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_drawer_padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_menu_drawer_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_drawer_radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_menu_drawer_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_nav_menu_wrapper' => '--awea_nav_menu_drawer_border: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$menu_id  = absint( $settings['awea_nav_menu_selected'] ?? 0 );

		if ( ! $menu_id ) {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<div class="awea_nav_menu_notice" style="padding:16px; background:#fef3c7; color:#b45309; border-radius:8px; font-size:13px; font-weight:600;">' . esc_html__( 'Please select a menu in the widget settings.', 'awesome-widgets-elementor' ) . '</div>';
			}
			return;
		}

		$unique_id      = $this->get_id();
		$show_indicator = ( 'yes' === ( $settings['awea_nav_menu_show_indicator'] ?? 'yes' ) );
		$has_breakpoint = ( 'none' !== ( $settings['awea_nav_menu_breakpoint'] ?? 'mobile' ) );
		$nav_id         = 'awea_nav_menu_container_' . $unique_id;
		?>
		<div class="awea_nav_menu_wrapper" data-awea_nav_menu_id="<?php echo esc_attr( $unique_id ); ?>">

			<?php if ( $has_breakpoint ) : ?>
				<div class="awea_nav_menu_toggle_wrapper">
					<button type="button" class="awea_nav_menu_toggle_btn" aria-expanded="false" aria-controls="<?php echo esc_attr( $nav_id ); ?>" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'awesome-widgets-elementor' ); ?>">
						<svg class="awea_nav_menu_icon_open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<line x1="3" y1="12" x2="21" y2="12"></line>
							<line x1="3" y1="6" x2="21" y2="6"></line>
							<line x1="3" y1="18" x2="21" y2="18"></line>
						</svg>
						<svg class="awea_nav_menu_icon_close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>
				</div>
			<?php endif; ?>

			<nav id="<?php echo esc_attr( $nav_id ); ?>" class="awea_nav_menu_container" aria-label="<?php esc_attr_e( 'Main Menu', 'awesome-widgets-elementor' ); ?>">
				<?php
				wp_nav_menu(
					[
						'menu'        => $menu_id,
						'menu_class'  => 'menu awea_nav_menu_list',
						'container'   => false,
						'fallback_cb' => '__return_false',
						'walker'      => new AWEA_Nav_Menu_Walker( $show_indicator ),
					]
				);
				?>
			</nav>
		</div>

		<script>
		(function() {
			function awea_nav_menu_bind(wrapper) {
				if (!wrapper || wrapper.dataset.aweaNavMenuBound === '1') return;
				wrapper.dataset.aweaNavMenuBound = '1';

				var toggleBtn     = wrapper.querySelector('.awea_nav_menu_toggle_btn');
				var menuContainer = wrapper.querySelector('.awea_nav_menu_container');

				function closeDrawer() {
					if (!toggleBtn || !menuContainer) return;
					toggleBtn.setAttribute('aria-expanded', 'false');
					menuContainer.classList.remove('awea_nav_menu_open');
					wrapper.querySelectorAll('.menu-item-has-children.awea_nav_menu_sub_open').forEach(function(li) {
						li.classList.remove('awea_nav_menu_sub_open');
						var anchor = li.querySelector(':scope > a');
						if (anchor) anchor.setAttribute('aria-expanded', 'false');
					});
				}

				if (toggleBtn && menuContainer) {
					toggleBtn.addEventListener('click', function(e) {
						e.preventDefault();
						var expanded = this.getAttribute('aria-expanded') === 'true';
						if (expanded) {
							closeDrawer();
						} else {
							this.setAttribute('aria-expanded', 'true');
							menuContainer.classList.add('awea_nav_menu_open');
						}
					});

					document.addEventListener('click', function(e) {
						if (!document.body.contains(wrapper)) return;
						if (!wrapper.contains(e.target) && menuContainer.classList.contains('awea_nav_menu_open')) {
							closeDrawer();
						}
					});

					document.addEventListener('keydown', function(e) {
						if (!document.body.contains(wrapper)) return;
						if (e.key === 'Escape' && menuContainer.classList.contains('awea_nav_menu_open')) {
							closeDrawer();
							toggleBtn.focus();
						}
					});
				}

				// Mobile drawer submenu accordion toggle
				wrapper.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
					link.addEventListener('click', function(e) {
						var toggleVisible = toggleBtn && window.getComputedStyle(toggleBtn.parentElement).display !== 'none';
						if (!toggleVisible) return;

						var parentLi = this.parentElement;
						var subMenu  = parentLi ? parentLi.querySelector(':scope > ul.sub-menu') : null;
						if (!subMenu) return;

						var href = (this.getAttribute('href') || '').trim();
						var isPlaceholder = !href || href === '#';
						var isOpen = parentLi.classList.contains('awea_nav_menu_sub_open');

						if (isPlaceholder || !isOpen) {
							e.preventDefault();
							parentLi.classList.toggle('awea_nav_menu_sub_open', !isOpen);
							this.setAttribute('aria-expanded', String(!isOpen));
						}
					});
				});

				// Desktop keyboard Escape support to close focused submenus
				wrapper.addEventListener('keydown', function(e) {
					if (e.key === 'Escape') {
						var focusedItem = wrapper.querySelector('.menu-item-has-children:focus-within');
						if (focusedItem) {
							var parentAnchor = focusedItem.querySelector(':scope > a');
							if (parentAnchor) parentAnchor.focus();
						}
					}
				});
			}

			function awea_nav_menu_init() {
				awea_nav_menu_bind(document.querySelector('[data-awea_nav_menu_id="<?php echo esc_js( $unique_id ); ?>"]'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_nav_menu_init);
			} else {
				awea_nav_menu_init();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.awea_nav_menu_hooked) {
				window.awea_nav_menu_hooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-nav-menu.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_nav_menu_wrapper') : null;
					awea_nav_menu_bind(el);
				});
			}
		})();
		</script>
		<?php
	}
}