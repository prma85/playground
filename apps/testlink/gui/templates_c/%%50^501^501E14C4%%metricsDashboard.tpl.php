<?php /* Smarty version 2.6.26, created on 2013-11-08 14:18:08
         compiled from results/metricsDashboard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'results/metricsDashboard.tpl', 6, false),array('modifier', 'escape', 'results/metricsDashboard.tpl', 40, false),array('modifier', 'date_format', 'results/metricsDashboard.tpl', 84, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => "generated_by_TestLink_on,testproject,test_plan,platform,show_only_active,
             info_metrics_dashboard,test_plan_progress,project_progress, info_metrics_dashboard_progress"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array('bResetEXTCss' => 1)));
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
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_table.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
  <?php endif; ?>
  <?php echo $this->_tpl_vars['matrix']->renderHeadSection(); ?>

<?php endforeach; endif; unset($_from); ?>

<?php $this->assign('tplan_metric', $this->_tpl_vars['gui']->tplan_metrics); ?>
<script type="text/javascript">
Ext.onReady(function() {
	<?php $_from = $this->_tpl_vars['gui']->project_metrics; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
    new Ext.ProgressBar({
        text:'&nbsp;&nbsp;<?php echo lang_get_smarty(array('s' => $this->_tpl_vars['value']['label_key']), $this);?>
: <?php echo $this->_tpl_vars['value']['value']; ?>
% [<?php echo $this->_tpl_vars['tplan_metric']['total'][$this->_tpl_vars['key']]; ?>
/<?php echo $this->_tpl_vars['tplan_metric']['total']['active']; ?>
]',
        width:'400',
        cls:'left-align',
        renderTo:'<?php echo $this->_tpl_vars['key']; ?>
',
        value:'<?php echo $this->_tpl_vars['value']['value']/100; ?>
'
    });
    <?php endforeach; endif; unset($_from); ?>
});
</script>

</head>

<body>
<h1 class="title"><?php echo $this->_tpl_vars['labels']['testproject']; ?>
 <?php echo @TITLE_SEP; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->tproject_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
<div class="workBack">
<?php echo $this->_tpl_vars['tlImages']['toggle_direct_link']; ?>
 &nbsp;&nbsp;
<div class="direct_link" style='display:none'>
<?php if ($this->_tpl_vars['gui']->direct_link_ok): ?>  
  <a href="<?php echo $this->_tpl_vars['gui']->direct_link; ?>
" target="_blank"><?php echo $this->_tpl_vars['gui']->direct_link; ?>
</a>
<?php else: ?>
  <?php echo $this->_tpl_vars['gui']->direct_link; ?>

<?php endif; ?>
</div>
<p><form method="post">
<input type="checkbox" name="show_only_active" value="show_only_active"
       <?php if ($this->_tpl_vars['gui']->show_only_active): ?> checked="checked" <?php endif; ?>
       onclick="this.form.submit();" /> <?php echo $this->_tpl_vars['labels']['show_only_active']; ?>

<input type="hidden"
       name="show_only_active_hidden"
       value="<?php echo $this->_tpl_vars['gui']->show_only_active; ?>
" />



</form></p><br/>

<?php if ($this->_tpl_vars['gui']->warning_msg == ''): ?>
	<h2><?php echo $this->_tpl_vars['labels']['project_progress']; ?>
</h2>
	<br>
	<?php $_from = $this->_tpl_vars['gui']->project_metrics; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['metric']):
?>
		<div id="<?php echo $this->_tpl_vars['key']; ?>
"></div>
		<?php if ($this->_tpl_vars['key'] == 'executed'): ?>
		<br />
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	<br />
	<p class="italic"><?php echo $this->_tpl_vars['labels']['info_metrics_dashboard_progress']; ?>
</p>
	<br />
	
	<h2><?php echo $this->_tpl_vars['labels']['test_plan_progress']; ?>
</h2>
	<br />
	<?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
?>
		<?php $this->assign('tableID', "table_".($this->_tpl_vars['idx'])); ?>
   		<?php echo $this->_tpl_vars['matrix']->renderBodySection($this->_tpl_vars['tableID']); ?>

	<?php endforeach; endif; unset($_from); ?>
	<br />
	<p class="italic"><?php echo $this->_tpl_vars['labels']['info_metrics_dashboard']; ?>
</p>
	<br />
	<?php echo $this->_tpl_vars['labels']['generated_by_TestLink_on']; ?>
 <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['gsmarty_timestamp_format']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['gsmarty_timestamp_format'])); ?>

<?php else: ?>
	<div class="user_feedback">
    <?php echo $this->_tpl_vars['gui']->warning_msg; ?>

    </div>
<?php endif; ?>
</div> 
</body>
</html>