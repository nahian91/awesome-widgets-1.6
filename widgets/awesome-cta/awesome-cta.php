<?php
/**
 * Awesome CTA Widget.
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
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;

class Widget_Awesome_CTA extends Widget_Base {

	public function get_name() {
		return 'awesome-cta';
	}

	public function get_title() {
		return esc_html__( 'CTA', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'cta', 'hero', 'banner', 'action', 'button', 'convert' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_badge_show',
			[
				'label'        => esc_html__( 'Show Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_badge_icon',
			[
				'label'     => esc_html__( 'Badge Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_text',
			[
				'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ready to Launch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 3,
				'default'   => esc_html__( 'Elevate Your Digital Presence Today.', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_hl_text',
			[
				'label'       => esc_html__( 'Highlight Phrase', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Digital Presence', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_hl_style',
			[
				'label'        => esc_html__( 'Highlight Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'color',
				'options'      => [
					'color'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Clean Underline', 'awesome-widgets-elementor' ),
					'marker'    => esc_html__( 'Soft Marker', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_hl_text!' => '' ],
				'prefix_class' => 'awea-cta-hl-',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
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

		$this->add_control(
			'awea_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'The all-in-one suite to construct, launch, and scale high-performance brand experiences with zero bloat.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_note',
			[
				'label'       => esc_html__( 'Micro-Trust Footnote', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'No credit card required • Instant setup • Cancel anytime', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. PRIMARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_btn1',
			[
				'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_btn1_show',
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
			'awea_btn1_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn1_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn1_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn1_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_btn1_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SECOND BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_btn2',
			[
				'label' => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_btn2_show',
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
			'awea_btn2_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Book Live Demo', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn2_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn2_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-calendar-check',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn2_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_btn2_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_layout_mode',
			[
				'label'        => esc_html__( 'Layout Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'stacked' => esc_html__( 'Stacked', 'awesome-widgets-elementor' ),
					'split'   => esc_html__( 'Split Row', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cta-mode-',
			]
		);

		$this->add_responsive_control(
			'awea_align',
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
				'condition'            => [ 'awea_layout_mode' => 'stacked' ],
				'selectors_dictionary' => [
					'left'   => 'left; --awea-cta-justify: flex-start; --awea-cta-ml: 0; --awea-cta-mr: auto',
					'center' => 'center; --awea-cta-justify: center; --awea-cta-ml: auto; --awea-cta-mr: auto',
					'right'  => 'right; --awea-cta-justify: flex-end; --awea-cta-ml: auto; --awea-cta-mr: 0',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-cta-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_box',
			[
				'label' => esc_html__( 'Container Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_max_width',
			[
				'label'      => esc_html__( 'Content Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1160 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '64',
					'right'    => '48',
					'bottom'   => '64',
					'left'     => '48',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cta-box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_border',
				'selector'       => '{{WRAPPER}} .awea-cta-box',
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
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->add_responsive_control(
			'awea_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '28',
					'right'    => '28',
					'bottom'   => '28',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_box_shadow',
				'selector' => '{{WRAPPER}} .awea-cta-box',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_badge_border',
				'selector'       => '{{WRAPPER}} .awea-cta-badge',
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
					'color'  => [ 'default' => 'rgba(79, 70, 229, 0.16)' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_badge_typo',
				'selector' => '{{WRAPPER}} .awea-cta-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '7',
					'right'    => '16',
					'bottom'   => '7',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_radius',
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
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_badge_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_text',
			[
				'label' => esc_html__( 'Typography & Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_title_heading',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_hl_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-hl' => 'color: {{VALUE}}; --awea-cta-hl: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typo',
				'selector' => '{{WRAPPER}} .awea-cta-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_desc_heading',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typo',
				'selector' => '{{WRAPPER}} .awea-cta-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_desc_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1000 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 640 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 34 ],
				'condition'  => [ 'awea_layout_mode' => 'stacked' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_note_heading',
			[
				'label'     => esc_html__( 'Footnote', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_note!' => '' ],
			]
		);

		$this->add_control(
			'awea_note_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'condition' => [ 'awea_note!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_note_typo',
				'selector'  => '{{WRAPPER}} .awea-cta-note',
				'condition' => [ 'awea_note!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_buttons',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-cta-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_btn_gap',
			[
				'label'      => esc_html__( 'Button Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '15',
					'right'    => '30',
					'bottom'   => '15',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cta-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Primary Button Colors
		$this->add_control(
			'awea_btn1_heading',
			[
				'label'     => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_btn1_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_btn1_tabs',
			[ 'condition' => [ 'awea_btn1_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_btn1_border',
				'selector'       => '{{WRAPPER}} .awea-cta-btn-primary',
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

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn1_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn1_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-primary:hover, {{WRAPPER}} .awea-cta-btn-primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Secondary Button Colors
		$this->add_control(
			'awea_btn2_heading',
			[
				'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_btn2_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs(
			'awea_btn2_tabs',
			[ 'condition' => [ 'awea_btn2_show' => 'yes' ] ]
		);

		$this->start_controls_tab(
			'awea_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_btn2_border',
				'selector'       => '{{WRAPPER}} .awea-cta-btn-secondary',
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
					'color'  => [ 'default' => '#cbd5e1' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn2_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cta-btn-secondary:hover, {{WRAPPER}} .awea-cta-btn-secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Safely highlight a phrase inside title text without breaking HTML tags or entities.
	 */
	private function format_highlighted_title( $title, $hl_text ) {
		$safe_title = wp_kses_post( $title );
		if ( empty( $hl_text ) ) {
			return $safe_title;
		}

		$safe_hl = wp_kses_post( $hl_text );
		$pattern = '/(' . preg_quote( $safe_hl, '/' ) . ')(?![^<]*>)/';

		return preg_replace(
			$pattern,
			'<span class="awea-cta-hl">$1</span>',
			$safe_title,
			1
		);
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$badge_show = 'yes' === ( $settings['awea_badge_show'] ?? 'no' );
		$badge_text = $settings['awea_badge_text'] ?? '';

		$title     = $settings['awea_title'] ?? '';
		$hl_text   = trim( $settings['awea_hl_text'] ?? '' );
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );
		$desc      = $settings['awea_desc'] ?? '';
		$note      = $settings['awea_note'] ?? '';

		$btn1_show  = 'yes' === ( $settings['awea_btn1_show'] ?? 'no' );
		$btn1_text  = $settings['awea_btn1_text'] ?? '';
		$btn1_pos   = $settings['awea_btn1_icon_pos'] ?? 'right';
		$has_b1_ico = ! empty( $settings['awea_btn1_icon']['value'] );

		$btn2_show  = 'yes' === ( $settings['awea_btn2_show'] ?? 'no' );
		$btn2_text  = $settings['awea_btn2_text'] ?? '';
		$btn2_pos   = $settings['awea_btn2_icon_pos'] ?? 'left';
		$has_b2_ico = ! empty( $settings['awea_btn2_icon']['value'] );

		$this->remove_render_attribute( 'btn1' );
		if ( $btn1_show ) {
			$btn1_link = ! empty( $settings['awea_btn1_link']['url'] ) ? $settings['awea_btn1_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn1', $btn1_link );
			$this->add_render_attribute( 'btn1', 'class', 'awea-cta-btn awea-cta-btn-primary' );
		}

		$this->remove_render_attribute( 'btn2' );
		if ( $btn2_show ) {
			$btn2_link = ! empty( $settings['awea_btn2_link']['url'] ) ? $settings['awea_btn2_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'btn2', $btn2_link );
			$this->add_render_attribute( 'btn2', 'class', 'awea-cta-btn awea-cta-btn-secondary' );
		}

		$formatted_title = $this->format_highlighted_title( $title, $hl_text );
		?>
		<section class="awea-cta-box">
			<div class="awea-cta-inner">

				<div class="awea-cta-copy">
					<?php if ( $badge_show && ! empty( $badge_text ) ) : ?>
						<div class="awea-cta-badge">
							<?php if ( ! empty( $settings['awea_badge_icon']['value'] ) ) : ?>
								<span class="awea-cta-badge-ico" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
							<span><?php echo esc_html( $badge_text ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-cta-title">
							<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $desc ) ) : ?>
						<p class="awea-cta-desc"><?php echo wp_kses_post( $desc ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) || ! empty( $note ) ) : ?>
					<div class="awea-cta-action-col">
						<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) ) : ?>
							<div class="awea-cta-actions">
								<?php if ( $btn1_show && ! empty( $btn1_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'btn1' ); ?>>
										<?php if ( 'left' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn1_text ); ?></span>

										<?php if ( 'right' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>

								<?php if ( $btn2_show && ! empty( $btn2_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'btn2' ); ?>>
										<?php if ( 'left' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn2_text ); ?></span>

										<?php if ( 'right' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $note ) ) : ?>
							<p class="awea-cta-note"><?php echo esc_html( $note ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var tag      = elementor.helpers.validateHTMLTag( settings.awea_title_tag || 'h2' );
		var title    = settings.awea_title || '';
		var hlText   = ( settings.awea_hl_text || '' ).trim();
		var badgeIco = elementor.helpers.renderIcon( view, settings.awea_badge_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn1Ico  = elementor.helpers.renderIcon( view, settings.awea_btn1_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn2Ico  = elementor.helpers.renderIcon( view, settings.awea_btn2_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn1Url  = ( settings.awea_btn1_link && settings.awea_btn1_link.url ) ? settings.awea_btn1_link.url : '#';
		var btn2Url  = ( settings.awea_btn2_link && settings.awea_btn2_link.url ) ? settings.awea_btn2_link.url : '#';

		if ( hlText ) {
			var escapedRegex = hlText.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
			var hlRegex      = new RegExp( '(' + escapedRegex + ')(?![^<]*>)' );
			title            = title.replace( hlRegex, '<span class="awea-cta-hl">$1</span>' );
		}
		#>
		<section class="awea-cta-box">
			<div class="awea-cta-inner">

				<div class="awea-cta-copy">
					<# if ( 'yes' === settings.awea_badge_show && settings.awea_badge_text ) { #>
						<div class="awea-cta-badge">
							<# if ( badgeIco && badgeIco.rendered ) { #>
								<span class="awea-cta-badge-ico" aria-hidden="true">{{{ badgeIco.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_badge_text }}}</span>
						</div>
					<# } #>

					<# if ( title ) { #>
						<{{{ tag }}} class="awea-cta-title">{{{ title }}}</{{{ tag }}}>
					<# } #>

					<# if ( settings.awea_desc ) { #>
						<p class="awea-cta-desc">{{{ settings.awea_desc }}}</p>
					<# } #>
				</div>

				<# if ( ( 'yes' === settings.awea_btn1_show && settings.awea_btn1_text ) || ( 'yes' === settings.awea_btn2_show && settings.awea_btn2_text ) || settings.awea_note ) { #>
					<div class="awea-cta-action-col">
						<# if ( ( 'yes' === settings.awea_btn1_show && settings.awea_btn1_text ) || ( 'yes' === settings.awea_btn2_show && settings.awea_btn2_text ) ) { #>
							<div class="awea-cta-actions">
								<# if ( 'yes' === settings.awea_btn1_show && settings.awea_btn1_text ) { #>
									<a href="{{ btn1Url }}" class="awea-cta-btn awea-cta-btn-primary">
										<# if ( 'left' === settings.awea_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_btn1_text }}}</span>
										<# if ( 'right' === settings.awea_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>

								<# if ( 'yes' === settings.awea_btn2_show && settings.awea_btn2_text ) { #>
									<a href="{{ btn2Url }}" class="awea-cta-btn awea-cta-btn-secondary">
										<# if ( 'left' === settings.awea_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-left" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_btn2_text }}}</span>
										<# if ( 'right' === settings.awea_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea-cta-ico awea-cta-ico-right" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>
							</div>
						<# } #>

						<# if ( settings.awea_note ) { #>
							<p class="awea-cta-note">{{{ settings.awea_note }}}</p>
						<# } #>
					</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}