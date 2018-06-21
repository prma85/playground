<?php /* Smarty version 2.6.26, created on 2014-03-31 16:53:17
         compiled from testcases/containerDeleteTC.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'testcases/containerDeleteTC.tpl', 10, false),array('modifier', 'escape', 'testcases/containerDeleteTC.tpl', 26, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'th_test_case,th_id,title_move_cp,title_move_cp_testcases,sorry_further,
             check_uncheck_all_checkboxes,btn_delete,th_linked_to_tplan,th_version,
             platform,th_executed,choose_target,copy_keywords,btn_move,warning,btn_cp,
             execution_history,design'), $this);?>


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

//BUGID 3943: Escape all messages (string)
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
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->object_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </h1>

<div class="workBack">
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<?php if ($this->_tpl_vars['gui']->op_ok == false): ?>
	<?php echo $this->_tpl_vars['gui']->user_feedback; ?>

<?php else: ?>
	<form id="delete_testcases" name="delete_testcases" method="post"
	      action="lib/testcases/containerEdit.php?objectID=<?php echo $this->_tpl_vars['gui']->objectID; ?>
">
    <input type="hidden" name="do_delete_testcases"  id="do_delete_testcases"  value="1" />

    <?php if ($this->_tpl_vars['gui']->user_feedback != ''): ?>
      <div class="user_feedback"><?php echo $this->_tpl_vars['gui']->user_feedback; ?>
</div>
      <br />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['gui']->system_message != ''): ?>
      <div class="user_feedback"><?php echo $this->_tpl_vars['gui']->system_message; ?>
</div>
      <br />
    <?php endif; ?>

		        <input type="hidden" name="add_value_memory"  id="add_value_memory"  value="0" />
		<div id="delete_checkboxes">
        <table class="simple">
          <tr>
          <th class="clickable_icon">
			         <img src="<?php echo @TL_THEME_IMG_DIR; ?>
/toggle_all.gif"
			              onclick='cs_all_checkbox_in_div("delete_checkboxes","tcaseSet_","add_value_memory");'
                    title="<?php echo $this->_tpl_vars['labels']['check_uncheck_all_checkboxes']; ?>
" />
			    </th>
          <th><?php echo $this->_tpl_vars['labels']['th_test_case']; ?>
</th>
          </tr>
          
        <?php $_from = $this->_tpl_vars['gui']->testCaseSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rowid'] => $this->_tpl_vars['tcinfo']):
?>
            <tr>
                <td>
					<?php if ($this->_tpl_vars['tcinfo']['draw_check']): ?>
                    	<input type="checkbox" name="tcaseSet[]" id="tcaseSet_<?php echo $this->_tpl_vars['tcinfo']['id']; ?>
" value="<?php echo $this->_tpl_vars['tcinfo']['id']; ?>
" />
                    <?php endif; ?>	
                </td>
                <td>
                    <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/history_small.png"
                         onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['tcinfo']['id']; ?>
);"
                         title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
                    <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/edit_icon.png"
                         onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['tcinfo']['id']; ?>
);"
                         title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['tcinfo']['external_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['gsmarty_gui']->title_separator_1; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tcinfo']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                </td>
            </tr>
            <?php if ($this->_tpl_vars['gui']->exec_status_quo[$this->_tpl_vars['rowid']] != ''): ?>
            <tr>
            <td>&nbsp;</td>
            <td>
	                      <table class="simple_tableruler">
	                  		<tr>
	                  			<th><?php echo $this->_tpl_vars['labels']['th_version']; ?>
</th>
	                  			<th><?php echo $this->_tpl_vars['labels']['th_linked_to_tplan']; ?>
</th>
	                  			<?php if ($this->_tpl_vars['gui']->display_platform[$this->_tpl_vars['rowid']]): ?><th><?php echo $this->_tpl_vars['labels']['platform']; ?>
</th> <?php endif; ?>
	                  			<th><?php echo $this->_tpl_vars['labels']['th_executed']; ?>
</th>
	                  			</tr>
	                  		<?php $_from = $this->_tpl_vars['gui']->exec_status_quo[$this->_tpl_vars['rowid']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['testcase_version_id'] => $this->_tpl_vars['on_tplan_status']):
?>
	                  			<?php $_from = $this->_tpl_vars['on_tplan_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tplan_id'] => $this->_tpl_vars['status_on_platform']):
?>
	                  				<?php $_from = $this->_tpl_vars['status_on_platform']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['platform_id'] => $this->_tpl_vars['status']):
?>
	                  			    <tr>
	                  				    <td style="width:4%;text-align:right;"><?php echo $this->_tpl_vars['status']['version']; ?>
</td>
	                  				    <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['status']['tplan_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	                  			      <?php if ($this->_tpl_vars['gui']->display_platform[$this->_tpl_vars['rowid']]): ?>
	                  			        <td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['status']['platform_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	                  			      <?php endif; ?>
	                  				    <td style="width:4%;text-align:center;"><?php if ($this->_tpl_vars['status']['executed'] != ""): ?><img src="<?php echo @TL_THEME_IMG_DIR; ?>
/apply_f2_16.png" /><?php endif; ?></td>
	                  				  </tr>
	                  			  <?php endforeach; endif; unset($_from); ?>
	                  			<?php endforeach; endif; unset($_from); ?>
	                  		<?php endforeach; endif; unset($_from); ?>
	                      </table>
            </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        </table>
        <br />
    </div>




		<div>
			<input type="submit" name="do_delete_testcases" value="<?php echo $this->_tpl_vars['labels']['btn_delete']; ?>
">
		</div>

	</form>
<?php endif; ?>

</div>
<?php if ($this->_tpl_vars['gui']->refreshTree): ?>
   	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</body>
</html>