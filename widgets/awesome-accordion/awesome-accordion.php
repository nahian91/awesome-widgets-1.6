<?php
/**
 * Awesome Accordion Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.0.0
 */

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Widget_Awesome_Accordion extends Widget_Base {

	public function get_name() {
		return 'awesome-accordion';
	}

	public function get_title() {
		return esc_html__( 'Accordion', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'accordion', 'faq', 'toggle', 'collapse', 'qna', 'questions' ];
	}

	public function get_style_depends() {
		return [ 'awea-accordion' ];
	}

	public function get_script_depends() {
		return [ 'awea-accordion' ];
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
		   CONTENT: 1. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_section_items',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_accordion_item_tabs' );

		// --- TAB 1: CONTENT ---
		$repeater->start_controls_tab(
			'awea_accordion_tab_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_accordion_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'What is your return and refund policy?', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Enter your question or heading...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_accordion_content',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( 'You can return any item within 30 days of purchase for a full refund, as long as it is in its original condition.', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Write your answer or details here...', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: OPTIONS ---
		$repeater->start_controls_tab(
			'awea_accordion_tab_settings',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_accordion_active',
			[
				'label'        => esc_html__( 'Open by Default', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Keep this item expanded automatically when visitors first view the page.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_accordion_item_icon',
			[
				'label'       => esc_html__( 'Leading Icon (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_accordion_items',
			[
				'label'       => esc_html__( 'Accordion List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_accordion_title }}}',
				'default'     => [
					[
						'awea_accordion_title'   => esc_html__( 'What is your return and refund policy?', 'awesome-widgets-elementor' ),
						'awea_accordion_content' => esc_html__( 'You can return any item within 30 days of purchase for a full refund, as long as it is in its original condition.', 'awesome-widgets-elementor' ),
						'awea_accordion_active'  => 'yes',
					],
					[
						'awea_accordion_title'   => esc_html__( 'How long does shipping usually take?', 'awesome-widgets-elementor' ),
						'awea_accordion_content' => esc_html__( 'Standard orders arrive within 3 to 5 business days. Express shipping options are also available at checkout.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_accordion_title'   => esc_html__( 'How can I contact customer support?', 'awesome-widgets-elementor' ),
						'awea_accordion_content' => esc_html__( 'Our support team is available Monday through Friday via live chat or email, and we typically reply within a few hours.', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. BEHAVIOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_section_settings',
			[
				'label' => esc_html__( 'Behavior', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_accordion_multiple_open',
			[
				'label'        => esc_html__( 'Allow Multiple Open', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Allow visitors to open several items at once instead of closing previous ones.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_accordion_show_index',
			[
				'label'        => esc_html__( 'Show Numbers', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Display 01, 02, 03 next to each question or title.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_accordion_title_tag',
			[
				'label'       => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Choose the heading tag used for SEO and page structure.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h4',
				'options'     => [
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
		   CONTENT: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_section_icon_settings',
			[
				'label' => esc_html__( 'Toggle Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_accordion_icon_style',
			[
				'label'   => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'plus-minus',
				'options' => [
					'plus-minus' => esc_html__( 'Plus / Minus', 'awesome-widgets-elementor' ),
					'chevron'    => esc_html__( 'Chevron Arrow', 'awesome-widgets-elementor' ),
					'custom'     => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
					'none'       => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_accordion_custom_icon',
			[
				'label'       => esc_html__( 'Normal Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_accordion_icon_style' => 'custom' ],
			]
		);

		$this->add_control(
			'awea_accordion_custom_icon_active',
			[
				'label'       => esc_html__( 'Open Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-minus',
					'library' => 'fa-solid',
				],
				'condition'   => [ 'awea_accordion_icon_style' => 'custom' ],
			]
		);

		$this->add_control(
			'awea_accordion_icon_align',
			[
				'label'        => esc_html__( 'Position', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'right',
				'condition'    => [ 'awea_accordion_icon_style!' => 'none' ],
				'prefix_class' => 'awea_accordion_icon_pos_',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. SEO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_section_seo',
			[
				'label' => esc_html__( 'SEO & Schema', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_accordion_faq_schema',
			[
				'label'        => esc_html__( 'FAQPage Schema', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Outputs valid JSON-LD FAQPage structured data for Google Rich Results.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. BOX / CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_style_card',
			[
				'label' => esc_html__( 'Item Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_accordion_item_gap',
			[
				'label'      => esc_html__( 'Spacing Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 48 ],
					'rem' => [ 'min' => 0, 'max' => 3 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_card_radius',
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
					'{{WRAPPER}} .awea_accordion_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_accordion_card_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_accordion_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_accordion_card_border',
				'selector'       => '{{WRAPPER}} .awea_accordion_item',
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
				'name'     => 'awea_accordion_card_shadow',
				'selector' => '{{WRAPPER}} .awea_accordion_item',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_accordion_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_accordion_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_accordion_item:hover',
			]
		);

		$this->end_controls_tab();

		// Open
		$this->start_controls_tab(
			'awea_accordion_card_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_card_bg_active',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_card_border_active',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_accordion_card_shadow_active',
				'selector' => '{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. TITLE / HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_style_header',
			[
				'label' => esc_html__( 'Title & Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_accordion_header_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '24',
					'bottom'   => '20',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_header_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_header'      => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_title_group' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_accordion_title_typo',
				'selector' => '{{WRAPPER}} .awea_accordion_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_lead_icon_size',
			[
				'label'      => esc_html__( 'Leading Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_lead_icon'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_lead_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_accordion_title_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_accordion_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_lead_icon_color',
			[
				'label'     => esc_html__( 'Leading Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_lead_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_lead_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_header_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_accordion_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_title_color_hover',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_lead_icon_color_hover',
			[
				'label'     => esc_html__( 'Leading Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_lead_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_lead_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_header_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Open
		$this->start_controls_tab(
			'awea_accordion_title_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_title_color_active',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_lead_icon_color_active',
			[
				'label'     => esc_html__( 'Leading Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_lead_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_lead_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_header_bg_active',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. NUMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_style_index',
			[
				'label'     => esc_html__( 'Numbers', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_accordion_show_index' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_accordion_index_typo',
				'selector' => '{{WRAPPER}} .awea_accordion_index',
			]
		);

		$this->add_control(
			'awea_accordion_index_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_index' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_index_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_index' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_index_color_active',
			[
				'label'     => esc_html__( 'Open Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_index' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_index_bg_active',
			[
				'label'     => esc_html__( 'Open Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_index' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_index_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_index' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_index_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_index' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TOGGLE ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_style_icon',
			[
				'label'     => esc_html__( 'Toggle Icon', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_accordion_icon_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_icon_line.awea_accordion_h' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_icon_line.awea_accordion_v' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_icon_chevron'               => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_icon_custom'                => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_accordion_icon_custom svg'            => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_accordion_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 56 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_icon_box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_accordion_icon_box_border',
				'selector' => '{{WRAPPER}} .awea_accordion_icon_box',
			]
		);

		$this->add_responsive_control(
			'awea_accordion_icon_box_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_icon_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_accordion_icon_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_accordion_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_icon_line'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_icon_chevron'    => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_icon_custom'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_icon_custom svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_icon_box_bg',
			[
				'label'     => esc_html__( 'Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_icon_box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_accordion_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_icon_line'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_icon_chevron'    => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_icon_custom'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_icon_custom svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_icon_box_bg_hover',
			[
				'label'     => esc_html__( 'Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_header:hover .awea_accordion_icon_box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Open
		$this->start_controls_tab(
			'awea_accordion_icon_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_accordion_icon_color_active',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_icon_line'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_icon_chevron'    => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_icon_custom'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_icon_custom svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_icon_box_bg_active',
			[
				'label'     => esc_html__( 'Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_item.awea_accordion_is_active .awea_accordion_icon_box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_accordion_style_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_accordion_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '0',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_accordion_content_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_accordion_content_typo',
				'selector' => '{{WRAPPER}} .awea_accordion_content_inner',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_accordion_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_content_inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_accordion_content_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_accordion_content_inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_accordion_content_top_border',
				'label'     => esc_html__( 'Divider', 'awesome-widgets-elementor' ),
				'selector'  => '{{WRAPPER}} .awea_accordion_content_inner',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$items       = $settings['awea_accordion_items'] ?? [];
		$is_multiple = 'yes' === ( $settings['awea_accordion_multiple_open'] ?? 'no' );
		$show_index  = 'yes' === ( $settings['awea_accordion_show_index'] ?? 'no' );
		$icon_style  = $settings['awea_accordion_icon_style'] ?? 'plus-minus';
		$title_tag   = Utils::validate_html_tag( $settings['awea_accordion_title_tag'] ?? 'h4' );
		$faq_schema  = 'yes' === ( $settings['awea_accordion_faq_schema'] ?? 'no' );
		$widget_id   = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}

		$has_opened_one  = false;
		$schema_entities = [];
		?>
		<div class="awea_accordion_wrap"
			 id="awea_accordion_<?php echo esc_attr( $widget_id ); ?>"
			 data-awea_accordion_multiple="<?php echo $is_multiple ? 'true' : 'false'; ?>">

			<?php foreach ( $items as $index => $item ) :
				$id        = $item['_id'] ?? $index;
				$title     = $item['awea_accordion_title'] ?? '';
				$content   = $item['awea_accordion_content'] ?? '';
				$want_open = 'yes' === ( $item['awea_accordion_active'] ?? '' );

				if ( $want_open && ( $is_multiple || ! $has_opened_one ) ) {
					$is_active      = true;
					$has_opened_one = true;
				} else {
					$is_active = false;
				}

				if ( $faq_schema && ! empty( $title ) && ! empty( $content ) ) {
					$schema_entities[] = [
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( $title ),
						'acceptedAnswer' => [
							'@type' => 'Answer',
							'text'  => wp_kses_post( do_shortcode( $content ) ),
						],
					];
				}

				$head_id  = 'awea_accordion_head_' . $widget_id . '_' . $index;
				$panel_id = 'awea_accordion_panel_' . $widget_id . '_' . $index;

				$item_classes = [ 'awea_accordion_item', 'elementor-repeater-item-' . esc_attr( $id ) ];
				if ( $is_active ) {
					$item_classes[] = 'awea_accordion_is_active';
				}
				?>
				<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">

					<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_accordion_heading_wrap">
						<button type="button"
								class="awea_accordion_header"
								id="<?php echo esc_attr( $head_id ); ?>"
								aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>">

							<span class="awea_accordion_title_group">
								<?php if ( $show_index ) : ?>
									<span class="awea_accordion_index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $item['awea_accordion_item_icon']['value'] ) ) : ?>
									<span class="awea_accordion_lead_icon" aria-hidden="true">
										<?php Icons_Manager::render_icon( $item['awea_accordion_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								<?php endif; ?>

								<span class="awea_accordion_title"><?php echo esc_html( $title ); ?></span>
							</span>

							<?php if ( 'plus-minus' === $icon_style ) : ?>
								<span class="awea_accordion_icon_box" aria-hidden="true">
									<span class="awea_accordion_icon_line awea_accordion_h"></span>
									<span class="awea_accordion_icon_line awea_accordion_v"></span>
								</span>
							<?php elseif ( 'chevron' === $icon_style ) : ?>
								<span class="awea_accordion_icon_box" aria-hidden="true">
									<svg class="awea_accordion_icon_chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="6 9 12 15 18 9"></polyline>
									</svg>
								</span>
							<?php elseif ( 'custom' === $icon_style ) : ?>
								<span class="awea_accordion_icon_box" aria-hidden="true">
									<?php if ( ! empty( $settings['awea_accordion_custom_icon']['value'] ) ) : ?>
										<span class="awea_accordion_icon_custom awea_accordion_icon_state_normal">
											<?php Icons_Manager::render_icon( $settings['awea_accordion_custom_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $settings['awea_accordion_custom_icon_active']['value'] ) ) : ?>
										<span class="awea_accordion_icon_custom awea_accordion_icon_state_active">
											<?php Icons_Manager::render_icon( $settings['awea_accordion_custom_icon_active'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</button>
					</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

					<div class="awea_accordion_collapse"
						 id="<?php echo esc_attr( $panel_id ); ?>"
						 role="region"
						 aria-labelledby="<?php echo esc_attr( $head_id ); ?>"
						 aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
						 <?php echo $is_active ? '' : 'inert'; ?>>
						<div class="awea_accordion_overflow">
							<div class="awea_accordion_content_inner">
								<?php echo wp_kses_post( $content ); ?>
							</div>
						</div>
					</div>

				</div>
			<?php endforeach; ?>

		</div>

		<?php if ( $faq_schema && ! empty( $schema_entities ) && ! Plugin::$instance->editor->is_edit_mode() ) :
			$schema_data = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_entities,
			];
			?>
			<script type="application/ld+json"><?php echo wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
		<?php endif; ?>
		<?php
	}
}