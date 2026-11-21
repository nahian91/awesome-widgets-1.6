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
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. TIERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_section_items',
			[
				'label' => esc_html__( 'Pricing Tiers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_price_tier_tabs' );

		// --- TAB 1: HEADER ---
		$repeater->start_controls_tab(
			'awea_price_tab_header',
			[ 'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_price_title',
			[
				'label'       => esc_html__( 'Plan Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_price_subtitle',
			[
				'label'       => esc_html__( 'Short Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'For growing product teams', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_price_featured',
			[
				'label'        => esc_html__( 'Featured Tier', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_price_ribbon',
			[
				'label'     => esc_html__( 'Corner Ribbon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_price_featured' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: VALUES ---
		$repeater->start_controls_tab(
			'awea_price_tab_values',
			[ 'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_price_currency',
			[
				'label'   => esc_html__( 'Currency Symbol', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_price_amount',
			[
				'label'   => esc_html__( 'Price Amount', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '79',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_price_original',
			[
				'label'       => esc_html__( 'Original / Sale Price (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '99',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_price_period',
			[
				'label'   => esc_html__( 'Billing Period', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'mo',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: FEATURES ---
		$repeater->start_controls_tab(
			'awea_price_tab_features',
			[ 'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ) ]
		);

		$feature_sub_repeater = new Repeater();

		$feature_sub_repeater->add_control(
			'awea_price_feat_text',
			[
				'label'       => esc_html__( 'Feature Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Unlimited Projects', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$feature_sub_repeater->add_control(
			'awea_price_feat_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$feature_sub_repeater->add_control(
			'awea_price_feat_active',
			[
				'label'        => esc_html__( 'Included in Plan', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_price_features_list',
			[
				'label'       => esc_html__( 'Features List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $feature_sub_repeater->get_controls(),
				'default'     => [
					[ 'awea_price_feat_text' => esc_html__( 'Unlimited Neural Projects', 'awesome-widgets-elementor' ), 'awea_price_feat_active' => 'yes' ],
					[ 'awea_price_feat_text' => esc_html__( 'Ultra-Low Latency API Access', 'awesome-widgets-elementor' ), 'awea_price_feat_active' => 'yes' ],
					[ 'awea_price_feat_text' => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ), 'awea_price_feat_active' => 'yes' ],
					[ 'awea_price_feat_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ), 'awea_price_feat_active' => 'yes' ],
				],
				'title_field' => '{{{ awea_price_feat_text }}}',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: BUTTON ---
		$repeater->start_controls_tab(
			'awea_price_tab_button',
			[ 'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_price_btn_text',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_price_btn_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'placeholder' => 'https://example.com/checkout',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 5: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_price_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_price_item_border',
			[
				'label'     => esc_html__( 'Card Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_price_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_price_item_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea_price_btn_cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_price_tiers',
			[
				'label'       => esc_html__( 'Plans List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_price_title }}} ({{{ awea_price_currency }}}{{{ awea_price_amount }}})',
				'default'     => [
					[
						'awea_price_title'    => esc_html__( 'Starter', 'awesome-widgets-elementor' ),
						'awea_price_subtitle' => esc_html__( 'Essential tools for solo creators', 'awesome-widgets-elementor' ),
						'awea_price_amount'   => '29',
						'awea_price_btn_text' => esc_html__( 'Start Free Trial', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_title'    => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
						'awea_price_subtitle' => esc_html__( 'Everything needed to scale fast', 'awesome-widgets-elementor' ),
						'awea_price_amount'   => '79',
						'awea_price_featured' => 'yes',
						'awea_price_ribbon'   => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
						'awea_price_btn_text' => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
					],
					[
						'awea_price_title'    => esc_html__( 'Enterprise', 'awesome-widgets-elementor' ),
						'awea_price_subtitle' => esc_html__( 'Custom SLA & dedicated infrastructure', 'awesome-widgets-elementor' ),
						'awea_price_amount'   => '199',
						'awea_price_btn_text' => esc_html__( 'Contact Sales', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_price_columns',
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
					'{{WRAPPER}} .awea_price_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_price_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_grid' => 'gap: {{SIZE}}{{UNIT}};',
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
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_price_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_price_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_price_divider_color',
			[
				'label'     => esc_html__( 'Header Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_price_card_header' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_price_card_state_tabs' );

		$this->start_controls_tab(
			'awea_price_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_price_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_price_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_price_card_border',
				'selector'       => '{{WRAPPER}} .awea_price_card',
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
				'name'     => 'awea_price_card_shadow',
				'selector' => '{{WRAPPER}} .awea_price_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_price_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_price_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_price_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_price_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_price_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. FEATURED TIER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_featured',
			[
				'label' => esc_html__( 'Featured Tier', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_price_featured_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_price_card.awea_price_is_featured' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_featured_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_card.awea_price_is_featured' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_price_featured_shadow',
				'selector' => '{{WRAPPER}} .awea_price_card.awea_price_is_featured',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. PLAN HEADER & RIBBON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_header',
			[
				'label' => esc_html__( 'Plan Header & Ribbon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_price_header_color',
			[
				'label'     => esc_html__( 'Plan Tag Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_plan_tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_header_bg',
			[
				'label'     => esc_html__( 'Plan Tag Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_price_plan_tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_header_typo',
				'label'    => esc_html__( 'Plan Tag Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_plan_tag',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'awea_price_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_price_subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_subtitle_typo',
				'label'    => esc_html__( 'Subtitle Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_subtitle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'awea_price_ribbon_color',
			[
				'label'     => esc_html__( 'Ribbon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_price_ribbon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_ribbon_bg',
			[
				'label'     => esc_html__( 'Ribbon Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_ribbon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_ribbon_typo',
				'label'    => esc_html__( 'Ribbon Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_ribbon',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. PRICING (CURRENCY, AMOUNT & PERIOD)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_pricing',
			[
				'label' => esc_html__( 'Price & Period', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_price_currency_color',
			[
				'label'     => esc_html__( 'Currency Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_price_currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_currency_typo',
				'label'    => esc_html__( 'Currency Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_currency',
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
				'default'   => '#0f172a',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_price_amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typo',
				'label'    => esc_html__( 'Amount Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_amount',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_price_original_color',
			[
				'label'     => esc_html__( 'Original Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_price_original' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_period_color',
			[
				'label'     => esc_html__( 'Period Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_price_cycle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_period_typo',
				'label'    => esc_html__( 'Period Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_price_cycle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. FEATURES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_features',
			[
				'label' => esc_html__( 'Features List', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_price_feature_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_feature_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_price_feature_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_price_feature_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_feature_item i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_price_feature_item svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_feature_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_feature_item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_feature_disabled_color',
			[
				'label'     => esc_html__( 'Excluded Feature Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .awea_price_feature_item.awea_price_is_disabled'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_price_feature_item.awea_price_is_disabled i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_price_feature_item.awea_price_is_disabled svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_feature_text_typo',
				'selector' => '{{WRAPPER}} .awea_price_feature_item',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_price_feature_spacing',
			[
				'label'      => esc_html__( 'Row Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_feature_item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_price_style_button',
			[
				'label' => esc_html__( 'CTA Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_btn_typo',
				'selector' => '{{WRAPPER}} .awea_price_btn_cta',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_price_btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '16', 'right' => '32', 'bottom' => '16', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_btn_cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_price_btn_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_price_btn_cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_price_btn_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_price_btn_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_price_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_price_btn_cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_price_btn_cta' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_price_btn_border',
				'selector' => '{{WRAPPER}} .awea_price_btn_cta',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_price_btn_shadow',
				'selector' => '{{WRAPPER}} .awea_price_btn_cta',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_price_btn_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_price_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_price_btn_cta:hover, {{WRAPPER}} .awea_price_btn_cta:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_price_btn_cta:hover, {{WRAPPER}} .awea_price_btn_cta:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_price_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_price_btn_cta:hover, {{WRAPPER}} .awea_price_btn_cta:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_price_btn_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_price_btn_cta:hover, {{WRAPPER}} .awea_price_btn_cta:focus-visible',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tiers    = $settings['awea_price_tiers'] ?? [];

		if ( empty( $tiers ) ) {
			return;
		}
		?>
		<div class="awea_price_grid">
			<?php foreach ( $tiers as $index => $tier ) :
				$id          = ! empty( $tier['_id'] ) ? sanitize_html_class( $tier['_id'] ) : $index;
				$title       = $tier['awea_price_title'] ?? '';
				$subtitle    = $tier['awea_price_subtitle'] ?? '';
				$is_featured = 'yes' === ( $tier['awea_price_featured'] ?? 'no' );
				$ribbon_text = $tier['awea_price_ribbon'] ?? '';
				$currency    = $tier['awea_price_currency'] ?? '$';
				$price       = $tier['awea_price_amount'] ?? '';
				$orig_price  = $tier['awea_price_original'] ?? '';
				$period      = $tier['awea_price_period'] ?? '';
				$features    = $tier['awea_price_features_list'] ?? [];
				$btn_text    = $tier['awea_price_btn_text'] ?? '';
				$link_key    = 'awea_price_link_' . $id;

				$this->remove_render_attribute( $link_key );
				$btn_url = ! empty( $tier['awea_price_btn_link']['url'] ) ? $tier['awea_price_btn_link'] : [ 'url' => '#' ];
				$this->add_link_attributes( $link_key, $btn_url );
				$this->add_render_attribute( $link_key, 'class', 'awea_price_btn_cta' );

				$card_classes = [ 'awea_price_card', 'elementor-repeater-item-' . $id ];
				if ( $is_featured ) {
					$card_classes[] = 'awea_price_is_featured';
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

					<?php if ( $is_featured && ! empty( $ribbon_text ) ) : ?>
						<div class="awea_price_ribbon">
							<span><?php echo esc_html( $ribbon_text ); ?></span>
						</div>
					<?php endif; ?>

					<!-- Header & Pricing Block -->
					<div class="awea_price_card_header">
						<?php if ( ! empty( $title ) ) : ?>
							<span class="awea_price_plan_tag"><?php echo esc_html( $title ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $subtitle ) ) : ?>
							<p class="awea_price_subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>

						<div class="awea_price_price_box">
							<?php if ( '' !== $orig_price ) : ?>
								<del class="awea_price_original"><?php echo esc_html( $currency . $orig_price ); ?></del>
							<?php endif; ?>

							<?php if ( '' !== $currency ) : ?>
								<span class="awea_price_currency"><?php echo esc_html( $currency ); ?></span>
							<?php endif; ?>

							<?php if ( '' !== $price ) : ?>
								<span class="awea_price_amount"><?php echo esc_html( $price ); ?></span>
							<?php endif; ?>

							<?php if ( '' !== $period ) : ?>
								<span class="awea_price_cycle">/<?php echo esc_html( ltrim( $period, '/' ) ); ?></span>
							<?php endif; ?>
						</div>
					</div>

					<!-- Body Features & CTA -->
					<div class="awea_price_card_body">
						<?php if ( ! empty( $features ) ) : ?>
							<ul class="awea_price_feature_list">
								<?php foreach ( $features as $feature ) :
									$f_text   = $feature['awea_price_feat_text'] ?? '';
									$f_active = 'yes' === ( $feature['awea_price_feat_active'] ?? 'yes' );
									if ( '' === trim( $f_text ) ) {
										continue;
									}
									?>
									<li class="awea_price_feature_item <?php echo $f_active ? '' : 'awea_price_is_disabled'; ?>">
										<span class="awea_price_feature_icon" aria-hidden="true">
											<?php
											if ( ! empty( $feature['awea_price_feat_icon']['value'] ) ) {
												Icons_Manager::render_icon( $feature['awea_price_feat_icon'], [ 'aria-hidden' => 'true' ] );
											} else {
												echo '<i class="fas fa-check" aria-hidden="true"></i>';
											}
											?>
										</span>
										<span class="awea_price_feature_text">
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
							<div class="awea_price_btn_wrap">
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
		if ( ! settings.awea_price_tiers || ! settings.awea_price_tiers.length ) {
			return;
		}
		#>
		<div class="awea_price_grid">
			<# _.each( settings.awea_price_tiers, function( tier, index ) {
				var id         = tier._id || index;
				var title      = tier.awea_price_title || '';
				var subtitle   = tier.awea_price_subtitle || '';
				var isFeatured = 'yes' === tier.awea_price_featured;
				var ribbon     = tier.awea_price_ribbon || '';
				var currency   = undefined !== tier.awea_price_currency ? tier.awea_price_currency : '$';
				var price      = tier.awea_price_amount || '';
				var origPrice  = tier.awea_price_original || '';
				var period     = ( tier.awea_price_period || '' ).replace( /^\/+/, '' );
				var features   = tier.awea_price_features_list || [];
				var btnText    = tier.awea_price_btn_text || '';
				var btnUrl     = ( tier.awea_price_btn_link && tier.awea_price_btn_link.url ) ? tier.awea_price_btn_link.url : '#';
				var cardClass  = 'awea_price_card elementor-repeater-item-' + id + ( isFeatured ? ' awea_price_is_featured' : '' );
			#>
				<article class="{{ cardClass }}">
					<# if ( isFeatured && ribbon ) { #>
						<div class="awea_price_ribbon">
							<span>{{{ ribbon }}}</span>
						</div>
					<# } #>

					<div class="awea_price_card_header">
						<# if ( title ) { #>
							<span class="awea_price_plan_tag">{{{ title }}}</span>
						<# } #>

						<# if ( subtitle ) { #>
							<p class="awea_price_subtitle">{{{ subtitle }}}</p>
						<# } #>

						<div class="awea_price_price_box">
							<# if ( '' !== origPrice ) { #>
								<del class="awea_price_original">{{{ currency }}}{{{ origPrice }}}</del>
							<# } #>

							<# if ( '' !== currency ) { #>
								<span class="awea_price_currency">{{{ currency }}}</span>
							<# } #>

							<# if ( '' !== price ) { #>
								<span class="awea_price_amount">{{{ price }}}</span>
							<# } #>

							<# if ( '' !== period ) { #>
								<span class="awea_price_cycle">/{{{ period }}}</span>
							<# } #>
						</div>
					</div>

					<div class="awea_price_card_body">
						<# if ( features.length ) { #>
							<ul class="awea_price_feature_list">
								<# _.each( features, function( feature ) {
									var fText   = feature.awea_price_feat_text || '';
									var fActive = 'yes' === feature.awea_price_feat_active;
									if ( ! fText.trim() ) {
										return;
									}
									var featIcon = elementor.helpers.renderIcon( view, feature.awea_price_feat_icon, { 'aria-hidden': true }, 'i', 'object' );
								#>
									<li class="awea_price_feature_item {{ fActive ? '' : 'awea_price_is_disabled' }}">
										<span class="awea_price_feature_icon" aria-hidden="true">
											<# if ( featIcon && featIcon.rendered ) { #>
												{{{ featIcon.value }}}
											<# } else { #>
												<i class="fas fa-check" aria-hidden="true"></i>
											<# } #>
										</span>
										<span class="awea_price_feature_text">
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
							<div class="awea_price_btn_wrap">
								<a href="{{ btnUrl }}" class="awea_price_btn_cta">
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