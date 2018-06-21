<?php /* Smarty version 2.6.26, created on 2013-11-06 13:43:17
         compiled from plan/newest_tcversions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/newest_tcversions.tpl', 12, false),array('function', 'html_options', 'plan/newest_tcversions.tpl', 34, false),array('modifier', 'escape', 'plan/newest_tcversions.tpl', 27, false),)), $this); ?>

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

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'testproject,test_plan,th_id,th_test_case,title_newest_tcversions,
             linked_version,newest_version,compare,design,execution_history'), $this);?>


</head>
<body>

<h1 class="title"> <?php echo $this->_tpl_vars['labels']['title_newest_tcversions']; ?>
 
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_help.tpl", 'smarty_include_vars' => array('helptopic' => 'hlp_planTcModified','show_help_icon' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</h1>

<form method="post" id="newest_tcversions.tpl">
  <table>
  <tr>
   <td><?php echo $this->_tpl_vars['labels']['testproject']; ?>
<?php echo @TITLE_SEP; ?>
</td>
   <td><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->tproject_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
  </tr>
  
  <tr>
    <td><?php echo $this->_tpl_vars['labels']['test_plan']; ?>
</td>
    <td>
      <select name="tplan_id" id="tplan_id" onchange="this.form.submit()">  
         <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->tplans,'selected' => $this->_tpl_vars['gui']->tplan_id), $this);?>

      </select>
    </td>
  </tr>
  </table>
</form>

<?php if ($this->_tpl_vars['gui']->show_details): ?>
  <div class="workBack">

    <table class="simple_tableruler">
      <tr>
		    		    <th><?php echo $this->_tpl_vars['labels']['th_test_case']; ?>
</th>
		    <th><?php echo $this->_tpl_vars['labels']['linked_version']; ?>
</th>
		    <th><?php echo $this->_tpl_vars['labels']['newest_version']; ?>
</th>
		    <th><?php echo $this->_tpl_vars['labels']['compare']; ?>
</th>
      </tr>   
    
      <?php $_from = $this->_tpl_vars['gui']->testcases; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tc']):
?>
      <tr>
		 
		<td> 
			<img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/history_small.png"
			     onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
);"
			     title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
			<img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/edit_icon.png"
			     onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
);"
			     title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
			<?php echo $this->_tpl_vars['tc']['path']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->tcasePrefix)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['tc_external_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:<?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

		</td>
		<td align="center"> <?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </td>
		<td align="center"> <?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['newest_version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </td>
		</td>
		<td align="center">
			<a href="lib/testcases/tcCompareVersions.php?testcase_id=<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
&version_left=<?php echo $this->_tpl_vars['tc']['version']; ?>
&version_right=<?php echo $this->_tpl_vars['tc']['newest_version']; ?>
&compare_selected_versions=1&use_html_comp=1" target="_blank">
			<img src="<?php echo @TL_THEME_IMG_DIR; ?>
/magnifier.png"></img></a>
		</td>
      </tr>
  	  <?php endforeach; endif; unset($_from); ?>
  	</table>
  </div>
<?php else: ?>
	<h2><?php echo $this->_tpl_vars['gui']->user_feedback; ?>
</h2>
<?php endif; ?>

</body>
</html>