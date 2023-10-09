<?php

class SeedProject_Buttons_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'seedproject_buttons';
    }
    public function get_title() {
        return __('Button', 'plugin-seedproject');
    }
    public function get_icon() {
        return 'eicon-button';
    }
    public function get_keywords() {
        return ['button', 'seedproject', 'link', 'ui'];
    }
    public function get_categories() {
        return ['seedproject-category'];
    }
    // public function get_script_depends() {}
    // public function get_style_depends() {}
    public function _register_controls() {
        $this->start_controls_section(
            'seedproject_buttons',
            [
                'label' => __('Button', 'plugin-seedproject'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'plugin-seedproject'),
                'label_block' => true,
                'placeholder' => __('Type your button contents here', 'plugin-seedproject'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Button text', 'plugin-seedproject'),
            ]
        );
        $this->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'plugin-seedproject'),
                'label_block' => true,
                'placeholder' => __('Paste URL or type', 'plugin-seedproject'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => false,
                ],
                'show_external' => true,
            ]
        );
        $this->add_control(
            'button_style',
            [
                'label' => __('Button Style', 'plugin-seedproject'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'btn-primary',
                'options' => [
                    'btn-primary' => __('Primary', 'plugin-seedproject'),
                    'btn-secondary' => __('Secondary', 'plugin-seedproject'),
                    'btn-invert' => __('Invert', 'plugin-seedproject'),
                ],
            ]
        );
        $this->add_control(
            'button_align',
            [
                'label' => __('Button Alignment', 'plugin-seedproject'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'toggle' => true,
                'default' => 'text-start',
                'options' => [
                    'text-start' => [
                        'title' => __('Left', 'plugin-seedproject'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'text-center' => [
                        'title' => __('Center', 'plugin-seedproject'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'text-end' => [
                        'title' => __('Right', 'plugin-seedproject'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
    }
    
    protected function render() {
		$settings = $this->get_settings_for_display();
        $target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';

		echo '<div class="link-box ' . $settings['button_align'] . ' ">';
        echo '<a href="' . $settings['button_link']['url'] . '" ' . $target . $nofollow . ' class="btn ' . $settings['button_style'] . '">' . $settings['button_text'] . '</a>';
        echo '</div>';
	}
}
