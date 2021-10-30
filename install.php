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

  
// table participants
$CI->db->query("CREATE TABLE IF NOT EXISTS `" . "tbltmm_participants" . "` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` VARCHAR(191) NOT NULL,
  `user_type` VARCHAR(191) NOT NULL,
  `user_email` VARCHAR(191) NOT NULL,
  `user_fullname` VARCHAR(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");


// table notes
$CI->db->query("CREATE TABLE IF NOT EXISTS `" . "tbltmm_notes" . "` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `meeting_id` VARCHAR(191) NOT NULL,
  `note` longtext DEFAULT NULL,
  `last_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");


create_email_template('You are added as participant to a new Teams Meeting', '<span> Hello {meeting_user_firstname} {meeting_user_lastname}</span><br /><br /><span> You are added to a new Teams meeting that needs to be held on {meeting_datetime}</span><br /><br /><span><strong>Additional info for your meeting:</strong></span><br /><span><strong>Meeting Topic:</strong> {meeting_topic}</span><br /><span><strong>Meeting Description:</strong> {meeting_description}</span><br /><span><strong>Meeting scheduled date to start:</strong> {meeting_datetime}<br /></span><strong>Meeting duration is set to last for</strong>: {meeting_duration}<br /><span><strong>You can join this meeting at the following link from your browser:</strong> <a href="{meeting_web_url}">Web Meeting Link</a></span><br /><strong>You can join this meeting at the following link from your Zoom Application installed on your PC:</strong> <a href="{meeting_app_url}">Web Meeting Link</a><br /><span><br />Kind Regards</span><br /><br /><span>{email_signature}</span>', 'teams_meeting_manager', 'Teams Meeting Manager New Meeting (Sent to Participants)', 'tmm-meeting-created-to-participants');