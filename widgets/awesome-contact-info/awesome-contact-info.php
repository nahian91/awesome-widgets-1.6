<?php
/**
 * Awesome Contact Info Widget.
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
use Elementor\Utils;

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
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_section_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_contact_info_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get In Touch', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_contact_info_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Reach our team directly via email, phone, or studio visit.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_contact_info_title_tag',
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
				'condition' => [ 'awea_contact_info_title!' => '' ],
			]
		);

		$this->add_control(
			'awea_contact_info_accent_bar',
			[
				'label'        => esc_html__( 'Accent Bar', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_contact_info_title!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_section_items',
			[
				'label' => esc_html__( 'Contact Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_contact_info_icon',
			[
				'label'       => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_contact_info_label',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Direct Email', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_contact_info_value',
			[
				'label'       => esc_html__( 'Value', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'hello@example.com', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_contact_info_subtext',
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
			'awea_contact_info_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'mailto:hello@example.com',
			]
		);

		$repeater->add_control(
			'awea_contact_info_copy',
			[
				'label'        => esc_html__( 'Enable One-Click Copy', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_contact_info_copy_value',
			[
				'label'       => esc_html__( 'Custom Copy Text (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Defaults to Value above', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_contact_info_copy' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_contact_info_items',
			[
				'label'       => esc_html__( 'Directory List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_contact_info_label }}}: {{{ awea_contact_info_value }}}',
				'default'     => [
					[
						'awea_contact_info_label'   => esc_html__( 'Direct Inquiries', 'awesome-widgets-elementor' ),
						'awea_contact_info_value'   => 'support@devnahian.com',
						'awea_contact_info_subtext' => esc_html__( 'Average response under 2 hrs', 'awesome-widgets-elementor' ),
						'awea_contact_info_icon'    => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
						'awea_contact_info_link'    => [ 'url' => 'mailto:support@devnahian.com' ],
						'awea_contact_info_copy'    => 'yes',
					],
					[
						'awea_contact_info_label'   => esc_html__( 'Telephone Support', 'awesome-widgets-elementor' ),
						'awea_contact_info_value'   => '+1 (800) 456-7890',
						'awea_contact_info_subtext' => esc_html__( 'Mon–Fri • 9:00 AM – 6:00 PM', 'awesome-widgets-elementor' ),
						'awea_contact_info_icon'    => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
						'awea_contact_info_link'    => [ 'url' => 'tel:+18004567890' ],
						'awea_contact_info_copy'    => 'yes',
					],
					[
						'awea_contact_info_label'   => esc_html__( 'Main Headquarters', 'awesome-widgets-elementor' ),
						'awea_contact_info_value'   => '100 Montgomery St, San Francisco, CA',
						'awea_contact_info_subtext' => esc_html__( 'Suite 400 • Financial District', 'awesome-widgets-elementor' ),
						'awea_contact_info_icon'    => [ 'value' => 'fas fa-map-marker-alt', 'library' => 'fa-solid' ],
						'awea_contact_info_copy'    => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_contact_info_card_layout',
			[
				'label'        => esc_html__( 'Card Direction', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'horizontal',
				'options'      => [
					'horizontal' => esc_html__( 'Horizontal Row', 'awesome-widgets-elementor' ),
					'vertical'   => esc_html__( 'Vertical Card', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_contact_info_dir_',
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_columns',
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
					'{{WRAPPER}} .awea_contact_info_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 60 ],
					'rem' => [ 'min' => 0, 'max' => 4 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. ACTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_section_actions',
			[
				'label' => esc_html__( 'Actions', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_contact_info_show_arrow',
			[
				'label'        => esc_html__( 'Show Link Arrow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_contact_info_arrow_icon',
			[
				'label'       => esc_html__( 'Custom Arrow Icon (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [ 'awea_contact_info_show_arrow' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_contact_info_copied_text',
			[
				'label'   => esc_html__( 'Copied Confirmation Label', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Copied', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_header',
			[
				'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_contact_info_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_title_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_contact_info_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_contact_info_bar_color',
			[
				'label'     => esc_html__( 'Accent Bar Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_contact_info_accent_bar' => 'yes' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_header' => 'border-inline-start-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_bar_width',
			[
				'label'      => esc_html__( 'Accent Bar Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 3 ],
				'condition'  => [ 'awea_contact_info_accent_bar' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_header' => 'border-inline-start-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_header_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_cards',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '22',
					'bottom'   => '20',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '18',
					'right'    => '18',
					'bottom'   => '18',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_row' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_contact_info_card_tabs' );

		$this->start_controls_tab(
			'awea_contact_info_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_contact_info_card_border',
				'selector'       => '{{WRAPPER}} .awea_contact_info_row',
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
				'name'     => 'awea_contact_info_card_shadow',
				'selector' => '{{WRAPPER}} .awea_contact_info_row',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_contact_info_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_contact_info_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_contact_info_row:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_icon',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_contact_info_icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_icon_gap',
			[
				'label'      => esc_html__( 'Spacing to Text', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_contact_info_icon_tabs' );

		$this->start_controls_tab(
			'awea_contact_info_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_contact_info_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.14)',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_contact_info_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_icon_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TYPOGRAPHY (LABEL, VALUE & SUBTEXT)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_label',
			[
				'label' => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_contact_info_label_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_label_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_label',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_contact_info_style_value',
			[
				'label' => esc_html__( 'Value', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_contact_info_value_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_value_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_value_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_value',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_contact_info_style_subtext',
			[
				'label' => esc_html__( 'Subtext', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_contact_info_subtext_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_subtext' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_subtext_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_subtext',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. COPY BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_copy',
			[
				'label' => esc_html__( 'Copy Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_contact_info_copy_typo',
				'selector' => '{{WRAPPER}} .awea_contact_info_copy_btn',
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_copy_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_copy_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_contact_info_copy_tabs' );

		$this->start_controls_tab(
			'awea_contact_info_copy_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_copy_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_copy_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_copy_btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_contact_info_copy_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_copy_btn:hover, {{WRAPPER}} .awea_contact_info_copy_btn:focus-visible' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_copy_btn:hover, {{WRAPPER}} .awea_contact_info_copy_btn:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_contact_info_copy_copied',
			[ 'label' => esc_html__( 'Copied', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_color_copied',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row.awea_contact_info_is_copied .awea_contact_info_copy_btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_bg_copied',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row.awea_contact_info_is_copied .awea_contact_info_copy_btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_copy_btn_border_copied',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row.awea_contact_info_is_copied .awea_contact_info_copy_btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. ARROW
		   ========================================================================== */
		$this->start_controls_section(
			'awea_contact_info_style_arrow',
			[
				'label'     => esc_html__( 'Link Arrow', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_contact_info_show_arrow' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_contact_info_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_contact_info_arrow'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_contact_info_arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_contact_info_arrow svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_contact_info_arrow_color_hover',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_contact_info_row:hover .awea_contact_info_arrow svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$title       = $settings['awea_contact_info_title'] ?? '';
		$subtitle    = $settings['awea_contact_info_subtitle'] ?? '';
		$title_tag   = Utils::validate_html_tag( $settings['awea_contact_info_title_tag'] ?? 'h2' );
		$accent_bar  = 'yes' === ( $settings['awea_contact_info_accent_bar'] ?? 'no' );
		$items       = $settings['awea_contact_info_items'] ?? [];
		$show_arrow  = 'yes' === ( $settings['awea_contact_info_show_arrow'] ?? 'no' );
		$copied_text = ! empty( $settings['awea_contact_info_copied_text'] ) ? $settings['awea_contact_info_copied_text'] : esc_html__( 'Copied', 'awesome-widgets-elementor' );
		$widget_id   = $this->get_id();

		$header_classes = [ 'awea_contact_info_header' ];
		if ( ! $accent_bar ) {
			$header_classes[] = 'awea_contact_info_no_bar';
		}
		?>
		<div class="awea_contact_info_wrap" id="awea_contact_info_<?php echo esc_attr( $widget_id ); ?>" data-awea_contact_info_copied_label="<?php echo esc_attr( $copied_text ); ?>">

			<?php if ( ! empty( $title ) || ! empty( $subtitle ) ) : ?>
				<header class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
					<?php if ( ! empty( $title ) ) : ?>
						<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_contact_info_title">
							<?php echo esc_html( $title ); ?>
						</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $subtitle ) ) : ?>
						<p class="awea_contact_info_subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<div class="awea_contact_info_grid">
					<?php foreach ( $items as $index => $item ) :
						$id       = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
						$row_key  = 'awea_contact_info_row_' . $id;
						$link_key = 'awea_contact_info_link_' . $id;

						$this->remove_render_attribute( $row_key );
						$this->remove_render_attribute( $link_key );

						$label    = $item['awea_contact_info_label'] ?? '';
						$val      = $item['awea_contact_info_value'] ?? '';
						$copy_val = ! empty( $item['awea_contact_info_copy_value'] ) ? $item['awea_contact_info_copy_value'] : $val;
						$subtext  = $item['awea_contact_info_subtext'] ?? '';
						$can_copy = 'yes' === ( $item['awea_contact_info_copy'] ?? '' );
						$has_url  = ! empty( $item['awea_contact_info_link']['url'] );

						$row_classes = [
							'awea_contact_info_row',
							'elementor-repeater-item-' . $id,
						];
						if ( $has_url ) {
							$row_classes[] = 'awea_contact_info_has_link';
						}
						if ( $can_copy && ! $has_url ) {
							$row_classes[] = 'awea_contact_info_row_copy';
						}

						$this->add_render_attribute( $row_key, 'class', $row_classes );

						if ( $can_copy && ! empty( $copy_val ) ) {
							$this->add_render_attribute( $row_key, 'data-awea_contact_info_copy_text', $copy_val );
							if ( ! $has_url ) {
								$this->add_render_attribute( $row_key, 'role', 'button' );
								$this->add_render_attribute( $row_key, 'tabindex', '0' );
								/* translators: %s: contact label and value */
								$this->add_render_attribute( $row_key, 'aria-label', sprintf( esc_attr__( 'Copy %s', 'awesome-widgets-elementor' ), trim( $label . ': ' . $copy_val, ': ' ) ) );
							}
						}

						if ( $has_url ) {
							$this->add_link_attributes( $link_key, $item['awea_contact_info_link'] );
							$this->add_render_attribute( $link_key, 'class', 'awea_contact_info_cover_link' );
							$this->add_render_attribute( $link_key, 'aria-label', trim( $label . ': ' . $val, ': ' ) );
						}
						?>
						<div <?php $this->print_render_attribute_string( $row_key ); ?>>

							<?php if ( $has_url ) : ?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>></a>
							<?php endif; ?>

							<?php if ( ! empty( $item['awea_contact_info_icon']['value'] ) ) : ?>
								<div class="awea_contact_info_icon" aria-hidden="true">
									<?php Icons_Manager::render_icon( $item['awea_contact_info_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</div>
							<?php endif; ?>

							<div class="awea_contact_info_body">
								<?php if ( ! empty( $label ) ) : ?>
									<span class="awea_contact_info_label"><?php echo esc_html( $label ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $val ) ) : ?>
									<span class="awea_contact_info_value"><?php echo esc_html( $val ); ?></span>
								<?php endif; ?>

								<?php if ( ! empty( $subtext ) ) : ?>
									<span class="awea_contact_info_subtext"><?php echo esc_html( $subtext ); ?></span>
								<?php endif; ?>
							</div>

							<?php if ( ( $can_copy && ! empty( $copy_val ) ) || ( $show_arrow && $has_url ) ) : ?>
								<div class="awea_contact_info_actions">
									<?php if ( $can_copy && ! empty( $copy_val ) ) : ?>
										<button type="button" class="awea_contact_info_copy_btn" aria-label="<?php esc_attr_e( 'Copy to clipboard', 'awesome-widgets-elementor' ); ?>">
											<svg class="awea_contact_info_ico_copy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
											<svg class="awea_contact_info_ico_check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
											<span class="awea_contact_info_copy_label" aria-live="polite"></span>
										</button>
									<?php endif; ?>

									<?php if ( $show_arrow && $has_url ) : ?>
										<span class="awea_contact_info_arrow" aria-hidden="true">
											<?php if ( ! empty( $settings['awea_contact_info_arrow_icon']['value'] ) ) : ?>
												<?php Icons_Manager::render_icon( $settings['awea_contact_info_arrow_icon'], [ 'aria-hidden' => 'true' ] ); ?>
											<?php else : ?>
												<svg class="awea_contact_info_arrow_default" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
													<line x1="7" y1="17" x2="17" y2="7"></line>
													<polyline points="7 7 17 7 17 17"></polyline>
												</svg>
											<?php endif; ?>
										</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			window.awea_contact_info_copy_text = window.awea_contact_info_copy_text || function(text, callback) {
				if (navigator.clipboard && window.isSecureContext) {
					navigator.clipboard.writeText(text).then(callback).catch(function() {
						fallbackCopy(text, callback);
					});
				} else {
					fallbackCopy(text, callback);
				}

				function fallbackCopy(val, cb) {
					var textarea = document.createElement('textarea');
					textarea.value = val;
					textarea.style.position = 'fixed';
					textarea.style.opacity = '0';
					document.body.appendChild(textarea);
					textarea.focus();
					textarea.select();
					try {
						document.execCommand('copy');
						if (cb) cb();
					} catch (err) {}
					document.body.removeChild(textarea);
				}
			};

			function awea_contact_info_bind(scope) {
				if (!scope || scope.dataset.aweaContactInfoBound === '1') return;
				scope.dataset.aweaContactInfoBound = '1';

				var copiedLabel = scope.getAttribute('data-awea_contact_info_copied_label') || 'Copied';

				function triggerCopy(row) {
					var text = row.getAttribute('data-awea_contact_info_copy_text');
					if (!text) return;
					window.awea_contact_info_copy_text(text, function() {
						var liveLabel = row.querySelector('.awea_contact_info_copy_label');
						if (liveLabel) {
							liveLabel.textContent = copiedLabel;
						}
						row.classList.add('awea_contact_info_is_copied');
						clearTimeout(row.__aweaCopyTimer);
						row.__aweaCopyTimer = setTimeout(function() {
							row.classList.remove('awea_contact_info_is_copied');
							if (liveLabel) {
								liveLabel.textContent = '';
							}
						}, 1800);
					});
				}

				scope.querySelectorAll('.awea_contact_info_copy_btn').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						var row = this.closest('.awea_contact_info_row');
						if (row) triggerCopy(row);
					});
				});

				scope.querySelectorAll('.awea_contact_info_row_copy').forEach(function(row) {
					row.addEventListener('click', function() {
						triggerCopy(this);
					});
					row.addEventListener('keydown', function(e) {
						if (e.key === 'Enter' || e.key === ' ') {
							e.preventDefault();
							triggerCopy(this);
						}
					});
				});
			}

			function awea_contact_info_init() {
				awea_contact_info_bind(document.getElementById('awea_contact_info_<?php echo esc_js( $widget_id ); ?>'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_contact_info_init);
			} else {
				awea_contact_info_init();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.awea_contact_info_hooked) {
				window.awea_contact_info_hooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awea-contact-info.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_contact_info_wrap') : null;
					awea_contact_info_bind(el);
				});
			}
		})();
		</script>
		<?php
	}
}