<?php
/**
 * Awesome Breadcrumb Studio Widget.
 * Architectural Hero Header & Dynamic Schema-Compliant Breadcrumbs.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Widget_Awesome_Breadcumb extends Widget_Base {

	public function get_name() {
		return 'awesome-breadcumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'breadcrumb', 'navigation', 'trail', 'header', 'page title', 'seo' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. BREADCRUMB
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_breadcrumb_content',
			[
				'label' => esc_html__( 'Breadcrumb', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_breadcrumb_mode',
			[
				'label'   => esc_html__( 'Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__( 'Automatic', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_custom_title',
			[
				'label'       => esc_html__( 'Custom Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_breadcrumb_mode' => 'custom' ],
			]
		);

		$this->add_control(
			'awea_home_label',
			[
				'label'   => esc_html__( 'Home Label', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Home', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_show_title',
			[
				'label'        => esc_html__( 'Show Title', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h1',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'span' => 'span',
					'div'  => 'div',
				],
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_breadcrumb_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_separator_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'chevron',
				'options' => [
					'chevron' => esc_html__( 'Chevron ( › )', 'awesome-widgets-elementor' ),
					'slash'   => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'dot'     => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_separator_custom_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_separator_type' => 'custom' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 3. BACKGROUND
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_bg_overlay',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero',
			]
		);

		$this->add_control(
			'awea_heading_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_overlay',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero::before',
			]
		);

		$this->add_responsive_control(
			'awea_overlay_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'   => [ 'size' => 0.65 ],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-hero::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_hero_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea-crumb-justify: flex-start;',
					'center' => 'text-align: center; --awea-crumb-justify: center;',
					'right'  => 'text-align: right; --awea-crumb-justify: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-breadcrumb-hero' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_inner_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1600 ],
					'%'  => [ 'min' => 50, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hero_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '80', 'right' => '24', 'bottom' => '80', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_hero_border',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero',
			]
		);

		$this->add_responsive_control(
			'awea_hero_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-hero' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. TITLE (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_trail',
			[
				'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_trail_typography',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-nav',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->start_controls_tabs( 'awea_trail_color_tabs' );

		// Link
		$this->start_controls_tab(
			'awea_trail_tab_normal',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.72)',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_trail_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Current
		$this->start_controls_tab(
			'awea_trail_tab_active',
			[ 'label' => esc_html__( 'Current', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_current_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item.is-current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 13 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-sep'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-breadcrumb-sep svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-breadcrumb-sep i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sep_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-sep' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.35)',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-sep'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-breadcrumb-sep svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function get_dynamic_breadcrumbs( $home_label ) {
		$crumbs   = [];
		$crumbs[] = [ 'label' => $home_label, 'url' => home_url( '/' ) ];

		if ( is_front_page() || is_home() ) {
			return $crumbs;
		}

		if ( is_singular() ) {
			$post = get_queried_object();

			if ( is_page() && $post->post_parent ) {
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				foreach ( $ancestors as $ancestor_id ) {
					$crumbs[] = [
						'label' => get_the_title( $ancestor_id ),
						'url'   => get_permalink( $ancestor_id ),
					];
				}
			} elseif ( is_single() ) {
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					$crumbs[] = [
						'label' => $cats[0]->name,
						'url'   => get_category_link( $cats[0]->term_id ),
					];
				}
			}

			$crumbs[] = [ 'label' => get_the_title( $post->ID ), 'url' => null ];
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term && ! is_wp_error( $term ) ) {
				$crumbs[] = [ 'label' => $term->name, 'url' => null ];
			}
		} elseif ( is_search() ) {
			$crumbs[] = [ 'label' => sprintf( esc_html__( 'Search: "%s"', 'awesome-widgets-elementor' ), get_search_query() ), 'url' => null ];
		} elseif ( is_author() ) {
			$crumbs[] = [ 'label' => get_the_author_meta( 'display_name', get_query_var( 'author' ) ), 'url' => null ];
		} elseif ( is_404() ) {
			$crumbs[] = [ 'label' => esc_html__( 'Page Not Found', 'awesome-widgets-elementor' ), 'url' => null ];
		} elseif ( is_archive() ) {
			$crumbs[] = [ 'label' => get_the_archive_title(), 'url' => null ];
		}

		return $crumbs;
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$mode       = $settings['awea_breadcrumb_mode'] ?? 'dynamic';
		$home_label = ! empty( $settings['awea_home_label'] ) ? $settings['awea_home_label'] : esc_html__( 'Home', 'awesome-widgets-elementor' );
		$show_title = 'yes' === ( $settings['awea_show_title'] ?? 'no' );
		$title_tag  = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h1' );
		$sep_type   = $settings['awea_separator_type'] ?? 'chevron';

		if ( 'custom' === $mode ) {
			$page_title = $settings['awea_custom_title'] ?? '';
			$crumbs     = [
				[ 'label' => $home_label, 'url' => home_url( '/' ) ],
				[ 'label' => $page_title, 'url' => null ],
			];
		} else {
			if ( is_404() ) {
				$page_title = esc_html__( '404 - Not Found', 'awesome-widgets-elementor' );
			} elseif ( is_search() ) {
				$page_title = sprintf( esc_html__( 'Results for "%s"', 'awesome-widgets-elementor' ), get_search_query() );
			} elseif ( is_archive() ) {
				$page_title = get_the_archive_title();
			} else {
				$page_title = get_the_title();
			}
			$crumbs = $this->get_dynamic_breadcrumbs( $home_label );
		}
		?>
		<header class="awea-breadcrumb-hero">
			<div class="awea-breadcrumb-inner">
				
				<?php if ( $show_title && ! empty( $page_title ) ) : ?>
					<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-breadcrumb-title">
						<?php echo esc_html( $page_title ); ?>
					</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
				<?php endif; ?>

				<!-- Schema-Compliant Breadcrumb List -->
				<nav class="awea-breadcrumb-nav" aria-label="<?php esc_attr_e( 'Breadcrumb', 'awesome-widgets-elementor' ); ?>">
					<ol class="awea-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
						<?php
						$total_items = count( $crumbs );
						foreach ( $crumbs as $index => $crumb ) :
							$is_last  = ( $index === $total_items - 1 );
							$position = $index + 1;
							?>
							<li class="awea-breadcrumb-item <?php echo $is_last ? 'is-current' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
								<?php if ( ! empty( $crumb['url'] ) && ! $is_last ) : ?>
									<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item">
										<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
									</a>
								<?php else : ?>
									<span class="awea-breadcrumb-text" aria-current="page" itemprop="name">
										<?php echo esc_html( $crumb['label'] ); ?>
									</span>
								<?php endif; ?>
								
								<meta itemprop="position" content="<?php echo esc_attr( (string) $position ); ?>" />

								<!-- Separator -->
								<?php if ( ! $is_last ) : ?>
									<span class="awea-breadcrumb-sep" aria-hidden="true">
										<?php if ( 'chevron' === $sep_type ) : ?>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"></polyline></svg>
										<?php elseif ( 'slash' === $sep_type ) : ?>
											/
										<?php elseif ( 'dot' === $sep_type ) : ?>
											•
										<?php elseif ( 'custom' === $sep_type && ! empty( $settings['awea_separator_custom_icon']['value'] ) ) : ?>
											<?php Icons_Manager::render_icon( $settings['awea_separator_custom_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php endif; ?>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				</nav>

			</div>
		</header>
		<?php
	}
}