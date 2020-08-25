<?php
if( function_exists('acf_add_local_field_group') ):

    ////////////
    // make an array of post type available for geolocation
    ////////////
    $post_type_for_geoloc;
    if(get_field('types_de_contenus', 'option')) {
        $t = get_field('types_de_contenus', 'option');
        foreach($t as $postttype) {
            $post_type_for_geoloc[] = array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $postttype,
                ),
            );
        }
    }

    ////////////
    // FIELDS ON POSTS AVAILABLE ONLY ON POST TYPES SELECTED ON SETTING FIELD
    ////////////
    acf_add_local_field_group(array(
        'key' => 'group_5f1973df863b2',
        'title' => 'Geolocalisation',
        'fields' => array(
            array(
                'key' => 'field_5f199245270ca',
                'label' => 'Géolocaliser ce contenu ?',
                'name' => 'geolocalisation_yesno',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5f1973e600ef0',
                'label' => 'Latitude',
                'name' => 'latitude',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5f199245270ca',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5f19740e00ef1',
                'label' => 'Longitude',
                'name' => 'longitude',
                'type' => 'number',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5f199245270ca',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => '',
                'max' => '',
                'step' => '',
            ),
            array(
                'key' => 'field_5f44fa3a7c0df',
                'label' => 'Contenu Infobulle',
                'name' => 'contenu_infobulle',
                'type' => 'text',
                'instructions' => 'Contenu de l\'infobulle disponible au clic sur le marqueur',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5f199245270ca',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => $post_type_for_geoloc,
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    ////////////   
    // FIELDS ON SETTING PAGE
    ////////////
    acf_add_local_field_group(array(
        'key' => 'group_5f1975d4b95c6',
        'title' => 'Interactive Map Setting',
        'fields' => array(
            array(
                'key' => 'field_5f1975dcc2e25',
                'label' => 'Types de contenus',
                'name' => 'types_de_contenus',
                'type' => 'select',
                'instructions' => 'Ajoutez ici les types de contenus qui auront la possibilité d\'être géolocalisés.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-theme-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    ////////////
    // FIELDS ON BLOCK
    ////////////
    acf_add_local_field_group(array(
        'key' => 'group_5f1981fb0e9c8',
        'title' => 'Ajouter une carte',
        'fields' => array(
            array(
                'key' => 'field_5f19822ce15f1',
                'label' => 'Types de contenus à afficher',
                'name' => 'types_de_contenus_a_afficher',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'ajax' => 0,
                'return_format' => 'value',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_5f2bfd6ddc609',
                'label' => 'Exclusion de contenus',
                'name' => 'exclusion_de_contenus',
                'type' => 'relationship',
                'instructions' => 'Selectionnez les contenus que vous souhaitez exclure de la carte',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => '',
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                ),
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/sedoo-blocks-maps',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
?>