<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * The file is responsible for handing the chat installation
 */
$CI = &get_instance();

add_option('tmm_app_id', '');
add_option('tmm_app_secret', '');
add_option('tmm_app_redirect_uri', base_url() . 'teams_meeting_manager/meetings/callback');

// table tmm
$CI->db->query("CREATE TABLE IF NOT EXISTS `" . "tbltmm" . "` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `user_name` VARCHAR(255),
    `user_email` VARCHAR(255),
    `access_token` TEXT NOT NULL,
    `refresh_token` TEXT NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
