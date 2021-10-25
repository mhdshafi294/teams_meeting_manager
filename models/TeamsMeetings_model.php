<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TeamsMeetings_model extends App_Model
{

    /**
     * Get a meeting 
     *
     * @param string $id
     * @return araay
     */
    public function get_teams_meeting($id)
    {
        $query = $this->db->get_where('tbltmm', array('id' => $id));
        return $query->row_array();
    }

    /**
     * Create meeting user
     *
     * @param araay $user
     * @return boolean
     */
    public function create_teams_user($user)
    {
        $data = array(
            'user_id' => get_staff_user_id(),
            'user_name' =>  $user['user_name'],
            'user_email' =>  $user['user_email'],
            'access_token' => $user['access_token'],
            'refresh_token' => $user['refresh_token'],
        );
        return $this->db->insert('tbltmm', $data);
    }


    /**
     * Update meeting user
     *
     * @param araay $user
     * @return boolean
     */
    public function update_teams_user($user)
    {
        $data = array(
            'user_id' => get_staff_user_id(),
            'user_name' =>  $user['user_name'],
            'user_email' =>  $user['user_email'],
            'access_token' => $user['access_token'],
            'refresh_token' => $user['refresh_token'],
        );
        $this->db->where('user_id', get_staff_user_id());
        return $this->db->update('tbltmm', $data);
    }

    /**
     * Update access token
     *
     * @param string $access_token
     * @return boolean
     */
    public function update_access_token($access_token)
    {
        $data = array(
            'access_token' => $access_token,
        );
        $this->db->where('user_id', get_staff_user_id());
        return $this->db->update('tbltmm', $data);
    }

    /**
     * Update refresh token
     *
     * @param string $refresh_token
     * @return boolean
     */
    public function update_refresh_token($refresh_token)
    {
        $data = array(
            'refresh_token' => $refresh_token,
        );
        $this->db->where('user_id', get_staff_user_id());
        return $this->db->update('tbltmm', $data);
    }

    /**
     * Get meeting user
     *
     * @return array
     */
    public function get_teams_user()
    {
        // Validate
        $result = $this->db->get_where('tbltmm', array('user_id' => get_staff_user_id()));

        return $result->result_array();
    }


    /**
     * Check user exists
     *
     * @return boolean
     */
    public function check_user_exists()
    {
        $query = $this->db->get_where('tbltmm', array('user_id' => get_staff_user_id()));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }
}