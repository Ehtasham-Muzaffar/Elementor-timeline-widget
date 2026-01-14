<?php
/**
 * Plugin Name: Elementor Vertical Timeline
 * Description: Responsive vertical timeline widget for Elementor with full styling + smooth scroll progress.
 * Author: Ehtasham Muzaffar
 * Version: 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('plugins_loaded', function () {

	// Dashboard-safe: if Elementor not active, do nothing.
	if ( ! did_action('elementor/loaded') ) return;

	add_action('elementor/widgets/register', function ($widgets_manager) {

		if ( ! class_exists('\Elementor\Widget_Base') ) return;

		class Elementor_Vertical_Timeline_Widget extends \Elementor\Widget_Base {

			public function get_name() { return 'vertical_timeline'; }
			public function get_title() { return 'Vertical Timeline'; }
			public function get_icon() { return 'eicon-time-line'; }
			public function get_categories() { return ['general']; }

			protected function register_controls() {

				/* ===================== CONTENT ===================== */
				$this->start_controls_section('section_content', [
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
					'default' => 'Timeline Title',
				]);

				$rep->add_control('desc', [
					'label'   => 'Description',
					'type'    => \Elementor\Controls_Manager::TEXTAREA,
					'rows'    => 4,
					'default' => 'Timeline description here.',
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
						['title'=>'Step One','desc'=>'Description','year'=>'2024'],
						['title'=>'Step Two','desc'=>'Description','year'=>'2023'],
						['title'=>'Step Three','desc'=>'Description','year'=>'2022'],
					],
				]);

				$this->end_controls_section();


				/* ===================== LAYOUT / ALIGNMENT ===================== */
				$this->start_controls_section('section_layout', [
					'label' => 'Layout & Alignment',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_control('left_content_align', [
					'label'   => 'Left Card Content Align',
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
					'label'   => 'Right Card Content Align',
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

				$this->add_control('left_header_justify', [
					'label'   => 'Left Icon+Title Row',
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

				$this->add_control('right_header_justify', [
					'label'   => 'Right Icon+Title Row',
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

				$this->add_responsive_control('mobile_line_left', [
					'label' => 'Mobile Line Left (px)',
					'type'  => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 24],
					'range' => ['px' => ['min' => 8, 'max' => 80]],
					'selectors' => [
						'{{WRAPPER}} .vtimeline.is-mobile .vt-line' => 'left: {{SIZE}}{{UNIT}}; transform: none;',
						'{{WRAPPER}} .vtimeline.is-mobile .vt-dot'  => 'left: {{SIZE}}{{UNIT}}; transform: none;',
					],
				]);

				$this->add_responsive_control('mobile_content_padding_left', [
					'label' => 'Mobile Content Padding Left',
					'type'  => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 72],
					'range' => ['px' => ['min' => 40, 'max' => 160]],
					'selectors' => [
						'{{WRAPPER}} .vtimeline.is-mobile .vt-item' => 'padding-left: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->end_controls_section();


				/* ===================== LINE ===================== */
				$this->start_controls_section('section_line', [
					'label' => 'Line',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_control('line_base_color', [
					'label'   => 'Base Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F033',
					'selectors' => [
						'{{WRAPPER}} .vt-line' => 'background: {{VALUE}};',
					],
				]);

				$this->add_control('line_progress_color', [
					'label'   => 'Progress Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-line-progress' => 'background: {{VALUE}};',
					],
				]);

				$this->add_responsive_control('line_width', [
					'label' => 'Width',
					'type'  => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 4],
					'range' => ['px' => ['min' => 1, 'max' => 14]],
					'selectors' => [
						'{{WRAPPER}} .vt-line' => 'width: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->end_controls_section();


				/* ===================== DOT ===================== */
				$this->start_controls_section('section_dot', [
					'label' => 'Dot',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_responsive_control('dot_size', [
					'label'   => 'Size',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 48],
					'range'   => ['px' => ['min' => 8, 'max' => 140]],
					'selectors' => [
						'{{WRAPPER}} .vt-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->add_control('dot_bg', [
					'label'   => 'Background',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-dot' => 'background: {{VALUE}};',
					],
				]);

				$this->add_control('dot_border_color', [
					'label'   => 'Border Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-dot' => 'border-color: {{VALUE}};',
					],
				]);

				$this->add_responsive_control('dot_border_width', [
					'label'   => 'Border Width',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 4],
					'range'   => ['px' => ['min' => 0, 'max' => 14]],
					'selectors' => [
						'{{WRAPPER}} .vt-dot' => 'border-width: {{SIZE}}{{UNIT}};',
					],
				]);

				// Radius option requested; default keeps your “infinite” radius idea.
				$this->add_responsive_control('dot_radius', [
					'label'   => 'Border Radius',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 33554400],
					'range'   => ['px' => ['min' => 0, 'max' => 33554400]],
					'selectors' => [
						'{{WRAPPER}} .vt-dot' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name'     => 'dot_shadow',
						'selector' => '{{WRAPPER}} .vt-dot',
						'fields_options' => [
							'box_shadow_type' => ['default' => 'yes'],
							'box_shadow' => [
								'default' => [
									'horizontal' => 0,
									'vertical'   => 10,
									'blur'       => 15,
									'spread'     => -3,
								]
							]
						]
					]
				);

				$this->end_controls_section();


				/* ===================== CARD ===================== */
				$this->start_controls_section('section_card', [
					'label' => 'Card',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->start_controls_tabs('card_tabs');

				$this->start_controls_tab('card_tab_normal', ['label' => 'Normal']);

				$this->add_control('card_bg', [
					'label'   => 'Background',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-card' => 'background-color: {{VALUE}};',
					],
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'card_border',
						'selector' => '{{WRAPPER}} .vt-card',
						'fields_options' => [
							'color' => ['default' => '#E5E7EB'],
							'width' => ['default' => ['top'=>1,'right'=>1,'bottom'=>1,'left'=>1]],
							'border' => ['default' => 'solid'],
						],
					]
				);

				$this->add_responsive_control('card_radius', [
					'label'   => 'Border Radius',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 16],
					'range'   => ['px' => ['min' => 0, 'max' => 80]],
					'selectors' => [
						'{{WRAPPER}} .vt-card' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->add_responsive_control('card_padding', [
					'label' => 'Padding',
					'type'  => \Elementor\Controls_Manager::DIMENSIONS,
					'default' => ['top'=>32,'right'=>32,'bottom'=>32,'left'=>32,'unit'=>'px'],
					'selectors' => [
						'{{WRAPPER}} .vt-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'card_shadow',
						'selector' => '{{WRAPPER}} .vt-card',
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab('card_tab_hover', ['label' => 'Hover']);

				$this->add_control('card_hover_bg', [
					'label'   => 'Hover Background',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover' => 'background-color: {{VALUE}};',
					],
				]);

				$this->add_control('card_hover_border_color', [
					'label'   => 'Hover Border Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover' => 'border-color: {{VALUE}};',
					],
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'card_hover_shadow',
						'selector' => '{{WRAPPER}} .vt-card:hover',
					]
				);

				$this->add_responsive_control('card_hover_translate', [
					'label'   => 'Hover Translate Y',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 0],
					'range'   => ['px' => ['min' => -30, 'max' => 30]],
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
					],
				]);

				$this->end_controls_tab();

				$this->end_controls_tabs();
				$this->end_controls_section();


				/* ===================== ICON ===================== */
				$this->start_controls_section('section_icon', [
					'label' => 'Icon',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_control('icon_color', [
					'label'   => 'Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-icon' => 'color: {{VALUE}};',
					],
				]);

				$this->add_control('icon_hover_color', [
					'label'   => 'Hover Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover .vt-icon' => 'color: {{VALUE}};',
					],
				]);

				$this->add_responsive_control('icon_size', [
					'label'   => 'Size',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 24],
					'range'   => ['px' => ['min' => 10, 'max' => 80]],
					'selectors' => [
						'{{WRAPPER}} .vt-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->add_responsive_control('icon_gap', [
					'label'   => 'Gap (Icon ↔ Title)',
					'type'    => \Elementor\Controls_Manager::SLIDER,
					'default' => ['size' => 10],
					'range'   => ['px' => ['min' => 0, 'max' => 40]],
					'selectors' => [
						'{{WRAPPER}} .vt-header' => 'gap: {{SIZE}}{{UNIT}};',
					],
				]);

				$this->end_controls_section();


				/* ===================== TYPOGRAPHY ===================== */
				$this->start_controls_section('section_typo_title', [
					'label' => 'Title',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'title_typo',
						'selector' => '{{WRAPPER}} .vt-title',
					]
				);

				$this->add_control('title_color', [
					'label'   => 'Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#111827',
					'selectors' => [
						'{{WRAPPER}} .vt-title' => 'color: {{VALUE}};',
					],
				]);

				$this->add_control('title_hover_color', [
					'label'   => 'Hover Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover .vt-title' => 'color: {{VALUE}};',
					],
				]);

				$this->end_controls_section();


				$this->start_controls_section('section_typo_desc', [
					'label' => 'Description',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'desc_typo',
						'selector' => '{{WRAPPER}} .vt-desc',
					]
				);

				$this->add_control('desc_color', [
					'label'   => 'Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#4B5563',
					'selectors' => [
						'{{WRAPPER}} .vt-desc' => 'color: {{VALUE}};',
					],
				]);

				$this->add_control('desc_hover_color', [
					'label'   => 'Hover Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover .vt-desc' => 'color: {{VALUE}};',
					],
				]);

				$this->end_controls_section();


				$this->start_controls_section('section_typo_year', [
					'label' => 'Year',
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'year_typo',
						'selector' => '{{WRAPPER}} .vt-year',
					]
				);

				$this->add_control('year_color', [
					'label'   => 'Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#2673F0',
					'selectors' => [
						'{{WRAPPER}} .vt-year' => 'color: {{VALUE}};',
					],
				]);

				$this->add_control('year_hover_color', [
					'label'   => 'Hover Color',
					'type'    => \Elementor\Controls_Manager::COLOR,
					'default' => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .vt-card:hover .vt-year' => 'color: {{VALUE}};',
					],
				]);

				$this->end_controls_section();
			}

			/* ===================== RENDER ===================== */
			protected function render() {

				$s = $this->get_settings_for_display();
				$items = ( isset($s['items']) && is_array($s['items']) ) ? $s['items'] : [];

				$uid = 'vtimeline-' . $this->get_id();
				?>
				<style>
					/* Scope strictly to widget wrapper to avoid affecting anything else */
					#<?php echo esc_attr($uid); ?>{position:relative; max-width:1100px; margin:0 auto; padding:80px 0;}
					#<?php echo esc_attr($uid); ?> .vt-line{position:absolute; left:50%; top:0; height:100%; transform:translateX(-50%);}
					#<?php echo esc_attr($uid); ?> .vt-line-progress{position:absolute; left:0; top:0; width:100%; height:0;}
					#<?php echo esc_attr($uid); ?> .vt-item{position:relative; width:50%; padding:30px 40px; box-sizing:border-box;}
					#<?php echo esc_attr($uid); ?> .vt-item.left{left:0;}
					#<?php echo esc_attr($uid); ?> .vt-item.right{left:50%;}
					#<?php echo esc_attr($uid); ?> .vt-card{box-sizing:border-box; transition: background-color .25s ease, border-color .25s ease, box-shadow .25s ease, transform .25s ease;}
					#<?php echo esc_attr($uid); ?> .vt-header{display:flex; align-items:center;}
					#<?php echo esc_attr($uid); ?> .vt-icon{display:inline-flex; align-items:center; justify-content:center; line-height:1;}
					#<?php echo esc_attr($uid); ?> .vt-icon svg{width:1em; height:1em; fill:currentColor; display:block;}
					#<?php echo esc_attr($uid); ?> .vt-title{margin:0;}
					#<?php echo esc_attr($uid); ?> .vt-desc{margin:0;}
					#<?php echo esc_attr($uid); ?> .vt-year{margin:0;}
					#<?php echo esc_attr($uid); ?> .vt-dot{position:absolute; left:50%; transform:translateX(-50%); border-style:solid; z-index:5;}

					/* Mobile: force vertical stack (one column) */
					@media (max-width: 768px){
						#<?php echo esc_attr($uid); ?>.is-mobile .vt-item{width:100% !important; left:0 !important; padding-right:16px; box-sizing:border-box;}
					}
                    @media (max-width: 768px){

	/* Force vertical stack */
	#<?php echo esc_attr($uid); ?> .vt-item{
		width:100% !important;
		left:0 !important;
		padding-left:72px;
		padding-right:16px;
	}

	/* Move line to left */
	#<?php echo esc_attr($uid); ?> .vt-line{
		left:24px;
		transform:none;
	}

	/* Move dots to left */
	#<?php echo esc_attr($uid); ?> .vt-dot{
		left:24px;
		transform:none;
	}

	/* Inner content ALWAYS left on mobile */
	#<?php echo esc_attr($uid); ?> .vt-card{
		text-align:left !important;
	}

	/* Icon + title row left */
	#<?php echo esc_attr($uid); ?> .vt-header{
		justify-content:flex-start !important;
	}

	/* Reduce icon size on mobile */
	#<?php echo esc_attr($uid); ?> .vt-icon{
		font-size:18px;
	}
}

				</style>

				<div id="<?php echo esc_attr($uid); ?>" class="vtimeline">
					<div class="vt-line"><div class="vt-line-progress"></div></div>

					<?php foreach ($items as $i => $it):
						$side = ($i % 2 === 0) ? 'left' : 'right';
						?>
						<div class="vt-dot" data-dot></div>

						<div class="vt-item <?php echo esc_attr($side); ?>">
							<div class="vt-card" data-card>
								<div class="vt-header">
									<?php if ( ! empty($it['icon']['value']) ): ?>
										<span class="vt-icon">
											<?php \Elementor\Icons_Manager::render_icon($it['icon'], ['aria-hidden' => 'true']); ?>
										</span>
									<?php endif; ?>
									<h4 class="vt-title"><?php echo esc_html($it['title'] ?? ''); ?></h4>
								</div>

								<p class="vt-desc"><?php echo esc_html($it['desc'] ?? ''); ?></p>
								<div class="vt-year"><?php echo esc_html($it['year'] ?? ''); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<script>
				(function(){
					try{
						const root = document.getElementById('<?php echo esc_js($uid); ?>');
						if(!root) return;

						const line = root.querySelector('.vt-line');
						const prog = root.querySelector('.vt-line-progress');
						const cards = Array.from(root.querySelectorAll('[data-card]'));
						const dots  = Array.from(root.querySelectorAll('[data-dot]'));
						if(!line || !prog) return;

						function setMobileClass(){
							if(window.innerWidth <= 768) root.classList.add('is-mobile');
							else root.classList.remove('is-mobile');
						}

						function placeDots(){
							if(!cards.length || !dots.length) return;
							const r0 = root.getBoundingClientRect();
							const mobile = window.innerWidth <= 768;
							const offset = mobile ? 30 : 40;

							cards.forEach((c,i)=>{
								if(!dots[i]) return;
								const r = c.getBoundingClientRect();
								dots[i].style.top = (r.top - r0.top + offset) + 'px';
							});
						}

						// Smooth progress line (lerp)
						let current = 0;
						function targetProgress(){
							const rect = root.getBoundingClientRect();
							const within = (window.innerHeight * 0.55) - rect.top;
							const clamped = Math.max(0, Math.min(rect.height, within));
							return clamped;
						}

						function animate(){
							const target = targetProgress();
							current += (target - current) * 0.12; // smoothness
							prog.style.height = current + 'px';
							requestAnimationFrame(animate);
						}

						setMobileClass();
						placeDots();
						animate();

						window.addEventListener('resize', function(){
							setMobileClass();
							placeDots();
						}, {passive:true});

						window.addEventListener('scroll', function(){
							// keep dots tight if layout shifts
							placeDots();
						}, {passive:true});

					}catch(e){
						// Editor/dashboard safe
						console.warn('Vertical Timeline widget error:', e);
					}
				})();
				</script>
				<?php
			}
		}

		$widgets_manager->register( new Elementor_Vertical_Timeline_Widget() );
	});
});
