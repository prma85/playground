<?php /* Smarty version 2.6.26, created on 2013-10-25 11:53:40
         compiled from lostPassword.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'lostPassword.tpl', 10, false),array('function', 'config_load', 'lostPassword.tpl', 29, false),array('modifier', 'escape', 'lostPassword.tpl', 37, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => "password_reset,login_name,btn_send,
                          password_mgmt_is_external,link_back_to_login"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['gui']->page_title,'openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script language="JavaScript" src="<?php echo $this->_tpl_vars['basehref']; ?>
gui/niftycube/niftycube.js" type="text/javascript"></script>
<script type="text/javascript">
	<?php echo '
	window.onload=function(){
 		Nifty("div#login_div","big");
 		Nifty("div.messages","normal");
 		// set focus on login text box
		focusInputField(\'login\');
	}
	'; ?>

</script>

</head>

<body>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => 'login'), $this);?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_login_title.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="forms" id="login_div">
	<?php if ($this->_tpl_vars['gui']->external_password_mgmt == 0): ?>
    <p class="title"><?php echo $this->_tpl_vars['labels']['password_reset']; ?>
</p>

    <form method="post" action="lostPassword.php">
 		  <div class="messages" style="text-align:center;"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->note)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
    	
    	<p class="label"><?php echo $this->_tpl_vars['labels']['login_name']; ?>
<br />
    	<input type="text" name="login" id="login" 
    	       size="<?php echo $this->_config[0]['vars']['LOGIN_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['LOGIN_MAXLEN']; ?>
" /></p>
    	<p><input type="submit" name="editUser" value="<?php echo $this->_tpl_vars['labels']['btn_send']; ?>
" /></p>
    </form>
    
	<?php else: ?>
     <p><?php echo $this->_tpl_vars['labels']['password_mgmt_is_external']; ?>
</p>
	<?php endif; ?>

    <hr />
	<p><a href="login.php"><?php echo $this->_tpl_vars['labels']['link_back_to_login']; ?>
</a></p>

</div>
</body>
</html>