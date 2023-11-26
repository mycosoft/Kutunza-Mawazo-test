<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Travlio_Elementor_Tabs extends Widget_Base {

    public function get_name() {
        return 'apus_element_tabs';
    }

    public function get_title() {
        return esc_html__( 'Apus Tabs', 'travlio' );
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return [ 'travlio-elements' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Tabs', 'travlio' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $tabs = new Repeater();

        $tabs->add_control(
            'title', [
                'label' => esc_html__( 'Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $ele_obj = \Elementor\Plugin::$instance;
        $templates = $ele_obj->templates_manager->get_source( 'local' )->get_items();

        if ( empty( $templates ) ) {

            $this->add_control(
                'no_templates',
                array(
                    'label' => false,
                    'type'  => Controls_Manager::RAW_HTML,
                    'raw'   => $this->empty_templates_message(),
                )
            );

            return;
        }

        $options = [
            '0' => '— ' . esc_html__( 'Select', 'travlio' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $tabs->add_control(
            'content_type',
            [
                'label'       => esc_html__( 'Content Type', 'travlio' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'template',
                'options'     => [
                    'template' => esc_html__( 'Template', 'travlio' ),
                    'editor'   => esc_html__( 'Editor', 'travlio' ),
                ],
                'label_block' => 'true',
            ]
        );

        $tabs->add_control(
            'item_template_id',
            [
                'label'       => esc_html__( 'Choose Template', 'travlio' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => $options,
                'types'       => $types,
                'label_block' => 'true',
                'condition'   => [
                    'content_type' => 'template',
                ]
            ]
        );

        $tabs->add_control(
            'content',
            [
                'label'      => esc_html__( 'Content', 'travlio' ),
                'type'       => Controls_Manager::WYSIWYG,
                'default'    => esc_html__( 'Tab Item Content', 'travlio' ),
                'dynamic' => [
                    'active' => true,
                ],
                'condition'   => [
                    'content_type' => 'editor',
                ]
            ]
        );


        $this->add_control(
            'title', [
                'label' => esc_html__( 'Title', 'travlio' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs', 'travlio' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $tabs->get_controls(),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'travlio'),
                    'style2' => esc_html__('Style 2', 'travlio'),
                    'style3' => esc_html__('Style 3', 'travlio'),
                ),
                'default' => 'style1'
            ]
        );

        $this->add_responsive_control(
            'alignment_header',
            [
                'label' => esc_html__( 'Alignment Header', 'travlio' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'travlio' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'travlio' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'travlio' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'travlio' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .nav-widget-tab' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment Content', 'travlio' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'travlio' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'travlio' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'travlio' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'travlio' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tab-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'travlio' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'travlio' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => esc_html__( 'Style', 'travlio' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'header_margin',
            [
                'label' => esc_html__( 'Margin Header', 'travlio' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .nav-widget-tab' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

            $this->start_controls_tabs( 'tabs_box_style' );

                $this->start_controls_tab(
                    'tab_box_normal',
                    [
                        'label' => esc_html__( 'Normal', 'travlio' ),
                    ]
                );

                $this->add_control(
                'tab_color',
                    [
                        'label' => esc_html__( 'Color', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .nav-widget-tab > li > a' => 'color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->add_control(
                'tab_bg_color',
                    [
                        'label' => esc_html__( 'Background Color', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .nav-widget-tab > li > a' => 'background-color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->end_controls_tab();

                // tab hover
                $this->start_controls_tab(
                    'tab_box_hover',
                    [
                        'label' => esc_html__( 'Hover', 'travlio' ),
                    ]
                );

                $this->add_control(
                'tab_hv_color',
                    [
                        'label' => esc_html__( 'Color', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .nav-widget-tab > li.active > a' => 'color: {{VALUE}} !important;',
                            '{{WRAPPER}} .nav-widget-tab > li:hover > a' => 'color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->add_control(
                'tab_bg_hv_color',
                    [
                        'label' => esc_html__( 'Background Color', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .nav-widget-tab > li.active > a' => 'background-color: {{VALUE}} !important;',
                            '{{WRAPPER}} .nav-widget-tab > li:hover > a' => 'background-color: {{VALUE}} !important;',
                            '{{WRAPPER}} .nav-widget-tab > li > a:before' => 'border-top-color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->add_control(
                'tab_hv_line_color',
                    [
                        'label' => esc_html__( 'Color Line', 'travlio' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .nav-widget-tab > li > a::before' => 'background-color: {{VALUE}};',
                        ],
                        'condition' => [
                            'style' => 'style3',
                        ],
                    ]
                );

                $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'typography',
                    'scheme' => Core\Schemes\Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .nav-widget-tab > li > a',
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $_id = travlio_random_key();

        ?>
        <div class="widget-tabs <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ( !empty($title) ): ?>
                <h2 class="widget-title">
                    <?php echo esc_attr( $title ); ?>
                </h2>
            <?php endif; ?>
            <div class="widget-content">
                <ul role="tablist" class="nav nav-tabs nav-widget-tab <?php echo esc_attr($style); ?>">
                    <?php $i = 0; foreach ($tabs as $tab) : ?>
                        <li class="<?php echo esc_attr($i == 0 ? 'active' : '');?>">
                            <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>" data-toggle="tab">
                                <?php if ( !empty($tab['title']) ) { ?>
                                    <?php echo esc_attr($tab['title']); ?>
                                <?php } ?>
                            </a>
                        </li>
                    <?php $i++; endforeach; ?>
                </ul>
                <div class="tab-content">

                    <?php $i = 0; foreach ($tabs as $tab) : ?>
                        <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>" class="tab-pane fade <?php echo esc_attr($i == 0 ? 'in active' : ''); ?>">

                            <div class="tabs-inner">

                                <?php
                                $ele_obj = \Elementor\Plugin::$instance;
                                $content_html = '';
                                switch ( $tab[ 'content_type' ] ) {
                                    case 'template':

                                        if ( '0' !== $tab['item_template_id'] ) {

                                            $template_content = $ele_obj->frontend->get_builder_content_for_display( $tab['item_template_id'] );

                                            if ( ! empty( $template_content ) ) {
                                                $content_html .= $template_content;

                                                if ( Plugin::$instance->editor->is_edit_mode() ) {
                                                    $link = add_query_arg(
                                                        array(
                                                            'elementor' => '',
                                                        ),
                                                        get_permalink( $tab['item_template_id'] )
                                                    );

                                                    $content_html .= sprintf( '<div class="travlio__edit-cover" data-template-edit-link="%s"><i class="fa fa-pencil"></i><span>%s</span></div>', $link, esc_html__( 'Edit Template', 'travlio' ) );
                                                }
                                            } else {
                                                $content_html = $this->no_template_content_message();
                                            }
                                        } else {
                                            $content_html = $this->no_templates_message();
                                        }
                                    break;

                                    case 'editor':
                                        if ( !empty($tab['content']) ) {
                                            $content_html = trim( $tab['content'] );
                                        }
                                    break;
                                }
                                echo trim($content_html);
                                ?>
                                
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function no_templates_message() {
        $message = '<span>' . esc_html__( 'Template is not defined. ', 'travlio' ) . '</span>';

        return sprintf(
            '<div class="no-template-message">%1$s</div>',
            $message
        );
    }

    public function no_template_content_message() {
        $message = '<span>' . esc_html__( 'The tabs are working. Please, note, that you have to add a template to the library in order to be able to display it inside the tabs.', 'travlio' ) . '</span>';

        return sprintf( '<div class="no-template-message">%1$s</div>', $message );
    }

    public function empty_templates_message() {
        return '<div id="elementor-widget-template-empty-templates">
                <div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
                <div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'travlio' ) . '</div>
                <div class="elementor-widget-template-empty-templates-footer">' . esc_html__( 'What is Library?', 'travlio' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . esc_html__( 'Read our tutorial on using Library templates.', 'travlio' ) . '</a></div>
                </div>';
    }
    
}

Plugin::instance()->widgets_manager->register_widget_type( new Travlio_Elementor_Tabs );