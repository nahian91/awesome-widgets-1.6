<?php
/**
 * Awesome Copyright Widget.
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
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Copyright extends Widget_Base {

	public function get_name() {
		return 'awesome-copyright';
	}

	public function get_title() {
		return esc_html__( 'Copyright', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-library-copy';
	}

	public function get_categories() {
		return [ 'awesome-header-footer' ];
	}

	public function get_keywords() {
		return [ 'awea', 'copyright', 'footer', 'year', 'legal', 'notice' ];
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
		   CONTENT: 1. COPYRIGHT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_section_main',
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
				'description' => esc_html__( 'Tokens: {copy}, {reg}, {tm}, {year}, {year_range}, {site_title}, {site_link}, {site_desc}, {author_name}', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_copyright_start_year',
			[
				'label'       => esc_html__( 'Start Year', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '2020',
				'description' => esc_html__( 'Used by {year_range} to output e.g. 2020–2026.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_copyright_html_tag',
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
		   CONTENT: 2. AUTHOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_section_author',
			[
				'label' => esc_html__( 'Author Token', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_author_name',
			[
				'label'   => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Studio Nahian', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_copyright_author_url',
			[
				'label'       => esc_html__( 'Author Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_copyright_author_name!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. SECONDARY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_section_secondary',
			[
				'label' => esc_html__( 'Secondary Credit', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_enable_secondary',
			[
				'label'        => esc_html__( 'Display Secondary Text', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_copyright_secondary_text',
			[
				'label'       => esc_html__( 'Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Crafted with precision.', 'awesome-widgets-elementor' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_copyright_enable_secondary' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_copyright_secondary_link',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_copyright_enable_secondary' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_copyright_separator_symbol',
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
				'condition' => [ 'awea_copyright_enable_secondary' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 4. LEGAL LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_section_links',
			[
				'label' => esc_html__( 'Legal Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_enable_links',
			[
				'label'        => esc_html__( 'Display Legal Links', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_copyright_legal_label',
			[
				'label'       => esc_html__( 'Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Privacy Policy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_copyright_legal_url',
			[
				'label'       => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/privacy',
				'default'     => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'awea_copyright_legal_links',
			[
				'label'       => esc_html__( 'Links List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_copyright_legal_label }}}',
				'condition'   => [ 'awea_copyright_enable_links' => 'yes' ],
				'default'     => [
					[
						'awea_copyright_legal_label' => esc_html__( 'Privacy Policy', 'awesome-widgets-elementor' ),
						'awea_copyright_legal_url'   => [ 'url' => '#' ],
					],
					[
						'awea_copyright_legal_label' => esc_html__( 'Terms of Service', 'awesome-widgets-elementor' ),
						'awea_copyright_legal_url'   => [ 'url' => '#' ],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 5. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_layout_mode',
			[
				'label'        => esc_html__( 'Direction', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inline',
				'options'      => [
					'inline' => esc_html__( 'Inline Row', 'awesome-widgets-elementor' ),
					'stack'  => esc_html__( 'Stacked Column', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea_copyright_dir_',
			]
		);

		$this->add_responsive_control(
			'awea_copyright_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'    => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Space Between', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'    => 'start; --awea_copyright_justify: flex-start; --awea_copyright_align: flex-start',
					'center'  => 'center; --awea_copyright_justify: center; --awea_copyright_align: center',
					'right'   => 'end; --awea_copyright_justify: flex-end; --awea_copyright_align: flex-end',
					'justify' => 'start; --awea_copyright_justify: space-between; --awea_copyright_align: stretch',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea_copyright_wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_copyright_items_gap',
			[
				'label'      => esc_html__( 'Items Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea_copyright_wrap' => 'gap: {{SIZE}}{{UNIT}};',
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
		   STYLE: 1. CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_style_container',
			[
				'label' => esc_html__( 'Container', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_copyright_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '24',
					'bottom'   => '16',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea_copyright_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_copyright_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_copyright_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_copyright_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_copyright_border',
				'selector' => '{{WRAPPER}} .awea_copyright_wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_copyright_shadow',
				'selector' => '{{WRAPPER}} .awea_copyright_wrap',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_style_text',
			[
				'label' => esc_html__( 'Copyright Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_copyright_text_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_copyright_text_typo',
				'selector' => '{{WRAPPER}} .awea_copyright_primary',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. SECONDARY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_style_secondary',
			[
				'label'     => esc_html__( 'Secondary Credit', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_copyright_enable_secondary' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_copyright_secondary_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_copyright_secondary_typo',
				'selector' => '{{WRAPPER}} .awea_copyright_secondary',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_style_separator',
			[
				'label'     => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_copyright_enable_secondary' => 'yes',
					'awea_copyright_separator_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'awea_copyright_sep_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_sep' => 'color: {{VALUE}}; opacity: 1;',
				],
			]
		);

		$this->add_responsive_control(
			'awea_copyright_sep_size',
			[
				'label'      => esc_html__( 'Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 24 ] ],
				'selectors'  => [
					'{{WRAPPER}} .awea_copyright_sep' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_copyright_style_links',
			[
				'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_copyright_link_weight',
			[
				'label'     => esc_html__( 'Font Weight', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''    => esc_html__( 'Default', 'awesome-widgets-elementor' ),
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
				],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap a' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_copyright_link_underline',
			[
				'label'     => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'underline',
				'options'   => [
					'underline' => esc_html__( 'Always', 'awesome-widgets-elementor' ),
					'none'      => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap a' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_copyright_legal_gap',
			[
				'label'      => esc_html__( 'Legal Links Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'condition'  => [ 'awea_copyright_enable_links' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea_copyright_legal_list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_copyright_link_tabs' );

		$this->start_controls_tab(
			'awea_copyright_link_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_copyright_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_copyright_link_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_copyright_link_color_hover',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap a:hover, {{WRAPPER}} .awea_copyright_wrap a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_copyright_link_hover_underline',
			[
				'label'     => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''          => esc_html__( 'Default', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Underline', 'awesome-widgets-elementor' ),
					'none'      => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea_copyright_wrap a:hover, {{WRAPPER}} .awea_copyright_wrap a:focus-visible' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$raw_text     = $settings['awea_copyright_text'] ?? '';
		$start_year   = preg_replace( '/[^0-9]/', '', (string) ( $settings['awea_copyright_start_year'] ?? '' ) );
		$tag          = Utils::validate_html_tag( $settings['awea_copyright_html_tag'] ?? 'div' );
		$show_extra   = 'yes' === ( $settings['awea_copyright_enable_secondary'] ?? '' );
		$extra_text   = $settings['awea_copyright_secondary_text'] ?? '';
		$extra_link   = $settings['awea_copyright_secondary_link'] ?? [];
		$separator    = $settings['awea_copyright_separator_symbol'] ?? '•';
		$author_name  = $settings['awea_copyright_author_name'] ?? '';
		$author_data  = $settings['awea_copyright_author_url'] ?? [];
		$enable_links = 'yes' === ( $settings['awea_copyright_enable_links'] ?? '' );
		$legal_links  = $settings['awea_copyright_legal_links'] ?? [];

		$current_year = wp_date( 'Y' );
		$year_range   = ( '' !== $start_year && (int) $start_year < (int) $current_year )
			? $start_year . '–' . $current_year
			: $current_year;

		$site_title = get_bloginfo( 'name' );
		$site_desc  = get_bloginfo( 'description' );
		$site_url   = home_url( '/' );

		$site_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( $site_url ),
			esc_html( $site_title )
		);

		$this->remove_render_attribute( 'awea_copyright_author_url' );
		$author_link = '';
		if ( ! empty( $author_name ) ) {
			if ( ! empty( $author_data['url'] ) ) {
				$this->add_link_attributes( 'awea_copyright_author_url', $author_data );
				$author_link = sprintf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string( 'awea_copyright_author_url' ),
					esc_html( $author_name )
				);
			} else {
				$author_link = esc_html( $author_name );
			}
		}

		$tokens = [
			'{year}'         => esc_html( $current_year ),
			'{current_year}' => esc_html( $current_year ),
			'{year_range}'   => esc_html( $year_range ),
			'{site_title}'   => esc_html( $site_title ),
			'{site_desc}'    => esc_html( $site_desc ),
			'{site_link}'    => $site_link,
			'{author_name}'  => $author_link,
			'{copy}'         => '&copy;',
			'{reg}'          => '&reg;',
			'{tm}'           => '&trade;',
		];

		$output = strtr( wp_kses_post( $raw_text ), $tokens );

		$this->remove_render_attribute( 'awea_copyright_secondary_url' );
		$has_extra_link = ! empty( $extra_link['url'] );
		if ( $has_extra_link ) {
			$this->add_link_attributes( 'awea_copyright_secondary_url', $extra_link );
		}
		?>
		<<?php Utils::print_validated_html_tag( $tag ); ?> class="awea_copyright_wrap">
			<?php if ( '' !== trim( $output ) ) : ?>
				<span class="awea_copyright_primary"><?php echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized via wp_kses_post() before token substitution with escaped values. ?></span>
			<?php endif; ?>

			<?php if ( $show_extra && '' !== trim( $extra_text ) ) : ?>
				<?php if ( '' !== trim( $output ) && '' !== $separator ) : ?>
					<span class="awea_copyright_sep" aria-hidden="true"><?php echo esc_html( $separator ); ?></span>
				<?php endif; ?>

				<span class="awea_copyright_secondary">
					<?php if ( $has_extra_link ) : ?>
						<a <?php $this->print_render_attribute_string( 'awea_copyright_secondary_url' ); ?>><?php echo esc_html( $extra_text ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $extra_text ); ?>
					<?php endif; ?>
				</span>
			<?php endif; ?>

			<?php if ( $enable_links && ! empty( $legal_links ) ) : ?>
				<nav class="awea_copyright_legal_list" aria-label="<?php esc_attr_e( 'Legal Navigation', 'awesome-widgets-elementor' ); ?>">
					<?php foreach ( $legal_links as $index => $legal ) :
						$legal_label = $legal['awea_copyright_legal_label'] ?? '';
						if ( '' === trim( $legal_label ) ) {
							continue;
						}
						$legal_key = 'awea_copyright_legal_' . $index;
						$this->remove_render_attribute( $legal_key );
						$legal_url = ! empty( $legal['awea_copyright_legal_url']['url'] ) ? $legal['awea_copyright_legal_url'] : [ 'url' => '#' ];
						$this->add_link_attributes( $legal_key, $legal_url );
						?>
						<a <?php $this->print_render_attribute_string( $legal_key ); ?>><?php echo esc_html( $legal_label ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>
		</<?php Utils::print_validated_html_tag( $tag ); ?>>
		<?php
	}
}