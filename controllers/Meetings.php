<?php
defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '/../vendor/autoload.php';

use myPHPnotes\Microsoft\Auth;
use myPHPnotes\Microsoft\Handlers\Session;
use myPHPnotes\Microsoft\Models\User;


class Meetings extends AdminController
{

	public function __construct()
	{
		parent::__construct();
		/**
		 * Init models
		 */
		$this->load->model('TeamsMeetings_model');

		$tenant = "common";
		$client_id = get_option('tmm_app_id');
		$client_secret = get_option('tmm_app_secret');
		$callback = admin_url('teams_meeting_manager/meetings/callback');
		$scopes = ["User.Read", "Calendars.ReadWrite", "Calendars.Read", "offline_access"];
		$this->microsoft = new Auth($tenant, $client_id, $client_secret, $callback, $scopes);
	}

	/**
	 * login to meetings
	 *
	 * @return View
	 */
	public function login()
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		$client_id = get_option('tmm_app_id');
		$client_secret = get_option('tmm_app_secret');

		if (($client_id == '') || ($client_secret == '')) {
			$this->load->view('missingCon');
			return;
		}

		if ($this->TeamsMeetings_model->check_user_exists()) {
			$this->load->view('login');
		} else {
			$user_data = $this->TeamsMeetings_model->get_teams_user();
			$accessToken = $user_data[0]['access_token'];;

			if ($this->checkAccesToken($accessToken)) {
				$this->index();
			} else {
				if ($this->checkRefrshToken($accessToken)) {
					$this->index();
				} else {
					$this->signin();
				}
			}
		}
	}

	/**
	 * signin to MS
	 *
	 * @return Void
	 */
	public function signin()
	{
		header("location: " . $this->microsoft->getAuthUrl());
	}

	public function callback()
	{
		$microsoft = new Auth(Session::get("tenant_id"), Session::get("client_id"),  Session::get("client_secret"), Session::get("redirect_uri"), Session::get("scopes"));
		$tokens = $microsoft->getToken($_REQUEST['code'], Session::get("state"));

		$refreshToken = $tokens->refresh_token;

		$microsoft->setRefreshToken($refreshToken);
		$accessToken = $microsoft->setAccessToken();

		$user = (new User);
		$user_name = $user->data->getDisplayName();
		$user_email = $user->data->getUserPrincipalName();


		$user_data = array(
			'user_name' => $user_name,
			'user_email' => $user_email,
			'refresh_token' => $refreshToken,
			'access_token' => $accessToken,
		);

		if ($this->TeamsMeetings_model->check_user_exists()) {
			$this->TeamsMeetings_model->create_teams_user($user_data);
		} else {
			$this->TeamsMeetings_model->update_teams_user($user_data);
		}

		redirect('admin/teams_meeting_manager/meetings/index');
	}

	/**
	 * index of meetings
	 *
	 * @return View
	 */
	public function index()
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		$user_data = $this->TeamsMeetings_model->get_teams_user();
		$accessToken = $user_data[0]['access_token'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me/events',
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

		$arr = json_decode($response, true);
		$meetings_array = [];

		foreach ($arr["value"] as $meeting) {
			if ($meeting["isOnlineMeeting"] && $meeting["onlineMeetingProvider"] == "teamsForBusiness") {
				$meetings_array[] = $meeting;
			}
		}

		$notes_array = [];
		foreach ($meetings_array as $meeting) {
			if ($this->TeamsMeetings_model->check_meeting_exists($meeting['id'])) {
				$this->TeamsMeetings_model->create_meeting_notes($meeting['id']);
			}
			$notes_array[$meeting["id"]] = $this->TeamsMeetings_model->get_meeting_notes($meeting['id']);
		}

		$data2 = [
			'meetings_array' => $meetings_array,
			'notes_array' => $notes_array
		];

		$data1 = [
			'data2' => $data2
		];

		$this->load->view('index', $data1);
	}

	/**
	 * View meeting
	 *
	 * @return void
	 */
	public function view()
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		$user_data = $this->TeamsMeetings_model->get_teams_user();
		$accessToken = $user_data[0]['access_token'];

		$id = $this->input->get('mid');

		if ($id) {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me/events/' . $id,
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
			$meeting = json_decode($response, true);

			$data['meeting'] = $meeting;
		} else {
			show_404();
		}

		$this->load->view('view', $data);
	}

	/**
	 * Create lunch meeting view
	 *
	 * @return view
	 */
	public function lunchMeeting()
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		$link = $this->input->get('mid');
		$data = [
			'link' => $link
		];
		$this->load->view('lunch', $data);
	}

	/**
	 * Create meeting view
	 *
	 * @return view
	 */
	public function createMeeting()
	{
		if (!staff_can('create', 'teams_meeting_manager')) {
			show_404();
		}

		$user_data = $this->TeamsMeetings_model->get_teams_user();
		$userName = $user_data[0]['user_name'];

		$data = [
			'staff_members' => $this->staff_model->get('', ['active' => 1]),
			'rel_type' => 'lead',
			'rel_contact_type' => 'contact',
			'rel_contact_id' => '',
			'rel_id' => '',
			'user' => $userName
		];

		$this->load->view('create', $data);
	}

	/**
	 * Create new meeting
	 *
	 * @return void
	 */
	public function create()
	{
		if (!staff_can('create', 'teams_meeting_manager')) {
			show_404();
		}

		$data = $this->input->post();

		if ($data) {
			var_dump($data);
		}
	}

	/**
	 * Delete a meeting
	 *
	 * @return void
	 */
	public function delete()
	{
		if (!staff_can('delete', 'teams_meeting_manager')) {
			show_404();
		}

		$user_data = $this->TeamsMeetings_model->get_teams_user();
		$accessToken = $user_data[0]['access_token'];

		$id = $this->input->get('mid');
		if ($id) {

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://graph.microsoft.com/v1.0/me/events/' . $id,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'DELETE',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $accessToken
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			echo $response;

			redirect('admin/teams_meeting_manager/meetings/index');
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

	/**
	 * Check Refrsh Token
	 *
	 * @return Boolean
	 */
	public function checkRefrshToken($accessToken)
	{
		$user_data = $this->TeamsMeetings_model->get_teams_user();
		$refreshToken = $user_data[0]['refresh_token'];

		$this->microsoft->setRefreshToken($refreshToken);
		$accessToken = $this->microsoft->setAccessToken();

		if ($this->checkAccesToken($accessToken)) {
			$this->TeamsMeetings_model->update_access_token($accessToken);
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Get meeting notes
	 *
	 * @param string $meeting_id
	 * @return Array
	 */
	public function get_notes($meeting_id)
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		return $this->TeamsMeetings_model->get_meeting_notes($meeting_id);
	}


	/**
	 * Update meeting notes
	 *
	 * @return Boolean
	 */
	public function update_notes()
	{
		if (!staff_can('view', 'teams_meeting_manager')) {
			show_404();
		}

		$request = $this->input->post();
		echo $request['meeting_id'] . "<br>";
		echo $request['notes'];

		if ($request) {
			$data = [
				'meeting_id' => $request['meeting_id'],
				'note' => $request['notes']
			];
		}

		return $this->TeamsMeetings_model->update_meeting_notes($data);
	}
}
