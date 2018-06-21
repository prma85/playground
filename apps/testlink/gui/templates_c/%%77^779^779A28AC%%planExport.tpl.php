<?php /* Smarty version 2.6.26, created on 2013-12-13 13:42:34
         compiled from plan/planExport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/planExport.tpl', 9, false),array('function', 'config_load', 'plan/planExport.tpl', 14, false),array('function', 'html_options', 'plan/planExport.tpl', 64, false),array('modifier', 'basename', 'plan/planExport.tpl', 13, false),array('modifier', 'replace', 'plan/planExport.tpl', 13, false),array('modifier', 'escape', 'plan/planExport.tpl', 19, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'export_filename,warning_empty_filename,file_type,warning,export_cfields,title_req_export,
             view_file_format_doc,export_with_keywords,btn_export,btn_cancel'), $this);?>
 

<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='plan/planExport.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>

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

<script type="text/javascript">
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_empty_filename = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_filename'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
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
'; ?>

</script>
</head>

<body>
<h1 class="title"><?php echo $this->_tpl_vars['gui']->page_title; ?>
<?php echo @TITLE_SEP; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->object_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<div class="workBack">

<?php if ($this->_tpl_vars['gui']->do_it == 1): ?>
  <form method="post" id="export_xml" enctype="multipart/form-data" 
        action="lib/plan/planExport.php"
        onSubmit="javascript:return validateForm(this);">
    <input type="hidden" name="tproject_id" id="tproject_id" value="<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
">
    <input type="hidden" name="tplan_id" id="tplan_id" value="<?php echo $this->_tpl_vars['gui']->tplan_id; ?>
">
    <input type="hidden" name="platform_id" id="platform_id" value="<?php echo $this->_tpl_vars['gui']->platform_id; ?>
">
    <input type="hidden" name="build_id" id="build_id" value="<?php echo $this->_tpl_vars['gui']->build_id; ?>
">
    <input type="hidden" name="exportContent" id="exportContent" value="<?php echo $this->_tpl_vars['gui']->exportContent; ?>
">
    <table>
    <tr>
    <td>
    <?php echo $this->_tpl_vars['labels']['export_filename']; ?>

    </td>
    <td>
  	<input type="text" id="export_filename" name="export_filename" maxlength="<?php echo $this->_config[0]['vars']['FILENAME_MAXLEN']; ?>
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
><?php echo lang_get_smarty(array('s' => 'view_file_format_doc'), $this);?>
</a>
  	</td>
  	</tr>
  	</table>
  	
  	<div class="groupBtn">
  		<input type="submit" name="export" value="<?php echo $this->_tpl_vars['labels']['btn_export']; ?>
" />
  		<input type="button" name="cancel" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
"
    		     <?php if ($this->_tpl_vars['gui']->goback_url != ''): ?>  onclick="location='<?php echo $this->_tpl_vars['gui']->goback_url; ?>
'"
    		     <?php else: ?>  onclick="javascript:history.back();" <?php endif; ?> />
  	</div>
  </form>
<?php else: ?>
	<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->nothing_todo_msg)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

<?php endif; ?>

</div>

</body>
</html>