<?php
/**
 * Awesome Heading Widget.
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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Heading extends Widget_Base {

	public function get_name() {
		return 'awesome-heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'heading', 'title', 'hero', 'section', 'divider', 'typography' ];
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
			'awea_heading_section_badge',
			[
				'label' => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_badge_show',
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
			'awea_heading_badge_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Architecture • 2026', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_heading_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_badge_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [ 'awea_heading_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_badge_dot',
			[
				'label'        => esc_html__( 'Live Pulse Dot', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_heading_badge_show' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. HEADING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_heading',
			[
				'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_title',
			[
				'label'   => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Built Beyond the Standard Grid.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_heading_highlight_text',
			[
				'label'       => esc_html__( 'Highlight Phrase', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Type any word or phrase from your Title to highlight it.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Standard Grid.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_heading_highlight_style',
			[
				'label'        => esc_html__( 'Highlight Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'color',
				'options'      => [
					'color'     => esc_html__( 'Accent Color', 'awesome-widgets-elementor' ),
					'gradient'  => esc_html__( 'Gradient Fill', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
					'marker'    => esc_html__( 'Marker Pill', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_heading_highlight_text!' => '' ],
				'prefix_class' => 'awea_heading_hl_',
			]
		);

		$this->add_control(
			'awea_heading_title_tag',
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
					'p'    => 'p',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_description',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_desc',
			[
				'label'   => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => esc_html__( 'Reimagining digital interfaces through clean architectural structure, balanced typography, and effortless clarity.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. DIVIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_divider',
			[
				'label' => esc_html__( 'Divider', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_divider_style',
			[
				'label'        => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'beam',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'beam'  => esc_html__( 'Animated Beam', 'awesome-widgets-elementor' ),
					'solid' => esc_html__( 'Solid Line', 'awesome-widgets-elementor' ),
					'dots'  => esc_html__( 'Accent Dots', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_heading_div_',
			]
		);

		$this->add_control(
			'awea_heading_divider_pos',
			[
				'label'     => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'above' => esc_html__( 'Above Title', 'awesome-widgets-elementor' ),
					'below' => esc_html__( 'Below Title', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_heading_divider_style!' => 'none' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. PRIMARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_btn1',
			[
				'label' => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_btn1_show',
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
			'awea_heading_btn1_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_heading_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn1_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_heading_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn1_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_heading_btn1_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn1_icon_pos',
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
					'awea_heading_btn1_show'        => 'yes',
					'awea_heading_btn1_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 6. SECONDARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_btn2',
			[
				'label' => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_heading_btn2_show',
			[
				'label'        => esc_html__( 'Display Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_heading_btn2_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_heading_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn2_link',
			[
				'label'     => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [ 'active' => true ],
				'default'   => [ 'url' => '#' ],
				'condition' => [ 'awea_heading_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn2_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [ 'awea_heading_btn2_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_btn2_icon_pos',
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
					'awea_heading_btn2_show'        => 'yes',
					'awea_heading_btn2_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 7. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_heading_align',
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
					'left'   => 'start; --awea_heading_justify: flex-start; --awea_heading_ml: 0; --awea_heading_mr: auto',
					'center' => 'center; --awea_heading_justify: center; --awea_heading_ml: auto; --awea_heading_mr: auto',
					'right'  => 'end; --awea_heading_justify: flex-end; --awea_heading_ml: auto; --awea_heading_mr: 0',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_heading_wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 320, 'max' => 1400 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 820 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_wrap' => 'max-width: {{SIZE}}{{UNIT}};',
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
		   STYLE: 1. BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_badge_show' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_heading_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_heading_badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_badge svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_pulse'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_badge_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_badge_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_badge_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_heading_badge_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_heading_badge_typo',
				'selector' => '{{WRAPPER}} .awea_heading_badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_heading_badge_border',
				'selector'       => '{{WRAPPER}} .awea_heading_badge',
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
			'awea_heading_badge_radius',
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
					'{{WRAPPER}} .awea_heading_badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_badge_padding',
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
					'{{WRAPPER}} .awea_heading_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_badge_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_badge_wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. HEADING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_heading',
			[
				'label'     => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_title!' => '' ],
			]
		);

		$this->add_control(
			'awea_heading_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_hl_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_heading_highlight_text!' => '' ],
				'selectors' => [
					'{{WRAPPER}} .awea_heading_hl' => 'color: {{VALUE}}; --awea_heading_hl_accent: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_hl_color_end',
			[
				'label'     => esc_html__( 'Gradient End Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ec4899',
				'condition' => [
					'awea_heading_highlight_text!' => '',
					'awea_heading_highlight_style' => 'gradient',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_heading_hl' => '--awea_heading_hl_end: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_heading_title_typo',
				'selector' => '{{WRAPPER}} .awea_heading_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_heading_title_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. DIVIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_divider',
			[
				'label'     => esc_html__( 'Divider', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_divider_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_heading_div_width',
			[
				'label'      => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 320 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 96 ],
				'condition'  => [ 'awea_heading_divider_style!' => 'dots' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_div' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_div_height',
			[
				'label'      => esc_html__( 'Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'condition'  => [ 'awea_heading_divider_style!' => 'dots' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_div' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_dot_size',
			[
				'label'      => esc_html__( 'Dot Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 16 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'condition'  => [ 'awea_heading_divider_style' => 'dots' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_div_track',
			[
				'label'     => esc_html__( 'Track Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'condition' => [ 'awea_heading_divider_style' => 'beam' ],
				'selectors' => [
					'{{WRAPPER}} .awea_heading_div' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_div_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}}.awea_heading_div_beam .awea_heading_div::after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea_heading_div_solid .awea_heading_div'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea_heading_div_dots .awea_heading_dot'        => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_div_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_div_wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_desc',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_desc!' => '' ],
			]
		);

		$this->add_control(
			'awea_heading_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_heading_desc_typo',
				'selector' => '{{WRAPPER}} .awea_heading_desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_heading_desc_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 280, 'max' => 1100 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 660 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_desc_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BUTTONS (SHARED)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_buttons',
			[
				'label' => esc_html__( 'Buttons (Shared)', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_heading_btn_typo',
				'selector' => '{{WRAPPER}} .awea_heading_btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_heading_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_btn_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_heading_btn_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_btn_gap',
			[
				'label'      => esc_html__( 'Gap Between Buttons', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '14',
					'right'    => '28',
					'bottom'   => '14',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_heading_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_heading_btn_radius',
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
					'{{WRAPPER}} .awea_heading_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. PRIMARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_btn1',
			[
				'label'     => esc_html__( 'Primary Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_btn1_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs( 'awea_heading_btn1_tabs' );

		$this->start_controls_tab(
			'awea_heading_btn1_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_heading_btn1_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_primary'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_btn_primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn1_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_heading_btn1_border',
				'selector'       => '{{WRAPPER}} .awea_heading_btn_primary',
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
				'name'     => 'awea_heading_btn1_shadow',
				'selector' => '{{WRAPPER}} .awea_heading_btn_primary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_heading_btn1_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_heading_btn1_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_primary:hover, {{WRAPPER}} .awea_heading_btn_primary:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_btn_primary:hover svg, {{WRAPPER}} .awea_heading_btn_primary:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn1_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_primary:hover, {{WRAPPER}} .awea_heading_btn_primary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn1_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_primary:hover, {{WRAPPER}} .awea_heading_btn_primary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_heading_btn1_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_heading_btn_primary:hover, {{WRAPPER}} .awea_heading_btn_primary:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 7. SECONDARY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_heading_style_btn2',
			[
				'label'     => esc_html__( 'Secondary Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_heading_btn2_show' => 'yes' ],
			]
		);

		$this->start_controls_tabs( 'awea_heading_btn2_tabs' );

		$this->start_controls_tab(
			'awea_heading_btn2_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_heading_btn2_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_secondary'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_btn_secondary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn2_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_heading_btn2_border',
				'selector'       => '{{WRAPPER}} .awea_heading_btn_secondary',
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
				'name'     => 'awea_heading_btn2_shadow',
				'selector' => '{{WRAPPER}} .awea_heading_btn_secondary',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_heading_btn2_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_heading_btn2_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_secondary:hover, {{WRAPPER}} .awea_heading_btn_secondary:focus-visible'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_heading_btn_secondary:hover svg, {{WRAPPER}} .awea_heading_btn_secondary:focus-visible svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn2_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_secondary:hover, {{WRAPPER}} .awea_heading_btn_secondary:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_btn2_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_heading_btn_secondary:hover, {{WRAPPER}} .awea_heading_btn_secondary:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_heading_btn2_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_heading_btn_secondary:hover, {{WRAPPER}} .awea_heading_btn_secondary:focus-visible',
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
			'<span class="awea_heading_hl">$1</span>',
			$safe_title,
			1
		);
	}

	/**
	 * Render divider helper so it can appear cleanly above or below title.
	 */
	protected function render_divider( $style ) {
		if ( 'none' === $style ) {
			return;
		}
		?>
		<div class="awea_heading_div_wrap" aria-hidden="true">
			<?php if ( 'dots' === $style ) : ?>
				<div class="awea_heading_dots">
					<span class="awea_heading_dot"></span>
					<span class="awea_heading_dot"></span>
					<span class="awea_heading_dot"></span>
				</div>
			<?php else : ?>
				<div class="awea_heading_div"></div>
			<?php endif; ?>
		</div>
		<?php
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$badge_show = 'yes' === ( $settings['awea_heading_badge_show'] ?? 'no' );
		$badge_text = $settings['awea_heading_badge_text'] ?? '';
		$badge_dot  = 'yes' === ( $settings['awea_heading_badge_dot'] ?? 'no' );

		$title     = $settings['awea_heading_title'] ?? '';
		$hl_text   = trim( $settings['awea_heading_highlight_text'] ?? '' );
		$title_tag = Utils::validate_html_tag( $settings['awea_heading_title_tag'] ?? 'h2' );

		$div_style = $settings['awea_heading_divider_style'] ?? 'beam';
		$div_pos   = $settings['awea_heading_divider_pos'] ?? 'below';

		$desc = $settings['awea_heading_desc'] ?? '';

		$btn1_show  = 'yes' === ( $settings['awea_heading_btn1_show'] ?? 'no' );
		$btn1_text  = $settings['awea_heading_btn1_text'] ?? '';
		$btn1_pos   = $settings['awea_heading_btn1_icon_pos'] ?? 'right';
		$has_b1_ico = ! empty( $settings['awea_heading_btn1_icon']['value'] );

		$btn2_show  = 'yes' === ( $settings['awea_heading_btn2_show'] ?? 'no' );
		$btn2_text  = $settings['awea_heading_btn2_text'] ?? '';
		$btn2_pos   = $settings['awea_heading_btn2_icon_pos'] ?? 'right';
		$has_b2_ico = ! empty( $settings['awea_heading_btn2_icon']['value'] );

		$this->remove_render_attribute( 'awea_heading_btn1' );
		if ( $btn1_show ) {
			$btn1_link = ! empty( $settings['awea_heading_btn1_link']['url'] ) ? $settings['awea_heading_btn1_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_heading_btn1', $btn1_link );
			$this->add_render_attribute( 'awea_heading_btn1', 'class', [ 'awea_heading_btn', 'awea_heading_btn_primary' ] );
		}

		$this->remove_render_attribute( 'awea_heading_btn2' );
		if ( $btn2_show ) {
			$btn2_link = ! empty( $settings['awea_heading_btn2_link']['url'] ) ? $settings['awea_heading_btn2_link'] : [ 'url' => '#' ];
			$this->add_link_attributes( 'awea_heading_btn2', $btn2_link );
			$this->add_render_attribute( 'awea_heading_btn2', 'class', [ 'awea_heading_btn', 'awea_heading_btn_secondary' ] );
		}

		$formatted_title = $this->format_highlighted_title( $title, $hl_text );
		?>
		<div class="awea_heading_wrap">

			<?php if ( $badge_show && ! empty( $badge_text ) ) : ?>
				<div class="awea_heading_badge_wrap">
					<span class="awea_heading_badge">
						<?php if ( $badge_dot ) : ?>
							<span class="awea_heading_pulse" aria-hidden="true"></span>
						<?php endif; ?>

						<?php if ( ! empty( $settings['awea_heading_badge_icon']['value'] ) ) : ?>
							<span class="awea_heading_badge_ico" aria-hidden="true">
								<?php Icons_Manager::render_icon( $settings['awea_heading_badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>

						<span><?php echo esc_html( $badge_text ); ?></span>
					</span>
				</div>
			<?php endif; ?>

			<?php
			if ( 'above' === $div_pos ) {
				$this->render_divider( $div_style );
			}
			?>

			<?php if ( ! empty( $title ) ) : ?>
				<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_heading_title">
					<?php echo $formatted_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
			<?php endif; ?>

			<?php
			if ( 'below' === $div_pos ) {
				$this->render_divider( $div_style );
			}
			?>

			<?php if ( ! empty( $desc ) ) : ?>
				<p class="awea_heading_desc"><?php echo wp_kses_post( $desc ); ?></p>
			<?php endif; ?>

			<?php if ( ( $btn1_show && ! empty( $btn1_text ) ) || ( $btn2_show && ! empty( $btn2_text ) ) ) : ?>
				<div class="awea_heading_actions">
					<?php if ( $btn1_show && ! empty( $btn1_text ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'awea_heading_btn1' ); ?>>
							<?php if ( 'left' === $btn1_pos && $has_b1_ico ) : ?>
								<span class="awea_heading_btn_ico awea_heading_ico_left" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_heading_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span><?php echo esc_html( $btn1_text ); ?></span>

							<?php if ( 'right' === $btn1_pos && $has_b1_ico ) : ?>
								<span class="awea_heading_btn_ico awea_heading_ico_right" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_heading_btn1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<?php if ( $btn2_show && ! empty( $btn2_text ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'awea_heading_btn2' ); ?>>
							<?php if ( 'left' === $btn2_pos && $has_b2_ico ) : ?>
								<span class="awea_heading_btn_ico awea_heading_ico_left" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_heading_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span><?php echo esc_html( $btn2_text ); ?></span>

							<?php if ( 'right' === $btn2_pos && $has_b2_ico ) : ?>
								<span class="awea_heading_btn_ico awea_heading_ico_right" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_heading_btn2_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var tag      = elementor.helpers.validateHTMLTag( settings.awea_heading_title_tag || 'h2' );
		var title    = settings.awea_heading_title || '';
		var hlText   = ( settings.awea_heading_highlight_text || '' ).trim();
		var divStyle = settings.awea_heading_divider_style || 'beam';
		var divPos   = settings.awea_heading_divider_pos || 'below';
		var badgeIco = elementor.helpers.renderIcon( view, settings.awea_heading_badge_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn1Ico  = elementor.helpers.renderIcon( view, settings.awea_heading_btn1_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn2Ico  = elementor.helpers.renderIcon( view, settings.awea_heading_btn2_icon, { 'aria-hidden': true }, 'i' , 'object' );
		var btn1Url  = ( settings.awea_heading_btn1_link && settings.awea_heading_btn1_link.url ) ? settings.awea_heading_btn1_link.url : '#';
		var btn2Url  = ( settings.awea_heading_btn2_link && settings.awea_heading_btn2_link.url ) ? settings.awea_heading_btn2_link.url : '#';

		if ( hlText ) {
			var escapedRegex = hlText.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' );
			var hlRegex      = new RegExp( '(' + escapedRegex + ')(?![^<]*>)' );
			title            = title.replace( hlRegex, '<span class="awea_heading_hl">$1</span>' );
		}
		#>
		<div class="awea_heading_wrap">
			<# if ( 'yes' === settings.awea_heading_badge_show && settings.awea_heading_badge_text ) { #>
				<div class="awea_heading_badge_wrap">
					<span class="awea_heading_badge">
						<# if ( 'yes' === settings.awea_heading_badge_dot ) { #>
							<span class="awea_heading_pulse" aria-hidden="true"></span>
						<# } #>
						<# if ( badgeIco && badgeIco.rendered ) { #>
							<span class="awea_heading_badge_ico" aria-hidden="true">{{{ badgeIco.value }}}</span>
						<# } #>
						<span>{{{ settings.awea_heading_badge_text }}}</span>
					</span>
				</div>
			<# } #>

			<# if ( 'none' !== divStyle && 'above' === divPos ) { #>
				<div class="awea_heading_div_wrap" aria-hidden="true">
					<# if ( 'dots' === divStyle ) { #>
						<div class="awea_heading_dots"><span class="awea_heading_dot"></span><span class="awea_heading_dot"></span><span class="awea_heading_dot"></span></div>
					<# } else { #>
						<div class="awea_heading_div"></div>
					<# } #>
				</div>
			<# } #>

			<# if ( title ) { #>
				<{{{ tag }}} class="awea_heading_title">{{{ title }}}</{{{ tag }}}>
			<# } #>

			<# if ( 'none' !== divStyle && 'below' === divPos ) { #>
				<div class="awea_heading_div_wrap" aria-hidden="true">
					<# if ( 'dots' === divStyle ) { #>
						<div class="awea_heading_dots"><span class="awea_heading_dot"></span><span class="awea_heading_dot"></span><span class="awea_heading_dot"></span></div>
					<# } else { #>
						<div class="awea_heading_div"></div>
					<# } #>
				</div>
			<# } #>

			<# if ( settings.awea_heading_desc ) { #>
				<p class="awea_heading_desc">{{{ settings.awea_heading_desc }}}</p>
			<# } #>

			<# if ( ( 'yes' === settings.awea_heading_btn1_show && settings.awea_heading_btn1_text ) || ( 'yes' === settings.awea_heading_btn2_show && settings.awea_heading_btn2_text ) ) { #>
				<div class="awea_heading_actions">
					<# if ( 'yes' === settings.awea_heading_btn1_show && settings.awea_heading_btn1_text ) { #>
						<a href="{{ btn1Url }}" class="awea_heading_btn awea_heading_btn_primary">
							<# if ( 'left' === settings.awea_heading_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
								<span class="awea_heading_btn_ico awea_heading_ico_left" aria-hidden="true">{{{ btn1Ico.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_heading_btn1_text }}}</span>
							<# if ( 'right' === settings.awea_heading_btn1_icon_pos && btn1Ico && btn1Ico.rendered ) { #>
								<span class="awea_heading_btn_ico awea_heading_ico_right" aria-hidden="true">{{{ btn1Ico.value }}}</span>
							<# } #>
						</a>
					<# } #>

					<# if ( 'yes' === settings.awea_heading_btn2_show && settings.awea_heading_btn2_text ) { #>
						<a href="{{ btn2Url }}" class="awea_heading_btn awea_heading_btn_secondary">
							<# if ( 'left' === settings.awea_heading_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
								<span class="awea_heading_btn_ico awea_heading_ico_left" aria-hidden="true">{{{ btn2Ico.value }}}</span>
							<# } #>
							<span>{{{ settings.awea_heading_btn2_text }}}</span>
							<# if ( 'right' === settings.awea_heading_btn2_icon_pos && btn2Ico && btn2Ico.rendered ) { #>
								<span class="awea_heading_btn_ico awea_heading_ico_right" aria-hidden="true">{{{ btn2Ico.value }}}</span>
							<# } #>
						</a>
					<# } #>
				</div>
			<# } #>
		</div>
		<?php
	}
}