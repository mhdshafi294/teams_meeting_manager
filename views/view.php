<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
/**
 * Current meeting
 */
init_head();
?>


<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div style="display: flex;justify-content:center;">
                            <div class="meeting_info_headers">
                                <h4>Meeting Information</h4>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4><strong>Subject:</strong> <?= $meeting["subject"] ?></h4>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rel_type" class="control-label"><?php echo _l('task_related_to'); ?></label>
                                        <select name="rel_type" class="selectpicker" id="rel_type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <option value=""></option>
                                            <option value="project" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                        if ($relation['rel_type'] == 'project') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>>
                                                <?php echo _l('project'); ?></option>
                                            <option value="invoice" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                        if ($relation['rel_type'] == 'invoice') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>>
                                                <?php echo _l('invoice'); ?>
                                            </option>
                                            <option value="customer" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                            if ($relation['rel_type'] == 'customer') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>
                                                <?php echo _l('client'); ?>
                                            </option>
                                            <option value="estimate" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                            if ($relation['rel_type'] == 'estimate') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>
                                                <?php echo _l('estimate'); ?>
                                            </option>
                                            <option value="contract" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                            if ($relation['rel_type'] == 'contract') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>
                                                <?php echo _l('contract'); ?>
                                            </option>
                                            <option value="ticket" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                        if ($relation['rel_type'] == 'ticket') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>>
                                                <?php echo _l('ticket'); ?>
                                            </option>
                                            <option value="expense" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                        if ($relation['rel_type'] == 'expense') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>>
                                                <?php echo _l('expense'); ?>
                                            </option>
                                            <option value="lead" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                        if ($relation['rel_type'] == 'lead') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>>
                                                <?php echo _l('lead'); ?>
                                            </option>
                                            <option value="proposal" <?php if (isset($relation['rel_type']) || $this->input->get('rel_type')) {
                                                                            if ($relation['rel_type'] == 'proposal') {
                                                                                echo 'selected';
                                                                            }
                                                                        } ?>>
                                                <?php echo _l('proposal'); ?>
                                            </option>
                                            <?php
                                            hooks()->do_action('task_modal_rel_type_select', ['task' => (isset($task) ? $task : 0), 'rel_type' => $relation['rel_type']]);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group<?php if ($relation['rel_id'] == '') {
                                                                echo ' hide';
                                                            } ?>" id="rel_id_wrapper">
                                        <label for="rel_id" class="control-label"><span class="rel_id_label"></span></label>
                                        <div id="rel_id_select">
                                            <select name="rel_id" id="rel_id" class="ajax-sesarch" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                <?php if ($relation['rel_id'] != '' && $relation['rel_type'] != '') {
                                                    $rel_data = get_relation_data($relation['rel_type'], $relation['rel_id']);
                                                    $rel_val = get_relation_values($rel_data, $relation['rel_type']);
                                                    echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-info" onclick="updateMeetingRelation(this)" data-id="<?= $meeting["id"]; ?>">Save
                                </button>
                            </div>
                            <hr>
                            <div class="form-group">
                                <h4><strong>Description:</strong>
                                    <?php
                                    $position = strpos($meeting["bodyPreview"], "___");
                                    if (!$position == 0) {
                                        $position = strpos($meeting["bodyPreview"], "\r\n");
                                        $result = substr($meeting["bodyPreview"], 0, $position);
                                    } else {
                                        $result = 'No Discription';
                                    }
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Meeting Date:</strong>
                                    <?php
                                    $position = strpos($meeting["start"]["dateTime"], 'T');
                                    $result = substr($meeting["start"]["dateTime"], 0, $position);
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Start Time:</strong>
                                    <?php
                                    $position1 = strpos($meeting["start"]["dateTime"], 'T');
                                    $result = substr($meeting["start"]["dateTime"], $position1 + 1, 5);
                                    echo $result;
                                    ?>
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>End Time:</strong>
                                    <?php
                                    $position1 = strpos($meeting["end"]["dateTime"], 'T');
                                    $result = substr($meeting["end"]["dateTime"], $position1 + 1, 5);
                                    echo $result;
                                    ?>
                                    <!-- <?php
                                            $startDate = new DateTime($meeting["start"]["dateTime"]);
                                            $endDate = new DateTime($meeting["end"]["dateTime"]);
                                            $duration = $startDate->diff($endDate);
                                            ?>
                                <?= $duration->h . " hours " . $duration->m . " minutes "; ?> -->
                                </h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Time Zone:</strong> <?= $meeting["originalStartTimeZone"]; ?></h4>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h4>
                                    <a href="<?= str_replace('j/', 'wc/join/', $meeting["onlineMeeting"]["joinUrl"]); ?>" target="_blank">
                                        <strong>Join URL</strong>
                                    </a>
                                </h4>
                                <hr>
                            </div>

                            <div class="form-group">
                                <h4><strong>Meeting Type:</strong>
                                    <?= $meeting["type"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Organizer:</strong>
                                    <?= $meeting["organizer"]["emailAddress"]["name"] ?></h4>
                                <hr>
                            </div>
                            <div class="form-group">
                                <h4><strong>Allow participants to join the meeting before the host starts the
                                        meeting:</strong>
                                    Yes</h4>
                                <hr>
                            </div>

                            <div class="form-group">
                                <h4><strong>Attendees:</strong>
                                    <?php
                                    foreach ($meeting["attendees"] as $attend) {
                                        echo '<br>' . $attend["emailAddress"]["name"];
                                    }
                                    ?>
                                    <hr>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <a href="<?= admin_url('teams_meeting_manager/meetings/index'); ?>" class="btn btn-default btn-xs">Back To Meetings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php init_tail(); ?>
<script>
    /**
     * Just toggles the menu to be active
     */
    $('.menu-item-teams_meeting_manager').toggleClass('active');
</script>

<script>
    var _rel_id = $('#rel_id'),
        _rel_type = $('#rel_type'),
        _rel_id_wrapper = $('#rel_id_wrapper'),
        _current_member = undefined,
        data = {};

    var _milestone_selected_data;
    _milestone_selected_data = undefined;

    <?php if (get_option('new_task_auto_assign_current_member') == '1') { ?>
        _current_member = "<?php echo get_staff_user_id(); ?>";
    <?php } ?>
    $(function() {

        $("body").off("change", "#rel_id");

        var inner_popover_template =
            '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>';

        $('#_task_modal .task-menu-options .trigger').popover({
            html: true,
            placement: "bottom",
            trigger: 'click',
            title: "<?php echo _l('actions'); ?>",
            content: function() {
                return $('body').find('#_task_modal .task-menu-options .content-menu').html();
            },
            template: inner_popover_template
        });

        custom_fields_hyperlink();

        appValidateForm($('#task-form'), {
            name: 'required',
            startdate: 'required',
            repeat_every_custom: {
                min: 1
            },
        }, task_form_handler);

        $('.rel_id_label').html(_rel_type.find('option:selected').text());

        _rel_type.on('change', function() {

            var clonedSelect = _rel_id.html('').clone();
            _rel_id.selectpicker('destroy').remove();
            _rel_id = clonedSelect;
            $('#rel_id_select').append(clonedSelect);
            $('.rel_id_label').html(_rel_type.find('option:selected').text());

            task_rel_select();
            if ($(this).val() != '') {
                _rel_id_wrapper.removeClass('hide');
            } else {
                _rel_id_wrapper.addClass('hide');
            }
            init_project_details(_rel_type.val());
        });

        init_datepicker();
        init_color_pickers();
        init_selectpicker();
        task_rel_select();

        var _allAssigneeSelect = $("#assignees").html();

        $('body').on('change', '#rel_id', function() {
            if ($(this).val() != '') {
                if (_rel_type.val() == 'project') {
                    $.get(admin_url + 'projects/get_rel_project_data/' + $(this).val() + '/' + taskid,
                        function(project) {
                            $("select[name='milestone']").html(project.milestones);
                            if (typeof(_milestone_selected_data) != 'undefined') {
                                $("select[name='milestone']").val(_milestone_selected_data.id);
                                $('input[name="duedate"]').val(_milestone_selected_data.due_date)
                            }
                            $("select[name='milestone']").selectpicker('refresh');

                            $("#assignees").html(project.assignees);
                            if (typeof(_current_member) != 'undefined') {
                                $("#assignees").val(_current_member);
                            }
                            $("#assignees").selectpicker('refresh')
                            if (project.billing_type == 3) {
                                $('.task-hours').addClass('project-task-hours');
                            } else {
                                $('.task-hours').removeClass('project-task-hours');
                            }

                            if (project.deadline) {
                                var $duedate = $('#_task_modal #duedate');
                                var currentSelectedTaskDate = $duedate.val();
                                $duedate.attr('data-date-end-date', project.deadline);
                                $duedate.datetimepicker('destroy');
                                init_datepicker($duedate);

                                if (currentSelectedTaskDate) {
                                    var dateTask = new Date(unformat_date(currentSelectedTaskDate));
                                    var projectDeadline = new Date(project.deadline);
                                    if (dateTask > projectDeadline) {
                                        $duedate.val(project.deadline_formatted);
                                    }
                                }
                            } else {
                                reset_task_duedate_input();
                            }
                            init_project_details(_rel_type.val(), project.allow_to_view_tasks);
                        }, 'json');



                } else {
                    reset_task_duedate_input();
                }
            }
        });

        /*  <
         !-- -- > <?php //if (!isset($task) && $rel_id != '') { 
                    ?>
         //            _rel_id.change();
         //        <?php //} 
                    ?> */

        _rel_type.on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            if (previousValue == 'project') {
                $("#assignees").html(_allAssigneeSelect);
                if (typeof(_current_member) != 'undefined') {
                    $("#assignees").val(_current_member);
                }
                $("#assignees").selectpicker('refresh')
            }
        });

    });

    <?php if (isset($_milestone_selected_data)) { ?>
        _milestone_selected_data = '<?php echo json_encode($_milestone_selected_data); ?>';
        _milestone_selected_data = JSON.parse(_milestone_selected_data);
    <?php } ?>

    function task_rel_select() {
        var serverData = {};
        serverData.rel_id = _rel_id.val();
        data.type = _rel_type.val();
        init_ajax_search(_rel_type.val(), _rel_id, serverData);
    }

    function init_project_details(type, tasks_visible_to_customer) {
        var wrap = $('.non-project-details');
        var wrap_task_hours = $('.task-hours');
        if (type == 'project') {
            if (wrap_task_hours.hasClass('project-task-hours') == true) {
                wrap_task_hours.removeClass('hide');
            } else {
                wrap_task_hours.addClass('hide');
            }
            wrap.addClass('hide');
            $('.project-details').removeClass('hide');
        } else {
            wrap_task_hours.removeClass('hide');
            wrap.removeClass('hide');
            $('.project-details').addClass('hide');
            $('.task-visible-to-customer').addClass('hide').prop('checked', false);
        }
        if (typeof(tasks_visible_to_customer) != 'undefined') {
            if (tasks_visible_to_customer == 1) {
                $('.task-visible-to-customer').removeClass('hide');
                $('.task-visible-to-customer input').prop('checked', true);
            } else {
                $('.task-visible-to-customer').addClass('hide')
                $('.task-visible-to-customer input').prop('checked', false);
            }
        }
    }

    function reset_task_duedate_input() {
        var $duedate = $('#_task_modal #duedate');
        $duedate.removeAttr('data-date-end-date');
        $duedate.datetimepicker('destroy');
        init_datepicker($duedate);
    }
</script>

<script>
    function updateMeetingRelation(e) {

        var meeting_id = jQuery(e).attr('data-id');
        var rel_type = $("#rel_type").val();
        var rel_id = $("#rel_id").val();
        var url = "<?= admin_url('teams_meeting_manager/meetings/update_related') ?>";

        $.post(url, {
            meeting_id: meeting_id,
            rel_type: rel_type,
            rel_id: rel_id
        }).done(function(data) {
            alert_float('success', 'Meeting related was updated successfully');
        });

    }
</script>

</body>

</html>