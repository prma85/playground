<?php /* Smarty version 2.6.26, created on 2013-10-29 14:21:49
         compiled from testcases/containerMoveTC.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'testcases/containerMoveTC.tpl', 11, false),array('function', 'html_options', 'testcases/containerMoveTC.tpl', 75, false),array('modifier', 'escape', 'testcases/containerMoveTC.tpl', 25, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'th_test_case,th_id,title_move_cp,title_move_cp_testcases,sorry_further,
             check_uncheck_all_checkboxes,warning,execution_history,design,
             choose_target,copy_keywords,btn_move,btn_cp,summary,btn_copy_ghost_zone'), $this);?>


<?php echo lang_get_smarty(array('s' => 'select_at_least_one_testcase','var' => 'check_msg'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_jsCheckboxes.tpl", 'smarty_include_vars' => array()));
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

var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
<?php echo '

/*
  function: check_action_precondition

  args :

  returns:

*/
function check_action_precondition(container_id,action,msg)
{
	var containerSelect = document.getElementById(\'containerID\');
	if(checkbox_count_checked(container_id) > 0 && containerSelect.value > 0)
	{
	     return true;
	}
	else
	{
	   alert_message(alert_box_title,msg);
	   return false;
	}
}
</script>
'; ?>

</head>

<body>
<?php echo lang_get_smarty(array('s' => $this->_tpl_vars['level'],'var' => 'level_translated'), $this);?>

<h1 class="title"><?php echo $this->_tpl_vars['level_translated']; ?>
<?php echo @TITLE_SEP; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['object_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </h1>

<div class="workBack">
<?php if (! $this->_tpl_vars['testCasesTableView']): ?>    
  <h1 class="title"><?php echo $this->_tpl_vars['labels']['title_move_cp_testcases']; ?>
</h1>
<?php endif; ?>

<?php if ($this->_tpl_vars['op_ok'] == false): ?>
	<?php echo $this->_tpl_vars['user_feedback']; ?>

<?php else: ?>
	<form id="move_copy_testcases" name="move_copy_testcases" method="post"
	      action="lib/testcases/containerEdit.php?objectID=<?php echo $this->_tpl_vars['objectID']; ?>
">

    <?php if (! $this->_tpl_vars['testCasesTableView']): ?>    
      <?php if ($this->_tpl_vars['user_feedback'] != ''): ?>
        <div class="user_feedback"><?php echo $this->_tpl_vars['user_feedback']; ?>
</div>
        <br />
      <?php endif; ?>
  		<p><?php echo $this->_tpl_vars['labels']['choose_target']; ?>
:
  			<select name="containerID" id="containerID">
  				  <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['containers']), $this);?>

  			</select>
  		</p>
  		<p>
  			<input type="checkbox" name="copyKeywords" checked="checked" value="1" />
  			<?php echo $this->_tpl_vars['labels']['copy_keywords']; ?>

  		</p>
    <?php endif; ?>

		        <input type="hidden" name="add_value_memory"  id="add_value_memory"  value="0" />
		<div id="move_copy_checkboxes">
        <table class="simple">
          <tr>
          <?php if (! $this->_tpl_vars['testCasesTableView']): ?>  
          <th class="clickable_icon">
			         <img src="<?php echo @TL_THEME_IMG_DIR; ?>
/toggle_all.gif"
			              onclick='cs_all_checkbox_in_div("move_copy_checkboxes","tcaseSet_","add_value_memory");'
                    title="<?php echo $this->_tpl_vars['labels']['check_uncheck_all_checkboxes']; ?>
" />
			    </th>
          <?php endif; ?>
          <th><?php echo $this->_tpl_vars['labels']['th_test_case']; ?>
</th>
          <th><?php echo $this->_tpl_vars['labels']['summary']; ?>
</th>
          </tr>
          
        <?php $_from = $this->_tpl_vars['testcases']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rowid'] => $this->_tpl_vars['tcinfo']):
?>
            <tr>
              <?php if (! $this->_tpl_vars['testCasesTableView']): ?>  
                <td>
                    <input type="checkbox" name="tcaseSet[]" id="tcaseSet_<?php echo $this->_tpl_vars['tcinfo']['tcid']; ?>
" value="<?php echo $this->_tpl_vars['tcinfo']['tcid']; ?>
" />
                </td>
              <?php endif; ?>
                <td>
                    <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/history_small.png"
                         onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['tcinfo']['tcid']; ?>
);"
                         title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
                    <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/edit_icon.png"
                         onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['tcinfo']['tcid']; ?>
);"
                         title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['tcprefix'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tcinfo']['tcexternalid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['gsmarty_gui']->title_separator_1; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tcinfo']['tcname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                </td>
                <td style="width:60%;">
                  <?php echo $this->_tpl_vars['tcinfo']['summary']; ?>

                </td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        <br />
    </div>

    <?php if (! $this->_tpl_vars['testCasesTableView']): ?>    
		<div>
			<input type="submit" name="do_move_tcase_set" value="<?php echo $this->_tpl_vars['labels']['btn_move']; ?>
"
             onclick="return check_action_precondition('move_copy_checkboxes','move','<?php echo $this->_tpl_vars['check_msg']; ?>
');"  />

			<input type="submit" name="do_copy_tcase_set" value="<?php echo $this->_tpl_vars['labels']['btn_cp']; ?>
"
			       onclick="return check_action_precondition('move_copy_checkboxes','copy','<?php echo $this->_tpl_vars['check_msg']; ?>
');"  />

      <input type="submit" name="do_copy_tcase_set_ghost" value="<?php echo $this->_tpl_vars['labels']['btn_copy_ghost_zone']; ?>
"
             onclick="return check_action_precondition('move_copy_checkboxes','copy','<?php echo $this->_tpl_vars['check_msg']; ?>
');"  />

			<input type="hidden" name="old_containerID" value="<?php echo $this->_tpl_vars['old_containerID']; ?>
" />
		</div>
    <?php endif; ?>
	</form>
<?php endif; ?>

</div>
<?php if ($this->_tpl_vars['refreshTree']): ?>
   	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
</body>
</html>