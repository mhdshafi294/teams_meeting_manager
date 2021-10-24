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
            <span
                data-topic="<?= $meeting["id"]  ?>"><?= isset($meeting["subject"]) ? $meeting["subject"] : 'No Subject'; ?></span>
            <div class="row-options">
                <a href="">view</a> |

                <?php
                         if (staff_can('delete', 'teams_meeting_manager')) : ?>

                <a href="<?= admin_url('teams_meeting_manager/meetings/delete/?mid=' . $meeting["id"]) . ''; ?>"
                    class="text-danger _delete">delete</a>
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