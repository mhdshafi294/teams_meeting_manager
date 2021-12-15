<?php
$this->load->model('teams_meeting_manager/TeamsMeetings_model');

if (!staff_can('view', 'teams_meeting_manager')) {
    show_404();
}

if ($this->TeamsMeetings_model->check_user_exists())
    redirect(admin_url('teams_meeting_manager/meetings/login'));

$user_data = $this->TeamsMeetings_model->get_teams_user();
$accessToken = $user_data[0]['access_token'];

if (!$this->TeamsMeetings_model->checkAccesToken($accessToken)) {
    redirect(admin_url('teams_meeting_manager/meetings/index'));
}

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

        $met = $this->TeamsMeetings_model->get_meeting_related($meeting["id"]);
        if ($met["rel_type"] == "customer" && $met["rel_id"] == $client->userid) {
            $meetings_array[] = $meeting;
        }
    }
}

$notes_array = [];
foreach ($meetings_array as $meeting) {
    if ($this->TeamsMeetings_model->check_meeting_exists($meeting['id'])) {
        $this->TeamsMeetings_model->create_meeting_notes($meeting['id']);
        $this->TeamsMeetings_model->create_meeting_related($meeting['id']);
        $this->TeamsMeetings_model->create_meeting_event($meeting);
    }
    $notes_array[$meeting["id"]] = $this->TeamsMeetings_model->get_meeting_notes($meeting['id']);
}

?>

<table class="table dt-table dt-inline scroll-responsive" id="meetings">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Web URl</th>
            <th>Type</th>
            <th>Start time</th>
            <th>Timezone</th>
            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($meetings_array as $meeting) : ?>
            <tr class="has-row-options">
                <td>
                    <span data-topic="<?= $meeting["id"]  ?>"><?= isset($meeting["subject"]) ? $meeting["subject"] : 'No Subject'; ?></span>
                    <div class="row-options">

                        <a href="<?= admin_url('teams_meeting_manager/meetings/view/?mid=' . $meeting["id"] . ''); ?>">view</a>

                        | <a data-toggle="collapse" title="Notes" data-id="<?= $meeting["id"]; ?>" style="cursor:pointer;" href="#<?= $meeting["id"] . "multiCollapseExample1"  ?> " role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Notes</a>

                        <?php
                        if (staff_can('delete', 'teams_meeting_manager')) : ?>

                            | <a href="<?= admin_url('teams_meeting_manager/meetings/delete/?mid=' . $meeting["id"]) . ''; ?>" class="text-danger _delete">delete</a>
                        <?php endif; ?>

                    </div>
                </td>
                <td>
                    <a href=" <?= $meeting["onlineMeeting"]["joinUrl"]; ?>" target="_blank">Join meeting</a>
                </td>

                <td>
                    <?= $meeting["type"] ?>
                </td>
                <td>
                    <?= isset($meeting["start"]["dateTime"]) ? _dt($meeting["start"]["dateTime"]) : ''; ?>
                </td>
                <td>
                    <?= isset($meeting["originalStartTimeZone"]) ? $meeting["originalStartTimeZone"] : ''; ?>
                </td>
                <td>
                    <?= _dt($meeting["createdDateTime"]); ?>
                </td>
                <td>
                    <div class="col">
                        <div class="collapse multi-collapse" id="<?= $meeting['id'] . 'multiCollapseExample1'  ?>">
                            <div class="edit_meeting_notes">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <span class="font-medium"><strong>Notes</strong></span>
                                    </div>
                                    <div class="panel-body" style="padding: 5px;">
                                        <textarea name="notes" class="ays-ignore" style="width:100%; border-style: none;"><?php echo isset($notes_array[$meeting["id"]]["note"]) ? $notes_array[$meeting["id"]]["note"] : 'no notes'; ?></textarea>
                                    </div>
                                    <div class="from-group">
                                        <button class="btn btn-primary mtop10 pull-right" data-id="<?= $meeting["id"]; ?>" onclick="updateMeetingFormData(this)">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>

    <div class="clearfix"></div>
    <hr class="hr-panel-heading">
    <!--<h4 class="text-center"><a href="https://teams.live.com/_#/calendarv2"> Schedule a New-->
    <!--        Meeting</a></h4>-->

    <!-- <h4 class="text-center"><a href="<?= admin_url('teams_meeting_manager/meetings/createMeeting') ?>"> Schedule a New
        Meeting</a></h4> -->
</table>

<script>
    function updateMeetingFormData(e) {

        var meeting_id = jQuery(e).attr('data-id');
        var notes = jQuery(e).parent().prev().children('textarea').val();
        var url = "<?= admin_url('teams_meeting_manager/meetings/update_notes') ?>";

        console.log(meeting_id);
        console.log(notes);

        $.post(url, {
            meeting_id: meeting_id,
            notes: notes
        }).done(function(data) {
            alert_float('success', 'Meeting notes was updated successfully');
        });

    }
</script>