<?php /* Smarty version 2.6.26, created on 2014-05-16 11:10:48
         compiled from attachmentdelete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'attachmentdelete.tpl', 7, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<body onunload="attachmentDlg_onUnload()" onload="attachmentDlg_onLoad()">
<h1 class="title"><?php echo lang_get_smarty(array('s' => 'title_delete_attachment'), $this);?>
</h1>
<p class='info'>
<?php if ($this->_tpl_vars['bDeleted'] == 1): ?>
	<?php echo lang_get_smarty(array('s' => 'deleting_was_ok'), $this);?>

<?php else: ?>
	<?php echo lang_get_smarty(array('s' => 'error_attachment_delete'), $this);?>

<?php endif; ?>
</p>

<div class="workBack">
		<div class="groupBtn" style="text-align:right">
			<input align="right" type="button" value="<?php echo lang_get_smarty(array('s' => 'btn_close'), $this);?>
" onclick="window.close()" />
		</div>
</div>

</body>
</html>