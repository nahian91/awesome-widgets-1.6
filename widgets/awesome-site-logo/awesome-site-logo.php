<?php
/**
 * Awesome Site Logo Studio Widget (Zero-Shadow Architectural Edition).
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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Site_Logo extends Widget_Base {

	public function get_name() {
		return 'awesome-site-logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}

	public function get_categories() {
		return [ 'awesome-header-footer', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'logo', 'site logo', 'brand', 'image', 'header', 'retina', 'sticky' ];
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
		   CONTENT: 1. LOGO
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_section_logo',
			[
				'label' => esc_html__( 'Logo', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_site_logo_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
					'text'  => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				],
			]
		);

		// IMAGE CONTROLS
		$this->add_control(
			'awea_site_logo_source',
			[
				'label'     => esc_html__( 'Source', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'custom',
				'options'   => [
					'custom'    => esc_html__( 'Custom', 'awesome-widgets-elementor' ),
					'site_logo' => esc_html__( 'Identity', 'awesome-widgets-elementor' ),
				],
				'condition' => [
					'awea_site_logo_type' => 'image',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_custom',
			[
				'label'     => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'awea_site_logo_type'   => 'image',
					'awea_site_logo_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_retina',
			[
				'label'       => esc_html__( 'Retina', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Optional high-DPI 2x version for crisp rendering on Retina displays.', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'awea_site_logo_type'   => 'image',
					'awea_site_logo_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_enable_hover',
			[
				'label'        => esc_html__( 'Hover Logo', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
				'condition'    => [
					'awea_site_logo_type'   => 'image',
					'awea_site_logo_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_hover_image',
			[
				'label'     => esc_html__( 'Hover Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'awea_site_logo_type'        => 'image',
					'awea_site_logo_source'      => 'custom',
					'awea_site_logo_enable_hover' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_enable_sticky',
			[
				'label'        => esc_html__( 'Sticky Logo', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Automatically switches logo when parent header becomes sticky.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'awea_site_logo_type' => 'image',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_sticky_image',
			[
				'label'     => esc_html__( 'Sticky Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'awea_site_logo_type'         => 'image',
					'awea_site_logo_enable_sticky' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_site_logo_image_size',
				'default'   => 'full',
				'separator' => 'before',
				'condition' => [
					'awea_site_logo_type'   => 'image',
					'awea_site_logo_source' => 'custom',
				],
			]
		);

		// TEXT CONTROLS
		$this->add_control(
			'awea_site_logo_show_icon',
			[
				'label'        => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'awea_site_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_icon',
			[
				'label'       => esc_html__( 'Brand Icon', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-shapes',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'awea_site_logo_type'      => 'text',
					'awea_site_logo_show_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_title_text',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => get_bloginfo( 'name' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [
					'awea_site_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_title_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'span',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'div'  => 'div',
					'span' => 'span',
				],
				'condition' => [
					'awea_site_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_show_tagline',
			[
				'label'        => esc_html__( 'Tagline', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'awea_site_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_tagline_text',
			[
				'label'       => esc_html__( 'Tagline Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => get_bloginfo( 'description' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [
					'awea_site_logo_type'        => 'text',
					'awea_site_logo_show_tagline' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_site_logo_link_type',
			[
				'label'   => esc_html__( 'Link Target', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'home',
				'options' => [
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'home'   => esc_html__( 'Home URL', 'awesome-widgets-elementor' ),
					'custom' => esc_html__( 'Custom URL', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_site_logo_custom_link',
			[
				'label'       => esc_html__( 'Custom URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'awea_site_logo_link_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_alignment',
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
				'default'              => 'left',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea_site_logo_align: flex-start;',
					'center' => 'text-align: center; --awea_site_logo_align: center;',
					'right'  => 'text-align: right; --awea_site_logo_align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_site_logo_outer' => '{{VALUE}}',
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
		   STYLE: 1. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_style_image',
			[
				'label'     => esc_html__( 'Image Logo', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_site_logo_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_width',
			[
				'label'      => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 20, 'max' => 600 ],
					'%'  => [ 'min' => 5, 'max' => 100 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 160,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_wrap img, {{WRAPPER}} .awea_site_logo_wrap svg' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%; height: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_max_height',
			[
				'label'      => esc_html__( 'Max Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 15, 'max' => 250 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_wrap img, {{WRAPPER}} .awea_site_logo_wrap svg' => 'max-height: {{SIZE}}{{UNIT}}; object-fit: contain;',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_wrap img, {{WRAPPER}} .awea_site_logo_wrap svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_site_logo_border',
				'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_site_logo_wrap img',
			]
		);

		$this->start_controls_tabs( 'awea_site_logo_filter_tabs' );

		$this->start_controls_tab(
			'awea_site_logo_filter_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_site_logo_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
				],
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_wrap' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_site_logo_css_filters',
				'selector' => '{{WRAPPER}} .awea_site_logo_wrap img, {{WRAPPER}} .awea_site_logo_wrap svg',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_site_logo_filter_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_site_logo_opacity_hover',
			[
				'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
				],
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_wrap:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_site_logo_css_filters_hover',
				'selector' => '{{WRAPPER}} .awea_site_logo_wrap:hover img, {{WRAPPER}} .awea_site_logo_wrap:hover svg',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_style_logo_icon',
			[
				'label'     => esc_html__( 'Brand Icon', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_site_logo_type'      => 'text',
					'awea_site_logo_show_icon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_icon_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 26 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_brand_ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea_site_logo_brand_ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_icon_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_brand_lockup' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_site_logo_icon_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_brand_ico'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea_site_logo_brand_ico svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TITLE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_style_title',
			[
				'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_site_logo_type' => 'text',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_site_logo_title_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'selector' => '{{WRAPPER}} .awea_site_logo_title',
			]
		);

		$this->start_controls_tabs( 'awea_site_logo_title_style_tabs' );

		$this->start_controls_tab(
			'awea_site_logo_title_style_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_site_logo_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_site_logo_title_style_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_site_logo_title_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_link:hover .awea_site_logo_title, {{WRAPPER}} .awea_site_logo_link:focus-visible .awea_site_logo_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TAGLINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_site_logo_style_tagline',
			[
				'label'     => esc_html__( 'Tagline', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_site_logo_type'         => 'text',
					'awea_site_logo_show_tagline' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_site_logo_tagline_typo',
				'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
				'selector' => '{{WRAPPER}} .awea_site_logo_tagline',
			]
		);

		$this->add_control(
			'awea_site_logo_tagline_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_site_logo_tagline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_site_logo_tagline_space',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_site_logo_tagline' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$logo_type = $settings['awea_site_logo_type'] ?? 'image';
		$link_type = $settings['awea_site_logo_link_type'] ?? 'home';
		$site_name = get_bloginfo( 'name' );

		$has_link = false;
		$this->remove_render_attribute( 'awea_site_logo_link' );
		$this->add_render_attribute( 'awea_site_logo_link', 'class', 'awea_site_logo_link' );

		if ( 'home' === $link_type ) {
			$has_link = true;
			$this->add_render_attribute( 'awea_site_logo_link', 'href', esc_url( home_url( '/' ) ) );
			$this->add_render_attribute( 'awea_site_logo_link', 'rel', 'home' );
			if ( is_front_page() ) {
				$this->add_render_attribute( 'awea_site_logo_link', 'aria-current', 'page' );
			}
		} elseif ( 'custom' === $link_type && ! empty( $settings['awea_site_logo_custom_link']['url'] ) ) {
			$has_link = true;
			$this->add_link_attributes( 'awea_site_logo_link', $settings['awea_site_logo_custom_link'] );
		}
		?>
		<div class="awea_site_logo_outer">
			<div class="awea_site_logo_wrap">
				<?php if ( $has_link ) : ?>
					<a <?php $this->print_render_attribute_string( 'awea_site_logo_link' ); ?>>
				<?php else : ?>
					<div class="awea_site_logo_link">
				<?php endif; ?>

					<?php if ( 'text' === $logo_type ) :
						$title_tag  = Utils::validate_html_tag( $settings['awea_site_logo_title_tag'] ?? 'span' );
						$show_icon  = 'yes' === ( $settings['awea_site_logo_show_icon'] ?? 'no' ) && ! empty( $settings['awea_site_logo_icon']['value'] );
						$logo_title = ! empty( $settings['awea_site_logo_title_text'] ) ? $settings['awea_site_logo_title_text'] : $site_name;
						?>
						<div class="awea_site_logo_brand_lockup">
							<?php if ( $show_icon ) : ?>
								<span class="awea_site_logo_brand_ico" aria-hidden="true">
									<?php Icons_Manager::render_icon( $settings['awea_site_logo_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<div class="awea_site_logo_text_group">
								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_site_logo_title">
									<?php echo esc_html( $logo_title ); ?>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( 'yes' === ( $settings['awea_site_logo_show_tagline'] ?? 'no' ) && ! empty( $settings['awea_site_logo_tagline_text'] ) ) : ?>
									<span class="awea_site_logo_tagline"><?php echo esc_html( $settings['awea_site_logo_tagline_text'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php else : ?>
						<?php
						$source          = $settings['awea_site_logo_source'] ?? 'custom';
						$has_hover_logo  = ( 'custom' === $source && 'yes' === ( $settings['awea_site_logo_enable_hover'] ?? 'no' ) ) && ! empty( $settings['awea_site_logo_hover_image']['url'] );
						$has_sticky_logo = ( 'yes' === ( $settings['awea_site_logo_enable_sticky'] ?? 'no' ) ) && ! empty( $settings['awea_site_logo_sticky_image']['url'] );
						$retina_url      = ( 'custom' === $source && ! empty( $settings['awea_site_logo_retina']['url'] ) ) ? $settings['awea_site_logo_retina']['url'] : '';
						$primary_html    = '';

						if ( 'site_logo' === $source && function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo_alt       = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
							$primary_html   = wp_get_attachment_image(
								$custom_logo_id,
								'full',
								false,
								[
									'class'   => 'awea_site_logo_primary awea_site_logo_img',
									'loading' => 'eager',
									'alt'     => ! empty( $logo_alt ) ? $logo_alt : $site_name,
								]
							);
						} elseif ( 'custom' === $source && ! empty( $settings['awea_site_logo_custom']['url'] ) ) {
							if ( ! empty( $retina_url ) ) {
								$base_url     = $settings['awea_site_logo_custom']['url'];
								$alt_text     = ! empty( $settings['awea_site_logo_custom']['alt'] ) ? $settings['awea_site_logo_custom']['alt'] : $site_name;
								$primary_html = sprintf(
									'<img src="%1$s" srcset="%1$s 1x, %2$s 2x" alt="%3$s" class="awea_site_logo_primary awea_site_logo_img" loading="eager" />',
									esc_url( $base_url ),
									esc_url( $retina_url ),
									esc_attr( $alt_text )
								);
							} else {
								$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_site_logo_image_size', 'awea_site_logo_custom' );
								if ( ! empty( $image_html ) ) {
									$primary_html = preg_replace( '/class="([^"]*)"/', 'class="$1 awea_site_logo_primary"', $image_html, 1 );
									if ( false === strpos( $primary_html, 'awea_site_logo_primary' ) ) {
										$primary_html = str_replace( '<img ', '<img class="awea_site_logo_primary" ', $primary_html );
									}
									if ( preg_match( '/alt=""/', $primary_html ) ) {
										$primary_html = preg_replace( '/alt=""/', 'alt="' . esc_attr( $site_name ) . '"', $primary_html, 1 );
									}
								} else {
									$primary_html = sprintf(
										'<img src="%s" alt="%s" class="awea_site_logo_primary" loading="eager" />',
										esc_url( $settings['awea_site_logo_custom']['url'] ),
										esc_attr( $site_name )
									);
								}
							}
						} else {
							$primary_html = '<span class="awea_site_logo_title">' . esc_html( $site_name ) . '</span>';
						}

						$group_classes = [ 'awea_site_logo_image_group' ];
						if ( $has_hover_logo ) {
							$group_classes[] = 'awea_site_logo_has_hover';
						}
						if ( $has_sticky_logo ) {
							$group_classes[] = 'awea_site_logo_has_sticky';
						}
						?>
						<div class="<?php echo esc_attr( implode( ' ', $group_classes ) ); ?>">
							<?php echo $primary_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

							<?php if ( $has_hover_logo ) : ?>
								<img src="<?php echo esc_url( $settings['awea_site_logo_hover_image']['url'] ); ?>" alt="" aria-hidden="true" class="awea_site_logo_hover" />
							<?php endif; ?>

							<?php if ( $has_sticky_logo ) : ?>
								<img src="<?php echo esc_url( $settings['awea_site_logo_sticky_image']['url'] ); ?>" alt="" aria-hidden="true" class="awea_site_logo_sticky" />
							<?php endif; ?>
						</div>
					<?php endif; ?>

				<?php if ( $has_link ) : ?>
					</a>
				<?php else : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var logoType = settings.awea_site_logo_type || 'image';
		var linkType = settings.awea_site_logo_link_type || 'home';
		var hasLink  = 'none' !== linkType;
		var linkUrl  = 'home' === linkType ? '<?php echo esc_url( home_url( '/' ) ); ?>' : ( settings.awea_site_logo_custom_link ? settings.awea_site_logo_custom_link.url : '#' );
		var siteName = <?php echo wp_json_encode( get_bloginfo( 'name' ) ); ?>;
		#>
		<div class="awea_site_logo_outer">
			<div class="awea_site_logo_wrap">
				<# if ( hasLink ) { #>
					<a href="{{ linkUrl }}" class="awea_site_logo_link">
				<# } else { #>
					<div class="awea_site_logo_link">
				<# } #>

					<# if ( 'text' === logoType ) {
						var titleTag = elementor.helpers.validateHTMLTag( settings.awea_site_logo_title_tag || 'span' );
						var iconHTML = elementor.helpers.renderIcon( view, settings.awea_site_logo_icon, { 'aria-hidden': true }, 'i', 'object' );
					#>
						<div class="awea_site_logo_brand_lockup">
							<# if ( 'yes' === settings.awea_site_logo_show_icon && iconHTML && iconHTML.rendered ) { #>
								<span class="awea_site_logo_brand_ico" aria-hidden="true">{{{ iconHTML.value }}}</span>
							<# } #>

							<div class="awea_site_logo_text_group">
								<{{{ titleTag }}} class="awea_site_logo_title">{{{ settings.awea_site_logo_title_text || siteName }}}</{{{ titleTag }}}>
								<# if ( 'yes' === settings.awea_site_logo_show_tagline && settings.awea_site_logo_tagline_text ) { #>
									<span class="awea_site_logo_tagline">{{{ settings.awea_site_logo_tagline_text }}}</span>
								<# } #>
							</div>
						</div>
					<# } else {
						var imageObj = {
							id: settings.awea_site_logo_custom ? settings.awea_site_logo_custom.id : '',
							url: settings.awea_site_logo_custom ? settings.awea_site_logo_custom.url : '',
							size: settings.awea_site_logo_image_size_size,
							dimension: settings.awea_site_logo_image_size_custom_dimension,
							model: view.getEditModel()
						};
						var primaryUrl = elementor.imagesManager.getImageUrl( imageObj );
						var hasHover   = 'custom' === settings.awea_site_logo_source && 'yes' === settings.awea_site_logo_enable_hover && settings.awea_site_logo_hover_image && settings.awea_site_logo_hover_image.url;
						var hasSticky  = 'yes' === settings.awea_site_logo_enable_sticky && settings.awea_site_logo_sticky_image && settings.awea_site_logo_sticky_image.url;
						var groupClass = 'awea_site_logo_image_group' + ( hasHover ? ' awea_site_logo_has_hover' : '' ) + ( hasSticky ? ' awea_site_logo_has_sticky' : '' );
					#>
						<div class="{{ groupClass }}">
							<# if ( primaryUrl ) { #>
								<img src="{{ primaryUrl }}" alt="{{ siteName }}" class="awea_site_logo_primary" />
							<# } else { #>
								<span class="awea_site_logo_title">{{{ siteName }}}</span>
							<# } #>

							<# if ( hasHover ) { #>
								<img src="{{ settings.awea_site_logo_hover_image.url }}" alt="" aria-hidden="true" class="awea_site_logo_hover" />
							<# } #>

							<# if ( hasSticky ) { #>
								<img src="{{ settings.awea_site_logo_sticky_image.url }}" alt="" aria-hidden="true" class="awea_site_logo_sticky" />
							<# } #>
						</div>
					<# } #>

				<# if ( hasLink ) { #>
					</a>
				<# } else { #>
					</div>
				<# } #>
			</div>
		</div>
		<?php
	}
}