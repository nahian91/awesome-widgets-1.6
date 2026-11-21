<?php
/**
 * Awesome Product Category Grid Widget.
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
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Product_Category_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Category Grid', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product category', 'grid', 'shop', 'catalog' ];
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
		   CONTENT: 1. QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_grid_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) ) {
			$categories = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				foreach ( $categories as $cat ) {
					$cat_options[ $cat->term_id ] = $cat->name;
				}
			}
		}

		$this->add_control(
			'awea_product_cat_grid_taxonomy_filter',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Leave empty to show all categories.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_product_cat_grid_posts_per_page',
			[
				'label'   => esc_html__( 'Count', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_product_cat_grid_orderby',
			[
				'label'   => esc_html__( 'Sort', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => esc_html__( 'Name', 'awesome-widgets-elementor' ),
					'count' => esc_html__( 'Count', 'awesome-widgets-elementor' ),
					'id'    => esc_html__( 'ID', 'awesome-widgets-elementor' ),
					'slug'  => esc_html__( 'Slug', 'awesome-widgets-elementor' ),
					'rand'  => esc_html__( 'Random', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_product_cat_grid_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_grid_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_columns',
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
					'{{WRAPPER}} .awea_product_cat_grid_wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'awea_product_cat_grid_kicker_text',
			[
				'label'       => esc_html__( 'Kicker', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Collection', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_product_cat_grid_action_text',
			[
				'label'       => esc_html__( 'Action', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_product_cat_grid_image_grayscale',
			[
				'label'        => esc_html__( 'Grayscale Filter', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_product_cat_grid_grayscale_',
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
			'awea_product_cat_grid_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_card_height',
			[
				'label'          => esc_html__( 'Height', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vh' ],
				'range'          => [ 'px' => [ 'min' => 200, 'max' => 1200 ] ],
				'default'        => [ 'unit' => 'px', 'size' => 540 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 460 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 380 ],
				'selectors'      => [
					'{{WRAPPER}} .awea_product_cat_grid_card' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_column_gap',
			[
				'label'      => esc_html__( 'Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_cat_grid_wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_card_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea_product_cat_grid_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_product_cat_grid_card_tabs' );

		$this->start_controls_tab(
			'awea_product_cat_grid_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_product_cat_grid_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_product_cat_grid_card',
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
					'color'  => [ 'default' => 'rgba(255, 255, 255, 0.08)' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_product_cat_grid_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_product_cat_grid_card_border_hover',
			[
				'label'     => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_grid_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_grid_style_overlay',
			[
				'label' => esc_html__( 'Overlay', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_product_cat_grid_image_overlay_bg',
				'label'    => esc_html__( 'Gradient', 'awesome-widgets-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea_product_cat_grid_card::before',
			]
		);

		$this->add_control(
			'awea_product_cat_grid_glass_box_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.06)',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_grid_info' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_glass_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_cat_grid_info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_product_cat_grid_glass_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_product_cat_grid_info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_product_cat_grid_style_text',
			[
				'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_product_cat_grid_sub_color',
			[
				'label'     => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.65)',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_grid_info span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_cat_grid_sub_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_cat_grid_info span',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_product_cat_grid_title_color',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_grid_info h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_cat_grid_title_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_cat_grid_info h3',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_product_cat_grid_btn_color',
			[
				'label'     => esc_html__( 'Action', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_product_cat_grid_view_collection' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_product_cat_grid_btn_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_product_cat_grid_view_collection',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea_product_cat_grid_notice_error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Grid widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings = $this->get_settings_for_display();
		$limit    = ! empty( $settings['awea_product_cat_grid_posts_per_page'] ) ? absint( $settings['awea_product_cat_grid_posts_per_page'] ) : 3;
		$orderby  = $settings['awea_product_cat_grid_orderby'] ?? 'name';
		$order    = $settings['awea_product_cat_grid_order'] ?? 'ASC';
		$filter   = $settings['awea_product_cat_grid_taxonomy_filter'] ?? [];
		$kicker   = ! empty( $settings['awea_product_cat_grid_kicker_text'] ) ? $settings['awea_product_cat_grid_kicker_text'] : esc_html__( 'Collection', 'awesome-widgets-elementor' );
		$action   = ! empty( $settings['awea_product_cat_grid_action_text'] ) ? $settings['awea_product_cat_grid_action_text'] : esc_html__( 'Explore Collection', 'awesome-widgets-elementor' );

		$args = [
			'taxonomy'   => 'product_cat',
			'number'     => $limit,
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => false,
		];

		if ( ! empty( $filter ) && is_array( $filter ) ) {
			$args['include'] = array_map( 'absint', $filter );
			if ( 'name' !== $orderby ) {
				$args['orderby'] = 'include';
			}
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return;
		}
		?>
		<div class="awea_product_cat_grid_wrap">
			<div class="awea_product_cat_grid_wrapper" role="list">
				<?php foreach ( $terms as $term ) :
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
					$link         = get_term_link( $term );
					if ( is_wp_error( $link ) ) {
						continue;
					}
					?>
					<div class="awea_product_cat_grid_item" role="listitem">
						<a href="<?php echo esc_url( $link ); ?>" class="awea_product_cat_grid_card" aria-label="<?php echo esc_attr( $term->name ); ?>">
							<?php if ( ! empty( $image_url ) ) : ?>
								<img src="<?php echo esc_url( $image_url ); ?>" class="awea_product_cat_grid_image" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy" />
							<?php endif; ?>

							<div class="awea_product_cat_grid_info">
								<?php if ( ! empty( $kicker ) ) : ?>
									<span aria-hidden="true"><?php echo esc_html( $kicker ); ?></span>
								<?php endif; ?>
								<h3><?php echo esc_html( $term->name ); ?></h3>
								<?php if ( ! empty( $action ) ) : ?>
									<div class="awea_product_cat_grid_view_collection">
										<span><?php echo esc_html( $action ); ?></span>
										<svg class="awea_product_cat_grid_arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
									</div>
								<?php endif; ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<div class="awea_product_cat_grid_wrap">
			<div class="awea_product_cat_grid_wrapper" role="list">
				<div class="awea_product_cat_grid_item" role="listitem">
					<a href="#" class="awea_product_cat_grid_card">
						<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea_product_cat_grid_image" alt="Placeholder" loading="lazy" />
						<div class="awea_product_cat_grid_info">
							<span aria-hidden="true">{{{ settings.awea_product_cat_grid_kicker_text || 'Collection' }}}</span>
							<h3><?php esc_html_e( 'Sample Category', 'awesome-widgets-elementor' ); ?></h3>
							<div class="awea_product_cat_grid_view_collection">
								<span>{{{ settings.awea_product_cat_grid_action_text || 'Explore Collection' }}}</span>
								<svg class="awea_product_cat_grid_arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<?php
	}
}