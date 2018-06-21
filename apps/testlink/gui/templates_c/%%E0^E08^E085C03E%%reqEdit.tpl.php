<?php /* Smarty version 2.6.26, created on 2014-03-31 14:14:47
         compiled from requirements/reqEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/reqEdit.tpl', 10, false),array('function', 'config_load', 'requirements/reqEdit.tpl', 19, false),array('function', 'html_options', 'requirements/reqEdit.tpl', 330, false),array('modifier', 'basename', 'requirements/reqEdit.tpl', 18, false),array('modifier', 'replace', 'requirements/reqEdit.tpl', 18, false),array('modifier', 'escape', 'requirements/reqEdit.tpl', 27, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'show_event_history,btn_save,cancel,status,scope,warning,req_doc_id,
             title,warning_expected_coverage,type,warning_expected_coverage_range,
             warning_empty_reqdoc_id,expected_coverage,warning_empty_req_title,
             insert_last_req_doc_id,suggest_create_revision,revision_log_title,
             please_add_revision_log,suggest_create_revision_html,warning_suggest_create_revision,
             warning_unsaved,stay_here_req'), $this);?>

             
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='requirements/reqEdit.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
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
//BUGID 3943: Escape all messages (string)
	var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
	var warning_empty_req_docid = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_reqdoc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
	var warning_empty_req_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_req_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
	var warning_expected_coverage = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_expected_coverage'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
	var warning_expected_coverage_range = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_expected_coverage_range'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  var log_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['revision_log_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  var log_box_text = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['please_add_revision_log'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  // var confirm_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  var confirm_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_suggest_create_revision'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
  var confirm_text = "<?php echo $this->_tpl_vars['labels']['suggest_create_revision_html']; ?>
";

  // To manage hide/show expected coverage logic, depending of req type
  var js_expected_coverage_cfg = new Array();
  
  // DOM Object ID (oid)
  // associative array with attributes
  js_attr_cfg = new Array();
  
  // Configuration for expected coverage attribute
  js_attr_cfg['expected_coverage'] = new Array();
  js_attr_cfg['expected_coverage']['oid'] = new Array();
  js_attr_cfg['expected_coverage']['oid']['input'] = 'expected_coverage';
  js_attr_cfg['expected_coverage']['oid']['container'] = 'expected_coverage_container';

  <?php $_from = $this->_tpl_vars['gui']->attrCfg['expected_coverage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['req_type'] => $this->_tpl_vars['cfg_def']):
?>
    js_attr_cfg['expected_coverage'][<?php echo $this->_tpl_vars['req_type']; ?>
]=<?php echo $this->_tpl_vars['cfg_def']; ?>
;
  <?php endforeach; endif; unset($_from); ?>

  <?php echo '
	function validateForm(f,cfg,check_expected_coverage)
	{
	
	 	var cf_designTime = document.getElementById(\'custom_field_container\');

		if (isWhitespace(f.reqDocId.value)) 
	  {
	    alert_message(alert_box_title,warning_empty_req_docid);
			selectField(f, \'reqDocId\');
			return false;
		}
	  
		if (isWhitespace(f.req_title.value)) 
		{
			alert_message(alert_box_title,warning_empty_req_title);
			selectField(f, \'req_title\');
			return false;
	  }
	
    if (check_expected_coverage)
    {
		  if( cfg[\'expected_coverage\'][f.reqType.value] == 1 )
		  {
		    value = parseInt(f.expected_coverage.value);
		    if (isNaN(value))
		    {
		    	alert_message(alert_box_title,warning_expected_coverage);
		    	selectField(f,\'expected_coverage\');
		    	return false;
		    }
		    else if( value <= 0)
		    {
		    	alert_message(alert_box_title,warning_expected_coverage_range);
		    	selectField(f,\'expected_coverage\');
		    	return false;
		    }
		  }
		  else
		  {
		    f.expected_coverage.value = 0;
		  }
	  }
	  
    /* Validation of a limited type of custom fields */
	  if (cf_designTime)
 	  {
 	  	var cfields_container = cf_designTime.getElementsByTagName(\'input\');
 	  	var cfieldsChecks = validateCustomFields(cfields_container);
	  	if(!cfieldsChecks.status_ok)
	    {
	      	var warning_msg = cfMessages[cfieldsChecks.msg_id];
	        alert_message(alert_box_title,warning_msg.replace(/%s/, cfieldsChecks.cfield_label));
	        return false;
	  	}
    
      /* Text area needs a special access */
 	  	cfields_container = cf_designTime.getElementsByTagName(\'textarea\');
 	  	cfieldsChecks = validateCustomFields(cfields_container);
	  	if(!cfieldsChecks.status_ok)
	    {
	      	var warning_msg = cfMessages[cfieldsChecks.msg_id];
	        alert_message(alert_box_title,warning_msg.replace(/%s/, cfieldsChecks.cfield_label));
	        return false;
	  	}
	  }
    if(f.prompt4log.value == 1)
    {
      Ext.Msg.prompt(log_box_title, log_box_text, function(btn, text){
        if (btn == \'ok\'){
            f.goaway.value=1;
            f.prompt4log.value=0;
            f.do_save.value=1;
            f.save_rev.value=1;
            f.log_message.value=text;
            f.submit();
        }
      },this,true);    
      return false;    
    }
    else if(f.prompt4revision.value == 1)
    {
      Ext.Msg.prompt(confirm_title, confirm_text, function(btn, text){
        if (btn == \'ok\'){
            f.goaway.value=1;
            f.prompt4log.value=0;
            f.do_save.value=1;
            f.save_rev.value=1;
            f.log_message.value=text;
            f.submit();
        }
        else
        {
            f.goaway.value=1;
            f.prompt4log.value=0;
            f.do_save.value=1;
            f.save_rev.value=0;
            f.log_message.value=\'\';
            f.submit();
        }
      },this,true);    
      return false;    
    }
    // Warning!!!!
    // no idea if all these how the require session and submit 
    // will work with the other propmts.    
	  return Ext.ux.requireSessionAndSubmit(f);
	}
	'; ?>

	
	
	/**
   * 
   *
   */
  <?php echo ' 
	window.onload = function()
  {
     // BUGID 4152: do not set focus on req doc id if log message window is shown
     if( document.getElementById(\'prompt4revision\').value == 0 &&  document.getElementById(\'prompt4log\').value == 0) {
	  focusInputField(\'reqDocId\');
	 }
     '; ?>

          <?php if ($this->_tpl_vars['gui']->req_cfg->expected_coverage_management): ?>
      configure_attr('reqType',js_attr_cfg);
     <?php endif; ?>
     <?php echo '
  }
 
  
  /*
  function: configure_attr
            depending of req type, attributes will be set to disable, 
            if its value is nonsense for req type choosen by user.

  args :
         oid_type: id of html input used to choose req type
         cfg: see js_attr_cfg
         

  returns: -

*/
function configure_attr(oid_type,cfg)
{
  var o_reqtype=document.getElementById(oid_type);
  var oid;
  var keys2loop=new Array();
  var idx;
  var key;
  var attr_container;
  var attr2loop=new Array();
  attr2loop[0] = \'expected_coverage\';
  
  for(idx=0;idx < attr2loop.length; idx++)
  {
    key=attr2loop[idx];
    oid=cfg[key][\'oid\'][\'container\'];
    attr_container=document.getElementById(oid);
    if( cfg[key][o_reqtype.value] == 0 )
    {
      attr_container.style.display=\'none\';
    }
    else
    {
      attr_container.style.display=\'\';
    }
  }
} // configure_attr


/**
 * insert_last_doc_id
 *
 */
function insert_last_doc_id() 
{
	var last_id = document.getElementById(\'last_doc_id\').value;
	var field = document.getElementById(\'reqDocId\');
	field.value = last_id;
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
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

	<?php if ($this->_tpl_vars['gui']->action_descr != ''): ?>
		<?php echo $this->_tpl_vars['tlCfg']->gui_title_separator_2; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->action_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

	<?php endif; ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_help.tpl", 'smarty_include_vars' => array('helptopic' => 'hlp_req_edit','show_help_icon' => true)));
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
<form name="reqEdit" id="reqEdit" method="post" 
      action="lib/requirements/reqEdit.php" 
      onSubmit="javascript:return validateForm(this,js_attr_cfg,<?php echo $this->_tpl_vars['gui']->req_cfg->expected_coverage_management; ?>
);">

	<input type="hidden" name="req_spec_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_id; ?>
" />
	<input type="hidden" name="requirement_id" value="<?php echo $this->_tpl_vars['gui']->req_id; ?>
" />
	<input type="hidden" name="req_version_id" value="<?php echo $this->_tpl_vars['gui']->req_version_id; ?>
" />
	<input type="hidden" name="last_doc_id" id="last_doc_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->last_doc_id)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
	<input type="hidden" name="save_rev" id="save_rev" value="0" />
	<input type="hidden" name="log_message" id="log_message" value="" />
	<input type="hidden" name="goaway" id="goaway" value="0" />
	<input type="hidden" name="prompt4log" id="prompt4log" value="<?php echo $this->_tpl_vars['gui']->askForLog; ?>
" />
	<input type="hidden" name="do_save" id="do_save" value="<?php echo $this->_tpl_vars['gui']->askForRevision; ?>
" />
	<input type="hidden" name="prompt4revision" id="prompt4revision" value="<?php echo $this->_tpl_vars['gui']->askForRevision; ?>
" />
	
			<div class="groupBtn">
		<input type="submit" name="create_req" value="<?php echo $this->_tpl_vars['labels']['btn_save']; ?>
"
	         onclick="show_modified_warning = false; doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
';"/>
		<input type="button" name="go_back" value="<?php echo $this->_tpl_vars['labels']['cancel']; ?>
" 
			onclick="javascript: show_modified_warning = false; history.back();"/>
	</div>
		<?php if ($this->_tpl_vars['gui']->doAction == 'create' || $this->_tpl_vars['gui']->doAction == 'doCreate'): ?>
	<div class="groupBtn">
	<input type="checkbox" id="stay_here"  name="stay_here" 
	       <?php if ($this->_tpl_vars['gui']->stay_here): ?> checked="checked" <?php endif; ?>/><?php echo $this->_tpl_vars['labels']['stay_here_req']; ?>

	</div>
	<?php endif; ?>
	<br />
	
  	<div class="labelHolder"><label for="reqDocId"><?php echo $this->_tpl_vars['labels']['req_doc_id']; ?>
</label>
  	   		<?php if ($this->_tpl_vars['gui']->grants->mgt_view_events == 'yes' && $this->_tpl_vars['gui']->req_id): ?>
			<img style="margin-left:5px;" class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/question.gif" 
			     onclick="showEventHistoryFor('<?php echo $this->_tpl_vars['gui']->req_id; ?>
','requirements')" 
			     alt="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
" title="<?php echo $this->_tpl_vars['labels']['show_event_history']; ?>
"/>
		<?php endif; ?>
  	</div>
  	
	<div><input type="text" name="reqDocId" id="reqDocId"
  		        size="<?php echo $this->_config[0]['vars']['REQ_DOCID_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['REQ_DOCID_MAXLEN']; ?>
"
  		        value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->req['req_doc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
  				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'reqDocId')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  				
  				  				<?php if ($this->_tpl_vars['gui']->req_cfg->allow_insertion_of_last_doc_id && $this->_tpl_vars['gui']->last_doc_id != null && ( $this->_tpl_vars['gui']->doAction == 'create' || $this->_tpl_vars['gui']->doAction == 'doCreate' )): ?>
	  				<span onclick="javascript:insert_last_doc_id();" >
	  				<img src="<?php echo @TL_THEME_IMG_DIR; ?>
/insert_step.png"
	  				     title='<?php echo $this->_tpl_vars['labels']['insert_last_req_doc_id']; ?>
: "<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->last_doc_id)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"'/>
	  				</span>
  				<?php endif; ?>
  				
  	</div>
 	<br />
 	<div class="labelHolder"> <label for="req_title"><?php echo $this->_tpl_vars['labels']['title']; ?>
</label></div>
  	<div><input type="text" name="req_title" id="req_title"
  		        size="<?php echo $this->_config[0]['vars']['REQ_TITLE_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['REQ_TITLE_MAXLEN']; ?>
"
  		        value="<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->req['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" required />
  		    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'req_title')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 	 </div>
  	<br />
  	<div class="labelHolder"> <label for="scope"><?php echo $this->_tpl_vars['labels']['scope']; ?>
</label></div>
	<div><?php echo $this->_tpl_vars['gui']->scope; ?>
</div>
 	<br />
  	<div class="labelHolder"> <label for="reqStatus"><?php echo $this->_tpl_vars['labels']['status']; ?>
</label>
     	<select name="reqStatus" id="reqStatus">
  			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->reqStatusDomain,'selected' => $this->_tpl_vars['gui']->req['status']), $this);?>

  		</select>
  	</div>
  	<br />
 	<br />

	<?php if ($this->_tpl_vars['gui']->req['type']): ?>
		<?php $this->assign('preSelectedType', $this->_tpl_vars['gui']->req['type']); ?>
	<?php else: ?>
		<?php $this->assign('preSelectedType', $this->_tpl_vars['gui']->preSelectedType); ?>
	<?php endif; ?>

  	<div class="labelHolder" id="reqType_container"> <label for="reqType"><?php echo $this->_tpl_vars['labels']['type']; ?>
</label>
     	<select name="reqType" id="reqType"
     	     	<?php if ($this->_tpl_vars['gui']->req_cfg->expected_coverage_management): ?>
     	     	  onchange="configure_attr('reqType',js_attr_cfg);"
     	<?php endif; ?>
     	>
  			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->reqTypeDomain,'selected' => $this->_tpl_vars['preSelectedType']), $this);?>

  		</select>
  	</div>
  	<br />
 	<br />
 	
 	<?php if ($this->_tpl_vars['gui']->req_cfg->expected_coverage_management): ?>
  		<div class="labelHolder" id="expected_coverage_container"> <label for="expected_coverage"><?php echo $this->_tpl_vars['labels']['expected_coverage']; ?>
</label>
  	
  	<?php if ($this->_tpl_vars['gui']->req['expected_coverage']): ?>
			<?php $this->assign('coverage_to_display', $this->_tpl_vars['gui']->req['expected_coverage']); ?>
		<?php else: ?>
			<?php $this->assign('coverage_to_display', $this->_tpl_vars['gui']->expected_coverage); ?>
		<?php endif; ?>
  	
  		<input type="text" name="expected_coverage" id="expected_coverage"
  		        size="<?php echo $this->_config[0]['vars']['REQ_EXPECTED_COVERAGE_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['REQ_EXPECTED_COVERAGE_MAXLEN']; ?>
"
  		        value="<?php echo $this->_tpl_vars['coverage_to_display']; ?>
" required />
  		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "error_icon.tpl", 'smarty_include_vars' => array('field' => 'expected_coverage')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	
 		</div>
 	<?php endif; ?>
 	
  	<br />
    
   	   	<?php if ($this->_tpl_vars['gui']->cfields != ""): ?>
   	      	<div id="custom_field_container" class="custom_field_container">
    	<?php echo $this->_tpl_vars['gui']->cfields; ?>

     	</div>
     <br />
  	<?php endif; ?>

			<div class="groupBtn">
		<input type="hidden" name="doAction" id="doAction" value="<?php echo $this->_tpl_vars['gui']->operation; ?>
" />
		<input type="submit" name="create_req" value="<?php echo $this->_tpl_vars['labels']['btn_save']; ?>
"
	         onclick="show_modified_warning = false; doAction.value='<?php echo $this->_tpl_vars['gui']->operation; ?>
';"/>
		<input type="button" name="go_back" value="<?php echo $this->_tpl_vars['labels']['cancel']; ?>
" 
			onclick="javascript: show_modified_warning = false; history.back();"/>
	</div>

  <?php if (isset ( $this->_tpl_vars['gui']->askForLog ) && $this->_tpl_vars['gui']->askForLog): ?>
    <script>
    var ddd = '<?php echo $this->_tpl_vars['gui']->req_cfg->expected_coverage_management; ?>
';
    <?php echo '
    if( document.getElementById(\'prompt4log\').value == 1 )
    {
      validateForm(document.forms[\'reqEdit\'],js_attr_cfg,ddd);
    }
    </script>
    '; ?>

  <?php endif; ?>
  
  <?php if (isset ( $this->_tpl_vars['gui']->askForRevision ) && $this->_tpl_vars['gui']->askForRevision): ?>
    <script>
    var ddd = '<?php echo $this->_tpl_vars['gui']->req_cfg->expected_coverage_management; ?>
';
    <?php echo '
    if( document.getElementById(\'prompt4revision\').value == 1 )
    {
      validateForm(document.forms[\'reqEdit\'],js_attr_cfg,ddd);
    }
    '; ?>

    </script>
  <?php endif; ?>
</form>
</div>

<?php if (isset ( $this->_tpl_vars['gui']->refreshTree ) && $this->_tpl_vars['gui']->refreshTree): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

</body>
</html>