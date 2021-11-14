<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Teams Meeting Manager
Description: Manages Teams Meetings
Version: 2.3.0
Requires at least: 2.3.*
Author: MHD Shafik AlNahhas
*/

define('TEAMS_MEETING_MANAGER_MODULE_NAME', 'teams_meeting_manager');
define('TEAMS_MEETING_MANAGER_CSS', module_dir_url(TEAMS_MEETING_MANAGER_MODULE_NAME, 'assets/css/styles.css'));
define('TEAMS_MEETING_MANAGER_JS', module_dir_url(TEAMS_MEETING_MANAGER_MODULE_NAME, 'assets/js/main.js'));

hooks()->add_action('admin_init', 'tmm_register_user_permissions');
hooks()->add_action('admin_init', 'tmm_register_menu_items');
hooks()->add_action('app_admin_head', 'tmm_head_components');
hooks()->add_action('app_admin_footer', 'tmm_js_footer_components');
hooks()->add_action('after_email_templates', 'tmm_add_email_templates');


$CI = &get_instance();


/**
 * Hook for assigning staff permissions for
 *
 * @return void
 */
function tmm_register_user_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view'),
        'create' => _l('permission_create'),
        'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('teams_meeting_manager', $capabilities, 'Teams Meeting Manager');
}

/**
 * Register new menu item in sidebar menu
 */
function tmm_register_menu_items()
{
    $CI = &get_instance();

    if (staff_can('view')) {
        $CI->app_menu->add_sidebar_menu_item(TEAMS_MEETING_MANAGER_MODULE_NAME, [
            'name'     => 'Teams Meetings',
            'href'     => admin_url('teams_meeting_manager/meetings/login'),
            'icon'     => 'fa fa-phone',
            'position' => 25,
        ]);
    }
}

/**
 * Check if can have permissions then apply new tab in settings
 */
if (staff_can('view', 'settings')) {
    hooks()->add_action('admin_init', 'tmm_add_settings_tab');
}

/**
 * @return void
 */
function tmm_add_settings_tab()
{
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_tabs->add_settings_tab('teams-meeting-manager-settings', [
            'name'     => 'Teams Meeting Manager',
            'view'     => 'teams_meeting_manager/settings',
            'position' => 32,
        ]);
    }
}

/**
 * @return void
 */
function tmm_add_project_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_project_tab('teams-meeting-manager-project', [
        'name'     => 'Teams Meetings Manager',
        'icon'     => 'fa fa-phone',
        'view'     => 'teams_meeting_manager/view',
        'position' => 20,
    ]);
}

/**
 * @return void
 */
function tmm_add_customer_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_customer_tab('teams-meeting-manager-customer', [
        'name'     => 'Teams Meetings Manager',
        'icon'     => 'fa fa-phone',
        'view'     => 'teams_meeting_manager/view',
        'position' => 20,
    ]);
}

if (!function_exists('tmm_head_components')) {
    /**
     * Injects module CSS
     * @return void
     */
    function tmm_head_components()
    {
        echo '<link href="' . TEAMS_MEETING_MANAGER_CSS . "?v=" . time() . '"  rel="stylesheet" type="text/css" >';
    }
}

if (!function_exists('tmm_js_footer_components')) {
    /**
     * Injects module js
     * @return void
     */
    function tmm_js_footer_components()
    {
        echo '<script src="' . TEAMS_MEETING_MANAGER_JS . "?v=" . time() . '"></script>';
    }
}


/**
 * Register module activation hook
 */
register_activation_hook(TEAMS_MEETING_MANAGER_MODULE_NAME, 'tmm_theme_activation_hook');

/**
 * The activation function
 */
function tmm_theme_activation_hook()
{
    require(__DIR__ . '/install.php');
}

//register_payment_gateway('example_gateway', 'teams_meeting_manager');


/* $CI->app_tabs->add_project_tab('project_overview', [
    'name'     => 'Teams Meetings',
    'icon'     => 'fa fa-th',
    'view'     => 'admin/projects/project_overview',
    'position' => 5,
]); */