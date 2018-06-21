<?php /* Smarty version 2.6.26, created on 2013-10-25 13:49:27
         compiled from issuetrackers/issueTrackerEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'issuetrackers/issueTrackerEdit.tpl', 13, false),array('function', 'config_load', 'issuetrackers/issueTrackerEdit.tpl', 65, false),array('function', 'html_options', 'issuetrackers/issueTrackerEdit.tpl', 96, false),array('modifier', 'escape', 'issuetrackers/issueTrackerEdit.tpl', 24, false),array('modifier', 'basename', 'issuetrackers/issueTrackerEdit.tpl', 64, false),array('modifier', 'replace', 'issuetrackers/issueTrackerEdit.tpl', 64, false),)), $this); ?>
<?php $this->assign('url_args', "lib/issuetrackers/issueTrackerEdit.php"); ?>
<?php $this->assign('edit_url', ($this->_tpl_vars['basehref']).($this->_tpl_vars['url_args'])); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'warning,warning_empty_issuetracker_name,warning_empty_issuetracker_type,
             show_event_history,th_issuetracker,th_issuetracker_type,config,btn_cancel,
             issuetracker_show_cfg_example,issuetracker_cfg_example,used_on_testproject'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('jsValidate' => 'yes','openHead' => 'yes')));
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

var warning_empty_issuetracker_name = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_issuetracker_name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
<?php echo '
function validateForm(f)
{
  if (isWhitespace(f.name.value))
  {
      alert_message(alert_box_title,warning_empty_issuetracker_name);
      selectField(f, \'name\');
      return false;
  }
  return true;
}

function displayITSCfgExample(oid,displayOID)
{
	var type;
	type = Ext.get(oid).getValue();
	Ext.Ajax.request({
		url: fRoot+\'lib/ajax/getissuetrackercfgtemplate.php\',
		method: \'GET\',
		params: {
			type: type
		},
		success: function(result, request) {
			var obj = Ext.util.JSON.decode(result.responseText);
			$(displayOID).innerHTML = obj[\'cfg\'];
		},
		failure: function (result, request) {
		}
	});
	
}


</script>
'; ?>

</head>

<body>
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='issuetrackers/issueTrackerEdit.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<?php if ($this->_tpl_vars['gui']->canManage != ""): ?>
  <div class="workBack">
  
  <div class="action_descr"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->action_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

  	<?php if ($this->_tpl_vars['gui']->mgt_view_events == 'yes' && $this->_tpl_vars['gui']->item['id'] > 0): ?>
			<img style="margin-left:5px;" class="clickable" src="<?php echo $this->_tpl_vars['tlImages']['info']; ?>
"
				 onclick="showEventHistoryFor('<?php echo $this->_tpl_vars['gui']->item['id']; ?>
','issuetrackers')" 
				 alt="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
" title="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
"/>
	<?php endif; ?>
  
  </div><br />
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_feedback.tpl", 'smarty_include_vars' => array('user_feedback' => $this->_tpl_vars['gui']->user_feedback)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  	<form name="edit" method="post" action="<?php echo $this->_tpl_vars['edit_url']; ?>
" onSubmit="javascript:return validateForm(this);">
  	<table class="common" style="width:50%">
  		<tr>
  			<th><?php echo $this->_tpl_vars['labels']['th_issuetracker']; ?>
</th>
  			<td><input type="text" name="name" id="name"  
  			           size="<?php echo $this->_config[0]['vars']['ISSUETRACKER_NAME_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['ISSUETRACKER_NAME_MAXLEN']; ?>
" 
  				         value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->item['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
			  		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'name')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			  </td>				
  		</tr>
  		<tr>
  			<th><?php echo $this->_tpl_vars['labels']['th_issuetracker_type']; ?>
</th>
			<td>
  			<select id="type" name="type">
  				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->typeDomain,'selected' => $this->_tpl_vars['gui']->item['type']), $this);?>

  			</select>
  			<a href="javascript:displayITSCfgExample('type','cfg_example')"><?php echo $this->_tpl_vars['labels']['issuetracker_show_cfg_example']; ?>
</a>
			</td>
  		</tr>
		
  		<tr>
  			<th><?php echo $this->_tpl_vars['labels']['config']; ?>
</th>
  			<td><textarea name="cfg" rows="<?php echo $this->_config[0]['vars']['ISSUETRACKER_CFG_ROWS']; ?>
" 
  									 cols="<?php echo $this->_config[0]['vars']['ISSUETRACKER_CFG_COLS']; ?>
"><?php echo $this->_tpl_vars['gui']->item['cfg']; ?>
</textarea></td>
  		</tr>
  		<tr>
  			<th><?php echo $this->_tpl_vars['labels']['issuetracker_cfg_example']; ?>
</th>
  			<td name="cfg_example" id="cfg_example">&nbsp;</td>
  		</tr>
  	</table>

	<?php if ($this->_tpl_vars['gui']->testProjectSet != ''): ?>
  	<table class="common" style="width:50%">
		<tr>
			<th>
			<?php echo $this->_tpl_vars['labels']['used_on_testproject']; ?>

			</th>
		</tr>
		<?php $_from = $this->_tpl_vars['gui']->testProjectSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item_id'] => $this->_tpl_vars['item_def']):
?>
		<tr>
			<td>
			<?php echo ((is_array($_tmp=$this->_tpl_vars['item_def']['testproject_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

			</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
  	</table>
	<?php endif; ?>

  	<div class="groupBtn">	
	<input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['gui']->item['id']; ?>
">
  	<input type="hidden" name="doAction" value="<?php echo $this->_tpl_vars['gui']->operation; ?>
" />
    <input type="submit" name="create" id="create" value="<?php echo $this->_tpl_vars['gui']->submit_button_label; ?>
"
	         onclick="doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
'" />
  	<input type="button" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
"
	         onclick="javascript:location.href=fRoot+'lib/issuetrackers/issueTrackerView.php'" />
  	</div>
  	</form>
  </div>
<?php endif; ?>
</body>
</html>