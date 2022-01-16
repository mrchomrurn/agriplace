<?php

namespace Layerdrops\Agriox\Metaboxes;


class Team
{
    function __construct()
    {
        add_action('cmb2_admin_init', [$this, 'add_metabox']);
    }

    function add_metabox()
    {
        $prefix = 'agriox_';

        $general = new_cmb2_box(array(
            'id'           => $prefix . 'team_option',
            'title'        => __('Team Options', 'agriox-addon'),
            'object_types' => array('team'),
            'context'      => 'normal',
            'priority'     => 'default',
        ));

        $general->add_field(array(
            'name' => __('Designation', 'agriox-addon'),
            'id' => $prefix . 'designation',
            'type' => 'text',
        ));

        $team_social = $general->add_field(array(
            'name' => __('Social Profiles', 'agriox-addon'),
            'id' => $prefix . 'team_social',
            'type' => 'group',
        ));

        $general->add_group_field($team_social, array(
            'name' => __('icon', 'agriox-addon'),
            'id' => $prefix . 'icon',
            'type' => 'pw_select',
            'default' => 'fa-facebook-f',
            'options' => agriox_get_fa_icons(),
        ));

        $general->add_group_field($team_social, array(
            'name' => __('link', 'agriox-addon'),
            'id' => $prefix . 'link',
            'type' => 'text',
        ));
    }
}
