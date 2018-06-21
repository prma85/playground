<?php /* Smarty version 2.6.26, created on 2013-10-29 13:39:43
         compiled from plan/planMilestonesView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/planMilestonesView.tpl', 9, false),array('function', 'config_load', 'plan/planMilestonesView.tpl', 15, false),array('modifier', 'basename', 'plan/planMilestonesView.tpl', 14, false),array('modifier', 'replace', 'plan/planMilestonesView.tpl', 14, false),array('modifier', 'escape', 'plan/planMilestonesView.tpl', 39, false),array('modifier', 'date_format', 'plan/planMilestonesView.tpl', 64, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'no_milestones,title_milestones,title_existing_milestones,th_name,
                         th_date_format,th_perc_a_prio,th_perc_b_prio,th_perc_c_prio,
                         btn_new_milestone,start_date,
                         th_perc_testcases,th_delete,alt_delete_milestone,no_milestones'), $this);?>


<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='plan/planMilestonesView.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<?php $this->assign('managerURL', "lib/plan/planMilestonesEdit.php"); ?>
<?php $this->assign('editAction', ($this->_tpl_vars['managerURL'])."?doAction=edit"); ?>
<?php $this->assign('deleteAction', ($this->_tpl_vars['managerURL'])."?doAction=doDelete&id="); ?>
<?php $this->assign('createAction', ($this->_tpl_vars['managerURL'])."?doAction=create&tplan_id="); ?>

<?php echo lang_get_smarty(array('s' => 'warning_delete_milestone','var' => 'warning_msg'), $this);?>

<?php echo lang_get_smarty(array('s' => 'delete','var' => 'del_msgbox_title'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes','jsValidate' => 'yes','enableTableSorting' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
var del_action=fRoot+'<?php echo $this->_tpl_vars['deleteAction']; ?>
';
</script>
</head>



<body>
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<div class="workBack">
	<?php if ($this->_tpl_vars['gui']->items != ""): ?>
		<table class="common" width="100%">
		<tr>
			<th><?php echo $this->_tpl_vars['labels']['th_name']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_date_format']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['start_date']; ?>
</th>
			<?php if ($this->_tpl_vars['session'] ['testprojectOptions']->testPriorityEnabled): ?>
				<th><?php echo $this->_tpl_vars['labels']['th_perc_a_prio']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_perc_b_prio']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_perc_c_prio']; ?>
</th>
			<?php else: ?>
				<th><?php echo $this->_tpl_vars['labels']['th_perc_testcases']; ?>
</th>
			<?php endif; ?>
			<th><?php echo $this->_tpl_vars['labels']['th_delete']; ?>
</th>
		</tr>

		<?php $_from = $this->_tpl_vars['gui']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['milestone']):
?>
		<tr>
			<td>
				<a href="<?php echo $this->_tpl_vars['editAction']; ?>
&id=<?php echo $this->_tpl_vars['milestone']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
			</td>
			<td>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['target_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['gsmarty_date_format']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['gsmarty_date_format'])); ?>

			</td>
			<td>
			  <?php if ($this->_tpl_vars['milestone']['start_date'] != '' && $this->_tpl_vars['milestone']['start_date'] != '0000-00-00'): ?>
				  <?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['gsmarty_date_format']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['gsmarty_date_format'])); ?>

				<?php endif; ?>
			</td>
			<?php if ($this->_tpl_vars['session'] ['testprojectOptions']->testPriorityEnabled): ?>
				<td style="text-align: right"><?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['high_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td style="text-align: right"><?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['medium_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td style="text-align: right"><?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['low_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			<?php else: ?>
				<td style="text-align: right"><?php echo ((is_array($_tmp=$this->_tpl_vars['milestone']['medium_percentage'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			<?php endif; ?>
			<td class="clickable_icon">
				       <img style="border:none;cursor: pointer;" 
  				            title="<?php echo $this->_tpl_vars['labels']['alt_delete_milestone']; ?>
" 
  				            alt="<?php echo $this->_tpl_vars['labels']['alt_delete_milestone']; ?>
" 
 					            onclick="delete_confirmation(<?php echo $this->_tpl_vars['milestone']['id']; ?>
,'<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['milestone']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
 					                                         '<?php echo $this->_tpl_vars['del_msgbox_title']; ?>
','<?php echo $this->_tpl_vars['warning_msg']; ?>
');"
  				            src="<?php echo $this->_tpl_vars['tlImages']['delete']; ?>
"/>
  				</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
		</table>

  <?php else: ?>
		<p><?php echo $this->_tpl_vars['labels']['no_milestones']; ?>
</p>
  <?php endif; ?>

   <div class="groupBtn">
    <form method="post" action="<?php echo $this->_tpl_vars['createAction']; ?>
<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
">
      <input type="submit" name="create_milestone" value="<?php echo $this->_tpl_vars['labels']['btn_new_milestone']; ?>
" />
    </form>
  </div>
</div>
</body>
</html>