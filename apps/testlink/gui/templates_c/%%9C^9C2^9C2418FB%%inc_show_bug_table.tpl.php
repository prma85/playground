<?php /* Smarty version 2.6.26, created on 2013-10-25 14:16:45
         compiled from inc_show_bug_table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'inc_show_bug_table.tpl', 20, false),array('modifier', 'escape', 'inc_show_bug_table.tpl', 27, false),)), $this); ?>

<?php if (! isset ( $this->_tpl_vars['tableClassName'] )): ?>
    <?php $this->assign('tableClassName', 'simple'); ?>
<?php endif; ?>
<?php if (! isset ( $this->_tpl_vars['tableStyles'] )): ?>
    <?php $this->assign('tableStyles', "font-size:12px"); ?>
<?php endif; ?>
<table class="simple">
  <tr>
	  <th style="text-align:left"><?php echo lang_get_smarty(array('s' => 'build'), $this);?>
</th>
	  <th style="text-align:left"><?php echo lang_get_smarty(array('s' => 'caption_bugtable'), $this);?>
</th>
	  <?php if ($this->_tpl_vars['can_delete']): ?> <th style="text-align:left">&nbsp;</th> <?php endif; ?>
  </tr>
  
 	<?php $_from = $this->_tpl_vars['bugs_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bug_id'] => $this->_tpl_vars['bug_elem']):
?>
	<tr>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['bug_elem']['build_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
		<td><?php echo $this->_tpl_vars['bug_elem']['link_to_bts']; ?>
</td>
		<?php if ($this->_tpl_vars['can_delete']): ?>
		  <td class="clickable_icon">
		  	<img class="clickable" onclick="delete_confirmation('<?php echo $this->_tpl_vars['exec_id']; ?>
-<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['bug_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
','<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['bug_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
			            '<?php echo lang_get_smarty(array('s' => 'delete_bug'), $this);?>
','<?php echo lang_get_smarty(array('s' => 'del_bug_warning_msg'), $this);?>
 (<?php echo lang_get_smarty(array('s' => 'bug_id'), $this);?>
 <?php echo $this->_tpl_vars['bug_id']; ?>
)',deleteBug);" style="border:none" title="<?php echo lang_get_smarty(array('s' => 'delete_bug'), $this);?>
" alt="<?php echo lang_get_smarty(array('s' => 'delete_bug'), $this);?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/trash.png"/></td>
		<?php endif; ?>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>
		