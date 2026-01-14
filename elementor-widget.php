<?php
/**
 * Plugin Name: Elementor Vertical Timeline (Final – Full Styling)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'elementor/init', function () {

	class Elementor_Vertical_Timeline_Widget extends \Elementor\Widget_Base {

		public function get_name() { return 'vertical_timeline'; }
		public function get_title() { return 'Vertical Timeline'; }
		public function get_icon() { return 'eicon-time-line'; }
		public function get_categories() { return ['general']; }

		protected function register_controls() {

			/* ================= CONTENT ================= */

			$this->start_controls_section('content', [
				'label' => 'Timeline Items',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]);

			$repeater = new \Elementor\Repeater();

			$repeater->add_control('icon', [
				'label' => 'Icon',
				'type' => \Elementor\Controls_Manager::ICONS,
			]);

			$repeater->add_control('title', [
				'label' => 'Title',
				'type' => \Elementor\Controls_Manager::TEXT,
			]);

			$repeater->add_control('desc', [
				'label' => 'Description',
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]);

			$repeater->add_control('year', [
				'label' => 'Year',
				'type' => \Elementor\Controls_Manager::TEXT,
			]);

			$this->add_control('items', [
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]);

			$this->end_controls_section();

			/* ================= ALIGNMENT ================= */

			$this->start_controls_section('alignment', [
				'label' => 'Alignment',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_control('left_align', [
				'label' => 'Left Card Content',
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left' => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center' => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'right' => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.left .vt-card' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .vt-item.left .vt-header' => 'justify-content: flex-end;',
				],
			]);

			$this->add_control('right_align', [
				'label' => 'Right Card Content',
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => ['title'=>'Left','icon'=>'eicon-text-align-left'],
					'center' => ['title'=>'Center','icon'=>'eicon-text-align-center'],
					'right' => ['title'=>'Right','icon'=>'eicon-text-align-right'],
				],
				'selectors' => [
					'{{WRAPPER}} .vt-item.right .vt-card' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .vt-item.right .vt-header' => 'justify-content: flex-start;',
				],
			]);

			$this->end_controls_section();

			/* ================= ICON ================= */

			$this->start_controls_section('icon_style', [
				'label' => 'Icon',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'icon_typography',
					'selector' => '{{WRAPPER}} .vt-icon',
				]
			);

			$this->add_control('icon_color', [
				'label' => 'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-icon' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('icon_hover_color', [
				'label' => 'Hover Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-icon' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* ================= TITLE ================= */

			$this->start_controls_section('title_style', [
				'label' => 'Title',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .vt-title',
				]
			);

			$this->add_control('title_color', [
				'label' => 'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .vt-title' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('title_hover_color', [
				'label' => 'Hover Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-title' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* ================= DESCRIPTION ================= */

			$this->start_controls_section('desc_style', [
				'label' => 'Description',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'desc_typography',
					'selector' => '{{WRAPPER}} .vt-desc',
				]
			);

			$this->add_control('desc_color', [
				'label' => 'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#4b5563',
				'selectors' => [
					'{{WRAPPER}} .vt-desc' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('desc_hover_color', [
				'label' => 'Hover Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-desc' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();

			/* ================= YEAR ================= */

			$this->start_controls_section('year_style', [
				'label' => 'Year',
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'year_typography',
					'selector' => '{{WRAPPER}} .vt-year',
				]
			);

			$this->add_control('year_color', [
				'label' => 'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#2673F0',
				'selectors' => [
					'{{WRAPPER}} .vt-year' => 'color: {{VALUE}};',
				],
			]);

			$this->add_control('year_hover_color', [
				'label' => 'Hover Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .vt-card:hover .vt-year' => 'color: {{VALUE}};',
				],
			]);

			$this->end_controls_section();
		}

		protected function render() {
			$items = $this->get_settings_for_display()['items'];
			$uid = 'vt-' . $this->get_id();
		?>

<style>
{{WRAPPER}} .vtimeline{position:relative;max-width:1100px;margin:auto;padding:80px 0;}
{{WRAPPER}} .vt-line{position:absolute;left:50%;top:0;width:4px;height:100%;background:#2673F033;transform:translateX(-50%);}
{{WRAPPER}} .vt-line-progress{position:absolute;left:0;top:0;width:100%;height:0;background:#2673F0;}
{{WRAPPER}} .vt-dot{
	position:absolute;left:50%;transform:translateX(-50%);
	width:48px;height:48px;background:#2673F0;border:4px solid #fff;
	border-radius:33554400px;
	box-shadow:0 10px 15px -3px rgba(0,0,0,.10),0 4px 6px -4px rgba(0,0,0,.10);
	z-index:5;
}
{{WRAPPER}} .vt-item{position:relative;width:50%;padding:30px 40px;box-sizing:border-box;}
{{WRAPPER}} .vt-item.left{left:0;}
{{WRAPPER}} .vt-item.right{left:50%;}
{{WRAPPER}} .vt-card{background:#fff;padding:24px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.08);}
{{WRAPPER}} .vt-header{display:flex;align-items:center;gap:10px;}
{{WRAPPER}} .vt-icon svg{width:1em;height:1em;fill:currentColor;}
{{WRAPPER}} .vt-title{margin:0;}
{{WRAPPER}} .vt-desc{margin:10px 0;}
{{WRAPPER}} .vt-year{font-weight:600;}
</style>

<div class="vtimeline" id="<?php echo esc_attr($uid); ?>">
	<div class="vt-line"><div class="vt-line-progress"></div></div>

	<?php foreach ($items as $i => $item): ?>
		<div class="vt-dot"></div>
		<div class="vt-item <?php echo $i%2===0?'left':'right'; ?>">
			<div class="vt-card" data-card>
				<div class="vt-header">
					<span class="vt-icon"><?php \Elementor\Icons_Manager::render_icon($item['icon']); ?></span>
					<h4 class="vt-title"><?php echo esc_html($item['title']); ?></h4>
				</div>
				<p class="vt-desc"><?php echo esc_html($item['desc']); ?></p>
				<div class="vt-year"><?php echo esc_html($item['year']); ?></div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<script>
(() => {
	const root=document.getElementById('<?php echo esc_js($uid); ?>');
	const progress=root.querySelector('.vt-line-progress');
	const cards=[...root.querySelectorAll('[data-card]')];
	const dots=[...root.querySelectorAll('.vt-dot')];
	const place=()=>{const r0=root.getBoundingClientRect();
		cards.forEach((c,i)=>{const r=c.getBoundingClientRect();
			dots[i].style.top=(r.top-r0.top+36)+'px';
		});
	};
	let cur=0,tgt=0;
	const anim=()=>{cur+=(tgt-cur)*.15;progress.style.height=cur+'px';requestAnimationFrame(anim);}
	const io=new IntersectionObserver(e=>e.forEach(x=>{
		if(x.isIntersecting){
			const r=x.target.getBoundingClientRect(),rt=root.getBoundingClientRect();
			tgt=r.top-rt.top+r.height*.6;
		}
	}),{rootMargin:'-40% 0px -40% 0px'});
	cards.forEach(c=>io.observe(c));place();anim();window.addEventListener('resize',place);
})();
</script>

<?php
		}
	}

	\Elementor\Plugin::instance()->widgets_manager->register(
		new Elementor_Vertical_Timeline_Widget()
	);
});
