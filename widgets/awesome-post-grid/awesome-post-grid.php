<?php
/**
 * Awesome Post Grid Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Post_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-post-grid';
	}

	public function get_title() {
		return esc_html__( 'Post Grid', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'post grid', 'blog', 'articles', 'feed', 'query', 'archive' ];
	}

	protected function register_controls() {
		$this->register_content_controls();$this->register_style_controls();
	}

	/**
	 * Content Tab Controls
	 */
	protected function register_content_controls() {

		/* ==========================================================================
		   CONTENT: 1. QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_section_query',
			[
				'label' => esc_html__( 'Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_grid_post_count',
			[
				'label'   => esc_html__( 'Posts Per Page', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$cat_options = [];$categories  = get_categories( [ 'hide_empty' => false ] );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {$cat_options[ $cat->term_id ] =$cat->name;
			}
		}

		$this->add_control(
			'awea_post_grid_category_select',
			[
				'label'       => esc_html__( 'Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
			]
		);

		$this->add_control(
			'awea_post_grid_orderby',
			[
				'label'   => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Date', 'awesome-widgets-elementor' ),
					'title'         => esc_html__( 'Title', 'awesome-widgets-elementor' ),
					'rand'          => esc_html__( 'Random', 'awesome-widgets-elementor' ),
					'comment_count' => esc_html__( 'Comments', 'awesome-widgets-elementor' ),
					'modified'      => esc_html__( 'Modified', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_post_grid_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Ascending', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_post_grid_post_offset',
			[
				'label'     => esc_html__( 'Offset', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'max'       => 50,
				'condition' => [ 'awea_post_grid_pagination!' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_grid_exclude_current',
			[
				'label'        => esc_html__( 'Exclude Current Post', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_post_grid_pagination',
			[
				'label'        => esc_html__( 'Enable Pagination', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_section_elements',
			[
				'label' => esc_html__( 'Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_grid_show_category',
			[
				'label'        => esc_html__( 'Category Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_grid_show_author',
			[
				'label'        => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_post_grid_show_date',
			[
				'label'        => esc_html__( 'Publish Date', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_grid_show_reading_time',
			[
				'label'        => esc_html__( 'Reading Time', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_grid_show_counter',
			[
				'label'        => esc_html__( 'Index Number (01, 02...)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_grid_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
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
		   CONTENT: 3. EXCERPT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_section_excerpt',
			[
				'label' => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_grid_show_excerpt',
			[
				'label'        => esc_html__( 'Display Excerpt', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_post_grid_excerpt_length',
			[
				'label'     => esc_html__( 'Word Length', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'min'       => 5,
				'max'       => 100,
				'condition' => [ 'awea_post_grid_show_excerpt' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_section_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_post_grid_show_button',
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
			'awea_post_grid_button_text',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Insight', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_post_grid_show_button' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_section_layout',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_columns',
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
					'{{WRAPPER}} .awea_post_grid_row' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
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
			'awea_post_grid_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_grid_row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_grid_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_card_radius',
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
					'{{WRAPPER}} .awea_post_grid_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_footer_divider',
			[
				'label'     => esc_html__( 'Footer Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_post_grid_card_tabs' );

		$this->start_controls_tab(
			'awea_post_grid_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_post_grid_card_border',
				'selector'       => '{{WRAPPER}} .awea_post_grid_card',
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
				'name'     => 'awea_post_grid_card_shadow',
				'selector' => '{{WRAPPER}} .awea_post_grid_card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_grid_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f8fafc',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_post_grid_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea_post_grid_card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_style_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_post_grid_image_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/10' => '16:10',
					'16/9'  => '16:9',
					'4/3'   => '4:3',
					'1/1'   => '1:1',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_img_wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_image_radius',
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
					'{{WRAPPER}} .awea_post_grid_img_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_image_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_grid_img_wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. BADGE & META
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_style_badge',
			[
				'label'     => esc_html__( 'Category Badge', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_grid_show_category' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_grid_cat_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_cat_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_grid_cat_typo',
				'selector' => '{{WRAPPER}} .awea_post_grid_badge',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_grid_badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_grid_style_meta',
			[
				'label' => esc_html__( 'Post Meta', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_post_grid_meta_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_grid_meta_typo',
				'selector' => '{{WRAPPER}} .awea_post_grid_meta',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TITLE & EXCERPT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_style_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_grid_title_typo',
				'selector' => '{{WRAPPER}} .awea_post_grid_title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->start_controls_tabs( 'awea_post_grid_title_tabs' );

		$this->start_controls_tab(
			'awea_post_grid_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_grid_title_hover_tab',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_title_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card:hover .awea_post_grid_title a, {{WRAPPER}} .awea_post_grid_title a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_grid_style_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_grid_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_grid_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#475569',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_grid_desc_typo',
				'selector' => '{{WRAPPER}} .awea_post_grid_desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BUTTON & COUNTER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_style_button',
			[
				'label'     => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_grid_show_button' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_post_grid_btn_typo',
				'selector' => '{{WRAPPER}} .awea_post_grid_link',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->start_controls_tabs( 'awea_post_grid_btn_tabs' );

		$this->start_controls_tab(
			'awea_post_grid_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_btn_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_btn_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_post_grid_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_post_grid_btn_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card:hover .awea_post_grid_link, {{WRAPPER}} .awea_post_grid_link:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_btn_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_card:hover .awea_post_grid_link, {{WRAPPER}} .awea_post_grid_link:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'awea_post_grid_style_counter',
			[
				'label'     => esc_html__( 'Index Number', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_grid_show_counter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_post_grid_counter_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cbd5e1',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. PAGINATION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_post_grid_style_pagination',
			[
				'label'     => esc_html__( 'Pagination', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_post_grid_pagination' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_post_grid_pag_space',
			[
				'label'      => esc_html__( 'Top Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 36 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_post_grid_pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_pag_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_pagination .page-numbers' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_post_grid_pag_active_bg',
			[
				'label'     => esc_html__( 'Active / Hover Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_post_grid_pagination .page-numbers.current, {{WRAPPER}} .awea_post_grid_pagination .page-numbers:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}}; color: #ffffff;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$num_posts    = ! empty( $settings['awea_post_grid_post_count'] ) ? absint( $settings['awea_post_grid_post_count'] ) : 6;
		$order        = in_array( $settings['awea_post_grid_order'] ?? 'DESC', [ 'ASC', 'DESC' ], true ) ? $settings['awea_post_grid_order'] : 'DESC';
		$orderby      = $settings['awea_post_grid_orderby'] ?? 'date';
		$categories   = $settings['awea_post_grid_category_select'] ?? [];
		$offset       = absint( $settings['awea_post_grid_post_offset'] ?? 0 );
		$exclude_curr = 'yes' === ( $settings['awea_post_grid_exclude_current'] ?? 'no' );
		$pagination   = 'yes' === ( $settings['awea_post_grid_pagination'] ?? 'no' );
		$show_cat     = 'yes' === ( $settings['awea_post_grid_show_category'] ?? 'no' );
		$show_author  = 'yes' === ( $settings['awea_post_grid_show_author'] ?? 'no' );
		$show_date    = 'yes' === ( $settings['awea_post_grid_show_date'] ?? 'no' );
		$show_read    = 'yes' === ( $settings['awea_post_grid_show_reading_time'] ?? 'no' );
		$show_exc     = 'yes' === ( $settings['awea_post_grid_show_excerpt'] ?? 'no' );
		$exc_len      = ! empty( $settings['awea_post_grid_excerpt_length'] ) ? absint( $settings['awea_post_grid_excerpt_length'] ) : 15;
		$show_btn     = 'yes' === ( $settings['awea_post_grid_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_post_grid_button_text'] ?? esc_html__( 'Read Insight', 'awesome-widgets-elementor' );
		$show_counter = 'yes' === ( $settings['awea_post_grid_show_counter'] ?? 'no' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_post_grid_title_tag'] ?? 'h3' );
		$thumb_size   = $settings['awea_post_grid_image_size_size'] ?? 'large';

		$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

		$args = [
			'posts_per_page'      => $num_posts,
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => ! $pagination,
		];

		if ( $pagination ) {
			$args['paged'] = $paged;
		} elseif ( $offset > 0 ) {
			$args['offset'] = $offset;
		}

		if ( $exclude_curr && is_singular() ) {
			$current_id = get_queried_object_id();
			if ( $current_id > 0 ) {
				// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
				$args['post__not_in'] = [ $current_id ];
			}
		}

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['category__in'] = array_map( 'absint', $categories );
		}

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p class="awea_post_grid_no_posts">' . esc_html__( 'No posts found matching your criteria.', 'awesome-widgets-elementor' ) . '</p>';
			return;
		}
		?>
		<div class="awea_post_grid_wrap">
			<div class="awea_post_grid_row">
				<?php
				$counter = $pagination ? ( ( $paged - 1 ) * $num_posts ) + 1 : 1;
				while ( $query->have_posts() ) :
					$query->the_post();
					$post_id      = get_the_ID();
					$plain_text   = trim( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
					$words        = '' !== $plain_text ? preg_split( '/\s+/u', $plain_text, -1, PREG_SPLIT_NO_EMPTY ) : [];
					$word_count   = is_array( $words ) ? count( $words ) : 0;
					$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
					$post_cats    = get_the_category( $post_id );
					$permalink    = get_the_permalink( $post_id );
					?>
					<div class="awea_post_grid_item">
						<article class="awea_post_grid_card">

							<div class="awea_post_grid_img_wrap">
								<?php if ( $show_cat && ! empty( $post_cats ) ) : ?>
									<a href="<?php echo esc_url( get_category_link( $post_cats[0]->term_id ) ); ?>" class="awea_post_grid_badge">
										<?php echo esc_html( $post_cats[0]->name ); ?>
									</a>
								<?php endif; ?>

								<a href="<?php echo esc_url( $permalink ); ?>" class="awea_post_grid_img_link" aria-label="<?php the_title_attribute(); ?>">
									<?php if ( has_post_thumbnail( $post_id ) ) : ?>
										<?php echo get_the_post_thumbnail( $post_id, $thumb_size, [ 'class' => 'awea_post_grid_img', 'loading' => 'lazy' ] ); ?>
									<?php else : ?>
										<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea_post_grid_img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
									<?php endif; ?>
								</a>
							</div>

							<div class="awea_post_grid_body">
								<?php if ( $show_author || $show_date || $show_read ) : ?>
									<div class="awea_post_grid_meta">
										<?php if ( $show_author ) : ?>
											<span><?php echo esc_html( get_the_author() ); ?></span>
										<?php endif; ?>

										<?php if ( $show_author && ( $show_date || $show_read ) ) : ?>
											<span class="awea_post_grid_meta_dot" aria-hidden="true">•</span>
										<?php endif; ?>

										<?php if ( $show_date ) : ?>
											<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>"><?php echo esc_html( get_the_date( '', $post_id ) ); ?></time>
										<?php endif; ?>

										<?php if ( $show_date && $show_read ) : ?>
											<span class="awea_post_grid_meta_dot" aria-hidden="true">•</span>
										<?php endif; ?>

										<?php if ( $show_read ) : ?>
											<span>
												<?php
												/* translators: %d: estimated reading time in minutes */
												echo esc_html( sprintf( __( '%d MIN READ', 'awesome-widgets-elementor' ), $reading_time ) );
												?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea_post_grid_title">
									<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( $show_exc ) : ?>
									<p class="awea_post_grid_desc">
										<?php echo esc_html( wp_trim_words( get_the_excerpt( $post_id ), $exc_len, '...' ) ); ?>
									</p>
								<?php endif; ?>
							</div>

							<?php if ( ( $show_btn && ! empty( $btn_text ) ) || $show_counter ) : ?>
								<div class="awea_post_grid_footer">
									<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
										<a href="<?php echo esc_url( $permalink ); ?>" class="awea_post_grid_link">
											<span><?php echo esc_html( $btn_text ); ?></span>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
										</a>
									<?php endif; ?>

									<?php if ( $show_counter ) : ?>
										<span class="awea_post_grid_num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $counter ) ); ?></span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</article>
					</div>
					<?php
					$counter++;
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<?php if ( $pagination && $query->max_num_pages > 1 ) :
				$pag_links = paginate_links(
					[
						'total'     => $query->max_num_pages,
						'current'   => $paged,
						'prev_text' => esc_html__( '&larr;', 'awesome-widgets-elementor' ),
						'next_text' => esc_html__( '&rarr;', 'awesome-widgets-elementor' ),
					]
				);
				if ( $pag_links ) :
					?>
					<nav class="awea_post_grid_pagination" aria-label="<?php esc_attr_e( 'Posts Pagination', 'awesome-widgets-elementor' ); ?>">
						<?php echo wp_kses_post( $pag_links ); ?>
					</nav>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}
}