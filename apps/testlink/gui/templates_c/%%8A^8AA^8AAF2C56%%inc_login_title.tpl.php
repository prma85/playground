<?php /* Smarty version 2.6.26, created on 2013-10-24 15:03:21
         compiled from inc_login_title.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'inc_login_title.tpl', 8, false),)), $this); ?>
<div class="login_title">
<p><img alt="Company logo" title="logo" src="<?php echo @TL_THEME_IMG_DIR; ?>
<?php echo $this->_tpl_vars['tlCfg']->logo_login; ?>
" />
   <br />TestLink <?php echo ((is_array($_tmp=$this->_tpl_vars['tlVersion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
</div>