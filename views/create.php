<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
     <div class="content">
          <div class="row">
               <form name="meeting-form" action="<?= admin_url('teams_meeting_manager/meetings/create'); ?>" method="POST">
                    <div class="col-md-12">
                         <div class="panel_s">
                              <div class="panel-body">
                                   <h4> Select participants / registrants
                                        <small> optional </small>
                                   </h4>
                                   <hr class="hr-panel-heading">
                                   <div class="col-md-12">
                                        <div class="row">
                                             <div class="col-md-4">
                                                  <div class="form-group" id="select_contacts">
                                                       <input type="text" hidden id="rel_contact_type" value="contacts">
                                                       <label for="rel_contact_id">Contacts</label>
                                                       <div id="rel_contact_id_select">
                                                            <select name="contacts[]" id="rel_contact_id" multiple="true" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                 <?php
                                                                 if ($rel_contact_id != '' && $rel_contact_type != '') {
                                                                      $rel_cdata = get_relation_data($rel_contact_type, $rel_contact_id);
                                                                      $rel_c_val = get_relation_values($rel_cdata, $rel_contact_type);
                                                                      echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_c_val['name'] . '</option>';
                                                                 }
                                                                 ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="form-group select-placeholder" id="rel_id_wrapper">
                                                       <input type="text" hidden id="rel_lead_type" value="leads">
                                                       <label for="rel_id"><?= _l('leads'); ?></label>
                                                       <div id="rel_id_select">
                                                            <select name="leads[]" id="rel_id" multiple="true" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                                 <?php
                                                                 if ($rel_id != '' && $rel_type != '') {
                                                                      $rel_data = get_relation_data($rel_type, $rel_id);
                                                                      $rel_val = get_relation_values($rel_data, $rel_type);
                                                                      echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                                                 } ?>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="col-md-4">
                                                  <div class="form-group">
                                                       <?php echo render_select('staff[]', $staff_members, array('staffid', array('firstname', 'lastname')), 'staff', [], array('multiple' => true), array(), '', '', false); ?>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <hr class="hr-panel-heading">
                                   <div class="col-md-12 no-padding">
                                        <h4>Schedule a Meeting</h4>
                                        <span>Note: All meetings created will be stored into MS Teams Servers Database</span>
                                        <hr>
                                        <input type="hidden" name="<?php echo get_instance()->security->get_csrf_token_name(); ?>" value="<?php echo get_instance()->security->get_csrf_hash(); ?>">
                                        <div class="col-md-6">
                                             <h4 class="mfont-bold-medium-size mtop1">General</h4>
                                             <hr>
                                             <div class="form-group">
                                                  <label for="topic"><small class="req text-danger">* </small>Topic</label>
                                                  <input type="text" name="topic" class="form-control" id="topic" placeholder="Topic">
                                             </div>
                                             <div class="form-group">
                                                  <label for="description">Description (optional)</label>
                                                  <textarea name="description" class="form-control" id="description" placeholder="Description (optional)"></textarea>
                                             </div>
                                             <div class="form-group">
                                                  <div class="form-group" app-field-wrapper="date">
                                                       <label for="date" class="control-label">
                                                            <small class="req text-danger">* </small>When
                                                       </label>
                                                       <div class="input-group date">
                                                            <input type="text" id="date" name="date" class="form-control datetimepicker meeting-date" readonly="readonly" autocomplete="off">
                                                            <div class="input-group-addon">
                                                                 <i class="fa fa-calendar calendar-icon"></i>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <hr>
                                             <h4 class="mfont-bold-medium-size">Duration</h4>
                                             <hr>
                                             <div class="form-group hour_mins">
                                                  <div class="pull-left">
                                                       <span>Hour</span>
                                                       <select class="selectpicker" name="hour" id="metting_hours">
                                                            <option value="0" selected>0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                            <option value="24">24</option>
                                                       </select>

                                                       <div class="clearfix"></div>
                                                       <br>

                                                       <label for="minutes">Minutes</label>
                                                       <select class=" selectpicker" name="minutes" id="minutes">
                                                            <option value="0">0</option>
                                                            <option value="15">15</option>
                                                            <option value="30" selected>30</option>
                                                            <option value="45">45</option>
                                                       </select>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                  <br>
                                                  <br>
                                                  <div class="timezone_parent pull-left">
                                                       <label for="timezones" id="timezones_label" class="control-label">Timezone</label>
                                                       <select name="timezone" id="timezones" class="form-control selectpicker" data-live-search="true">
                                                            <?php foreach (get_timezones_list() as $key => $timezones) { ?>
                                                                 <optgroup label="<?php echo $key; ?>">
                                                                      <?php foreach ($timezones as $timezone) { ?>
                                                                           <option value="<?php echo $timezone; ?>"><?php echo $timezone; ?></option>
                                                                      <?php } ?>
                                                                 </optgroup>
                                                            <?php } ?>
                                                       </select>
                                                  </div>
                                                  <div class="clearfix"></div>
                                             </div>
                                             <hr>
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                        <div class="clearfix"></div>
                                        <hr class="hr-panel-heading">
                                        <a href="<?= admin_url('teams_meeting_manager/meetings/login'); ?>" class="btn btn-default btn-xs">Back To Meetings</a>
                                        <button type="submit" id="btnScheduleMeeting" class="btn btn-primary btn-xs pull-right">Schedule</button>

                                   </div>
                              </div>
                         </div>
                    </div>
               </form>
          </div>
     </div>
</div>
<?php init_tail(); ?>
<!-- Include create js functionality file -->
<?php require('modules/teams_meeting_manager/assets/js/create_js.php'); ?>
</body>

</html>