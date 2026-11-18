<?php
/**
 * Awesome Price Menu Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;

class Widget_Awesome_Price_Menu extends Widget_Base {

	public function get_name() {
		return 'awesome-price-menu';
	}

	public function get_title() {
		return esc_html__( 'Price Menu', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-menu-card';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'price menu', 'restaurant', 'catalog', 'pricing', 'food menu' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. ITEMS (REPEATER)
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
			'awea_item_image',
			[
				'label'   => esc_html__( 'Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_item_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_item_badge',
			[
				'label'       => esc_html__( 'Tag / Dietary Badge', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Chef’s Pick', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_item_price',
			[
				'label'   => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$28.00',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_item_description',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_item_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_price_menu_items',
			[
				'label'       => esc_html__( 'Menu List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'awea_item_title'       => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
						'awea_item_badge'       => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$28.00',
						'awea_item_description' => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_item_title'       => esc_html__( 'Pan-Seared Chilean Sea Bass', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$42.00',
						'awea_item_description' => esc_html__( 'Served over saffron risotto with charred asparagus and lemon-herb beurre blanc.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_item_title'       => esc_html__( 'Artisanal Burrata & Heirloom', 'awesome-widgets-elementor' ),
						'awea_item_badge'       => esc_html__( 'GF', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$22.00',
						'awea_item_description' => esc_html__( 'Fresh creamy burrata, organic heirloom tomatoes, basil oil, and 25-year aged balsamic.', 'awesome-widgets-elementor' ),
					],
				],
				'title_field' => '{{{ awea_item_title }}} — {{{ awea_item_price }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_settings',
			[
				'label' => esc_html__( 'Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
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
		   STYLE: 1. CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_container',
			[
				'label' => esc_html__( 'Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_container_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 1400 ],
					'%'  => [ 'min' => 30, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_container_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '36',
					'right'    => '36',
					'bottom'   => '36',
					'left'     => '36',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_container_radius',
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
					'{{WRAPPER}} .awea-price-menu-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_container_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_container_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_container_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_container_border',
				'selector'       => '{{WRAPPER}} .awea-price-menu-list',
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
				'name'     => 'awea_container_shadow',
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_container_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_container_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_container_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_container_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-price-menu-list:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. PHOTO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_image',
			[
				'label' => esc_html__( 'Photo', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_thumbnail_size',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'awea_thumb_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 44, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 76 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_thumb_radius',
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
					'{{WRAPPER}} .awea-price-menu-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_thumb_border',
				'selector' => '{{WRAPPER}} .awea-price-menu-thumb',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & LEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography & Leader', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Item Title
		$this->add_control(
			'awea_heading_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-price-menu-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_title_tabs' );

		$this->start_controls_tab(
			'awea_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-title, {{WRAPPER}} .awea-price-menu-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_title_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu:hover .awea-price-menu-title, {{WRAPPER}} .awea-price-menu:hover .awea-price-menu-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Badge
		$this->add_control(
			'awea_heading_badge',
			[
				'label'     => esc_html__( 'Tag Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_badge_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-badge' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-price-menu-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Price Amount
		$this->add_control(
			'awea_heading_price',
			[
				'label'     => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_price_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typography',
				'selector' => '{{WRAPPER}} .awea-price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Leader Line
		$this->add_control(
			'awea_heading_leader',
			[
				'label'     => esc_html__( 'Leader Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_leader_style',
			[
				'label'     => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'dotted',
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'awesome-widgets-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'awesome-widgets-elementor' ),
					'solid'  => esc_html__( 'Solid', 'awesome-widgets-elementor' ),
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_leader_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.16)',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [ 'awea_leader_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_leader_thickness',
			[
				'label'      => esc_html__( 'Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-header::after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_leader_style!' => 'none' ],
			]
		);

		// Description
		$this->add_control(
			'awea_heading_desc',
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
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typography',
				'selector' => '{{WRAPPER}} .awea-description',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_margin_top',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-description' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Rows & Dividers
		$this->add_control(
			'awea_heading_row_spacing',
			[
				'label'     => esc_html__( 'Row Dividers', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_row_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_row_divider_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.06)',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_price_menu_items'] ?? [];
		$title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h4' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<ul class="awea-price-menu-list" role="list">
			<?php foreach ( $items as $index => $item ) :
				$id       = $item['_id'] ?? $index;
				$title    = $item['awea_item_title'] ?? '';
				$badge    = $item['awea_item_badge'] ?? '';
				$price    = $item['awea_item_price'] ?? '';
				$desc     = $item['awea_item_description'] ?? '';
				$has_link = ! empty( $item['awea_item_link']['url'] );
				$link_key = 'link_' . $id;

				if ( $has_link ) {
					$this->add_link_attributes( $link_key, $item['awea_item_link'] );
				}
				?>
				<li class="awea-price-menu elementor-repeater-item-<?php echo esc_attr( $id ); ?>" role="listitem">

					<?php if ( ! empty( $item['awea_item_image']['url'] ) ) : ?>
						<div class="awea-price-menu-thumb">
							<?php
							if ( ! empty( $item['awea_item_image']['id'] ) ) {
								echo wp_get_attachment_image( $item['awea_item_image']['id'], $settings['awea_thumbnail_size_size'], false, [ 'loading' => 'lazy' ] );
							} else {
								echo '<img src="' . esc_url( $item['awea_item_image']['url'] ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
							}
							?>
						</div>
					<?php endif; ?>

					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<?php if ( ! empty( $title ) ) : ?>
								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-price-menu-title">
									<?php if ( $has_link ) : ?>
										<a <?php $this->print_render_attribute_string( $link_key ); ?>><?php echo esc_html( $title ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $title ); ?>
									<?php endif; ?>
									<?php if ( ! empty( $badge ) ) : ?>
										<span class="awea-price-menu-badge"><?php echo esc_html( $badge ); ?></span>
									<?php endif; ?>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $price ) ) : ?>
								<span class="awea-price"><?php echo esc_html( $price ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea-description">
								<?php echo esc_html( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var items = settings.awea_price_menu_items || [];
		if ( ! items.length ) {
			return;
		}
		var tag = elementor.helpers.validateHTMLTag( settings.awea_title_tag || 'h4' );
		#>
		<ul class="awea-price-menu-list" role="list">
			<# _.each( items, function( item ) {
				var imgUrl = item.awea_item_image && item.awea_item_image.url ? item.awea_item_image.url : '';
			#>
				<li class="awea-price-menu elementor-repeater-item-{{ item._id }}" role="listitem">
					<# if ( imgUrl ) { #>
						<div class="awea-price-menu-thumb">
							<img src="{{ imgUrl }}" alt="{{ item.awea_item_title }}" loading="lazy" />
						</div>
					<# } #>

					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<# if ( item.awea_item_title ) { #>
								<{{{ tag }}} class="awea-price-menu-title">
									<# if ( item.awea_item_link && item.awea_item_link.url ) { #>
										<a href="{{ item.awea_item_link.url }}">{{{ item.awea_item_title }}}</a>
									<# } else { #>
										{{{ item.awea_item_title }}}
									<# } #>
									<# if ( item.awea_item_badge ) { #>
										<span class="awea-price-menu-badge">{{{ item.awea_item_badge }}}</span>
									<# } #>
								</{{{ tag }}}>
							<# } #>

							<# if ( item.awea_item_price ) { #>
								<span class="awea-price">{{{ item.awea_item_price }}}</span>
							<# } #>
						</div>

						<# if ( item.awea_item_description ) { #>
							<p class="awea-description">{{{ item.awea_item_description }}}</p>
						<# } #>
					</div>
				</li>
			<# } ); #>
		</ul>
		<?php
	}
}