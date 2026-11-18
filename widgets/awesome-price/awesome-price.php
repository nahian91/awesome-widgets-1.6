<?php
/**
 * Awesome Price Studio Widget.
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

class Widget_Awesome_Price extends Widget_Base {

	public function get_name() {
		return 'awesome-price';
	}

	public function get_title() {
		return esc_html__( 'Price Table', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'price', 'pricing', 'table', 'grid', 'plan', 'tier', 'subscription' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_items',
			[
				'label' => esc_html__( 'Tiers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_tier_tabs' );

		// --- TAB 1: HEADER ---
		$repeater->start_controls_tab(
			'awea_tab_header',
			[ 'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_featured',
			[
				'label'        => esc_html__( 'Featured', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_ribbon',
			[
				'label'     => esc_html__( 'Ribbon Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_featured' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: VALUES ---
		$repeater->start_controls_tab(
			'awea_tab_values',
			[ 'label' => esc_html__( 'Values', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_currency',
			[
				'label'   => esc_html__( 'Currency', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_price',
			[
				'label'   => esc_html__( 'Amount', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '79',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_period',
			[
				'label'   => esc_html__( 'Period', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'mo',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: FEATURES ---
		$repeater->start_controls_tab(
			'awea_tab_features',
			[ 'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ) ]
		);

		$feature_sub_repeater = new Repeater();

		$feature_sub_repeater->add_control(
			'awea_feat_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Unlimited Projects', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$feature_sub_repeater->add_control(
			'awea_feat_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$feature_sub_repeater->add_control(
			'awea_feat_active',
			[
				'label'        => esc_html__( 'Included', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_features_list',
			[
				'label'       => esc_html__( 'Checklist', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $feature_sub_repeater->get_controls(),
				'default'     => [
					[ 'awea_feat_text' => esc_html__( 'Unlimited Neural Projects', 'awesome-widgets-elementor' ), 'awea_feat_active' => 'yes' ],
					[ 'awea_feat_text' => esc_html__( 'Ultra-Low Latency API Access', 'awesome-widgets-elementor' ), 'awea_feat_active' => 'yes' ],
					[ 'awea_feat_text' => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ), 'awea_feat_active' => 'yes' ],
					[ 'awea_feat_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ), 'awea_feat_active' => 'yes' ],
				],
				'title_field' => '{{{ awea_feat_text }}}',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: BUTTON ---
		$repeater->start_controls_tab(
			'awea_tab_button',
			[ 'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_btn_text',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_btn_link',
			[
				'label'       => esc_html__( 'URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'placeholder' => 'https://example.com/checkout',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 5: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_pricing_tiers',
			[
				'label'       => esc_html__( 'Tiers', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_title }}} ({{{ awea_currency }}}{{{ awea_price }}})',
				'default'     => [
					[
						'awea_title'    => esc_html__( 'Starter', 'awesome-widgets-elementor' ),
						'awea_price'    => '29',
						'awea_btn_text' => esc_html__( 'Start Free Trial', 'awesome-widgets-elementor' ),
					],
					[
						'awea_title'    => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
						'awea_price'    => '79',
						'awea_featured' => 'yes',
						'awea_ribbon'   => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
						'awea_btn_text' => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
					],
					[
						'awea_title'    => esc_html__( 'Enterprise', 'awesome-widgets-elementor' ),
						'awea_price'    => '199',
						'awea_btn_text' => esc_html__( 'Contact Sales', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
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
					'{{WRAPPER}} .awea-pricing-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
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
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

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
					'{{WRAPPER}} .awea-pricing-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_card_border',
				'selector'       => '{{WRAPPER}} .awea-pricing-card',
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
				'selector' => '{{WRAPPER}} .awea-pricing-card',
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
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-pricing-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Featured Overrides
		$this->add_control(
			'awea_heading_featured_style',
			[
				'label'     => esc_html__( 'Featured', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_featured_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card.awea-is-featured' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_featured_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card.awea-is-featured' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_header_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-plan-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_header_bg',
			[
				'label'     => esc_html__( 'Title Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-plan-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_header_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-plan-tag',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_heading_ribbon_style',
			[
				'label'     => esc_html__( 'Ribbon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_ribbon_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-ribbon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ribbon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-ribbon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ribbon_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-ribbon',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. PRICING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_pricing',
			[
				'label' => esc_html__( 'Pricing', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_currency_color',
			[
				'label'     => esc_html__( 'Currency Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_currency_typo',
				'label'    => esc_html__( 'Currency Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-pricing-currency',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_price_color',
			[
				'label'     => esc_html__( 'Amount Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-amount' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-amount',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_period_color',
			[
				'label'     => esc_html__( 'Period Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-cycle' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_period_typo',
				'label'    => esc_html__( 'Period Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-pricing-cycle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. FEATURES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_features',
			[
				'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_feature_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-feature-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_feature_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-feature-item i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-pricing-feature-item svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_feature_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-feature-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_feature_disabled_color',
			[
				'label'     => esc_html__( 'Excluded Item Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-feature-item.is-disabled'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-pricing-feature-item.is-disabled i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-pricing-feature-item.is-disabled svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_feature_text_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-feature-item',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_feature_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-feature-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_btn_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_btn_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_btn_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_btn_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta:hover, {{WRAPPER}} .awea-pricing-btn-cta:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta:hover, {{WRAPPER}} .awea-pricing-btn-cta:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tiers    = $settings['awea_pricing_tiers'] ?? [];

		if ( empty( $tiers ) ) {
			return;
		}
		?>
		<div class="awea-pricing-grid">
			<?php foreach ( $tiers as $index => $tier ) :
				$id          = ! empty( $tier['_id'] ) ? sanitize_html_class( $tier['_id'] ) : $index;
				$title       = $tier['awea_title'] ?? '';
				$is_featured = 'yes' === ( $tier['awea_featured'] ?? 'no' );
				$ribbon_text = $tier['awea_ribbon'] ?? '';
				$currency    = $tier['awea_currency'] ?? '$';
				$price       = $tier['awea_price'] ?? '';
				$period      = $tier['awea_period'] ?? '';
				$features    = $tier['awea_features_list'] ?? [];
				$btn_text    = $tier['awea_btn_text'] ?? '';
				$link_key    = 'link_' . $id;

				$this->remove_render_attribute( $link_key );
				$btn_url = ! empty( $tier['awea_btn_link']['url'] ) ? $tier['awea_btn_link'] : [ 'url' => '#' ];
				$this->add_link_attributes( $link_key, $btn_url );
				$this->add_render_attribute( $link_key, 'class', 'awea-pricing-btn-cta' );

				$card_classes = [ 'awea-pricing-card', 'elementor-repeater-item-' . $id ];
				if ( $is_featured ) {
					$card_classes[] = 'awea-is-featured';
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

					<?php if ( $is_featured && ! empty( $ribbon_text ) ) : ?>
						<div class="awea-pricing-ribbon">
							<span><?php echo esc_html( $ribbon_text ); ?></span>
						</div>
					<?php endif; ?>

					<!-- Header & Pricing Block -->
					<div class="awea-pricing-card-header">
						<?php if ( ! empty( $title ) ) : ?>
							<span class="awea-pricing-plan-tag"><?php echo esc_html( $title ); ?></span>
						<?php endif; ?>

						<div class="awea-pricing-price-box">
							<?php if ( '' !== $currency ) : ?>
								<span class="awea-pricing-currency"><?php echo esc_html( $currency ); ?></span>
							<?php endif; ?>

							<?php if ( '' !== $price ) : ?>
								<span class="awea-pricing-amount"><?php echo esc_html( $price ); ?></span>
							<?php endif; ?>

							<?php if ( '' !== $period ) : ?>
								<span class="awea-pricing-cycle">/<?php echo esc_html( ltrim( $period, '/' ) ); ?></span>
							<?php endif; ?>
						</div>
					</div>

					<!-- Body Features & CTA -->
					<div class="awea-pricing-card-body">
						<?php if ( ! empty( $features ) ) : ?>
							<ul class="awea-pricing-feature-list">
								<?php foreach ( $features as $feature ) :
									$f_text   = $feature['awea_feat_text'] ?? '';
									$f_active = 'yes' === ( $feature['awea_feat_active'] ?? 'yes' );
									if ( '' === trim( $f_text ) ) {
										continue;
									}
									?>
									<li class="awea-pricing-feature-item <?php echo $f_active ? '' : 'is-disabled'; ?>">
										<span class="awea-feature-icon" aria-hidden="true">
											<?php
											if ( ! empty( $feature['awea_feat_icon']['value'] ) ) {
												Icons_Manager::render_icon( $feature['awea_feat_icon'], [ 'aria-hidden' => 'true' ] );
											} else {
												echo '<i class="fas fa-check" aria-hidden="true"></i>';
											}
											?>
										</span>
										<span class="awea-feature-text">
											<?php if ( ! $f_active ) : ?>
												<span class="elementor-screen-only"><?php esc_html_e( 'Not included:', 'awesome-widgets-elementor' ); ?> </span>
											<?php endif; ?>
											<?php echo esc_html( $f_text ); ?>
										</span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $btn_text ) ) : ?>
							<div class="awea-pricing-btn-wrap">
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<span><?php echo esc_html( $btn_text ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		if ( ! settings.awea_pricing_tiers || ! settings.awea_pricing_tiers.length ) {
			return;
		}
		#>
		<div class="awea-pricing-grid">
			<# _.each( settings.awea_pricing_tiers, function( tier, index ) {
				var id         = tier._id || index;
				var title      = tier.awea_title || '';
				var isFeatured = 'yes' === tier.awea_featured;
				var ribbon     = tier.awea_ribbon || '';
				var currency   = undefined !== tier.awea_currency ? tier.awea_currency : '$';
				var price      = tier.awea_price || '';
				var period     = ( tier.awea_period || '' ).replace( /^\/+/, '' );
				var features   = tier.awea_features_list || [];
				var btnText    = tier.awea_btn_text || '';
				var btnUrl     = ( tier.awea_btn_link && tier.awea_btn_link.url ) ? tier.awea_btn_link.url : '#';
				var cardClass  = 'awea-pricing-card elementor-repeater-item-' + id + ( isFeatured ? ' awea-is-featured' : '' );
			#>
				<article class="{{ cardClass }}">
					<# if ( isFeatured && ribbon ) { #>
						<div class="awea-pricing-ribbon">
							<span>{{{ ribbon }}}</span>
						</div>
					<# } #>

					<div class="awea-pricing-card-header">
						<# if ( title ) { #>
							<span class="awea-pricing-plan-tag">{{{ title }}}</span>
						<# } #>

						<div class="awea-pricing-price-box">
							<# if ( '' !== currency ) { #>
								<span class="awea-pricing-currency">{{{ currency }}}</span>
							<# } #>

							<# if ( '' !== price ) { #>
								<span class="awea-pricing-amount">{{{ price }}}</span>
							<# } #>

							<# if ( '' !== period ) { #>
								<span class="awea-pricing-cycle">/{{{ period }}}</span>
							<# } #>
						</div>
					</div>

					<div class="awea-pricing-card-body">
						<# if ( features.length ) { #>
							<ul class="awea-pricing-feature-list">
								<# _.each( features, function( feature ) {
									var fText   = feature.awea_feat_text || '';
									var fActive = 'yes' === feature.awea_feat_active;
									if ( ! fText.trim() ) {
										return;
									}
									var featIcon = elementor.helpers.renderIcon( view, feature.awea_feat_icon, { 'aria-hidden': true }, 'i', 'object' );
								#>
									<li class="awea-pricing-feature-item {{ fActive ? '' : 'is-disabled' }}">
										<span class="awea-feature-icon" aria-hidden="true">
											<# if ( featIcon && featIcon.rendered ) { #>
												{{{ featIcon.value }}}
											<# } else { #>
												<i class="fas fa-check" aria-hidden="true"></i>
											<# } #>
										</span>
										<span class="awea-feature-text">
											<# if ( ! fActive ) { #>
												<span class="elementor-screen-only"><?php esc_html_e( 'Not included:', 'awesome-widgets-elementor' ); ?> </span>
											<# } #>
											{{{ fText }}}
										</span>
									</li>
								<# } ); #>
							</ul>
						<# } #>

						<# if ( btnText ) { #>
							<div class="awea-pricing-btn-wrap">
								<a href="{{ btnUrl }}" class="awea-pricing-btn-cta">
									<span>{{{ btnText }}}</span>
								</a>
							</div>
						<# } #>
					</div>
				</article>
			<# } ); #>
		</div>
		<?php
	}
}