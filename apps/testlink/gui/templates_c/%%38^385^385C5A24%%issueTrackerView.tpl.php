<?php /* Smarty version 2.6.26, created on 2013-10-25 13:47:56
         compiled from issuetrackers/issueTrackerView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'issuetrackers/issueTrackerView.tpl', 12, false),array('function', 'config_load', 'issuetrackers/issueTrackerView.tpl', 27, false),array('modifier', 'basename', 'issuetrackers/issueTrackerView.tpl', 26, false),array('modifier', 'replace', 'issuetrackers/issueTrackerView.tpl', 26, false),array('modifier', 'escape', 'issuetrackers/issueTrackerView.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('jsValidate' => 'yes','openHead' => 'yes','enableTableSorting' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'th_issuetracker,th_issuetracker_type,th_delete,th_description,menu_assign_kw_to_tc,
          	 btn_create,alt_delete,th_issuetracker_env,check_bts_connection,bts_check_ok,bts_check_ko'), $this);?>


<?php echo lang_get_smarty(array('s' => 'warning_delete','var' => 'warning_msg'), $this);?>

<?php echo lang_get_smarty(array('s' => 'delete','var' => 'del_msgbox_title'), $this);?>


<script type="text/javascript">
/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
var del_action=fRoot+'lib/issuetrackers/issueTrackerEdit.php?doAction=doDelete&id=';
</script>
 
</head>
<body <?php echo $this->_tpl_vars['body_onload']; ?>
>
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='issuetrackers/issueTrackerView.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<div class="workBack">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_feedback.tpl", 'smarty_include_vars' => array('user_feedback' => $this->_tpl_vars['gui']->user_feedback)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['gui']->items != ''): ?>
	<table class="simple_tableruler sortable">
		<tr>
			<th width="30%"><?php echo $this->_tpl_vars['tlImages']['sort_hint']; ?>
<?php echo $this->_tpl_vars['labels']['th_issuetracker']; ?>
</th>
			<th><?php echo $this->_tpl_vars['tlImages']['sort_hint']; ?>
<?php echo $this->_tpl_vars['labels']['th_issuetracker_type']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_issuetracker_env']; ?>
</th>
			<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
				<th style="min-width:70px"><?php echo $this->_tpl_vars['tlImages']['sort_hint']; ?>
<?php echo $this->_tpl_vars['labels']['th_delete']; ?>
</th>
			<?php endif; ?>
		</tr>

  	<?php $_from = $this->_tpl_vars['gui']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_id'] => $this->_tpl_vars['item_def']):
?>
		<tr>
			<td>
				<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
					<a href="lib/issuetrackers/issueTrackerView.php?id=<?php echo $this->_tpl_vars['item_def']['id']; ?>
">
					  <img src="<?php echo $this->_tpl_vars['tlImages']['wrench']; ?>
" title="<?php echo $this->_tpl_vars['labels']['check_bts_connection']; ?>
">
					</a>
          <?php if ($this->_tpl_vars['item_def']['connection_status'] == 'ok'): ?>
					  <img src="<?php echo $this->_tpl_vars['tlImages']['check_ok']; ?>
" title="<?php echo $this->_tpl_vars['labels']['bts_check_ok']; ?>
">
				  <?php elseif ($this->_tpl_vars['item_def']['connection_status'] == 'ko'): ?>
					  <img src="<?php echo $this->_tpl_vars['tlImages']['check_ko']; ?>
" title="<?php echo $this->_tpl_vars['labels']['bts_check_ko']; ?>
">
				  <?php else: ?>
				    &nbsp;
				  <?php endif; ?>
				<?php endif; ?>

				<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
					<a href="lib/issuetrackers/issueTrackerEdit.php?doAction=edit&amp;id=<?php echo $this->_tpl_vars['item_def']['id']; ?>
">
				<?php endif; ?>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['item_def']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

				<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
					</a>
				<?php endif; ?>

			</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item_def']['type_descr'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			<td class="clickable_icon"><?php echo ((is_array($_tmp=$this->_tpl_vars['item_def']['env_check_msg'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>

				<td class="clickable_icon">
				<?php if ($this->_tpl_vars['gui']->canManage != "" && $this->_tpl_vars['item_def']['link_count'] == 0): ?>
			  		<img style="border:none;cursor: pointer;"
			       		alt="<?php echo $this->_tpl_vars['labels']['alt_delete']; ?>
" title="<?php echo $this->_tpl_vars['labels']['alt_delete']; ?>
"   
             		src="<?php echo $this->_tpl_vars['tlImages']['delete']; ?>
"			     
				     	 onclick="delete_confirmation(<?php echo $this->_tpl_vars['item_def']['id']; ?>
,
				              '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item_def']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
				              '<?php echo $this->_tpl_vars['del_msgbox_title']; ?>
','<?php echo $this->_tpl_vars['warning_msg']; ?>
');" />
				<?php endif; ?>
				</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php endif; ?>
	
	<div class="groupBtn">	
	  	<form name="item_view" id="item_view" method="post" action="lib/issuetrackers/issueTrackerEdit.php"> 
	  	  <input type="hidden" name="doAction" value="" />
	
		<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
	  		<input type="submit" id="create" name="create" value="<?php echo $this->_tpl_vars['labels']['btn_create']; ?>
" 
	  	           onclick="doAction.value='create'"/>
		<?php endif; ?>
	  	</form>
	</div>
</div>

</body>
</html>