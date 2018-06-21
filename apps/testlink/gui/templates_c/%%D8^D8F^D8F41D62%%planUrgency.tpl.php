<?php /* Smarty version 2.6.26, created on 2013-10-29 14:20:55
         compiled from plan/planUrgency.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/planUrgency.tpl', 17, false),array('modifier', 'escape', 'plan/planUrgency.tpl', 25, false),)), $this); ?>
<?php $this->assign('ownURL', "lib/plan/planUrgency.php"); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'title_plan_urgency, th_testcase, th_urgency, urgency_low, urgency_medium, urgency_high,
             label_set_urgency_ts, btn_set_urgency_tc, urgency_description,testsuite_is_empty,
             priority, importance, execution_history, design'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>

<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->tplan_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['tlCfg']->gui_title_separator_2; ?>
<?php echo $this->_tpl_vars['labels']['title_plan_urgency']; ?>

	 <?php echo $this->_tpl_vars['tlCfg']->gui_title_separator_1; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->node_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<div class="workBack">

<?php if ($this->_tpl_vars['gui']->listTestCases != ''): ?>
	<div class="groupBtn">
    <form method="post" action="<?php echo $this->_tpl_vars['ownURL']; ?>
" id="set_urgency">
	<span><?php echo $this->_tpl_vars['labels']['label_set_urgency_ts']; ?>

    	<input type="submit" name="high_urgency" value="<?php echo $this->_tpl_vars['labels']['urgency_high']; ?>
" />
    	<input type="submit" name="medium_urgency" value="<?php echo $this->_tpl_vars['labels']['urgency_medium']; ?>
" />
    	<input type="submit" name="low_urgency" value="<?php echo $this->_tpl_vars['labels']['urgency_low']; ?>
" />
		<input type="hidden" name="tplan_id" value="<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
" />
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['gui']->node_id; ?>
" />
    </span>
    </form>
	</div>

	<form method="post" action="<?php echo $this->_tpl_vars['ownURL']; ?>
" id="set_urgency_tc">
	<input type="hidden" name="tplan_id" value="<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
" />
	<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['gui']->node_id; ?>
" />
	<table class="simple_tableruler" style="text-align: center">
	<tr>
		<th style="text-align: left;"><?php echo $this->_tpl_vars['labels']['th_testcase']; ?>
</th>
		<th><?php echo $this->_tpl_vars['labels']['importance']; ?>
</th>
		<th colspan="3"><?php echo $this->_tpl_vars['labels']['th_urgency']; ?>
</th>
		<th><?php echo $this->_tpl_vars['labels']['priority']; ?>
</th>
	</tr>

	<?php $_from = $this->_tpl_vars['gui']->listTestCases; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
	<tr>
		<td style="text-align: left;">
			<img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/history_small.png"
			     onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['res']['testcase_id']; ?>
);"
			     title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
			<img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/edit_icon.png"
			     onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['res']['testcase_id']; ?>
);"
			     title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
				<?php echo ((is_array($_tmp=$this->_tpl_vars['res']['tcprefix'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['res']['tc_external_id']; ?>
<?php echo $this->_tpl_vars['gsmarty_gui']->title_separator_1; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['res']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

		</td>
		<?php $this->assign('importance', $this->_tpl_vars['res']['importance']); ?>
		<td><?php echo $this->_tpl_vars['gsmarty_option_importance'][$this->_tpl_vars['importance']]; ?>
</td>
  		<?php $this->assign('urgencyCode', $this->_tpl_vars['res']['urgency']); ?>
		<td><input type="radio"
				   name="urgency[<?php echo $this->_tpl_vars['res']['tcversion_id']; ?>
]"
				   value="<?php echo @HIGH; ?>
" 
				   <?php if ($this->_tpl_vars['urgencyCode'] == @HIGH): ?>
					checked="checked"
				   <?php endif; ?>
					/>
			<span style="vertical-align:middle;"><?php echo $this->_tpl_vars['labels']['urgency_high']; ?>
</span>
		</td>
		<td><input type="radio"
				   name="urgency[<?php echo $this->_tpl_vars['res']['tcversion_id']; ?>
]"
				   value="<?php echo @MEDIUM; ?>
" 
				   <?php if ($this->_tpl_vars['urgencyCode'] == @MEDIUM): ?>
				       checked="checked"
				   <?php endif; ?>
					/>
			<span style="vertical-align:middle;"><?php echo $this->_tpl_vars['labels']['urgency_medium']; ?>
</span>
		</td>
		<td><input type="radio"
				   name="urgency[<?php echo $this->_tpl_vars['res']['tcversion_id']; ?>
]"
				   value="<?php echo @LOW; ?>
" 
				   <?php if ($this->_tpl_vars['urgencyCode'] == @LOW): ?>
				       checked="checked"
				   <?php endif; ?>
					/>
			<span style="vertical-align:middle;"><?php echo $this->_tpl_vars['labels']['urgency_low']; ?>
</span>
		</td>
		<?php $this->assign('priority', $this->_tpl_vars['res']['priority']); ?>
		<td><?php echo $this->_tpl_vars['gsmarty_option_priority'][$this->_tpl_vars['priority']]; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	<div class="groupBtn">
		<input type="submit" value="<?php echo $this->_tpl_vars['labels']['btn_set_urgency_tc']; ?>
" />
	</div>
	</form>
	<p><?php echo $this->_tpl_vars['labels']['urgency_description']; ?>
</p>
<?php else: ?>
	<p><?php echo $this->_tpl_vars['labels']['testsuite_is_empty']; ?>
</p>
<?php endif; ?>
</div>
</body>
</html>