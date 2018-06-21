<?php /* Smarty version 2.6.26, created on 2014-01-16 11:29:35
         compiled from testcases/containerMove.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'testcases/containerMove.tpl', 12, false),array('function', 'html_options', 'testcases/containerMove.tpl', 35, false),array('modifier', 'escape', 'testcases/containerMove.tpl', 20, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo lang_get_smarty(array('s' => 'container','var' => 'parent'), $this);?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => "cont_move_first,sorry_further,title_move_cp,cont_copy_first,defined_exclam,
             cont_move_second,cont_copy_second,choose_target,copy_keywords,
             btn_move,btn_cp,as_first_testsuite,as_last_testsuite"), $this);?>


<body>
<?php echo lang_get_smarty(array('s' => $this->_tpl_vars['level'],'var' => 'level_translated'), $this);?>

<h1 class="title"><?php echo $this->_tpl_vars['level_translated']; ?>
<?php echo @TITLE_SEP; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['object_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </h1>

<div class="workBack">
<h1 class="title"><?php echo $this->_tpl_vars['labels']['title_move_cp']; ?>
</h1>

<?php if ($this->_tpl_vars['containers'] == ''): ?>
	<?php echo $this->_tpl_vars['labels']['sorry_further']; ?>
 <?php echo $this->_tpl_vars['parent']; ?>
 <?php echo $this->_tpl_vars['labels']['defined_exclam']; ?>

<?php else: ?>
	<form method="post" action="lib/testcases/containerEdit.php?objectID=<?php echo ((is_array($_tmp=$this->_tpl_vars['objectID'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
		<p>
		<?php echo $this->_tpl_vars['labels']['cont_move_first']; ?>
 <?php echo $this->_tpl_vars['level_translated']; ?>
 <?php echo $this->_tpl_vars['labels']['cont_move_second']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
.<br />
		<?php echo $this->_tpl_vars['labels']['cont_copy_first']; ?>
 <?php echo $this->_tpl_vars['level_translated']; ?>
 <?php echo $this->_tpl_vars['labels']['cont_copy_second']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
.
		</p>
		<p><?php echo $this->_tpl_vars['labels']['choose_target']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['parent'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:
			<select name="containerID">
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['containers']), $this);?>

			</select>
		</p>

	<p><input type="radio" name="target_position"
	          value="top" <?php echo $this->_tpl_vars['top_checked']; ?>
 /><?php echo $this->_tpl_vars['labels']['as_first_testsuite']; ?>

  	<br /><input type="radio" name="target_position"
	          value="bottom" <?php echo $this->_tpl_vars['bottom_checked']; ?>
 /><?php echo $this->_tpl_vars['labels']['as_last_testsuite']; ?>


		<p>
			<input type="checkbox" name="copyKeywords" checked="checked" value="1" />
			<?php echo $this->_tpl_vars['labels']['copy_keywords']; ?>

		</p>

		<div>
			<input type="submit" name="do_move" value="<?php echo $this->_tpl_vars['labels']['btn_move']; ?>
" />
			<input type="submit" name="do_copy" value="<?php echo $this->_tpl_vars['labels']['btn_cp']; ?>
" />
			<input type="hidden" name="old_containerID" value="<?php echo $this->_tpl_vars['old_containerID']; ?>
" />
		</div>

	</form>
<?php endif; ?>
</div>
</body>
</html>