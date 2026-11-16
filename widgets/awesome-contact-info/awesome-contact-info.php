<?php
/**
 * Awesome Contact Info Studio Widget (Zero-Shadow Architectural Edition).
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
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_Contact_Info extends Widget_Base {

	public function get_name() {
		return 'awea-contact-info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-unread';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'contact', 'info', 'directory', 'phone', 'email', 'address' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get In Touch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Reach our team directly via email, phone, or studio visit.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
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
				'condition' => [ 'awea_title!' => '' ],
			]
		);

		$this->add_control(
			'awea_accent_bar',
			[
				'label'        => esc_html__( 'Accent Bar', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_title!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_label',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Direct Email', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_value',
			[
				'label'       => esc_html__( 'Value', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'hello@example.com', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_subtext',
			[
				'label'       => esc_html__( 'Subtext', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Replies within 2 hours', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'mailto:hello@example.com',
			]
		);

		$repeater->add_control(
			'awea_copy',
			[
				'label'        => esc_html__( 'Copy Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_items',
			[
				'label'       => esc_html__( 'List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_label }}}: {{{ awea_value }}}',
				'default'     => [
					[
						'awea_label'   => esc_html__( 'Direct Inquiries', 'awesome-widgets-elementor' ),
						'awea_value'   => 'support@devnahian.com',
						'awea_subtext' => esc_html__( 'Average response under 2 hrs', 'awesome-widgets-elementor' ),
						'awea_icon'    => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
						'awea_link'    => [ 'url' => 'mailto:support@devnahian.com' ],
						'awea_copy'    => 'yes',
					],
					[
						'awea_label'   => esc_html__( 'Telephone Support', 'awesome-widgets-elementor' ),
						'awea_value'   => '+1 (800) 456-7890',
						'awea_subtext' => esc_html__( 'Mon–Fri • 9:00 AM – 6:00 PM', 'awesome-widgets-elementor' ),
						'awea_icon'    => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
						'awea_link'    => [ 'url' => 'tel:+18004567890' ],
						'awea_copy'    => 'yes',
					],
					[
						'awea_label'   => esc_html__( 'Main Headquarters', 'awesome-widgets-elementor' ),
						'awea_value'   => '100 Montgomery St, San Francisco, CA',
						'awea_subtext' => esc_html__( 'Suite 400 • Financial District', 'awesome-widgets-elementor' ),
						'awea_icon'    => [ 'value' => 'fas fa-map-marker-alt', 'library' => 'fa-solid' ],
						'awea_copy'    => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-ci-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_show_arrow',
			[
				'label'        => esc_html__( 'Show Arrow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-ci-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_bar_color',
			[
				'label'     => esc_html__( 'Bar Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_accent_bar' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-header' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_header_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_cards',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '20', 'right' => '22', 'bottom' => '20', 'left' => '22', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-row' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_tabs' );

		$this->start_controls_tab(
			'awea_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-ci-row',
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
			'awea_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_icon',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-ci-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '14', 'right' => '14', 'bottom' => '14', 'left' => '14', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ci-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_tabs' );

		$this->start_controls_tab(
			'awea_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-ci-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_label_heading',
			[
				'label' => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_label_typo',
				'selector' => '{{WRAPPER}} .awea-ci-label',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_label_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_value_heading',
			[
				'label'     => esc_html__( 'Value', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_value_typo',
				'selector' => '{{WRAPPER}} .awea-ci-value',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_value_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_value_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ci-row:hover .awea-ci-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_subtext_heading',
			[
				'label'     => esc_html__( 'Subtext', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_subtext_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .awea-ci-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$title      = $settings['awea_title'] ?? '';
		$subtitle   = $settings['awea_subtitle'] ?? '';
		$title_tag  = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );
		$accent_bar = 'yes' === ( $settings['awea_accent_bar'] ?? 'no' );
		$items      = $settings['awea_items'] ?? [];
		$show_arrow = 'yes' === ( $settings['awea_show_arrow'] ?? 'no' );
		$widget_id  = $this->get_id();

		$header_classes = [ 'awea-ci-header' ];
		if ( ! $accent_bar ) {
			$header_classes[] = 'awea-ci-no-bar';
		}
		?>
		<div class="awea-ci-wrap" id="awea-ci-<?php echo esc_attr( $widget_id ); ?>">

			<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
				<header class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-ci-title">
							<?php echo esc_html( $title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $subtitle ) ) : ?>
						<p class="awea-ci-subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<div class="awea-ci-grid">
					<?php foreach ( $items as $index => $item ) :
						$id       = $item['_id'] ?? $index;
						$row_key  = 'row_' . $id;
						$link_key = 'link_' . $id;

						$label    = $item['awea_label'] ?? '';
						$val      = $item['awea_value'] ?? '';
						$subtext  = $item['awea_subtext'] ?? '';
						$can_copy = 'yes' === ( $item['awea_copy'] ?? '' );
						$has_url  = ! empty( $item['awea_link']['url'] );

						$row_classes = [
							'awea-ci-row',
							'elementor-repeater-item-' . esc_attr( $id ),
						];
						if ( $has_url ) {
							$row_classes[] = 'awea-ci-has-link';
						}
						if ( $can_copy && ! $has_url ) {
							$row_classes[] = 'awea-ci-row-copy';
						}

						$this->add_render_attribute( $row_key, 'class', $row_classes );

						if ( $can_copy && ! empty( $val ) ) {
							$this->add_render_attribute( $row_key, 'data-copy-text', esc_attr( $val ) );
						}

						if ( $has_url ) {
							$this->add_link_attributes( $link_key, $item['awea_link'] );
							$this->add_render_attribute( $link_key, 'class', 'awea-ci-cover-link' );
							$this->add_render_attribute( $link_key, 'aria-label', esc_attr( $label . ': ' . $val ) );
						}
						?>
						<div <?php $this->print_render_attribute_string( $row_key ); ?>>

							<?php if ( $has_url ) : ?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>></a>
							<?php endif; ?>

							<div class="awea-ci-icon" aria-hidden="true">
								<?php Icons_Manager::render_icon( $item['awea_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>

							<div class="awea-ci-body">
								<?php if ( ! empty( $label ) ) : ?>
									<span class="awea-ci-label"><?php echo esc_html( $label ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $val ) ) : ?>
									<span class="awea-ci-value"><?php echo esc_html( $val ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $subtext ) ) : ?>
									<span class="awea-ci-subtext"><?php echo esc_html( $subtext ); ?></span>
								<?php endif; ?>
							</div>

							<div class="awea-ci-actions">
								<?php if ( $can_copy && ! empty( $val ) ) : ?>
									<button type="button" class="awea-ci-copy-btn" aria-label="<?php esc_attr_e( 'Copy to clipboard', 'awesome-widgets-elementor' ); ?>">
										<svg class="awea-ci-ico-copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
										<svg class="awea-ci-ico-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
										<span class="awea-ci-copy-label"><?php esc_html_e( 'Copied', 'awesome-widgets-elementor' ); ?></span>
									</button>
								<?php endif; ?>

								<?php if ( $show_arrow && $has_url ) : ?>
									<span class="awea-ci-arrow" aria-hidden="true">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
											<line x1="7" y1="17" x2="17" y2="7"></line>
											<polyline points="7 7 17 7 17 17"></polyline>
										</svg>
									</span>
								<?php endif; ?>
							</div>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function initContactInfo() {
				var scope = document.getElementById('awea-ci-<?php echo esc_js( $widget_id ); ?>');
				if (!scope || scope.__aweaBound) return;
				scope.__aweaBound = true;

				function triggerCopy(row) {
					var text = row.getAttribute('data-copy-text');
					if (!text || !navigator.clipboard) return;
					navigator.clipboard.writeText(text);
					row.classList.add('is-copied');
					clearTimeout(row.__copyTimer);
					row.__copyTimer = setTimeout(function() {
						row.classList.remove('is-copied');
					}, 1800);
				}

				scope.querySelectorAll('.awea-ci-copy-btn').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						var row = this.closest('.awea-ci-row');
						if (row) triggerCopy(row);
					});
				});

				scope.querySelectorAll('.awea-ci-row-copy').forEach(function(row) {
					row.addEventListener('click', function() {
						triggerCopy(this);
					});
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initContactInfo);
			} else {
				initContactInfo();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea-contact-info.default', initContactInfo);
			}
		})();
		</script>
		<?php
	}
}