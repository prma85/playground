<?php /* Smarty version 2.6.26, created on 2013-10-25 14:11:22
         compiled from usermanagement/usersView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'usermanagement/usersView.tpl', 47, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $this->assign('userActionMgr', "lib/usermanagement/usersEdit.php"); ?>
<?php $this->assign('createUserAction', ($this->_tpl_vars['userActionMgr'])."?doAction=create"); ?>

<script type="text/javascript">
var del_action=fRoot+"lib/usermanagement/usersView.php?operation=disable&user=";
</script>

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

<style type=text/css>
.x-action-col-cell img.normal_user {
    height: 16px;
    width: 16px;
    background-image: url(<?php echo $this->_tpl_vars['tlImages']['delete']; ?>
);
}

.x-action-col-cell img.special_user {
    height: 16px;
    width: 16px;        
    background-image: url(<?php echo $this->_tpl_vars['tlImages']['demo_mode']; ?>
);
}
</style>
</head>


<?php echo lang_get_smarty(array('var' => 'labels','s' => "title_user_mgmt,th_login,title_user_mgmt,th_login,th_first_name,th_last_name,th_email,
             th_role,order_by_role_descr,order_by_role_dir,th_locale,th_active,th_api,th_delete,
             disable,alt_edit_user,Yes,No,alt_delete_user,no_permissions_for_action,btn_create,
             show_inactive_users,hide_inactive_users,alt_disable_user,order_by_login,
             order_by_login_dir,alt_active_user,demo_special_user"), $this);?>


<body>
<?php if ($this->_tpl_vars['gui']->grants->user_mgmt == 'yes'): ?>

	<h1 class="title"><?php echo $this->_tpl_vars['labels']['title_user_mgmt']; ?>
</h1>
	<?php $this->assign('grants', $this->_tpl_vars['gui']->grants); ?>    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "usermanagement/tabsmenu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="workBack">

	  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_update.tpl", 'smarty_include_vars' => array('result' => $this->_tpl_vars['gui']->result,'item' => 'user','action' => $this->_tpl_vars['gui']->action,'user_feedback' => $this->_tpl_vars['gui']->user_feedback)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	           
	  <?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
?>
      <?php echo $this->_tpl_vars['matrix']->renderBodySection(); ?>

    <?php endforeach; endif; unset($_from); ?>

		<div class="groupBtn">
		<form method="post" action="<?php echo $this->_tpl_vars['createUserAction']; ?>
" name="launch_create">
		  <input type="hidden" id="operation" name="operation" value="" />
		  <input type="submit" name="doCreate"  value="<?php echo $this->_tpl_vars['labels']['btn_create']; ?>
" />
  	</form>
		</div>
	</div>
	
	<?php if ($this->_tpl_vars['update_title_bar'] == 1): ?>
	<?php echo '
	<script type="text/javascript">
		parent.titlebar.location.reload();
	</script>
	'; ?>

	<?php endif; ?>
	<?php if ($this->_tpl_vars['reload'] == 1): ?>
	<?php echo '
	<script type="text/javascript">
		top.location.reload();
	</script>
	'; ?>

	<?php endif; ?>
<?php else: ?>
	<?php echo $this->_tpl_vars['labels']['no_permissions_for_action']; ?>
<br />
	<a href="<?php echo $this->_tpl_vars['gui']->basehref; ?>
" alt="Home">Home</a>
<?php endif; ?>
</body>
</html>