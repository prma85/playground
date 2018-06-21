<?php /* Smarty version 2.6.26, created on 2014-03-31 14:44:59
         compiled from requirements/reqExport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/reqExport.tpl', 6, false),array('function', 'config_load', 'requirements/reqExport.tpl', 11, false),array('function', 'html_options', 'requirements/reqExport.tpl', 77, false),array('modifier', 'basename', 'requirements/reqExport.tpl', 10, false),array('modifier', 'replace', 'requirements/reqExport.tpl', 10, false),array('modifier', 'escape', 'requirements/reqExport.tpl', 38, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => "warning_empty_filename,title_req_export,warning,btn_export,btn_cancel,
             view_file_format_doc,req_spec,export_filename,file_type"), $this);?>


<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='requirements/reqExport.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<?php $this->assign('req_module', 'lib/requirements/'); ?>
<?php $this->assign('url_args', "reqExport.php"); ?>
<?php $this->assign('req_export_url', ($this->_tpl_vars['req_module']).($this->_tpl_vars['url_args'])); ?>

<?php $this->assign('url_args', "reqSpecView.php?req_spec_id="); ?>
<?php $this->assign('req_spec_view_url', ($this->_tpl_vars['basehref']).($this->_tpl_vars['req_module']).($this->_tpl_vars['url_args'])); ?>

<?php if ($this->_tpl_vars['gui']->req_spec_id == 0): ?>
  <?php $this->assign('dummy', $this->_tpl_vars['gui']->tproject_id); ?>
  <?php $this->assign('targetUrl', "lib/project/project_req_spec_mgmt.php?id="); ?>
  <?php $this->assign('xurl', ($this->_tpl_vars['basehref']).($this->_tpl_vars['targetUrl'])); ?>
  <?php $this->assign('cancelUrl', ($this->_tpl_vars['xurl']).($this->_tpl_vars['dummy'])); ?>
<?php else: ?>
  <?php $this->assign('req_spec_view_url', ($this->_tpl_vars['basehref']).($this->_tpl_vars['req_module']).($this->_tpl_vars['url_args'])); ?>
  <?php $this->assign('dummy', $this->_tpl_vars['gui']->req_spec_id); ?>
  <?php $this->assign('cancelUrl', ($this->_tpl_vars['req_spec_view_url']).($this->_tpl_vars['dummy'])); ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes','jsValidate' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
'; ?>

// BUGID 3943: Escape all messages (string)
var warning_empty_filename = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_filename'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var alert_box_title = "<?php echo $this->_tpl_vars['labels']['warning']; ?>
";
<?php echo '
function validateForm(f)
{
  if (isWhitespace(f.export_filename.value)) 
  {
      alert_message(alert_box_title,warning_empty_filename);
      selectField(f, \'export_filename\');
      return false;
  }
  return true;
}
</script>
'; ?>

</head>

<body>
<h1 class="title"><?php echo $this->_tpl_vars['labels']['req_spec']; ?>
 <?php echo @TITLE_SEP; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->req_spec['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<div class="workBack">
<h1 class="title"><?php echo $this->_tpl_vars['labels']['title_req_export']; ?>
</h1>

<form method="post" enctype="multipart/form-data" action="<?php echo $this->_tpl_vars['req_export_url']; ?>
"
      onSubmit="javascript:return validateForm(this);">
    <table>
    <tr>
    <td>
    <?php echo $this->_tpl_vars['labels']['export_filename']; ?>

    </td>
    <td>
  	<input type="text" name="export_filename" maxlength="<?php echo $this->_config[0]['vars']['FILENAME_MAXLEN']; ?>
" 
			           value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->export_filename)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="<?php echo $this->_config[0]['vars']['FILENAME_SIZE']; ?>
"/>
			  				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'export_filename')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	</td>
  	<tr>
  	<td><?php echo $this->_tpl_vars['labels']['file_type']; ?>
</td>
  	<td>
  	<select name="exportType">
  		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->exportTypes), $this);?>

  	</select>
	  <a href=<?php echo $this->_tpl_vars['basehref']; ?>
<?php echo @PARTIAL_URL_TL_FILE_FORMATS_DOCUMENT; ?>
><?php echo $this->_tpl_vars['labels']['view_file_format_doc']; ?>
</a>
  	</td>
  	</tr>
  	</table>
      
	 <div class="groupBtn">
		<input type="hidden" id="doAction" name="doAction" value="export" />
		<input type="hidden" name="req_spec_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_id; ?>
" />
		<input type="hidden" name="scope" id="scope" value="<?php echo $this->_tpl_vars['gui']->scope; ?>
" />
		<input type="hidden" name="tproject_id" value="<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
" />
		<input type="submit" id="export" name="export" value="<?php echo $this->_tpl_vars['labels']['btn_export']; ?>
" 
		       onclick="doAction.value='doExport'" />
     
    <input type="button" name="cancel" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
" 
      onclick="javascript: location.href='<?php echo $this->_tpl_vars['cancelUrl']; ?>
';" />
      
	 </div>
</form>

</div>

</body>
</html>