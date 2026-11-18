<?php
/**
 * Awesome Counter Widget.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class Widget_Awesome_Counter extends Widget_Base {

	public function get_name() {
		return 'awesome-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'counter', 'stats', 'grid', 'metrics', 'odometer', 'number' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Counters', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_item_tabs' );

		// --- TAB 1: NUMBER ---
		$repeater->start_controls_tab(
			'awea_tab_number',
			[ 'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_start',
			[
				'label'   => esc_html__( 'Starting Number', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_target',
			[
				'label'   => esc_html__( 'Ending Number', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_decimals',
			[
				'label'   => esc_html__( 'Decimal Places', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 4,
				'step'    => 1,
				'default' => 0,
			]
		);

		$repeater->add_control(
			'awea_prefix',
			[
				'label'       => esc_html__( 'Prefix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => '$',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_suffix',
			[
				'label'       => esc_html__( 'Suffix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '+',
				'placeholder' => '+',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_duration',
			[
				'label'   => esc_html__( 'Animation Duration (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
				'default' => 2200,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: CONTENT ---
		$repeater->start_controls_tab(
			'awea_tab_content',
			[ 'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_subtext',
			[
				'label'       => esc_html__( 'Subtext (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'e.g. Verified Q4 metrics', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_item_border',
			[
				'label'     => esc_html__( 'Card Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_beam',
			[
				'label'     => esc_html__( 'Hover Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-cnt-item-beam: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_items',
			[
				'label'       => esc_html__( 'Counter Cards', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_prefix }}}{{{ awea_target }}}{{{ awea_suffix }}} — {{{ awea_title }}}',
				'default'     => [
					[
						'awea_target' => 150,
						'awea_suffix' => '+',
						'awea_title'  => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
						'awea_icon'   => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
					],
					[
						'awea_target'   => 99.9,
						'awea_decimals' => 1,
						'awea_suffix'   => '%',
						'awea_title'    => esc_html__( 'Uptime SLA Guarantee', 'awesome-widgets-elementor' ),
						'awea_icon'     => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
					],
					[
						'awea_prefix' => '$',
						'awea_target' => 45,
						'awea_suffix' => 'M',
						'awea_title'  => esc_html__( 'Client Revenue Generated', 'awesome-widgets-elementor' ),
						'awea_icon'   => [ 'value' => 'fas fa-chart-line', 'library' => 'fa-solid' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT & OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_layout',
			[
				'label' => esc_html__( 'Layout & Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-cnt-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_card_direction',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'vertical',
				'options'      => [
					'vertical'   => esc_html__( 'Vertical Stacked', 'awesome-widgets-elementor' ),
					'horizontal' => esc_html__( 'Horizontal (Icon Left)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cnt-dir-',
			]
		);

		$this->add_control(
			'awea_thousand_sep',
			[
				'label'        => esc_html__( 'Thousand Separator ( , )', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_beam_enable',
			[
				'label'        => esc_html__( 'Kinetic Border Beam', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-cnt-beam-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_align',
			[
				'label'                => esc_html__( 'Content Alignment', 'awesome-widgets-elementor' ),
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
				'condition'            => [ 'awea_card_direction' => 'vertical' ],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}}.awea-cnt-dir-vertical .awea-cnt-card'  => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
					'{{WRAPPER}}.awea-cnt-dir-vertical .awea-cnt-stats' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '36',
					'right'    => '28',
					'bottom'   => '36',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_beam_color',
			[
				'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_beam_enable' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-grid' => '--awea-cnt-global-beam: {{VALUE}};',
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
					'{{WRAPPER}} .awea-cnt-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-cnt-card',
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

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-cnt-card',
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
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-card:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-cnt-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-cnt-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_icon',
			[
				'label' => esc_html__( 'Icon Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 58 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-cnt-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_space',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}}.awea-cnt-dir-vertical .awea-cnt-icon'   => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0;',
					'{{WRAPPER}}.awea-cnt-dir-horizontal .awea-cnt-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-cnt-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-cnt-icon svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .awea-cnt-icon' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .awea-cnt-card:hover .awea-cnt-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. NUMBER & AFFIXES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_number',
			[
				'label' => esc_html__( 'Number & Affixes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_num_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_num_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-val',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_num_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cnt-stats' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_affix_heading',
			[
				'label'     => esc_html__( 'Prefix & Suffix', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_affix_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-pre, {{WRAPPER}} .awea-cnt-suf' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_affix_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-pre, {{WRAPPER}} .awea-cnt-suf',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. LABEL & SUBTEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_label',
			[
				'label' => esc_html__( 'Label & Subtext', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea-cnt-lbl' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_label_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-lbl',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
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
					'{{WRAPPER}} .awea-cnt-subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_subtext_typo',
				'selector' => '{{WRAPPER}} .awea-cnt-subtext',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$items        = $settings['awea_items'] ?? [];
		$use_grouping = 'yes' === ( $settings['awea_thousand_sep'] ?? 'yes' );
		$widget_id    = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-cnt-grid" id="awea-cnt-<?php echo esc_attr( $widget_id ); ?>">
			<?php foreach ( $items as $index => $item ) :
				$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$start    = '' !== ( $item['awea_start'] ?? '' ) ? floatval( $item['awea_start'] ) : 0;
				$target   = '' !== ( $item['awea_target'] ?? '' ) ? floatval( $item['awea_target'] ) : 0;
				$decimals = ! empty( $item['awea_decimals'] ) ? min( 4, absint( $item['awea_decimals'] ) ) : 0;
				$duration = ! empty( $item['awea_duration'] ) ? absint( $item['awea_duration'] ) : 2200;
				$prefix   = $item['awea_prefix'] ?? '';
				$suffix   = $item['awea_suffix'] ?? '';
				$title    = $item['awea_title'] ?? '';
				$subtext  = $item['awea_subtext'] ?? '';
				$has_icon = ! empty( $item['awea_icon']['value'] );

				$card_key = 'card_' . $id;
				$this->remove_render_attribute( $card_key );
				$this->add_render_attribute( $card_key, 'class', [
					'awea-cnt-card',
					'elementor-repeater-item-' . $id,
				] );

				$this->add_render_attribute( $card_key, 'data-start', (string) $start );
				$this->add_render_attribute( $card_key, 'data-target', (string) $target );
				$this->add_render_attribute( $card_key, 'data-decimals', (string) $decimals );
				$this->add_render_attribute( $card_key, 'data-duration', (string) $duration );
				$this->add_render_attribute( $card_key, 'data-grouping', $use_grouping ? '1' : '0' );

				$formatted_start = $use_grouping
					? number_format( $start, $decimals, '.', ',' )
					: number_format( $start, $decimals, '.', '' );

				$formatted_target = $use_grouping
					? number_format( $target, $decimals, '.', ',' )
					: number_format( $target, $decimals, '.', '' );

				$final_aria_label = trim( $prefix . $formatted_target . $suffix );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<?php if ( $has_icon ) : ?>
						<div class="awea-cnt-icon" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<div class="awea-cnt-content">
						<div class="awea-cnt-stats" aria-label="<?php echo esc_attr( $final_aria_label ); ?>">
							<?php if ( ! empty( $prefix ) ) : ?>
								<span class="awea-cnt-pre" aria-hidden="true"><?php echo esc_html( $prefix ); ?></span>
							<?php endif; ?>

							<span class="awea-cnt-val" aria-hidden="true"><?php echo esc_html( $formatted_start ); ?></span>

							<?php if ( ! empty( $suffix ) ) : ?>
								<span class="awea-cnt-suf" aria-hidden="true"><?php echo esc_html( $suffix ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $title ) ) : ?>
							<p class="awea-cnt-lbl"><?php echo esc_html( $title ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $subtext ) ) : ?>
							<span class="awea-cnt-subtext"><?php echo esc_html( $subtext ); ?></span>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

		<script>
		(function() {
			function bindCounters(grid) {
				if (!grid || grid.dataset.aweaBound === '1') return;
				grid.dataset.aweaBound = '1';

				var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
				var cards = grid.querySelectorAll('.awea-cnt-card');

				cards.forEach(function(card) {
					var valEl = card.querySelector('.awea-cnt-val');
					if (!valEl) return;

					var start    = parseFloat(card.getAttribute('data-start')) || 0;
					var target   = parseFloat(card.getAttribute('data-target')) || 0;
					var decimals = parseInt(card.getAttribute('data-decimals'), 10) || 0;
					var duration = parseInt(card.getAttribute('data-duration'), 10) || 2200;
					var grouping = card.getAttribute('data-grouping') === '1';
					var started  = false;

					function formatNumber(num) {
						return num.toLocaleString('en-US', {
							useGrouping: grouping,
							minimumFractionDigits: decimals,
							maximumFractionDigits: decimals
						});
					}

					function runCount() {
						if (started) return;
						started = true;

						if (reduceMotion || start === target) {
							valEl.textContent = formatNumber(target);
							return;
						}

						var startTime = null;

						function step(timestamp) {
							if (!document.body.contains(card)) return;
							if (!startTime) startTime = timestamp;
							var elapsed  = timestamp - startTime;
							var progress = Math.min(elapsed / duration, 1);
							var eased    = 1 - Math.pow(1 - progress, 3);
							var current  = start + (target - start) * eased;

							valEl.textContent = formatNumber(current);

							if (progress < 1) {
								requestAnimationFrame(step);
							} else {
								valEl.textContent = formatNumber(target);
							}
						}

						requestAnimationFrame(step);
					}

					if ('IntersectionObserver' in window) {
						var observer = new IntersectionObserver(function(entries) {
							entries.forEach(function(entry) {
								if (entry.isIntersecting) {
									runCount();
									observer.disconnect();
								}
							});
						}, { threshold: 0.15 });
						observer.observe(card);
					} else {
						runCount();
					}
				});
			}

			function initById() {
				bindCounters(document.getElementById('awea-cnt-<?php echo esc_js( $widget_id ); ?>'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initById);
			} else {
				initById();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.aweaCounterHooked) {
				window.aweaCounterHooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-counter.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea-cnt-grid') : null;
					bindCounters(el);
				});
			}
		})();
		</script>
		<?php
	}
}