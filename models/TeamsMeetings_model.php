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

    public function logout()
    {
        $this->db->where('user_id', get_staff_user_id());
        return $this->db->delete(db_prefix() . 'tmm');
    }


    /**
     * Delete meeting id
     *
     * @param araay $user
     * @return boolean
     */
    public function delete_teams_meeting($id)
    {
        $this->delete_teams_meeting_related($id);
        $this->db->where('meeting_id', $id);
        $this->db->delete(db_prefix() . 'tmm_notes');
    }

    /**
     * Delete meeting id
     *
     * @param araay $user
     * @return boolean
     */
    public function delete_teams_meeting_related($id)
    {
        $this->db->where('meeting_id', $id);
        $this->db->delete(db_prefix() . 'tmm_related');
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

    /**
     * Create meeting notes
     *
     * @param araay $data
     * @return boolean
     */
    public function create_meeting_notes($data)
    {
        $data = array(
            'meeting_id' =>  $data,
            'note' =>  'no note'
        );
        return $this->db->insert('tbltmm_notes', $data);
    }


    /**
     * Get a meeting note
     *
     * @param string $meeting_id
     * @return araay
     */
    public function get_meeting_notes($meeting_id)
    {
        $query = $this->db->get_where('tbltmm_notes', array('meeting_id' => $meeting_id));
        return $query->row_array();
    }

    /**
     * Update Meeting notes
     *
     * @return boolean
     */
    public function update_meeting_notes($data)
    {
        $this->db->where('meeting_id', $data['meeting_id']);
        $this->db->update('tbltmm_notes', $data);
        $query = $this->db->get_where('tbltmm_notes', array('meeting_id' => $data['meeting_id']));
        return $query->row_array();
    }

    /**
     * Create meeting related
     *
     * @param araay $data
     * @return boolean
     */
    public function create_meeting_related($data)
    {
        $data = array(
            'meeting_id' =>  $data
        );
        return $this->db->insert('tbltmm_related', $data);
    }

    /**
     * Get a meeting related
     *
     * @param string $meeting_id
     * @return araay
     */
    public function get_meeting_related($meeting_id)
    {
        $query = $this->db->get_where('tbltmm_related', array('meeting_id' => $meeting_id));
        return $query->row_array();
    }

    /**
     * Update Meeting related
     *
     * @return boolean
     */
    public function update_meeting_related($data)
    {
        $this->db->where('meeting_id', $data['meeting_id']);
        $this->db->update('tbltmm_related', $data);
        $query = $this->db->get_where('tbltmm_related', array('meeting_id' => $data['meeting_id']));
        return $query->row_array();
    }

    /**
     * Create meeting event
     *
     * @param araay $data
     * @return boolean
     */
    public function create_meeting_event($meeting)
    {
        $position = strpos($meeting["bodyPreview"], "___");
        if (!$position == 0) {
            $result = substr($meeting["bodyPreview"], 0, $position - 16);
        } else {
            $result = 'No Discription';
        }

        $data = array(
            'title' =>  $meeting["subject"] . " (Teams meeting)",
            'description' =>  $result,
            'userid' =>  get_staff_user_id(),
            'start' =>  $meeting["start"]["dateTime"],
            'end' =>  $meeting["end"]["dateTime"],
            'public' =>  '0',
            'color' =>  '#28B8DA',
            'isstartnotified' =>  '1',
            'reminder_before' =>  '30',
            'reminder_before_type' =>  'minutes',
        );
        return $this->db->insert('tblevents', $data);
    }

    /**
     * Check user exists
     *
     * @return boolean
     */
    public function check_meeting_exists($meeting_id)
    {
        $query = $this->db->get_where('tbltmm_notes', array('meeting_id' => $meeting_id));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check Acces Token
     *
     * @return Boolean
     */
    public function checkAccesToken($accessToken)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $accessToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);

        if (isset($response["error"])) {
            return false;
        } else {
            return true;
        }
    }
}
