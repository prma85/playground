<?php /* Smarty version 2.6.26, created on 2013-11-05 08:10:54
         compiled from requirements/reqSpecEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/reqSpecEdit.tpl', 11, false),array('function', 'config_load', 'requirements/reqSpecEdit.tpl', 18, false),array('function', 'html_options', 'requirements/reqSpecEdit.tpl', 199, false),array('modifier', 'basename', 'requirements/reqSpecEdit.tpl', 17, false),array('modifier', 'replace', 'requirements/reqSpecEdit.tpl', 17, false),array('modifier', 'escape', 'requirements/reqSpecEdit.tpl', 26, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'warning,warning_empty_req_spec_title,title,scope,req_total,type,
             doc_id,cancel,show_event_history,warning_empty_doc_id,warning_countreq_numeric,
             warning_unsaved,revision_log_title,please_add_revision_log,
             warning_suggest_create_revision,suggest_create_revision_html'), $this);?>

             
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='requirements/reqSpecEdit.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes','jsValidate' => 'yes','editorType' => $this->_tpl_vars['gui']->editorType)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" src="gui/javascript/ext_extensions.js" type="text/javascript"></script>

<script type="text/javascript">
// Escape all messages (string)
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_empty_req_spec_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_req_spec_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_empty_doc_id = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_doc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_countreq_numeric = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_countreq_numeric'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";

// TICKET 4661
var log_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['revision_log_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var log_box_text = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['please_add_revision_log'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var confirm_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_suggest_create_revision'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var confirm_text = "<?php echo $this->_tpl_vars['labels']['suggest_create_revision_html']; ?>
";

var external_req_management = <?php echo $this->_tpl_vars['gui']->external_req_management; ?>
;

<?php echo '
function validateForm(f)
{

	if (isWhitespace(f.doc_id.value)) 
	{
		alert_message(alert_box_title,warning_empty_doc_id);
		selectField(f, \'doc_id\');
		return false;
	}

	if (isWhitespace(f.title.value))
	{
		alert_message(alert_box_title,warning_empty_req_spec_title);
		selectField(f,\'title\');
		return false;
	}
	if (external_req_management && isNaN(parseInt(f.countReq.value)))
	{
		alert_message(alert_box_title,warning_countreq_numeric);
		selectField(f,\'countReq\');
		return false;
	}
    
	// ---------------------------------------------------------
    if(f.prompt4log.value == 1)
	{
  		Ext.Msg.prompt(	log_box_title, log_box_text, 
  						function(btn, text)
  						{
    						if (btn == \'ok\')
    						{
        						f.goaway.value=1;
        						f.prompt4log.value=0;
        						f.do_save.value=1;
        						f.save_rev.value=1;
        						f.log_message.value=text;
        						f.submit();
    						}
    					},
    					this,true);    

  		return false;    
	} // if(f.prompt4log.value == 1)
    else if(f.prompt4revision.value == 1)
	{
  		Ext.Msg.prompt(	confirm_title, confirm_text, 
  						function(btn, text)
  						{
    						if (btn == \'ok\')
    						{
        						f.save_rev.value=1;
        						f.log_message.value=text;
    						}
    						else
    						{
        						f.save_rev.value=0;
        						f.log_message.value=\'\';
    						}
        					f.goaway.value=1;
        					f.prompt4log.value=0;
        					f.do_save.value=1;
        					f.submit();
  						},this,true);    
  		return false;    
	} // else if(f.prompt4revision.value == 1)

	return Ext.ux.requireSessionAndSubmit(f);
}
'; ?>

</script>

<?php if ($this->_tpl_vars['tlCfg']->gui->checkNotSaved): ?>
  <script type="text/javascript">
  var unload_msg = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_unsaved'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  var tc_editor = "<?php echo $this->_tpl_vars['gui']->editorType; ?>
";
  </script>
  <script src="gui/javascript/checkmodified.js" type="text/javascript"></script>
<?php endif; ?>

</head>

<body>
<h1 class="title">
	<?php if ($this->_tpl_vars['gui']->action_descr != ''): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->action_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_help.tpl", 'smarty_include_vars' => array('helptopic' => 'hlp_req_spec_edit','show_help_icon' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</h1>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_update.tpl", 'smarty_include_vars' => array('user_feedback' => $this->_tpl_vars['gui']->user_feedback)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="workBack">
	<form name="reqSpecEdit" id="reqSpecEdit" method="post" 
		  action="lib/requirements/reqSpecEdit.php"
		  onSubmit="javascript:return validateForm(this);">
		  
	    <input type="hidden" name="parentID" value="<?php echo $this->_tpl_vars['gui']->parentID; ?>
" />
	    <input type="hidden" name="req_spec_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_id; ?>
" />
		<input type="hidden" name="req_spec_revision_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_revision_id; ?>
" />

	<div class="groupBtn">
		<input type="hidden" name="doAction" value="<?php echo $this->_tpl_vars['gui']->operation; ?>
" />
		<input type="submit" name="createSRS" value="<?php echo $this->_tpl_vars['gui']->submit_button_label; ?>
"
	       onclick="show_modified_warning = false; doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
';" />
		<input type="button" name="go_back" value="<?php echo $this->_tpl_vars['labels']['cancel']; ?>
" 
			onclick="javascript: show_modified_warning = false; history.back();"/>

				<input type="hidden" name="save_rev" id="save_rev" value="0" />
		<input type="hidden" name="log_message" id="log_message" value="" />
		<input type="hidden" name="goaway" id="goaway" value="0" />
		<input type="hidden" name="prompt4log" id="prompt4log" value="<?php echo $this->_tpl_vars['gui']->askForLog; ?>
" />
		<input type="hidden" name="do_save" id="do_save" value="<?php echo $this->_tpl_vars['gui']->askForRevision; ?>
" />
		<input type="hidden" name="prompt4revision" id="prompt4revision" value="<?php echo $this->_tpl_vars['gui']->askForRevision; ?>
" />


	</div>
	<br />
  	<div class="labelHolder"><label for="doc_id"><?php echo $this->_tpl_vars['labels']['doc_id']; ?>
</label>
  	</div>
	  <div><input type="text" name="doc_id" id="doc_id"
  		        size="<?php echo $this->_config[0]['vars']['REQSPEC_DOCID_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['REQSPEC_DOCID_MAXLEN']; ?>
"
  		        value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->req_spec['doc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
  				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'doc_id')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	</div>
	
		<div class="labelHolder"><label for="req_spec_title"><?php echo $this->_tpl_vars['labels']['title']; ?>
</label>
	   		<?php if ($this->_tpl_vars['mgt_view_events'] == 'yes' && $this->_tpl_vars['gui']->req_spec_id): ?>
				<img style="margin-left:5px;" class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/question.gif" 
				     onclick="showEventHistoryFor('<?php echo $this->_tpl_vars['gui']->req_spec_id; ?>
','req_specs')" 
				     alt="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
" title="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
"/>
			<?php endif; ?>
	   	</div>
	   	<div>
		    <input type="text" id="title" name="title"
		           size="<?php echo $this->_config[0]['vars']['REQ_SPEC_TITLE_SIZE']; ?>
"
				   maxlength="<?php echo $this->_config[0]['vars']['REQ_SPEC_TITLE_MAXLEN']; ?>
"
		           value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->req_spec['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
		  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'req_spec_title')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	   	</div>
	   	<br />
		<div class="labelHolder">
			<label for="scope"><?php echo $this->_tpl_vars['labels']['scope']; ?>
</label>
		</div>
		<div>
					<?php echo $this->_tpl_vars['gui']->scope; ?>

	   	</div>
	   	
	   	<?php if ($this->_tpl_vars['gui']->external_req_management): ?>
	   	<br />
	   	<div class="labelHolder"><label for="countReq"><?php echo $this->_tpl_vars['labels']['req_total']; ?>
</label>
			<input type="text" id="countReq" name="countReq" size="<?php echo $this->_config[0]['vars']['REQ_COUNTER_SIZE']; ?>
" 
			      maxlength="<?php echo $this->_config[0]['vars']['REQ_COUNTER_MAXLEN']; ?>
" value="<?php echo $this->_tpl_vars['gui']->req_spec['total_req']; ?>
" />
		</div>
		<?php endif; ?>
		
	  <br />
		
  	<div class="labelHolder"> <label for="reqSpecType"><?php echo $this->_tpl_vars['labels']['type']; ?>
</label>
     	<select name="reqSpecType">
  			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->reqSpecTypeDomain,'selected' => $this->_tpl_vars['gui']->req_spec['type']), $this);?>

  		</select>
  	</div>

		
	    <br />
		<?php if ($this->_tpl_vars['gui']->cfields != ""): ?>
			<div class="custom_field_container">
		    	<?php echo $this->_tpl_vars['gui']->cfields; ?>

		    </div>
		<br />
		<?php endif; ?>

						<div class="groupBtn">
			<input type="submit" name="createSRS" value="<?php echo $this->_tpl_vars['gui']->submit_button_label; ?>
"
		       onclick="show_modified_warning = false; doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
';" />
			<input type="button" name="go_back" value="<?php echo $this->_tpl_vars['labels']['cancel']; ?>
" 
				onclick="javascript: show_modified_warning = false; history.back();"/>
		</div>
		
  <?php if (isset ( $this->_tpl_vars['gui']->askForLog ) && $this->_tpl_vars['gui']->askForLog): ?>
    <script>
    <?php echo '
    
    if( document.getElementById(\'prompt4log\').value == 1 )
    {
      	validateForm(document.forms[\'reqSpecEdit\'],\'askforlog\');
    }
    </script>
    '; ?>

  <?php endif; ?>
  
  <?php if (isset ( $this->_tpl_vars['gui']->askForRevision ) && $this->_tpl_vars['gui']->askForRevision): ?>
    <script>
    <?php echo '
    if( document.getElementById(\'prompt4revision\').value == 1 )
    {
      validateForm(document.forms[\'reqSpecEdit\'],\'askforrevision\');
    }
    '; ?>

    </script>
  <?php endif; ?>
	</form>
</div>

<script type="text/javascript" defer="1">
   	document.forms[0].doc_id.focus()
</script>

<?php if (isset ( $this->_tpl_vars['gui']->refreshTree ) && $this->_tpl_vars['gui']->refreshTree): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

</body>
</html>