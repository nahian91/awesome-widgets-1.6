<?php
/**
 * Awesome Progress Bar Studio Widget (Zero-Shadow Architectural Edition).
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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'awesome-progress-bar';
	}

	public function get_title() {
		return esc_html__( 'Progress Bar', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'progress bar', 'skill bar', 'circle progress', 'meter' ];
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
		   CONTENT: 1. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_progress_bar_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_progress_bar_layout_style',
			[
				'label'   => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => esc_html__( 'Circle', 'awesome-widgets-elementor' ),
					'line'   => esc_html__( 'Bar', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_progress_bar_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'System Accuracy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_progress_bar_percent',
			[
				'label'   => esc_html__( 'Percent', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => 85,
				],
				'range'   => [
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'awea_progress_bar_suffix',
			[
				'label'   => esc_html__( 'Suffix', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '%',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_progress_bar_section_options',
			[
				'label' => esc_html__( 'Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_progress_bar_duration',
			[
				'label'   => esc_html__( 'Duration (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1800,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_progress_bar_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_circle_dimension',
			[
				'label'      => esc_html__( 'Diameter', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 500 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 200 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_progress_bar_radial_container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_progress_bar_layout_style' => 'circle' ],
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_line_max_width',
			[
				'label'      => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 150, 'max' => 1200 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_progress_bar_linear_container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_progress_bar_layout_style' => 'line' ],
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea_progress_bar_wrapper' => 'display: flex; justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. COLORS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_progress_bar_style_colors',
			[
				'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_progress_bar_accent_color',
			[
				'label'     => esc_html__( 'Fill Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_progress_bar_circle_fill' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_progress_bar_line_fill'   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_progress_bar_track_color',
			[
				'label'     => esc_html__( 'Track Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea_progress_bar_track' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea_progress_bar_line_track'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_stroke_width',
			[
				'label'      => esc_html__( 'Stroke Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_progress_bar_svg circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_progress_bar_layout_style' => 'circle' ],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_line_height',
			[
				'label'      => esc_html__( 'Bar Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_progress_bar_line_track, {{WRAPPER}} .awea_progress_bar_line_fill' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_progress_bar_layout_style' => 'line' ],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_progress_bar_line_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_progress_bar_line_track, {{WRAPPER}} .awea_progress_bar_line_fill' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_progress_bar_layout_style' => 'line' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_progress_bar_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_progress_bar_digit_color',
			[
				'label'     => esc_html__( 'Digit Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea_progress_bar_percent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_progress_bar_digit_typo',
				'label'    => esc_html__( 'Digit Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_progress_bar_percent',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_progress_bar_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea_progress_bar_label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_progress_bar_label_typo',
				'label'    => esc_html__( 'Label Typography', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea_progress_bar_label',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$style         = $settings['awea_progress_bar_layout_style'] ?? 'circle';
		$target        = isset( $settings['awea_progress_bar_percent']['size'] ) && '' !== $settings['awea_progress_bar_percent']['size'] ? min( 100, max( 0, absint( $settings['awea_progress_bar_percent']['size'] ) ) ) : 0;
		$label         = $settings['awea_progress_bar_title'] ?? '';
		$duration      = ! empty( $settings['awea_progress_bar_duration'] ) ? absint( $settings['awea_progress_bar_duration'] ) : 1800;
		$suffix        = $settings['awea_progress_bar_suffix'] ?? '%';
		$widget_id     = $this->get_id();
		$circumference = 263.89;
		$initial_text  = $target . $suffix;
		?>
		<div class="awea_progress_bar_wrapper awea_progress_bar_style_<?php echo esc_attr( $style ); ?>"
			 id="awea_progress_bar_<?php echo esc_attr( $widget_id ); ?>"
			 role="progressbar"
			 aria-valuemin="0"
			 aria-valuemax="100"
			 aria-valuenow="<?php echo esc_attr( (string) $target ); ?>"
			 <?php if ( ! empty( $label ) ) : ?>aria-label="<?php echo esc_attr( $label ); ?>"<?php endif; ?>
			 data-awea_progress_bar_target="<?php echo esc_attr( (string) $target ); ?>"
			 data-awea_progress_bar_duration="<?php echo esc_attr( (string) $duration ); ?>"
			 data-awea_progress_bar_suffix="<?php echo esc_attr( $suffix ); ?>"
			 data-awea_progress_bar_style="<?php echo esc_attr( $style ); ?>">

			<?php if ( 'circle' === $style ) : ?>
				<div class="awea_progress_bar_radial_container">
					<svg class="awea_progress_bar_svg" viewBox="0 0 100 100" aria-hidden="true">
						<circle class="awea_progress_bar_track" cx="50" cy="50" r="42" fill="none"></circle>
						<circle class="awea_progress_bar_circle_fill" cx="50" cy="50" r="42" fill="none" stroke-dasharray="<?php echo esc_attr( (string) $circumference ); ?>" stroke-dashoffset="<?php echo esc_attr( (string) $circumference ); ?>" data-awea_progress_bar_circumference="<?php echo esc_attr( (string) $circumference ); ?>"></circle>
					</svg>
					<div class="awea_progress_bar_radial_content">
						<span class="awea_progress_bar_percent" aria-hidden="true"><?php echo esc_html( $initial_text ); ?></span>
						<?php if ( ! empty( $label ) ) : ?>
							<span class="awea_progress_bar_label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="awea_progress_bar_linear_container">
					<div class="awea_progress_bar_linear_meta">
						<?php if ( ! empty( $label ) ) : ?>
							<span class="awea_progress_bar_label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
						<span class="awea_progress_bar_percent" aria-hidden="true"><?php echo esc_html( $initial_text ); ?></span>
					</div>
					<div class="awea_progress_bar_line_track">
						<div class="awea_progress_bar_line_fill" style="width: 0%;"></div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function awea_progress_bar_bind(wrapper) {
				if (!wrapper || wrapper.__aweaBound) return;
				wrapper.__aweaBound = true;

				var target       = parseInt(wrapper.getAttribute('data-awea_progress_bar_target'), 10) || 0;
				var duration     = parseInt(wrapper.getAttribute('data-awea_progress_bar_duration'), 10) || 1800;
				var suffix       = wrapper.hasAttribute('data-awea_progress_bar_suffix') ? wrapper.getAttribute('data-awea_progress_bar_suffix') : '%';
				var style        = wrapper.getAttribute('data-awea_progress_bar_style') || 'circle';
				var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

				var percentEl  = wrapper.querySelector('.awea_progress_bar_percent');
				var fillCircle = wrapper.querySelector('.awea_progress_bar_circle_fill');
				var fillLine   = wrapper.querySelector('.awea_progress_bar_line_fill');

				var circumference = fillCircle ? (parseFloat(fillCircle.getAttribute('data-awea_progress_bar_circumference')) || 263.89) : 263.89;

				function applyFinalState() {
					if (percentEl) percentEl.textContent = target + suffix;
					if (style === 'circle' && fillCircle) {
						fillCircle.style.strokeDashoffset = circumference - ((target / 100) * circumference);
					} else if (style === 'line' && fillLine) {
						fillLine.style.width = target + '%';
					}
				}

				function runProgress() {
					if (reduceMotion || target === 0) {
						applyFinalState();
						return;
					}

					var startTime = null;

					function step(timestamp) {
						if (!document.body.contains(wrapper)) return;
						if (!startTime) startTime = timestamp;
						var elapsed    = timestamp - startTime;
						var progress   = Math.min(elapsed / duration, 1);
						var eased      = 1 - Math.pow(1 - progress, 3);
						var currentVal = Math.round(target * eased);

						if (percentEl) {
							percentEl.textContent = currentVal + suffix;
						}

						if (style === 'circle' && fillCircle) {
							var offset = circumference - (eased * (target / 100) * circumference);
							fillCircle.style.strokeDashoffset = offset;
						} else if (style === 'line' && fillLine) {
							fillLine.style.width = (eased * target) + '%';
						}

						if (progress < 1) {
							requestAnimationFrame(step);
						} else {
							applyFinalState();
						}
					}

					requestAnimationFrame(step);
				}

				if ('IntersectionObserver' in window) {
					var observer = new IntersectionObserver(function(entries) {
						entries.forEach(function(entry) {
							if (entry.isIntersecting) {
								runProgress();
								observer.disconnect();
							}
						});
					}, { threshold: 0.2 });
					observer.observe(wrapper);
				} else {
					runProgress();
				}
			}

			function awea_progress_bar_init() {
				awea_progress_bar_bind(document.getElementById('awea_progress_bar_<?php echo esc_js( $widget_id ); ?>'));
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', awea_progress_bar_init);
			} else {
				awea_progress_bar_init();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks && !window.aweaProgressBarHooked) {
				window.aweaProgressBarHooked = true;
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-progress-bar.default', function($scope) {
					var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_progress_bar_wrapper') : null;
					awea_progress_bar_bind(el);
				});
			}
		})();
		</script>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var style     = settings.awea_progress_bar_layout_style || 'circle';
		var target    = ( settings.awea_progress_bar_percent && settings.awea_progress_bar_percent.size !== '' ) ? Math.min( 100, Math.max( 0, parseInt( settings.awea_progress_bar_percent.size, 10 ) ) ) : 0;
		var label     = settings.awea_progress_bar_title || '';
		var suffix    = settings.awea_progress_bar_suffix || '%';
		var initialText = target + suffix;
		var circ      = 263.89;
		var offset    = circ - ( ( target / 100 ) * circ );
		#>
		<div class="awea_progress_bar_wrapper awea_progress_bar_style_{{ style }}" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ target }}">
			<# if ( 'circle' === style ) { #>
				<div class="awea_progress_bar_radial_container">
					<svg class="awea_progress_bar_svg" viewBox="0 0 100 100" aria-hidden="true">
						<circle class="awea_progress_bar_track" cx="50" cy="50" r="42" fill="none"></circle>
						<circle class="awea_progress_bar_circle_fill" cx="50" cy="50" r="42" fill="none" stroke-dasharray="{{ circ }}" stroke-dashoffset="{{ offset }}"></circle>
					</svg>
					<div class="awea_progress_bar_radial_content">
						<span class="awea_progress_bar_percent" aria-hidden="true">{{{ initialText }}}</span>
						<# if ( label ) { #>
							<span class="awea_progress_bar_label">{{{ label }}}</span>
						<# } #>
					</div>
				</div>
			<# } else { #>
				<div class="awea_progress_bar_linear_container">
					<div class="awea_progress_bar_linear_meta">
						<# if ( label ) { #>
							<span class="awea_progress_bar_label">{{{ label }}}</span>
						<# } #>
						<span class="awea_progress_bar_percent" aria-hidden="true">{{{ initialText }}}</span>
					</div>
					<div class="awea_progress_bar_line_track">
						<div class="awea_progress_bar_line_fill" style="width: {{ target }}%;"></div>
					</div>
				</div>
			<# } #>
		</div>
		<?php
	}
}