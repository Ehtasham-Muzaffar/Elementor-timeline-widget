<?php
/**
 * Plugin Name: Elementor Vertical Timeline
 * Description: Fully stylable vertical timeline widget with smooth scroll progress line.
 * Author: Ehtasham Muzaffar
 * Version: 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'elementor/widgets/register', function( $widgets_manager ) {

	class Elementor_Vertical_Timeline_Widget extends \Elementor\Widget_Base {

		public function get_name() { return 'vertical_timeline'; }
		public function get_title() { return 'Vertical Timeline'; }
		public function get_icon() { return 'eicon-time-line'; }
		public function get_categories() { return ['general']; }

		protected function register_controls() {

			/* =========================
			 * CONTENT
			 * ========================= */
			$this->start_controls_section('content', [
				'label' => 'Timeline Items',
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]);

			$rep = new \Elementor\Repeater();

			$rep->add_control('icon', [
				'label' => 'Icon',
				'type'  => \Elementor\Controls_Manager::ICONS,
			]);

			$rep->add_control('title', [
				'label'   => 'Title',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => 'Heading Title',
			]);

			$rep->add_control('desc', [
				'label' => 'Description',
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 4,
				'default' => 'Write description here...',
			]);

			$rep->add_control('year', [
				'label'   => 'Year',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '2024',
			]);

			$this->add_control('items', [
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $rep->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => [
					['title' => 'Heading Title', 'desc' => 'Description...', 'year' => '2024'],
					['title' => 'Heading Title', 'desc' => 'Description...', 'year' => '2023'],
					['title' => 'Heading Title', 'desc' => 'Description...', 'year' => '2022'],
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * ALIGNMENT (KEEPED)
			 * ========================= */
			$this->start_controls_section('alignment', [
				'label' => 'Alignment',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_control('left_content_align', [
				'label'   => 'Left Card Content',
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left'   => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center' => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'right'  => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.left .vt-card' => 'text-align: {{VALUE}};',
				],
			]);

			$this->add_control('right_content_align', [
				'label'   => 'Right Card Content',
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left'   => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center' => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'right'  => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.right .vt-card' => 'text-align: {{VALUE}};',
				],
			]);

			// Icon + Title row alignment per side
			$this->add_control('left_header_align', [
				'label'   => 'Left Icon + Title Row',
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'flex-end',
				'options' => [
					'flex-start' => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center'     => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'flex-end'   => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.left .vt-header' => 'justify-content: {{VALUE}};',
				],
			]);

			$this->add_control('right_header_align', [
				'label'   => 'Right Icon + Title Row',
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => [
					'flex-start' => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center'     => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'flex-end'   => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.right .vt-header' => 'justify-content: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * ICON (TYPO + COLOR + HOVER)
			 * ========================= */
			$this->start_controls_section('icon_style', [
				'label' => 'Icon',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'icon_typo',
					'selector' => '{{WRAPPER}} .vt-icon',
				]
			);

			$this->add_control('icon_color', [
				'label' => 'Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-icon' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('icon_hover_color', [
				'label' => 'Hover Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-icon' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * TITLE
			 * ========================= */
			$this->start_controls_section('title_style', [
				'label' => 'Title',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typo',
					'selector' => '{{WRAPPER}} .vt-title',
				]
			);

			$this->add_control('title_color', [
				'label' => 'Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .vt-title' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('title_hover_color', [
				'label' => 'Hover Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-title' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * DESCRIPTION
			 * ========================= */
			$this->start_controls_section('desc_style', [
				'label' => 'Description',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'desc_typo',
					'selector' => '{{WRAPPER}} .vt-desc',
				]
			);

			$this->add_control('desc_color', [
				'label' => 'Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .vt-desc' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('desc_hover_color', [
				'label' => 'Hover Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-desc' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * YEAR
			 * ========================= */
			$this->start_controls_section('year_style', [
				'label' => 'Year',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'year_typo',
					'selector' => '{{WRAPPER}} .vt-year',
				]
			);

			$this->add_control('year_color', [
				'label' => 'Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-year' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('year_hover_color', [
				'label' => 'Hover Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-year' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* =========================
			 * CARD (NORMAL + HOVER TABS)
			 * ========================= */
			$this->start_controls_section('card_style', [
				'label' => 'Card',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->start_controls_tabs('card_tabs');

			// NORMAL TAB
			$this->start_controls_tab('card_tab_normal', ['label' => 'Normal']);

			$this->add_responsive_control('card_width', [
				'label' => 'Width',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 624],
				'range' => ['px' => ['min' => 200, 'max' => 1100]],
				'selectors' => [
					'{{WRAPPER}} .vt-card' => 'width: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_responsive_control('card_min_height', [
				'label' => 'Min Height',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 224],
				'range' => ['px' => ['min' => 120, 'max' => 900]],
				'selectors' => [
					'{{WRAPPER}} .vt-card' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_responsive_control('card_padding', [
				'label' => 'Padding',
				'type'  => \Elementor\Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 33, 'right' => 33, 'bottom' => 33, 'left' => 33, 'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .vt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

			$this->add_control('card_bg', [
				'label' => 'Background',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-card' => 'background-color: {{VALUE}};',
				],
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name'     => 'card_border',
					'selector' => '{{WRAPPER}} .vt-card',
					'fields_options' => [
						'border' => ['default' => 'solid'],
						'width'  => ['default' => ['top'=>1,'right'=>1,'bottom'=>1,'left'=>1]],
						'color'  => ['default' => '#E5E7EB'],
					],
				]
			);

			$this->add_responsive_control('card_radius', [
				'label' => 'Border Radius',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 16],
				'range' => ['px' => ['min' => 0, 'max' => 80]],
				'selectors' => [
					'{{WRAPPER}} .vt-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'card_shadow',
					'selector' => '{{WRAPPER}} .vt-card',
				]
			);

			$this->end_controls_tab();

			// HOVER TAB
			$this->start_controls_tab('card_tab_hover', ['label' => 'Hover']);

			$this->add_control('card_hover_bg', [
				'label' => 'Hover Background',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover' => 'background-color: {{VALUE}};',
				],
			]);

			$this->add_control('card_hover_border_color', [
				'label' => 'Hover Border Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover' => 'border-color: {{VALUE}};',
				],
			]);

			$this->add_responsive_control('card_hover_radius', [
				'label' => 'Hover Border Radius',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 16],
				'range' => ['px' => ['min' => 0, 'max' => 80]],
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'card_hover_shadow',
					'selector' => '{{WRAPPER}} .vt-card:hover',
				]
			);

			$this->add_responsive_control('card_hover_translate', [
				'label' => 'Hover Translate Y',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 0],
				'range' => ['px' => ['min' => -30, 'max' => 30]],
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]);

			$this->end_controls_tab();

			$this->end_controls_tabs();
			$this->end_controls_section();

			/* =========================
			 * DOT (FULL STYLE + RADIUS OPTION)
			 * ========================= */
			$this->start_controls_section('dot_style', [
				'label' => 'Dot',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_responsive_control('dot_size', [
				'label' => 'Size',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 48],
				'range' => ['px' => ['min' => 8, 'max' => 140]],
				'selectors' => [
					'{{WRAPPER}} .vt-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_control('dot_bg', [
				'label' => 'Background Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-dot' => 'background-color: {{VALUE}};',
				],
			]);

			$this->add_control('dot_border_color', [
				'label' => 'Border Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .vt-dot' => 'border-color: {{VALUE}};',
				],
			]);

			$this->add_responsive_control('dot_border_width', [
				'label' => 'Border Width',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 4],
				'range' => ['px' => ['min' => 0, 'max' => 12]],
				'selectors' => [
					'{{WRAPPER}} .vt-dot' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]);

			// radius option (requested)
			$this->add_responsive_control('dot_radius', [
				'label' => 'Border Radius',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 33554400], // keep your previous default
				'range' => ['px' => ['min' => 0, 'max' => 33554400]],
				'selectors' => [
					'{{WRAPPER}} .vt-dot' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'dot_shadow',
					'selector' => '{{WRAPPER}} .vt-dot',
				]
			);

			$this->end_controls_section();

			/* =========================
			 * LINE (OPTIONAL: keeps defaults)
			 * ========================= */
			$this->start_controls_section('line_style', [
				'label' => 'Line',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_control('line_base_color', [
				'label' => 'Base Line Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F033',
				'selectors' => [
					'{{WRAPPER}} .vt-line' => 'background: {{VALUE}};',
				],
			]);

			$this->add_control('line_progress_color', [
				'label' => 'Progress Line Color',
				'type'  => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-line-progress' => 'background: {{VALUE}};',
				],
			]);

			$this->add_responsive_control('line_width', [
				'label' => 'Line Width',
				'type'  => \Elementor\Controls_Manager::SLIDER,
				'default' => ['size' => 4],
				'range' => ['px' => ['min' => 1, 'max' => 12]],
				'selectors' => [
					'{{WRAPPER}} .vt-line' => 'width: {{SIZE}}{{UNIT}};',
				],
			]);

			$this->end_controls_section();
		}

		protected function render() {
			$s = $this->get_settings_for_display();
			$items = ! empty($s['items']) ? $s['items'] : [];
			$uid = 'vt-' . $this->get_id();
			?>
			<style>
				{{WRAPPER}} .vtimeline{position:relative;max-width:1100px;margin:0 auto;padding:80px 0;}
				{{WRAPPER}} .vt-line{position:absolute;left:50%;top:0;height:100%;background:#2673F033;transform:translateX(-50%);width:4px;}
				{{WRAPPER}} .vt-line-progress{position:absolute;left:0;top:0;width:100%;height:0;background:#2673F0;}
				{{WRAPPER}} .vt-item{position:relative;width:50%;padding:30px 40px;box-sizing:border-box;}
				{{WRAPPER}} .vt-item.left{left:0;}
				{{WRAPPER}} .vt-item.right{left:50%;}
				{{WRAPPER}} .vt-card{box-sizing:border-box;transition:background-color .25s ease,border-color .25s ease,box-shadow .25s ease,transform .25s ease;}
				{{WRAPPER}} .vt-card *{box-sizing:border-box;}
				{{WRAPPER}} .vt-header{display:flex;align-items:center;gap:10px;}
				{{WRAPPER}} .vt-icon{display:inline-flex;align-items:center;justify-content:center;line-height:1;}
				{{WRAPPER}} .vt-icon svg{width:1em;height:1em;fill:currentColor;display:block;}
				{{WRAPPER}} .vt-title{margin:0;}
				{{WRAPPER}} .vt-desc{margin:0;}
				{{WRAPPER}} .vt-year{margin:0;}
				{{WRAPPER}} .vt-dot{
					position:absolute;left:50%;transform:translateX(-50%);
					width:48px;height:48px;background:#2673F0;border:4px solid #fff;border-radius:33554400px;
					box-shadow:0 10px 15px -3px rgba(0,0,0,.10),0 4px 6px -4px rgba(0,0,0,.10);
					z-index:5;border-style:solid;
				}

				@media (max-width:768px){
					{{WRAPPER}} .vt-line{left:20px;transform:none;}
					{{WRAPPER}} .vt-item{width:100%;left:0;padding-left:60px;padding-right:20px;}
					{{WRAPPER}} .vt-dot{left:20px;transform:none;}
				}
			</style>

			<div class="vtimeline" id="<?php echo esc_attr($uid); ?>">
				<div class="vt-line"><div class="vt-line-progress"></div></div>

				<?php foreach ($items as $i => $it):
					$side = ($i % 2 === 0) ? 'left' : 'right';
					?>
					<div class="vt-dot" data-dot></div>

					<div class="vt-item <?php echo esc_attr($side); ?>">
						<div class="vt-card" data-card>
							<div class="vt-header">
								<span class="vt-icon">
									<?php
									if (!empty($it['icon']['value'])) {
										\Elementor\Icons_Manager::render_icon($it['icon'], ['aria-hidden' => 'true']);
									}
									?>
								</span>
								<h4 class="vt-title"><?php echo esc_html($it['title'] ?? ''); ?></h4>
							</div>

							<p class="vt-desc"><?php echo esc_html($it['desc'] ?? ''); ?></p>
							<div class="vt-year"><?php echo esc_html($it['year'] ?? ''); ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<script>
			(() => {
				const root = document.getElementById('<?php echo esc_js($uid); ?>');
				if (!root) return;

				const line = root.querySelector('.vt-line');
				const progress = root.querySelector('.vt-line-progress');
				const cards = Array.from(root.querySelectorAll('[data-card]'));
				const dots  = Array.from(root.querySelectorAll('[data-dot]'));

				// Position dots aligned to each card (near the header)
				function placeDots() {
					const r0 = root.getBoundingClientRect();
					cards.forEach((card, i) => {
						const r = card.getBoundingClientRect();
						const top = (r.top - r0.top) + 38; // visually matches your design (can remain)
						if (dots[i]) dots[i].style.top = top + 'px';
					});
				}

				// Smooth progress fill top -> down with scroll (LERP)
				let current = 0;

				function targetProgressPx() {
					const rect = root.getBoundingClientRect();
					const viewportMid = window.innerHeight * 0.55;

					// distance from top of root to mid-viewport line (in px within root)
					const within = viewportMid - rect.top;
					const total = rect.height;

					const clamped = Math.max(0, Math.min(total, within));
					return clamped;
				}

				function tick() {
					const target = targetProgressPx();
					current += (target - current) * 0.12; // smoothness
					progress.style.height = current + 'px';
					requestAnimationFrame(tick);
				}

				placeDots();
				window.addEventListener('resize', placeDots, {passive:true});
				window.addEventListener('scroll', () => {
					// keep dots stable even if fonts/images shift
					placeDots();
				}, {passive:true});

				tick();
			})();
			</script>
			<?php
		}
	}

	$widgets_manager->register( new Elementor_Vertical_Timeline_Widget() );

});
