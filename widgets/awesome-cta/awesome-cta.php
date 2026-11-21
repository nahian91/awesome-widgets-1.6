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
use Elementor\Utils;

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
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_badge_show',
			[
				'label'        => esc_html__( 'Display Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_cta_badge_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_badge_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ready to Launch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_title',
			[
				'label'   => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Elevate Your Digital Presence Today.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_cta_hl_text',
			[
				'label'       => esc_html__( 'Highlight Phrase', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Digital Presence', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_cta_hl_style',
			[
				'label'        => esc_html__( 'Highlight Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'color',
				'options'      => [
					'color'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
					'marker'    => esc_html__( 'Marker Pill', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_cta_hl_text!' => '' ],
				'prefix_class' => 'awea_cta_hl_',
			]
		);

		$this->add_control(
			'awea_cta_title_tag',
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
					'p'    => 'p',
				],
			]
		);

		$this->add_control(
			'awea_cta_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'The all-in-one suite to construct, launch, and scale high-performance brand experiences with zero bloat.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_cta_note',
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
		   CONTENT: 3. PRIMARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_btn1',
			[
				'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_btn1_show',
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
			'awea_cta_btn1_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn1_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Before', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'After', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'right',
				'condition' => [
					'awea_cta_btn1_show'        => 'yes',
					'awea_cta_btn1_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. SECONDARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_btn2',
			[
				'label' => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_btn2_show',
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
			'awea_cta_btn2_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Book Live Demo', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-calendar-check',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_btn2_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Before', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'After', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'left',
				'condition' => [
					'awea_cta_btn2_show'        => 'yes',
					'awea_cta_btn2_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cta_layout_mode',
			[
				'label'        => esc_html__( 'Layout Mode', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'stacked' => esc_html__( 'Stacked Center / Hero', 'awesome-widgets-elementor' ),
					'split'   => esc_html__( 'Split Horizontal Banner', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_cta_mode_',
			]
		);

		$this->add_responsive_control(
			'awea_cta_align',
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
				'condition'            => [ 'awea_cta_layout_mode' => 'stacked' ],
				'selectors_dictionary' => [
					'left'   => 'start; --awea_cta_justify: flex-start; --awea_cta_ml: 0; --awea_cta_mr: auto',
					'center' => 'center; --awea_cta_justify: center; --awea_cta_ml: auto; --awea_cta_mr: auto',
					'right'  => 'end; --awea_cta_justify: flex-end; --awea_cta_ml: auto; --awea_cta_mr: 0',
				],
				'selectors'            => [
					'{{WRAPPER}}.awea_cta_mode_stacked .awea_cta_box'  => 'text-align: {{VALUE}};',
					'{{WRAPPER}}.awea_cta_mode_stacked .awea_cta_copy' => 'align-items: var(--awea_cta_justify);',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_split_valign',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Middle', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'   => 'center',
				'condition' => [ 'awea_cta_layout_mode' => 'split' ],
				'selectors' => [
					'{{WRAPPER}}.awea_cta_mode_split .awea_cta_inner' => 'align-items: {{VALUE}};',
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
		   STYLE: 1. BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_box',
			[
				'label' => esc_html__( 'Box Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cta_max_width',
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
					'{{WRAPPER}} .awea_cta_inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_padding',
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
					'{{WRAPPER}} .awea_cta_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cta_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea_cta_box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cta_border',
				'selector'       => '{{WRAPPER}} .awea_cta_box',
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
			'awea_cta_radius',
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
					'{{WRAPPER}} .awea_cta_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_box_shadow',
				'selector' => '{{WRAPPER}} .awea_cta_box',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cta_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cta_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_cta_badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_cta_badge svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_badge_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_cta_badge_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cta_badge_border',
				'selector'       => '{{WRAPPER}} .awea_cta_badge',
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
				'name'     => 'awea_cta_badge_typo',
				'selector' => '{{WRAPPER}} .awea_cta_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_padding',
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
					'{{WRAPPER}} .awea_cta_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_radius',
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
					'{{WRAPPER}} .awea_cta_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_badge_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cta_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_cta_hl_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea_cta_hl' => 'color: {{VALUE}}; --awea_cta_hl: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_title_typo',
				'selector' => '{{WRAPPER}} .awea_cta_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cta_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_desc_typo',
				'selector' => '{{WRAPPER}} .awea_cta_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_desc_width',
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
					'{{WRAPPER}} .awea_cta_desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 34 ],
				'condition'  => [ 'awea_cta_layout_mode' => 'stacked' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. FOOTNOTE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_note',
			[
				'label'     => esc_html__( 'Footnote', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cta_note!' => '' ],
			]
		);

		$this->add_control(
			'awea_cta_note_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_note_typo',
				'selector' => '{{WRAPPER}} .awea_cta_note',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_note_space',
			[
				'label'      => esc_html__( 'Top Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_note' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTONS (SHARED)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_buttons',
			[
				'label' => esc_html__( 'Buttons (Shared)', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cta_btn_typo',
				'selector' => '{{WRAPPER}} .awea_cta_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 15 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_cta_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_gap',
			[
				'label'      => esc_html__( 'Gap Between Buttons', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_cta_actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_padding',
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
					'{{WRAPPER}} .awea_cta_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cta_btn_radius',
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
					'{{WRAPPER}} .awea_cta_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. PRIMARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_btn1',
			[
				'label'     => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cta_btn1_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs( 'awea_cta_btn1_tabs' );

		$this->start_controls_tab(
			'awea_cta_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn1_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_primary'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_cta_btn_primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn1_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cta_btn1_border',
				'selector'       => '{{WRAPPER}} .awea_cta_btn_primary',
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn1_shadow',
				'selector' => '{{WRAPPER}} .awea_cta_btn_primary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cta_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn1_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_primary:hover, {{WRAPPER}} .awea_cta_btn_primary:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_cta_btn_primary:hover svg, {{WRAPPER}} .awea_cta_btn_primary:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn1_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_primary:hover, {{WRAPPER}} .awea_cta_btn_primary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn1_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_primary:hover, {{WRAPPER}} .awea_cta_btn_primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn1_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_cta_btn_primary:hover, {{WRAPPER}} .awea_cta_btn_primary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 8. SECONDARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cta_style_btn2',
			[
				'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_cta_btn2_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs( 'awea_cta_btn2_tabs' );

		$this->start_controls_tab(
			'awea_cta_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn2_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_secondary'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_cta_btn_secondary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn2_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_cta_btn2_border',
				'selector'       => '{{WRAPPER}} .awea_cta_btn_secondary',
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn2_shadow',
				'selector' => '{{WRAPPER}} .awea_cta_btn_secondary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cta_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cta_btn2_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_secondary:hover, {{WRAPPER}} .awea_cta_btn_secondary:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_cta_btn_secondary:hover svg, {{WRAPPER}} .awea_cta_btn_secondary:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn2_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_secondary:hover, {{WRAPPER}} .awea_cta_btn_secondary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cta_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_cta_btn_secondary:hover, {{WRAPPER}} .awea_cta_btn_secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cta_btn2_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_cta_btn_secondary:hover, {{WRAPPER}} .awea_cta_btn_secondary:focus-visible',
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
			'<span class="awea_cta_hl">$1</span>',
			$safe_title,
			1
		);
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$badge_show = 'yes' === ( $settings['awea_cta_badge_show'] ?? 'no' );
		$badge_text = $settings['awea_cta_badge_text'] ?? '';

		$title     = $settings['awea_cta_title'] ?? '';
		$hl_text   = trim( $settings['awea_cta_hl_text'] ?? '' );
		$title_tag = Utils::validate_html_tag( $settings['awea_cta_title_tag'] ?? 'h2' );
		$desc      = $settings['awea_cta_desc'] ?? '';
		$note      = $settings['awea_cta_note'] ?? '';

		$btn1_show  = 'yes' === ( $settings['awea_cta_btn1_show'] ?? 'no' );
		$btn1_text  = $settings['awea_cta_btn1_text'] ?? '';
		$btn1_pos   = $settings['awea_cta_btn1_icon_pos'] ?? 'right';
		$has_b1_ico = ! empty( $settings['awea_cta_btn1_icon']['value'] );

		$btn2_show  = 'yes' === ( $settings['awea_cta_btn2_show'] ?? 'no' );
		$btn2_text  = $settings['awea_cta_btn2_text'] ?? '';
		$btn2_pos   = $settings['awea_cta_btn2_icon_pos'] ?? 'left';
		$has_b2_ico = ! empty( $settings['awea_cta_btn2_icon']['value'] );

		$this->remove_render_attribute( 'awea_cta_btn1' );
		if ( $btn1_show ) {
			$btn1_link = ! empty( $settings['awea_cta_btn1_link']['url'] ) ? $settings['awea_cta_btn1_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_cta_btn1', $btn1_link );
			$this->add_render_attribute( 'awea_cta_btn1', 'class', 'awea_cta_btn awea_cta_btn_primary' );
		}

		$this->remove_render_attribute( 'awea_cta_btn2' );
		if ( $btn2_show ) {
			$btn2_link = ! empty( $settings['awea_cta_btn2_link']['url'] ) ? $settings['awea_cta_btn2_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_cta_btn2', $btn2_link );
			$this->add_render_attribute( 'awea_cta_btn2', 'class', 'awea_cta_btn awea_cta_btn_secondary' );
		}

		$formatted_title = $this->format_highlighted_title( $title, $hl_text );
		?>
		<section class="awea_cta_box">
			<div class="awea_cta_inner">

				<div class="awea_cta_copy">
					<?php if ( $badge_show && ! empty( $badge_text ) ) : ?>
						<div class="awea_cta_badge">
							<?php if ( ! empty( $settings['awea_cta_badge_icon']['value'] ) ) : ?>
								<span class="awea_cta_badge_ico" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_cta_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
							<span><?php echo esc_html( $badge_text ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_cta_title">
							<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $desc ) ) : ?>
						<p class="awea_cta_desc"><?php echo wp_kses_post( $desc ); ?></p>
					<?php endif; ?>
				</div>

				<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) || ! empty( $note ) ) : ?>
					<div class="awea_cta_action_col">
						<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) ) : ?>
							<div class="awea_cta_actions">
								<?php if ( $btn1_show && ! empty( $btn1_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'awea_cta_btn1' ); ?>>
										<?php if ( 'left' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea_cta_ico awea_cta_ico_left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn1_text ); ?></span>

										<?php if ( 'right' === $btn1_pos && $has_b1_ico ) : ?>
											<span class="awea_cta_ico awea_cta_ico_right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>

								<?php if ( $btn2_show && ! empty( $btn2_text ) ) : ?>
									<a <?php $this->print_render_attribute_string( 'awea_cta_btn2' ); ?>>
										<?php if ( 'left' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea_cta_ico awea_cta_ico_left" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>

										<span><?php echo esc_html( $btn2_text ); ?></span>

										<?php if ( 'right' === $btn2_pos && $has_b2_ico ) : ?>
											<span class="awea_cta_ico awea_cta_ico_right" aria-hidden="true">
												<?php Icons_Manager::render_icon( $settings['awea_cta_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $note ) ) : ?>
							<p class="awea_cta_note"><?php echo esc_html( $note ); ?></p>
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
		var tag      = elementor.helpers.validateHTMLTag( settings.awea_cta_title_tag || 'h2' );
		var title    = settings.awea_cta_title || '';
		var hlText   = ( settings.awea_cta_hl_text || '' ).trim();
		var badgeIco = elementor.helpers.renderIcon( view, settings.awea_cta_badge_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn1Ico  = elementor.helpers.renderIcon( view, settings.awea_cta_btn1_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn2Ico  = elementor.helpers.renderIcon( view, settings.awea_cta_btn2_icon, { 'aria-hidden': true }, 'i', 'object' );
		var btn1Url  = ( settings.awea_cta_btn1_link && settings.awea_cta_btn1_link.url ) ? settings.awea_cta_btn1_link.url : '#';
		var btn2Url  = ( settings.awea_cta_btn2_link && settings.awea_cta_btn2_link.url ) ? settings.awea_cta_btn2_link.url : '#';

		if ( hlText ) {
			var escapedRegex = hlText.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
			var hlRegex      = new RegExp( '(' + escapedRegex + ')(?![^<]*>)' );
			title            = title.replace( hlRegex, '<span class="awea_cta_hl">$1</span>' );
		}
		#>
		<section class="awea_cta_box">
			<div class="awea_cta_inner">

				<div class="awea_cta_copy">
					<# if ( 'yes' === settings.awea_cta_badge_show && settings.awea_cta_badge_text ) { #>
						<div class="awea_cta_badge">
							<# if ( badgeIco && badgeIco.rendered ) { #>
								<span class="awea_cta_badge_ico" aria-hidden="true">{{{ badgeIco.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_cta_badge_text }}}</span>
						</div>
					<# } #>

					<# if ( title ) { #>
						<{{{ tag }}} class="awea_cta_title">{{{ title }}}</{{{ tag }}}>
					<# } #>

					<# if ( settings.awea_cta_desc ) { #>
						<p class="awea_cta_desc">{{{ settings.awea_cta_desc }}}</p>
					<# } #>
				</div>

				<# if ( ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) || ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) || settings.awea_cta_note ) { #>
					<div class="awea_cta_action_col">
						<# if ( ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) || ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) ) { #>
							<div class="awea_cta_actions">
								<# if ( 'yes' === settings.awea_cta_btn1_show && settings.awea_cta_btn1_text ) { #>
									<a href="{{ btn1Url }}" class="awea_cta_btn awea_cta_btn_primary">
										<# if ( 'left' === settings.awea_cta_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea_cta_ico awea_cta_ico_left" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_cta_btn1_text }}}</span>
										<# if ( 'right' === settings.awea_cta_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
											<span class="awea_cta_ico awea_cta_ico_right" aria-hidden="true">{{{ btn1Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>

								<# if ( 'yes' === settings.awea_cta_btn2_show && settings.awea_cta_btn2_text ) { #>
									<a href="{{ btn2Url }}" class="awea_cta_btn awea_cta_btn_secondary">
										<# if ( 'left' === settings.awea_cta_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea_cta_ico awea_cta_ico_left" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
										<span>{{{ settings.awea_cta_btn2_text }}}</span>
										<# if ( 'right' === settings.awea_cta_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
											<span class="awea_cta_ico awea_cta_ico_right" aria-hidden="true">{{{ btn2Ico.value }}}</span>
										<# } #>
									</a>
								<# } #>
							</div>
						<# } #>

						<# if ( settings.awea_cta_note ) { #>
							<p class="awea_cta_note">{{{ settings.awea_cta_note }}}</p>
						<# } #>
					</div>
				<# } #>

			</div>
		</section>
		<?php
	}
}