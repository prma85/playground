<?php /* Smarty version 2.6.26, created on 2013-11-05 15:05:46
         compiled from results/resultsByStatus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'results/resultsByStatus.tpl', 11, false),array('modifier', 'escape', 'results/resultsByStatus.tpl', 33, false),array('modifier', 'date_format', 'results/resultsByStatus.tpl', 66, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'th_test_suite,test_case,version,th_build,th_run_by,th_bugs_not_linked,
          th_date,title_execution_notes,th_bugs,summary,generated_by_TestLink_on,
          th_assigned_to,th_platform,platform,info_failed_tc_report,
          info_blocked_tc_report,info_notrun_tc_report,export_as_spreadsheet'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['initializer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['initializer']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
        $this->_foreach['initializer']['iteration']++;
?>
  <?php $this->assign('tableID', $this->_tpl_vars['matrix']->tableID); ?>
  <?php if (($this->_foreach['initializer']['iteration'] <= 1)): ?>
    <?php echo $this->_tpl_vars['matrix']->renderCommonGlobals(); ?>

    <?php if ($this->_tpl_vars['matrix'] instanceof tlExtTable): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array('bResetEXTCss' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_table.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php echo $this->_tpl_vars['matrix']->renderHeadSection(); ?>

<?php endforeach; endif; unset($_from); ?>
</head>
<body>
<form name="resultsByStatus" id="resultsByStatus" METHOD="POST"
      action="lib/results/resultsByStatus.php?type=<?php echo $this->_tpl_vars['gui']->type; ?>
&format=3&tplan_id=<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
&tproject_id=<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
">
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

  <?php if ($this->_tpl_vars['gui']->apikey != ''): ?>
  <input type="hidden" name="apikey" id="apikey" value="<?php echo $this->_tpl_vars['gui']->apikey; ?>
">
  <?php endif; ?>
  <input type="image" name="exportSpreadSheet" id="exportSpreadSheet" 
         src="<?php echo $this->_tpl_vars['tlImages']['export_excel']; ?>
" title="<?php echo $this->_tpl_vars['labels']['export_as_spreadsheet']; ?>
">
</form>
</h1>




<div class="workBack">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_result_tproject_tplan.tpl", 'smarty_include_vars' => array('arg_tproject_name' => $this->_tpl_vars['gui']->tproject_name,'arg_tplan_name' => $this->_tpl_vars['gui']->tplan_name)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['gui']->warning_msg == ''): ?>
	<?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
?>
		<?php $this->assign('tableID', "table_".($this->_tpl_vars['idx'])); ?>
   		<?php echo $this->_tpl_vars['matrix']->renderBodySection($this->_tpl_vars['tableID']); ?>

	<?php endforeach; endif; unset($_from); ?>
	<br />
	
	<?php if ($this->_tpl_vars['gui']->bugs_msg != ''): ?>
	  <h2 class="simple"><?php echo $this->_tpl_vars['gui']->bugs_msg; ?>
<?php echo $this->_tpl_vars['gui']->without_bugs_counter; ?>
</h2>
	  <br />
	<?php endif; ?>


  <p class="italic"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->report_context)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
	<p class="italic"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->info_msg)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
	<br />
	<?php echo $this->_tpl_vars['labels']['generated_by_TestLink_on']; ?>
 <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['gsmarty_timestamp_format']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['gsmarty_timestamp_format'])); ?>

<?php else: ?>
	<br \>
	<?php echo $this->_tpl_vars['gui']->warning_msg; ?>

<?php endif; ?>
</div>
</body>
</html>