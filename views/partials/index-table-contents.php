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

                <a href="<?= admin_url('teams_meeting_manager/meetings/view/?mid=' . $meeting["id"] . ''); ?>">view</a>

                | <a data-toggle="tooltip" title="Notes" data-id="<?= $meeting["id"];  ?>"
                    onclick="editMeetingNotes(this)" style="cursor:pointer;">Notes</a>




                <?php
                         if (staff_can('delete', 'teams_meeting_manager')) : ?>

                | <a href="<?= admin_url('teams_meeting_manager/meetings/delete/?mid=' . $meeting["id"]) . ''; ?>"
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

<script>
$(function() {

    $('#meetings').DataTable();

    init_selectpicker();
    $('.menu-item-teams_meeting_manager').addClass('active');

    // Leads functionality
    var _rel_id = $('#rel_id'),
        _rel_type = $('#rel_lead_type');

    // Items ajax search for leads
    var serverData = {};

    init_ajax_search('items', '#item_select.ajax-search', undefined, admin_url + 'items/search');
    serverData.rel_id = _rel_id.val();
    init_ajax_search(_rel_type.val(), _rel_id, serverData);

});

var tmm_app_edit_id = '';
var lang_save = "<?= _l('save'); ?>";;
var lang_view_notes = 'Viewing notes for meeting with topic: ';


function editMeetingNotes(el) {
    var appointment_id = $(el).data('id');
    var content12 = $('.content .col-md-12');
    var content_row = $('.content .row.main_row');
    var skeleton_loader = `
               <div class="ph-item">
                    <div class="ph-col-12">
                         <div class="ph-picture"></div>
                              <div class="ph-row">
                                   <div class="ph-col-6 big"></div>
                                   <div class="ph-col-4 empty big"></div>
                                   <div class="ph-col-2 big"></div>
                                   <div class="ph-col-4"></div>
                                   <div class="ph-col-8 empty"></div>
                                   <div class="ph-col-6"></div>
                                   <div class="ph-col-6 empty"></div>
                                   <div class="ph-col-12"></div>
                              </div>
                         </div>
               </div>`;
    $('.content .col-md-12').removeClass('col-md-12').addClass('col-md-6');
    $('td div.text-center a:first').css('margin', '-9px');
    $('#toggleTableBtn').removeClass('hidden');

    if (!content_row.find('.edit_meeting_notes').length) {
        var div_loader = '<div class="col-md-6 edit_meeting_notes old"><div class="panel_s"><div class="panel-body">' +
            skeleton_loader + '</div></div><div>';
        content_row.append(div_loader);
    } else {
        content_row.find('.edit_meeting_notes').append(div_loader);
        content_row.find('.edit_meeting_notes.old').remove();
    }

    var meeting_notes = $.ajax({
            url: "/teams_meeting_manager/meetings/get_notes/" + appointment_id,
            beforeSend: function(xhr) {
                $('.edit_meeting_notes .panel-body').html(skeleton_loader);
                tmm_app_edit_id = appointment_id;
            }
        })
        .done(function(data) {

            if (data) {
                data = JSON.parse(data);

                var current_topic = $('[data-topic="' + appointment_id + '"]').text();

                tinymce.remove('textarea[name="notes"]');

                setTimeout(() => {
                    content_row.find('.edit_meeting_notes').remove();
                    content_row.append(`
                                        <div class="col-md-6 edit_meeting_notes">
                                             <div class="panel_s">
                                                  <div class="panel-body">
                                                       <div class="panel-heading"> 
                                                       <span class="font-medium">${lang_view_notes}: <strong>${current_topic}</strong></span>
                                                       </div>
                                                  <textarea name="notes" class="ays-ignore">${data.note ? data.note : ''}</textarea>
                                                  <div class="from-group">
                                                       <button class="btn btn-primary mtop10 pull-right" onclick="updateMeetingFormData()">${lang_save}</button>
                                                  </div>
                                             </div>
                                        </div>
                                        <div>`);
                    init_editor('textarea[name="notes"]');
                }, 1000);
            } else {
                alert('Teams session expired, re-authenticating...');
                location.reload();
            }
        });
}


function updateMeetingFormData() {
    var notes = tinyMCE.activeEditor.getContent();
    var $button = $('.edit_meeting_notes .from-group button');

    $.post('/teams_meeting_manager/meetings/update_notes', {
        meeting_id: zmm_app_edit_id,
        notes: notes,
        beforeUpdate() {
            $button.html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
        },
    }).done(function(response) {
        response = JSON.parse(response);
        if (response) {
            alert_float('success', 'Meeting notes was updated successfully');
        }
        $button.html(lang_save);
    });
}

// Show/hide full table
function toggle_meeting_notes_table() {
    $('#toggleTableBtn').addClass('hidden');
    $('.content .row.main_row .col-md-6').removeClass('col-md-6').addClass('col-md-12');
    $('td div.text-center a:first').css('margin', 'auto');

    $('.edit_meeting_notes').remove();
    setTimeout(() => {
        $('.edit_meeting_notes').remove();
    }, 1000);
    $(window).trigger('resize');
}
</script>