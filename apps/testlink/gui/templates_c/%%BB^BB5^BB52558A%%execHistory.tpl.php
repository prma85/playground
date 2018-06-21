<?php /* Smarty version 2.6.26, created on 2013-10-25 14:09:28
         compiled from execute/execHistory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'execute/execHistory.tpl', 8, false),array('function', 'cycle', 'execute/execHistory.tpl', 67, false),array('function', 'localize_timestamp', 'execute/execHistory.tpl', 75, false),array('function', 'localize_tc_status', 'execute/execHistory.tpl', 92, false),array('modifier', 'escape', 'execute/execHistory.tpl', 43, false),)), $this); ?>
	
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'title_test_case,th_test_case_id,version,date_time_run,platform,test_exec_by,
             exec_status,testcaseversion,attachment_mgmt,deleted_user,build,testplan,
             execution_type_manual,execution_type_auto,run_mode,exec_notes,edit_execution'), $this);?>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script>
<?php echo '
panel_init_functions = new Array();
Ext.onReady(function() {
	for(var gdx=0; gdx<panel_init_functions.length;gdx++) {
		panel_init_functions[gdx]();
	}
});

function load_notes(panel,exec_id)
{
  var url2load=fRoot+\'lib/execute/getExecNotes.php?readonly=1&exec_id=\' + exec_id;
  panel.load({url:url2load});
}
'; ?>

</script>
</head>

<?php $this->assign('attachment_model', $this->_tpl_vars['gui']->exec_cfg->att_model); ?>
<?php $this->assign('my_colspan', $this->_tpl_vars['attachment_model']->num_cols+2); ?>

<body onUnload="storeWindowSize('execHistoryPopup')">
<?php if ($this->_tpl_vars['gui']->main_descr != ''): ?>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br></h1>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->detailed_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br></h1>
<?php endif; ?>
<div class="workBack">
	<?php if ($this->_tpl_vars['gui']->warning_msg == ''): ?>
		<table cellspacing="0" class="exec_history">
			 
			<tr>
				<th style="text-align:left"><?php echo $this->_tpl_vars['labels']['date_time_run']; ?>
</th>
				<th style="text-align:left"><?php echo $this->_tpl_vars['labels']['testplan']; ?>
</th>
				<th style="text-align:left"><?php echo $this->_tpl_vars['labels']['build']; ?>
</th>
				<?php if ($this->_tpl_vars['gui']->displayPlatformCol): ?>
					<?php $this->assign('my_colspan', $this->_tpl_vars['my_colspan']+1); ?>
					<th style="text-align:left"><?php echo $this->_tpl_vars['labels']['platform']; ?>
</th>
				<?php endif; ?>
				<th style="text-align:left"><?php echo $this->_tpl_vars['labels']['test_exec_by']; ?>
</th>
				<th style="text-align:center"><?php echo $this->_tpl_vars['labels']['exec_status']; ?>
</th>
				<th style="text-align:center"><?php echo $this->_tpl_vars['labels']['testcaseversion']; ?>
</th>
				<th style="text-align:left"><nobr><?php echo $this->_tpl_vars['labels']['run_mode']; ?>
</nobr></th>
			</tr>
		
					 	<?php $_from = $this->_tpl_vars['gui']->execSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tcv_exec_set']):
?>
		 		<?php $_from = $this->_tpl_vars['tcv_exec_set']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tcv_exec']):
?>
					<?php echo smarty_function_cycle(array('values' => '#eeeeee,#d0d0d0','assign' => 'bg_color'), $this);?>

					<tr style="border-top:1px solid black; background-color: <?php echo $this->_tpl_vars['bg_color']; ?>
">
						<td>
							<?php if ($this->_tpl_vars['gui']->exec_cfg->edit_notes): ?>
								<img src="<?php echo @TL_THEME_IMG_DIR; ?>
/note_edit.png" style="vertical-align:middle" 
								     title="<?php echo $this->_tpl_vars['labels']['edit_execution']; ?>
" onclick="javascript: openExecEditWindow(
								     <?php echo $this->_tpl_vars['tcv_exec']['execution_id']; ?>
,<?php echo $this->_tpl_vars['tcv_exec']['id']; ?>
,<?php echo $this->_tpl_vars['tcv_exec']['testplan_id']; ?>
,<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
);">
							<?php endif; ?>
							<?php echo localize_timestamp_smarty(array('ts' => $this->_tpl_vars['tcv_exec']['execution_ts']), $this);?>

						</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['tcv_exec']['testplan_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
						<td>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['tcv_exec']['build_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

						</td>
						<?php if ($this->_tpl_vars['gui']->displayPlatformCol): ?><td><?php echo $this->_tpl_vars['tcv_exec']['platform_name']; ?>
</td><?php endif; ?>
						<td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['tcv_exec']['tester_first_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['tcv_exec']['tester_last_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['tcv_exec']['tester_login'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

						</td>
						<?php $this->assign('tc_status_code', $this->_tpl_vars['tcv_exec']['status']); ?>
						<td class="<?php echo $this->_tpl_vars['tlCfg']->results['code_status'][$this->_tpl_vars['tc_status_code']]; ?>
" style="text-align:center">
						    <?php echo translate_tc_status_smarty(array('s' => $this->_tpl_vars['tcv_exec']['status']), $this);?>

						</td>
						<td  style="text-align:center"><?php echo $this->_tpl_vars['tcv_exec']['tcversion_number']; ?>
</td>
		
						<td class="icon_cell" align="center">
						<?php if ($this->_tpl_vars['tcv_exec']['execution_run_type'] == @TESTCASE_EXECUTION_TYPE_MANUAL): ?>
						<img src="<?php echo @TL_THEME_IMG_DIR; ?>
/user.png" title="<?php echo $this->_tpl_vars['labels']['execution_type_manual']; ?>
"
						     style="border:none" />
						<?php else: ?>
						<img src="<?php echo @TL_THEME_IMG_DIR; ?>
/bullet_wrench.png" title="<?php echo $this->_tpl_vars['labels']['execution_type_auto']; ?>
"
						     style="border:none" />
						<?php endif; ?>
						</td>
					</tr>
		
		
					<?php if ($this->_tpl_vars['tcv_exec']['execution_notes'] != ""): ?>
	  				<script>
										<?php echo '
	        		var panel_init = function(){
	            	var p = new Ext.Panel({
	            			title: '; ?>
'<?php echo $this->_tpl_vars['labels']['exec_notes']; ?>
'<?php echo ',
	            			collapsible:true, collapsed: true, baseCls: \'x-tl-panel\',
	            			renderTo: '; ?>
'exec_notes_container_<?php echo $this->_tpl_vars['tcv_exec']['execution_id']; ?>
'<?php echo ',
	            			width:\'100%\',html:\'\'
	            	});
	            	p.on({\'expand\' : function(){load_notes(this,'; ?>
<?php echo $this->_tpl_vars['tcv_exec']['execution_id']; ?>
<?php echo ');}});
	        		};
	        		panel_init_functions.push(panel_init);
	        		'; ?>

		  			</script>
					<tr style="background-color: <?php echo $this->_tpl_vars['bg_color']; ?>
">
	  			 		<td colspan="<?php echo $this->_tpl_vars['my_colspan']; ?>
" id="exec_notes_container_<?php echo $this->_tpl_vars['tcv_exec']['execution_id']; ?>
"
	  			     		style="padding:5px 5px 5px 5px;">
	  			 		</td>
	   				</tr>
	 			  <?php endif; ?>
		
					<tr style="background-color: <?php echo $this->_tpl_vars['bg_color']; ?>
">
					<td colspan="<?php echo $this->_tpl_vars['my_colspan']; ?>
">
						<?php if (isset ( $this->_tpl_vars['gui']->cfexec[$this->_tpl_vars['tcv_exec']['execution_id']] )): ?>
							<?php $this->assign('cf_value_info', $this->_tpl_vars['gui']->cfexec[$this->_tpl_vars['tcv_exec']['execution_id']]); ?>
							<?php echo $this->_tpl_vars['cf_value_info']; ?>

						<?php endif; ?>	
					</td>
					</tr>
		
										<tr style="background-color: <?php echo $this->_tpl_vars['bg_color']; ?>
">
						<td colspan="<?php echo $this->_tpl_vars['my_colspan']; ?>
">
						<?php if (isset ( $this->_tpl_vars['gui']->attachments[$this->_tpl_vars['tcv_exec']['execution_id']] )): ?>
							<?php $this->assign('attach_info', $this->_tpl_vars['gui']->attachments[$this->_tpl_vars['tcv_exec']['execution_id']]); ?>
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_attachments.tpl", 'smarty_include_vars' => array('attach_attachmentInfos' => $this->_tpl_vars['attach_info'],'attach_id' => $this->_tpl_vars['tcv_exec']['execution_id'],'attach_tableName' => 'executions','attach_show_upload_btn' => $this->_tpl_vars['attachment_model']->show_upload_btn,'attach_show_title' => $this->_tpl_vars['attachment_model']->show_title,'attach_downloadOnly' => 1,'attach_tableClassName' => null,'attach_inheritStyle' => 0,'attach_tableStyles' => null)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<?php endif; ?>
					</td>
					</tr>
		
		
					
					<?php if (isset ( $this->_tpl_vars['gui']->bugs[$this->_tpl_vars['tcv_exec']['execution_id']] )): ?>
						<tr style="background-color: <?php echo $this->_tpl_vars['bg_color']; ?>
">
						<td colspan="<?php echo $this->_tpl_vars['my_colspan']; ?>
">
							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_show_bug_table.tpl", 'smarty_include_vars' => array('bugs_map' => $this->_tpl_vars['gui']->bugs[$this->_tpl_vars['tcv_exec']['execution_id']],'can_delete' => 0,'exec_id' => $this->_tpl_vars['tcv_exec']['execution_id'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</td>
					</tr>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			<?php endforeach; endif; unset($_from); ?>
		
		
		</table>
	<?php else: ?>
		<br />
		<div class="user_feedback">
		<?php echo $this->_tpl_vars['gui']->warning_msg; ?>

		</div>
	<?php endif; ?>
</div>
</body>
</html>