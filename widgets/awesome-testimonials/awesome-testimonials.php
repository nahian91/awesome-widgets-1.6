<?php
/**
 * Awesome Testimonials Studio Widget (Zero-Shadow Repeater Grid Edition).
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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Testimonials extends Widget_Base {

	public function get_name() {
		return 'awesome-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'testimonial', 'reviews', 'grid', 'rating', 'feedback', 'quote' ];
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
			'awea_testimonials_section_items',
			[
				'label' => esc_html__( 'Testimonials List', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_testimonials_item_tabs' );

		// --- TAB 1: REVIEW ---
		$repeater->start_controls_tab(
			'awea_testimonials_tab_review',
			[ 'label' => esc_html__( 'Review', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_rating',
			[
				'label'   => esc_html__( 'Rating Stars', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'0' => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'1' => '1 Star',
					'2' => '2 Stars',
					'3' => '3 Stars',
					'4' => '4 Stars',
					'5' => '5 Stars',
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_quote',
			[
				'label'       => esc_html__( 'Quote', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'The architectural clarity and speed of this system are world-class. It transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Write review...', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: AUTHOR ---
		$repeater->start_controls_tab(
			'awea_testimonials_tab_author',
			[ 'label' => esc_html__( 'Author', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_photo',
			[
				'label'   => esc_html__( 'Avatar Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_name',
			[
				'label'       => esc_html__( 'Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_testimonials_role',
			[
				'label'       => esc_html__( 'Role / Company', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_testimonials_verified',
			[
				'label'        => esc_html__( 'Verified Customer', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: HIGHLIGHT ---
		$repeater->start_controls_tab(
			'awea_testimonials_tab_highlight',
			[ 'label' => esc_html__( 'Highlight', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_testimonials_item_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_testimonials_item_beam',
			[
				'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea_testimonials_item_beam: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_testimonials_items',
			[
				'label'       => esc_html__( 'Reviews List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_testimonials_name }}} — {{{ awea_testimonials_role }}}',
				'default'     => [
					[
						'awea_testimonials_rating'   => '5',
						'awea_testimonials_quote'    => esc_html__( 'The architectural clarity and speed of this system are world-class. It transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
						'awea_testimonials_name'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
						'awea_testimonials_role'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
						'awea_testimonials_verified' => 'yes',
					],
					[
						'awea_testimonials_rating'   => '5',
						'awea_testimonials_quote'    => esc_html__( 'Clean, shadow-free aesthetics with zero CSS bloat. Our engineering team shipped an entire redesign two weeks ahead of schedule.', 'awesome-widgets-elementor' ),
						'awea_testimonials_name'     => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_testimonials_role'     => esc_html__( 'VP of Product at Vercel', 'awesome-widgets-elementor' ),
						'awea_testimonials_verified' => 'yes',
					],
					[
						'awea_testimonials_rating'   => '5',
						'awea_testimonials_quote'    => esc_html__( 'Every detail feels intentional—from typography scale to responsive spacing. Hands down the best component suite we have adopted.', 'awesome-widgets-elementor' ),
						'awea_testimonials_name'     => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_testimonials_role'     => esc_html__( 'Founder at Studio Mono', 'awesome-widgets-elementor' ),
						'awea_testimonials_verified' => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_section_grid',
			[
				'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_columns',
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
					'{{WRAPPER}} .awea_testimonials_grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_testimonials_quote_icon',
			[
				'label'        => esc_html__( 'Watermark Quote Icon', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_testimonials_beam_enable',
			[
				'label'        => esc_html__( 'Kinetic Border Beam', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea_testimonials_beam_',
			]
		);

		$this->add_control(
			'awea_testimonials_name_tag',
			[
				'label'   => esc_html__( 'Name HTML Tag', 'awesome-widgets-elementor' ),
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
	}

	/**
	 * Style Tab Controls
	 */
	protected function register_style_controls() {

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_style_card',
			[
				'label' => esc_html__( 'Card Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [ 'top' => '32', 'right' => '30', 'bottom' => '32', 'left' => '30', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_beam_color',
			[
				'label'     => esc_html__( 'Global Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_testimonials_beam_enable' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_grid' => '--awea_testimonials_global_beam: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_testimonials_card_tabs' );

		$this->start_controls_tab(
			'awea_testimonials_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_testimonials_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_testimonials_card_border',
				'label'          => esc_html__( 'Border', 'awesome-widgets-elementor' ),
				'selector'       => '{{WRAPPER}} .awea_testimonials_card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ],
					],
					'color'  => [ 'default' => '#e2e8f0' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_testimonials_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_testimonials_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. RATING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_style_stars',
			[
				'label' => esc_html__( 'Rating & Quote Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_star_size',
			[
				'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_stars svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_star_color',
			[
				'label'     => esc_html__( 'Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_stars .awea_testimonials_star_on' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_star_empty',
			[
				'label'     => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_stars .awea_testimonials_star_off' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_quote_color',
			[
				'label'     => esc_html__( 'Quote Watermark Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_testimonials_quote_icon' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_quote_mark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. QUOTE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_style_quote',
			[
				'label' => esc_html__( 'Quote Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_quote_color_text',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#334155',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_quote_typo',
				'selector' => '{{WRAPPER}} .awea_testimonials_text',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_quote_space',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. AUTHOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_testimonials_style_author',
			[
				'label' => esc_html__( 'Author Footer', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_testimonials_line_color',
			[
				'label'     => esc_html__( 'Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f5f9',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_avatar_size',
			[
				'label'      => esc_html__( 'Avatar Photo Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_testimonials_avatar_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => '%', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea_testimonials_avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_testimonials_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_name_typo',
				'selector' => '{{WRAPPER}} .awea_testimonials_name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_testimonials_role_color',
			[
				'label'     => esc_html__( 'Role Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#64748b',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_testimonials_role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_testimonials_role_typo',
				'selector' => '{{WRAPPER}} .awea_testimonials_role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_testimonials_items'] ?? [];
		$has_quote = 'yes' === ( $settings['awea_testimonials_quote_icon'] ?? 'no' );
		$name_tag  = Utils::validate_html_tag( $settings['awea_testimonials_name_tag'] ?? 'h4' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea_testimonials_grid">
			<?php foreach ( $items as $index => $item ) :
				$id         = ! empty( $item['_id'] ) ? sanitize_html_class( $item['_id'] ) : $index;
				$rating     = absint( $item['awea_testimonials_rating'] ?? 5 );
				$quote      = $item['awea_testimonials_quote'] ?? '';
				$photo_item = $item['awea_testimonials_photo'] ?? [];
				$avatar_url = ! empty( $photo_item['url'] ) ? $photo_item['url'] : Utils::get_placeholder_image_src();
				$name       = $item['awea_testimonials_name'] ?? '';
				$role       = $item['awea_testimonials_role'] ?? '';
				$verified   = 'yes' === ( $item['awea_testimonials_verified'] ?? 'no' );

				$img_data = [
					'awea_testimonials_photo'                     => $photo_item,
					'awea_testimonials_img_size_size'             => 'thumbnail',
					'awea_testimonials_img_size_custom_dimension' => [],
				];
				?>
				<article class="awea_testimonials_card elementor-repeater-item-<?php echo esc_attr( $id ); ?>">

					<?php if ( $has_quote ) : ?>
						<svg class="awea_testimonials_quote_mark" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
						</svg>
					<?php endif; ?>

					<?php if ( $rating > 0 ) : ?>
						<?php
						/* translators: %s: rating value out of 5 */
						$rating_label = sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating );
						?>
						<div class="awea_testimonials_stars" aria-label="<?php echo esc_attr( $rating_label ); ?>">
							<?php for ( $i = 1; $i <= 5; $i++ ) :
								$star_class = ( $i <= $rating ) ? 'awea_testimonials_star_on' : 'awea_testimonials_star_off';
								?>
								<svg class="<?php echo esc_attr( $star_class ); ?>" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
								</svg>
							<?php endfor; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $quote ) ) : ?>
						<blockquote class="awea_testimonials_text">
							&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;
						</blockquote>
					<?php endif; ?>

					<footer class="awea_testimonials_footer">
						<?php if ( ! empty( $avatar_url ) ) : ?>
							<?php
							if ( ! empty( $photo_item['id'] ) ) {
								echo Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_testimonials_img_size', 'awea_testimonials_photo' );
							} else {
								printf( '<img src="%s" alt="%s" class="awea_testimonials_avatar" loading="lazy" />', esc_url( $avatar_url ), esc_attr( $name ) );
							}
							?>
						<?php endif; ?>

						<div class="awea_testimonials_meta">
							<?php if ( ! empty( $name ) ) : ?>
								<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea_testimonials_name">
									<?php echo esc_html( $name ); ?>
								</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $role ) ) : ?>
								<cite class="awea_testimonials_role"><?php echo esc_html( $role ); ?></cite>
							<?php endif; ?>
						</div>

						<?php if ( $verified ) : ?>
							<span class="awea_testimonials_verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
						<?php endif; ?>
					</footer>

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
		if ( ! settings.awea_testimonials_items || ! settings.awea_testimonials_items.length ) {
			return;
		}
		var hasQuote = 'yes' === settings.awea_testimonials_quote_icon;
		var nameTag  = elementor.helpers.validateHTMLTag( settings.awea_testimonials_name_tag || 'h4' );
		#>
		<div class="awea_testimonials_grid">
			<# _.each( settings.awea_testimonials_items, function( item, index ) {
				var id        = item._id || index;
				var rating    = parseInt( item.awea_testimonials_rating, 10 ) || 0;
				var quote     = item.awea_testimonials_quote || '';
				var name      = item.awea_testimonials_name || '';
				var role      = item.awea_testimonials_role || '';
				var verified  = 'yes' === item.awea_testimonials_verified;

				var imageObj = {
					id: item.awea_testimonials_photo ? item.awea_testimonials_photo.id : '',
					url: item.awea_testimonials_photo ? item.awea_testimonials_photo.url : '',
					size: 'thumbnail',
					dimension: [],
					model: view.getEditModel()
				};
				var avatarUrl = elementor.imagesManager.getImageUrl( imageObj ) || '<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>';
			#>
				<article class="awea_testimonials_card elementor-repeater-item-{{ id }}">
					<# if ( hasQuote ) { #>
						<svg class="awea_testimonials_quote_mark" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
						</svg>
					<# } #>

					<# if ( rating > 0 ) { #>
						<div class="awea_testimonials_stars">
							<# for ( var i = 1; i <= 5; i++ ) { #>
								<svg class="{{ i <= rating ? 'awea_testimonials_star_on' : 'awea_testimonials_star_off' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
								</svg>
							<# } #>
						</div>
					<# } #>

					<# if ( quote ) { #>
						<blockquote class="awea_testimonials_text">&ldquo;{{{ quote }}}&rdquo;</blockquote>
					<# } #>

					<footer class="awea_testimonials_footer">
						<# if ( avatarUrl ) { #>
							<img src="{{ avatarUrl }}" alt="{{ name }}" class="awea_testimonials_avatar" />
						<# } #>

						<div class="awea_testimonials_meta">
							<# if ( name ) { #>
								<{{{ nameTag }}} class="awea_testimonials_name">{{{ name }}}</{{{ nameTag }}}>
							<# } #>

							<# if ( role ) { #>
								<cite class="awea_testimonials_role">{{{ role }}}</cite>
							<# } #>
						</div>

						<# if ( verified ) { #>
							<span class="awea_testimonials_verify" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
						<# } #>
					</footer>
				</article>
			<# } ); #>
		</div>
		<?php
	}
}