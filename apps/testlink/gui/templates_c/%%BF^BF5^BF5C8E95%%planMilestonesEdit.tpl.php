<?php /* Smarty version 2.6.26, created on 2013-10-29 13:39:48
         compiled from plan/planMilestonesEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/planMilestonesEdit.tpl', 7, false),array('function', 'config_load', 'plan/planMilestonesEdit.tpl', 17, false),array('modifier', 'basename', 'plan/planMilestonesEdit.tpl', 16, false),array('modifier', 'replace', 'plan/planMilestonesEdit.tpl', 16, false),array('modifier', 'escape', 'plan/planMilestonesEdit.tpl', 34, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'show_event_history,warning_empty_milestone_name,
                          warning_empty_low_priority_tcases,warning_empty_medium_priority_tcases,
                          warning_empty_high_priority_tcases,info_milestones_date,
                          warning_invalid_percentage_value,warning_must_be_number,
                          btn_cancel,warning,start_date,info_milestones_start_date,
                          th_name,th_date_format,th_perc_a_prio,th_perc_b_prio,th_perc_c_prio,
                          th_perc_testcases,th_delete,alt_delete_milestone,show_calender,
                          clear_date,info_milestone_create_prio,info_milestone_create_no_prio'), $this);?>


<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='plan/planMilestonesEdit.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<?php $this->assign('managerURL', "lib/plan/planMilestonesEdit.php"); ?>
<?php $this->assign('editAction', ($this->_tpl_vars['managerURL'])."?doAction=edit&tplan_id="); ?>
<?php $this->assign('deleteAction', ($this->_tpl_vars['managerURL'])."?doAction=doDelete&tplan_id="); ?>
<?php $this->assign('createAction', ($this->_tpl_vars['managerURL'])."?doAction=create&tplan_id="); ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('jsValidate' => 'yes','openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array('bResetEXTCss' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
'; ?>

// BUGID 3943: Escape all messages (string)
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_invalid_percentage_value = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_invalid_percentage_value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_must_be_number = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_must_be_number'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";

var warning_empty = new Object;
warning_empty.milestone_name  = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_milestone_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
warning_empty.low_priority_tcases = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_low_priority_tcases'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
warning_empty.medium_priority_tcases = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_medium_priority_tcases'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
warning_empty.high_priority_tcases = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_high_priority_tcases'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";



var warning_nonumeric_low_priority_tcases = 'no numeric';
<?php echo '

/*
  function: validateForm
            validate form inputs, doing several checks like:
            - fields that can not be empty

            if some check fails:
            1. an alert message is displayed
            2. background color of offending field is changed.

  args : f: form object

  returns: true  -> all checks ok
           false -> when a check fails
*/

function validateForm(f)
{
  var numeric_check = /[^\\d]/;
  var idx;
  var obj;
  var dummy;

  // Very Important: name and id must be the same for these HTML field
  var fields2check = new Array(\'low_priority_tcases\',\'medium_priority_tcases\',\'high_priority_tcases\');
    
  if (isWhitespace(f.milestone_name.value))
  {
      alert_message(alert_box_title,warning_empty.milestone_name);
      selectField(f, \'milestone_name\');
      return false;
  }

  for(idx=0; idx < fields2check.length; idx++)
  {
      obj = document.getElementById(fields2check[idx]);
      if (isWhitespace(obj.value))
      {
          alert_message(alert_box_title,warning_empty[fields2check[idx]]);
          selectField(f, fields2check[idx]);
          return false;
      }

      dummy = obj.value.trim();   // IMPORTANT: trim is function provided by EXT-JS library
      if(numeric_check.test(dummy))
      {
          alert_message(alert_box_title,warning_must_be_number);
          selectField(f, fields2check[idx]);
          return false;
      }
   
      if(dummy < 0 || dummy > 100)
      {
          alert_message(alert_box_title,warning_invalid_percentage_value);
          selectField(f, fields2check[idx]);
          return false;
      }
  }

}
'; ?>

</script>

</head>

<body class="testlink">

<div class="workBack">
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_update.tpl", 'smarty_include_vars' => array('user_feedback' => $this->_tpl_vars['gui']->user_feedback)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<h2>
	<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->action_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

	<?php if ($this->_tpl_vars['gui']->milestone['id'] > 0): ?>
		<?php if ($this->_tpl_vars['gui']->grants->mgt_view_events == 'yes'): ?>
			<img style="margin-left:5px;" class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/question.gif" 
					onclick="showEventHistoryFor('<?php echo $this->_tpl_vars['gui']->milestone['id']; ?>
','milestones')" 
					alt="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
" title="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
"/>
		<?php endif; ?>
	<?php endif; ?>
	</h2>

	<form method="post" action="lib/plan/planMilestonesEdit.php"
	      name="milestone_mgr" onSubmit="javascript:return validateForm(this);">
	
	    <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['gui']->milestone['id']; ?>
"/>
	    <table class="common" style="width:80%">
		      <tr>
			    <th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_name']; ?>
</th>
	        		<td>
	        			<input type="text" id="milestone_name" name="milestone_name" size="<?php echo $this->_config[0]['vars']['MILESTONE_NAME_SIZE']; ?>
"
                	  	 maxlength="<?php echo $this->_config[0]['vars']['MILESTONE_NAME_MAXLEN']; ?>
"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->milestone['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
	              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'milestone_name')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        		</td>
    	    </tr>
    	    
 	    		<tr>
			    <th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_date_format']; ?>
</th>
			        <td>
	                <input type="text" 
	                       name="target_date" id="target_date" 
					       value="<?php echo $this->_tpl_vars['gui']->milestone['target_date']; ?>
" required />
					<img title="<?php echo $this->_tpl_vars['labels']['show_calender']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/calendar.gif"
					     onclick="showCal('target_date-cal','target_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" >
					<img title="<?php echo $this->_tpl_vars['labels']['clear_date']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/trash.png"
			             onclick="javascript:var x = document.getElementById('target_date'); x.value = '';" >
					<div id="target_date-cal" style="position:absolute;width:240px;left:300px;z-index:1;"></div>
             		<span class="italic"><?php echo $this->_tpl_vars['labels']['info_milestones_date']; ?>
</span>
		      	</td>
			    </tr>
	 	    	<tr>

			    <th style="background:none;"><?php echo $this->_tpl_vars['labels']['start_date']; ?>
</th>
			        <td>
			        	                <input type="text" 
	                       name="start_date" id="start_date" 
					       value="<?php echo $this->_tpl_vars['gui']->milestone['start_date']; ?>
" />
					<img title="<?php echo $this->_tpl_vars['labels']['show_calender']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/calendar.gif"
					     onclick="showCal('start_date-cal','start_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" >
					<img title="<?php echo $this->_tpl_vars['labels']['clear_date']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/trash.png"
			             onclick="javascript:var x = document.getElementById('start_date'); x.value = '';" >
					<div id="start_date-cal" style="position:absolute;width:240px;left:300px;z-index:1;"></div>
             		<span class="italic"><?php echo $this->_tpl_vars['labels']['info_milestones_start_date']; ?>
</span>
		      	</td>
		      </tr>

          <?php if ($this->_tpl_vars['session'] ['testprojectOptions']->testPriorityEnabled): ?>
		          <tr>
		          	<th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_perc_a_prio']; ?>
:</th>
		          	<td>
		          		<input type="text" id="low_priority_tcases" name="low_priority_tcases" 
		          		       size="<?php echo $this->_config[0]['vars']['PRIORITY_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['PRIORITY_MAXLEN']; ?>
" 
		          		       value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->milestone['high_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
	                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'low_priority_tcases')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		          	</td>
		          </tr>
		          <tr>
		          	<th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_perc_b_prio']; ?>
:</th>
		          	<td>
		          		<input type="text" id="medium_priority_tcases" name="medium_priority_tcases" 
		          		       size="<?php echo $this->_config[0]['vars']['PRIORITY_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['PRIORITY_MAXLEN']; ?>
" 
		          		       value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->milestone['medium_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
	                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'medium_priority_tcases')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		          	</td>
		          </tr>
		          <tr>
		          	<th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_perc_c_prio']; ?>
:</th>
		          	<td>
		          		<input type="text" id="high_priority_tcases" name="high_priority_tcases" 
		          		       size="<?php echo $this->_config[0]['vars']['PRIORITY_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['PRIORITY_MAXLEN']; ?>
" 
		          		       value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->milestone['low_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
	                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'high_priority_tcases')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		          	</td>
		          </tr>
		       
		      <?php else: ?>
		      		<tr>
			        	<th style="background:none;"><?php echo $this->_tpl_vars['labels']['th_perc_testcases']; ?>
:</th>
			          <td>
			          	<input type="hidden" name="low_priority_tcases" id="low_priority_tcases" value="0"/>
			          	<input type="hidden" name="high_priority_tcases" id="high_priority_tcases" value="0"/>
			          	<input type="text" name="medium_priority_tcases" id="medium_priority_tcases" 
			          	       size="<?php echo $this->_config[0]['vars']['PRIORITY_SIZE']; ?>
"  maxlength="<?php echo $this->_config[0]['vars']['PRIORITY_MAXLEN']; ?>
" 
			          	       value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->milestone['medium_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
			          </td>
		         </tr>
          <?php endif; ?>
      </table>


	<div class="groupBtn">
		<input type="hidden" id="doAction" name="doAction" value="" />
		<input type="submit" id="create" name="create" value="<?php echo $this->_tpl_vars['gui']->submit_button_label; ?>
"
	         onclick="doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
'" />
		<input type="button" id="go_back" name="go_back" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
" 
			     onclick="javascript: history.back();"/>
	</div>
	</form>
	
		<br />
	<?php if ($this->_tpl_vars['session'] ['testprojectOptions']->testPriorityEnabled): ?>
		<p class="italic"><?php echo $this->_tpl_vars['labels']['info_milestone_create_prio']; ?>
</p>
	<?php else: ?>
		<p class="italic"><?php echo $this->_tpl_vars['labels']['info_milestone_create_no_prio']; ?>
</p>
	<?php endif; ?>
	
</div>
</body>
</html>