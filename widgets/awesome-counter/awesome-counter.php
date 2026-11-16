<?php
/**
 * Awesome Counter Studio Widget.
 * Modern Kinetic Metrics Card with 60FPS Micro-Animations.
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
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Icons_Manager;

class Widget_Awesome_Counter extends Widget_Base {

	public function get_name() {
		return 'awesome-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'counter', 'stats', 'number', 'metrics', 'odometer', 'timer' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. NUMBER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_counter_numbers',
			[
				'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_start_number',
			[
				'label'   => esc_html__( 'Start', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_target_number',
			[
				'label'   => esc_html__( 'Target', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_decimal_places',
			[
				'label'   => esc_html__( 'Decimals', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 3,
				'step'    => 1,
				'default' => 0,
			]
		);

		$this->add_control(
			'awea_number_prefix',
			[
				'label'       => esc_html__( 'Prefix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => '$',
			]
		);

		$this->add_control(
			'awea_number_suffix',
			[
				'label'       => esc_html__( 'Suffix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '+',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => '+',
			]
		);

		$this->add_control(
			'awea_duration',
			[
				'label'   => esc_html__( 'Duration (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
				'default' => 2200,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_counter_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_counter_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'awea_counter_title',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_align',
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
					'left'   => 'align-items: flex-start; text-align: left;',
					'center' => 'align-items: center; text-align: center;',
					'right'  => 'align-items: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-counter-card' => '{{VALUE}}',
				],
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
					'{{WRAPPER}} .awea-counter-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-counter-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-counter-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-counter-card',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-counter-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-counter-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. BEAM
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_beam',
			[
				'label' => esc_html__( 'Beam', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_enable_beam',
			[
				'label'        => esc_html__( 'Enable', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_beam_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card' => '--awea-beam-color: {{VALUE}};',
				],
				'condition' => [ 'awea_enable_beam' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_beam_speed',
			[
				'label'      => esc_html__( 'Speed (s)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3.5 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-card' => '--awea-beam-speed: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. ICON (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_counter_icon[value]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 120 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-counter-icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_radius',
			[
				'label'      => esc_html__( 'Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_icon_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-icon-box'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-counter-icon-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_icon_badge_border',
				'selector' => '{{WRAPPER}} .awea-counter-icon-box',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_icon_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg_hover',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. NUMBER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_number',
			[
				'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_number_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_typography',
				'selector' => '{{WRAPPER}} .awea-counter-val',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_digits_margin_bottom',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-stat-holder' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Prefix & Suffix
		$this->add_control(
			'awea_heading_affixes',
			[
				'label'      => esc_html__( 'Prefix & Suffix', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'awea_number_prefix',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'awea_number_suffix',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'awea_affix_color',
			[
				'label'      => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::COLOR,
				'global'     => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-prefix, {{WRAPPER}} .awea-counter-suffix' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'awea_number_prefix',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'awea_number_suffix',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'       => 'awea_affix_typography',
				'selector'   => '{{WRAPPER}} .awea-counter-prefix, {{WRAPPER}} .awea-counter-suffix',
				'global'     => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'awea_number_prefix',
							'operator' => '!=',
							'value'    => '',
						],
						[
							'name'     => 'awea_number_suffix',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 5. LABEL (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_label',
			[
				'label'     => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_counter_title!' => '' ],
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-counter-label',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$start     = '' !== ( $settings['awea_start_number'] ?? '' ) ? floatval( $settings['awea_start_number'] ) : 0;
		$target    = '' !== ( $settings['awea_target_number'] ?? '' ) ? floatval( $settings['awea_target_number'] ) : 0;
		$decimals  = ! empty( $settings['awea_decimal_places'] ) ? absint( $settings['awea_decimal_places'] ) : 0;
		$duration  = ! empty( $settings['awea_duration'] ) ? absint( $settings['awea_duration'] ) : 2200;
		$prefix    = $settings['awea_number_prefix'] ?? '';
		$suffix    = $settings['awea_number_suffix'] ?? '';
		$title     = $settings['awea_counter_title'] ?? '';
		$has_beam  = 'yes' === ( $settings['awea_enable_beam'] ?? 'no' );
		$widget_id = $this->get_id();

		$card_classes = [ 'awea-counter-card' ];
		if ( $has_beam ) {
			$card_classes[] = 'awea-has-beam';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>"
			 id="awea-counter-<?php echo esc_attr( $widget_id ); ?>"
			 data-start="<?php echo esc_attr( (string) $start ); ?>"
			 data-target="<?php echo esc_attr( (string) $target ); ?>"
			 data-decimals="<?php echo esc_attr( (string) $decimals ); ?>"
			 data-duration="<?php echo esc_attr( (string) $duration ); ?>">

			<?php if ( ! empty( $settings['awea_counter_icon']['value'] ) ) : ?>
				<div class="awea-counter-icon-box" aria-hidden="true">
					<?php Icons_Manager::render_icon( $settings['awea_counter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>

			<div class="awea-counter-stat-holder">
				<?php if ( ! empty( $prefix ) ) : ?>
					<span class="awea-counter-prefix"><?php echo esc_html( $prefix ); ?></span>
				<?php endif; ?>

				<span class="awea-counter-val"><?php echo esc_html( number_format( $start, $decimals ) ); ?></span>

				<?php if ( ! empty( $suffix ) ) : ?>
					<span class="awea-counter-suffix"><?php echo esc_html( $suffix ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $title ) ) : ?>
				<p class="awea-counter-label"><?php echo esc_html( $title ); ?></p>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function initCounter() {
				var card = document.getElementById('awea-counter-<?php echo esc_js( $widget_id ); ?>');
				if (!card || card.__aweaBound) return;
				card.__aweaBound = true;

				var valEl    = card.querySelector('.awea-counter-val');
				if (!valEl) return;

				var start    = parseFloat(card.getAttribute('data-start')) || 0;
				var target   = parseFloat(card.getAttribute('data-target')) || 0;
				var decimals = parseInt(card.getAttribute('data-decimals'), 10) || 0;
				var duration = parseInt(card.getAttribute('data-duration'), 10) || 2200;
				var started  = false;

				function formatNumber(num) {
					return num.toLocaleString(undefined, {
						minimumFractionDigits: decimals,
						maximumFractionDigits: decimals
					});
				}

				function runCount() {
					if (started) return;
					started = true;
					var startTime = null;

					function step(timestamp) {
						if (!startTime) startTime = timestamp;
						var elapsed  = timestamp - startTime;
						var progress = Math.min(elapsed / duration, 1);
						var eased    = 1 - Math.pow(1 - progress, 3);
						var current  = start + (target - start) * eased;

						valEl.textContent = formatNumber(current);

						if (progress < 1) {
							requestAnimationFrame(step);
						} else {
							valEl.textContent = formatNumber(target);
						}
					}

					requestAnimationFrame(step);
				}

				if ('IntersectionObserver' in window) {
					var observer = new IntersectionObserver(function(entries) {
						entries.forEach(function(entry) {
							if (entry.isIntersecting) {
								runCount();
								observer.disconnect();
							}
						});
					}, { threshold: 0.2 });
					observer.observe(card);
				} else {
					runCount();
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initCounter);
			} else {
				initCounter();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-counter.default', initCounter);
			}
		})();
		</script>
		<?php
	}
}