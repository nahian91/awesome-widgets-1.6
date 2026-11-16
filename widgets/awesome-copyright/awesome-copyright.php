<?php
/**
 * Awesome Copyright Studio Widget.
 * Clean, automated copyright notice with dynamic year, site tokens, and modular styling.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.7.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Copyright extends Widget_Base {

	public function get_name() {
		return 'awesome-copyright';
	}

	public function get_title() {
		return esc_html__( 'Copyright Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-library-copy';
	}

	public function get_categories() {
		return [ 'awesome-header-footer', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'copyright', 'footer', 'year', 'legal', 'credits', 'notice' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. COPYRIGHT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_content_primary',
			[
				'label' => esc_html__( 'Copyright', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Copyright {copy} {year} {site_title}. All rights reserved.', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Tokens: {copy}, {year}, {site_title}, {site_link}', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_html_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div'    => 'div',
					'p'      => 'p',
					'span'   => 'span',
					'footer' => 'footer',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. SECONDARY TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_content_secondary',
			[
				'label' => esc_html__( 'Secondary Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_enable_secondary',
			[
				'label'        => esc_html__( 'Show Secondary', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_affiliate_notice',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Crafted with precision.', 'awesome-widgets-elementor' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'awea_enable_secondary' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_secondary_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-site.com', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'awea_enable_secondary' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_separator_symbol',
			[
				'label'     => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '•',
				'options'   => [
					'•' => esc_html__( 'Bullet ( • )', 'awesome-widgets-elementor' ),
					'|' => esc_html__( 'Pipe ( | )', 'awesome-widgets-elementor' ),
					'/' => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'—' => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
					''  => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'condition' => [
					'awea_enable_secondary' => 'yes',
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
			'awea_align',
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
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'   => 'justify-content: flex-start; text-align: left;',
					'center' => 'justify-content: center; text-align: center;',
					'right'  => 'justify-content: flex-end; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-copyright-wrap' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_items_gap',
			[
				'label'      => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-copyright-wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'awea_enable_secondary' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'awea_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-copyright-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. COPYRIGHT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_primary',
			[
				'label' => esc_html__( 'Copyright', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_text_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_text_typography',
				'selector' => '{{WRAPPER}} .awea-copyright-text',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. SECONDARY TEXT (CONDITIONAL)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_secondary',
			[
				'label'     => esc_html__( 'Secondary Text', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_enable_secondary' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_secondary_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-extra' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_secondary_typography',
				'selector' => '{{WRAPPER}} .awea-copyright-extra',
			]
		);

		$this->add_control(
			'awea_heading_separator_style',
			[
				'label'     => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'awea_separator_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'awea_separator_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-divider' => 'color: {{VALUE}}; opacity: 1;',
				],
				'condition' => [
					'awea_separator_symbol!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'awea_separator_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 32 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-copyright-divider' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'awea_separator_symbol!' => '',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_links',
			[
				'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_link_underline',
			[
				'label'     => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'underline',
				'options'   => [
					'underline' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
					'none'      => esc_html__( 'No', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap a' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_link_tabs' );

		$this->start_controls_tab(
			'awea_link_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_link_tab_hover',
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
					'{{WRAPPER}} .awea-copyright-wrap a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$raw_text   = $settings['awea_copyright_text'] ?? '';
		$tag        = Utils::validate_html_tag( $settings['awea_html_tag'] ?? 'div' );
		$show_extra = ( 'yes' === ( $settings['awea_enable_secondary'] ?? '' ) );
		$extra_text = $settings['awea_affiliate_notice'] ?? '';
		$extra_link = $settings['awea_secondary_link'] ?? [];
		$separator  = $settings['awea_separator_symbol'] ?? '•';

		$current_year = date_i18n( 'Y' );
		$site_title   = get_bloginfo( 'name' );
		$site_url     = home_url( '/' );

		$site_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( $site_url ),
			esc_html( $site_title )
		);

		// Dynamic Token Replacements
		$replacements = [
			'{year}'         => esc_html( $current_year ),
			'{current_year}' => esc_html( $current_year ),
			'{site_title}'   => esc_html( $site_title ),
			'{site_link}'    => $site_link,
			'{copy}'         => '&copy;',
		];

		$output = str_replace( array_keys( $replacements ), array_values( $replacements ), $raw_text );

		// Build Secondary Link Attributes if URL exists
		$has_extra_link = ! empty( $extra_link['url'] );
		if ( $has_extra_link ) {
			$this->add_link_attributes( 'secondary_url', $extra_link );
		}
		?>
		<<?php Utils::print_validated_html_tag( $tag ); ?> class="awea-copyright-wrap">
			<?php if ( ! empty( $output ) ) : ?>
				<span class="awea-copyright-text"><?php echo wp_kses_post( $output ); ?></span>
			<?php endif; ?>

			<?php if ( $show_extra && ! empty( $extra_text ) ) : ?>
				<?php if ( ! empty( $output ) && '' !== $separator ) : ?>
					<span class="awea-copyright-divider" aria-hidden="true"><?php echo esc_html( $separator ); ?></span>
				<?php endif; ?>

				<span class="awea-copyright-extra">
					<?php if ( $has_extra_link ) : ?>
						<a <?php $this->print_render_attribute_string( 'secondary_url' ); ?>><?php echo esc_html( $extra_text ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $extra_text ); ?>
					<?php endif; ?>
				</span>
			<?php endif; ?>
		</<?php Utils::print_validated_html_tag( $tag ); ?>>
		<?php
	}
}