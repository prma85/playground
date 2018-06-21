<?php /* Smarty version 2.6.26, created on 2013-12-16 10:05:35
         compiled from execute/editExecution.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'execute/editExecution.tpl', 13, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes','editorType' => $this->_tpl_vars['gui']->editorType)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<body onUnload="storeWindowSize('ExecEditPopup')">
<h1 class="title"><?php echo lang_get_smarty(array('s' => 'title_execution_notes'), $this);?>
</h1>
<div class="workBack">
	<form method="post">
				<input type="hidden" name="tplan_id" value="<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
">
		<input type="hidden" name="tproject_id" value="<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
">
		<input type="hidden" name="exec_id" value="<?php echo $this->_tpl_vars['gui']->exec_id; ?>
">
		<input type="hidden" name="tcversion_id" value="<?php echo $this->_tpl_vars['gui']->tcversion_id; ?>
">
		
		<table width="100%">
		<tr>
			<td>
	      		<?php echo $this->_tpl_vars['gui']->notes; ?>

			</td>
		</tr>	
	    <?php if ($this->_tpl_vars['gui']->cfields_exec != ''): ?>
	  	<tr>
	  	  	<td colspan="2">
	  	  		<div id="cfields_exec" class="custom_field_container" 
	  	  			style="background-color:#dddddd;"><?php echo $this->_tpl_vars['gui']->cfields_exec; ?>

	  	  		</div>
	  	  	</td>
	  	</tr>
	    <?php endif; ?>
		
		</table>
		<div class="groupBtn">
			<input type="hidden" name="doAction" value="doUpdate" />
			<input type="submit" value="<?php echo lang_get_smarty(array('s' => 'btn_save'), $this);?>
" />
			<input type="button" value="<?php echo lang_get_smarty(array('s' => 'btn_close'), $this);?>
" onclick="window.close()" />
		</div>
	</form>
</div>
</body>
</html>