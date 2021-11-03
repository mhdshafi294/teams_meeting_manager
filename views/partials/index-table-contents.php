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

                    | <a data-toggle="collapse" title="Notes" data-id="<?= $meeting["id"];  ?>" onclick="editMeetingNotes2(this)" style="cursor:pointer;" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Notes</a>

                    <div class="col">
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                <div class="edit_meeting_notes">
                                    <div class="panel_s">
                                        <div class="panel-body">
                                            <div class="panel-heading">
                                                <span class="font-medium">Topic: <strong><?= $meeting["subject"]; ?></strong></span>
                                            </div>
                                            <textarea name="notes" class="ays-ignore" style="width:100%;">${data.note ? data.note : ''}</textarea>
                                            <div class="from-group">
                                                <button class="btn btn-primary mtop10 pull-right" onclick="updateMeetingFormData()">${lang_save}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
        </tr>
    <?php endforeach; ?>

</tbody>

<h4 class="text-center"><a href="<?= admin_url('teams_meeting_manager/meetings/createMeeting') ?>"> Schedule a New
        Meeting</a></h4>