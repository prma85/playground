<?php /* Smarty version 2.6.26, created on 2013-10-25 16:35:26
         compiled from results/resultsReqs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'results/resultsReqs.tpl', 14, false),array('function', 'html_options', 'results/resultsReqs.tpl', 74, false),array('modifier', 'escape', 'results/resultsReqs.tpl', 57, false),array('modifier', 'date_format', 'results/resultsReqs.tpl', 125, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'title_result_req_testplan, show_only_finished_reqs, caption_nav_settings,
          generated_by_TestLink_on, info_resultsReqs, platform, status, btn_apply,
          info_resultsReqsProgress, title_resultsReqsProgress, title_resultsReqs'), $this);?>


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
	<?php $this->assign('tableID', "table_".($this->_tpl_vars['idx'])); ?>
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
	<?php echo $this->_tpl_vars['matrix']->renderHeadSection($this->_tpl_vars['tableID']); ?>

<?php endforeach; endif; unset($_from); ?>

<?php $this->assign('total_reqs', $this->_tpl_vars['gui']->total_reqs); ?>

<script type="text/javascript">
Ext.onReady(function() {
	<?php $_from = $this->_tpl_vars['gui']->summary; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
	<?php $this->assign('label', $this->_tpl_vars['value']['label']); ?>
	<?php $this->assign('count', $this->_tpl_vars['value']['count']); ?>
		<?php if ($this->_tpl_vars['count'] != 0): ?>
	    new Ext.ProgressBar({
	        text:'&nbsp;&nbsp;<?php echo $this->_tpl_vars['label']; ?>
: <?php echo $this->_tpl_vars['count']; ?>
 of <?php echo $this->_tpl_vars['total_reqs']; ?>
',
	        width:'400',
	        cls:'left-align',
	        renderTo:'<?php echo $this->_tpl_vars['key']; ?>
',
	        value:'<?php echo $this->_tpl_vars['count']/$this->_tpl_vars['total_reqs']; ?>
'
	    });
	<?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
});
</script>

</head>

<body>
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->pageTitle)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>
<div class="workBack" style="overflow-y: auto;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_result_tproject_tplan.tpl", 'smarty_include_vars' => array('arg_tproject_name' => $this->_tpl_vars['gui']->tproject_name,'arg_tplan_name' => $this->_tpl_vars['gui']->tplan_name)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br /><p>
<!-- <h2 class="title"><?php echo $this->_tpl_vars['labels']['caption_nav_settings']; ?>
</h2> -->
<br />
<p><form method="post">
<table>
	<?php if ($this->_tpl_vars['gui']->platforms): ?>
	<tr>
		<td>
				<?php echo $this->_tpl_vars['labels']['platform']; ?>

		</td>
		<td>
		<select name="platform" onchange="this.form.submit()">
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->platforms,'selected' => $this->_tpl_vars['gui']->selected_platform), $this);?>

		</select>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
		<td><?php echo $this->_tpl_vars['labels']['status']; ?>
</td>
		<td> <select id="states_to_show" 
	                         name="states_to_show[]"
	                         multiple="multiple"
	                         size="4" >
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->states_to_show->items,'selected' => $this->_tpl_vars['gui']->states_to_show->selected), $this);?>

							</select>
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit"
			       name="send_states_to_show"
			       value="<?php echo $this->_tpl_vars['labels']['btn_apply']; ?>
" />       
		</td>
	</tr>
</table>
</form></p><br/>

<?php if ($this->_tpl_vars['gui']->warning_msg == ''): ?>

	<h2><?php echo $this->_tpl_vars['labels']['title_resultsReqsProgress']; ?>
</h2>
	<br />

	<?php $_from = $this->_tpl_vars['gui']->summary; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['metric']):
?>
		<div id="<?php echo $this->_tpl_vars['key']; ?>
"></div>
	<?php endforeach; endif; unset($_from); ?>

	<br />
		<p class="italic"><?php echo $this->_tpl_vars['labels']['info_resultsReqsProgress']; ?>
</p>
	<br />
	
	<h2><?php echo $this->_tpl_vars['labels']['title_resultsReqs']; ?>
</h2>
	<br />
	<?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
?>
		<?php $this->assign('tableID', "table_".($this->_tpl_vars['idx'])); ?>
   		<?php echo $this->_tpl_vars['matrix']->renderBodySection($this->_tpl_vars['tableID']); ?>

	<?php endforeach; endif; unset($_from); ?>
	
	<br />
		<p class="italic"><?php echo $this->_tpl_vars['labels']['info_resultsReqs']; ?>
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