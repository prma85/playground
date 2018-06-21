<?php /* Smarty version 2.6.26, created on 2014-03-31 14:15:04
         compiled from requirements/reqViewVersions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/reqViewVersions.tpl', 12, false),array('function', 'config_load', 'requirements/reqViewVersions.tpl', 36, false),array('function', 'html_options', 'requirements/reqViewVersions.tpl', 311, false),array('modifier', 'escape', 'requirements/reqViewVersions.tpl', 41, false),array('modifier', 'dirname', 'requirements/reqViewVersions.tpl', 216, false),)), $this); ?>

<?php echo lang_get_smarty(array('s' => 'warning_delete_requirement','var' => 'warning_msg'), $this);?>

<?php echo lang_get_smarty(array('s' => 'warning_freeze_requirement','var' => 'freeze_warning_msg'), $this);?>

<?php echo lang_get_smarty(array('s' => 'warning_unfreeze_requirement','var' => 'unfreeze_warning_msg'), $this);?>


<?php echo lang_get_smarty(array('s' => 'delete','var' => 'del_msgbox_title'), $this);?>

<?php echo lang_get_smarty(array('s' => 'freeze','var' => 'freeze_msgbox_title'), $this);?>

<?php echo lang_get_smarty(array('s' => 'unfreeze','var' => 'unfreeze_msgbox_title'), $this);?>


<?php echo lang_get_smarty(array('s' => 'delete_rel_msgbox_msg','var' => 'delete_rel_msgbox_msg'), $this);?>

<?php echo lang_get_smarty(array('s' => 'delete_rel_msgbox_title','var' => 'delete_rel_msgbox_title'), $this);?>

<?php echo lang_get_smarty(array('s' => 'warning_empty_reqdoc_id','var' => 'warning_empty_reqdoc_id'), $this);?>


<?php echo lang_get_smarty(array('var' => 'labels','s' => 'relation_id, relation_type, relation_document, relation_status, relation_project,
             relation_set_by, relation_delete, relations, new_relation, by, title_created,
             relation_destination_doc_id, in, btn_add, img_title_delete_relation, current_req,
             no_records_found,other_versions,version,title_test_case,match_count,warning,
             revision_log_title,please_add_revision_log,commit_title,current_direct_link,
             specific_direct_link,req_does_not_exist'), $this);?>



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

<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf"), $this);?>


<script type="text/javascript">

// Requirement can not be deleted due to JS error -> label has to be escaped
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var delete_rel_msgbox_msg = '<?php echo ((is_array($_tmp=$this->_tpl_vars['delete_rel_msgbox_msg'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
';
var delete_rel_msgbox_title = '<?php echo ((is_array($_tmp=$this->_tpl_vars['delete_rel_msgbox_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
';
var warning_empty_reqdoc_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['warning_empty_reqdoc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
';
var log_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['commit_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var log_box_text = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['please_add_revision_log'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";

<?php echo '
Ext.onReady(function(){ 
'; ?>

<?php $_from = $this->_tpl_vars['gui']->log_target; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['item_id']):
?>
  tip4log(<?php echo $this->_tpl_vars['item_id']; ?>
);
<?php endforeach; endif; unset($_from); ?>
<?php echo '
});


/* All this stuff is needed for logic contained in inc_del_onclick.tpl */
function delete_req(btn, text, o_id)
{ 
  var my_action=fRoot+\'lib/requirements/reqEdit.php?doAction=doDelete&requirement_id=\';
  if( btn == \'yes\' )
  {
    my_action = my_action+o_id;
    window.location=my_action;
  }
}

/**
 * 
 *
 */
function delete_req_version(btn, text, o_id)
{ 
	var my_action=fRoot+\'lib/requirements/reqEdit.php?doAction=doDeleteVersion&req_version_id=\';
  if( btn == \'yes\' )
  {
    my_action = my_action+o_id;
	  window.location=my_action;
	}
}					

/**
 * 
 *
 */
function freeze_req_version(btn, text, o_id)
{
	var my_action=fRoot+\'lib/requirements/reqEdit.php?doAction=doFreezeVersion&req_version_id=\';
	if( btn == \'yes\' )
	{
		my_action = my_action+o_id;
		window.location=my_action;
	}
}

/**
 * 
 *
 */
function unfreeze_req_version(btn, text, o_id)
{
	var my_action=fRoot+\'lib/requirements/reqEdit.php?doAction=doUnfreezeVersion&req_version_id=\';
	if( btn == \'yes\' )
	{
		my_action = my_action+o_id;
		window.location=my_action;
	}
}

/**
 * 
 *
 */
function validate_req_docid_input(input_id, original_value) {

	var input = document.getElementById(input_id);

	if (isWhitespace(input.value) || input.value == original_value) {
    	alert_message(alert_box_title,warning_empty_reqdoc_id);
		return false;
	}

	return true;
}

/**
 * 
 *
 */
function delete_req_relation(btn, text, req_id, relation_id) {
	var my_action=fRoot + \'lib/requirements/reqEdit.php?doAction=doDeleteRelation&requirement_id=\'
	                   + req_id + \'&relation_id=\' + relation_id;
	if( btn == \'yes\' ) {
		window.location=my_action;
	}
}

/**
 * 
 *
 */
function relation_delete_confirmation(requirement_id, relation_id, title, msg, pFunction) {
	var my_msg = msg.replace(\'%i\',relation_id);
	var safe_title = title.escapeHTML();
	Ext.Msg.confirm(safe_title, my_msg,
	                function(btn, text) { 
	                	pFunction(btn,text,requirement_id, relation_id);
	                });
}


/**
 * 
 *
 */
function ask4log(fid_prefix,tid_prefix,idx)
{
  var target = document.getElementById(tid_prefix+\'_\'+idx);
  var my_form = document.getElementById(fid_prefix+\'_\'+idx);
  Ext.Msg.prompt(log_box_title, log_box_text, function(btn, text){
      if (btn == \'ok\')
      {
          target.value=text;
          my_form.submit();
      }
  },this,true);    
  return false;    
} 

/**
 * 
 * @since 1.9.4
 */
function tip4log(itemID)
{
	var fUrl = fRoot+\'lib/ajax/getreqlog.php?item_id=\';
	new Ext.ToolTip({
        target: \'tooltip-\'+itemID,
        width: 500,
        autoLoad:{url: fUrl+itemID},
        dismissDelay: 0,
        trackMouse: true
    });
}
'; ?>


// **************************************************************************
// VERY IMPORTANT:
// needed to make delete_confirmation() understand we are using a function.
// if I pass delete_req as argument javascript complains.
// **************************************************************************
var pF_delete_req = delete_req;
var pF_delete_req_version = delete_req_version; 
var pF_freeze_req_version = freeze_req_version;
var pF_delete_req_relation = delete_req_relation;
var pF_unfreeze_req_version = unfreeze_req_version;
</script>

<script language="JavaScript" src="gui/javascript/expandAndCollapseFunctions.js" type="text/javascript"></script>

<?php if ($this->_tpl_vars['gui']->bodyOnLoad != ''): ?>
<script language="JavaScript">
  var <?php echo $this->_tpl_vars['gui']->dialogName; ?>
 = new std_dialog('&refreshTree');
</script>  
<?php endif; ?>

</head>

<?php $this->assign('my_style', ""); ?>
<?php if ($this->_tpl_vars['gui']->hilite_item_name): ?>
    <?php $this->assign('my_style', "background:#059; color:white; margin:0px 0px 4px 0px;padding:3px;"); ?>
<?php endif; ?>

<?php $this->assign('this_template_dir', ((is_array($_tmp='requirements/reqViewVersions.tpl')) ? $this->_run_mod_handler('dirname', true, $_tmp) : dirname($_tmp))); ?>

<body onLoad="viewElement(document.getElementById('other_versions'),false);<?php echo $this->_tpl_vars['gui']->bodyOnLoad; ?>
" onUnload="<?php echo $this->_tpl_vars['gui']->bodyOnUnload; ?>
">
<h1 class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->main_descr)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php if (isset ( $this->_tpl_vars['gui']->show_match_count )): ?> - <?php echo $this->_tpl_vars['labels']['match_count']; ?>
: <?php echo $this->_tpl_vars['gui']->match_count; ?>
<?php endif; ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_help.tpl", 'smarty_include_vars' => array('helptopic' => 'hlp_req_view','show_help_icon' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</h1>
<?php if (! isset ( $this->_tpl_vars['refresh_tree'] )): ?>
  <?php $this->assign('refresh_tree', false); ?>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_update.tpl", 'smarty_include_vars' => array('user_feedback' => $this->_tpl_vars['user_feedback'],'refresh' => $this->_tpl_vars['refresh_tree'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="workBack">

<?php if (isset ( $this->_tpl_vars['gui']->current_version )): ?>
<?php unset($this->_sections['idx']);
$this->_sections['idx']['name'] = 'idx';
$this->_sections['idx']['loop'] = is_array($_loop=$this->_tpl_vars['gui']->current_version) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['idx']['show'] = true;
$this->_sections['idx']['max'] = $this->_sections['idx']['loop'];
$this->_sections['idx']['step'] = 1;
$this->_sections['idx']['start'] = $this->_sections['idx']['step'] > 0 ? 0 : $this->_sections['idx']['loop']-1;
if ($this->_sections['idx']['show']) {
    $this->_sections['idx']['total'] = $this->_sections['idx']['loop'];
    if ($this->_sections['idx']['total'] == 0)
        $this->_sections['idx']['show'] = false;
} else
    $this->_sections['idx']['total'] = 0;
if ($this->_sections['idx']['show']):

            for ($this->_sections['idx']['index'] = $this->_sections['idx']['start'], $this->_sections['idx']['iteration'] = 1;
                 $this->_sections['idx']['iteration'] <= $this->_sections['idx']['total'];
                 $this->_sections['idx']['index'] += $this->_sections['idx']['step'], $this->_sections['idx']['iteration']++):
$this->_sections['idx']['rownum'] = $this->_sections['idx']['iteration'];
$this->_sections['idx']['index_prev'] = $this->_sections['idx']['index'] - $this->_sections['idx']['step'];
$this->_sections['idx']['index_next'] = $this->_sections['idx']['index'] + $this->_sections['idx']['step'];
$this->_sections['idx']['first']      = ($this->_sections['idx']['iteration'] == 1);
$this->_sections['idx']['last']       = ($this->_sections['idx']['iteration'] == $this->_sections['idx']['total']);
?>

	<?php $this->assign('reqID', $this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['id']); ?>
        <?php if ($this->_tpl_vars['gui']->other_versions[$this->_sections['idx']['index']] != null): ?>
        <?php $this->assign('my_delete_version', true); ?>
    <?php else: ?>
        <?php $this->assign('my_delete_version', false); ?>
    <?php endif; ?>
  
  	    <?php if ($this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['is_open']): ?>
        <?php $this->assign('frozen_version', false); ?>
    <?php else: ?>
        <?php $this->assign('frozen_version', true); ?>
    <?php endif; ?>
  
    <h2 style="<?php echo $this->_tpl_vars['my_style']; ?>
">
	  <?php echo $this->_tpl_vars['tlImages']['toggle_direct_link']; ?>
 &nbsp;
	  <?php if ($this->_tpl_vars['gui']->display_path): ?>
	      <?php $_from = $this->_tpl_vars['gui']->path_info[$this->_tpl_vars['reqID']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['path_part']):
?>
	          <?php echo ((is_array($_tmp=$this->_tpl_vars['path_part'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 /
	      <?php endforeach; endif; unset($_from); ?>
	  <?php endif; ?>
    <?php if (! $this->_tpl_vars['gui']->show_title): ?>
	    <?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['req_doc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
    <?php endif; ?>
    <div class="direct_link" style='display:none'>
    <a href="<?php echo $this->_tpl_vars['gui']->direct_link; ?>
" target="_blank"><?php echo $this->_tpl_vars['labels']['current_direct_link']; ?>
</a><br/>
    <a href="<?php echo $this->_tpl_vars['gui']->direct_link; ?>
&version=<?php echo $this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['version']; ?>
" target="_blank"><?php echo $this->_tpl_vars['labels']['specific_direct_link']; ?>
</a><br/>
    </div>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['this_template_dir'])."/reqViewVersionsViewer.tpl", 'smarty_include_vars' => array('args_req_coverage' => $this->_tpl_vars['gui']->req_coverage,'args_req' => $this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0],'args_gui' => $this->_tpl_vars['gui'],'args_grants' => $this->_tpl_vars['gui']->grants,'args_can_copy' => true,'args_can_delete_req' => true,'args_can_delete_version' => $this->_tpl_vars['my_delete_version'],'args_frozen_version' => $this->_tpl_vars['frozen_version'],'args_show_version' => true,'args_show_title' => $this->_tpl_vars['gui']->show_title,'args_cf' => $this->_tpl_vars['gui']->cfields_current_version[$this->_sections['idx']['index']],'args_tproject_name' => $this->_tpl_vars['gui']->tproject_name,'args_reqspec_name' => ($this->_tpl_vars['gui'])."->current_version[idx][0]['req_spec_title']")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  
  <?php $this->assign('downloadOnly', false); ?>
  <?php if ($this->_tpl_vars['gui']->grants->req_mgmt != 'yes' || $this->_tpl_vars['frozen_version']): ?>
    <?php $this->assign('downloadOnly', true); ?>
  <?php endif; ?>
  
  <?php if (! isset ( $this->_tpl_vars['loadOnCancelURL'] )): ?>
      <?php $this->assign('loadOnCancelURL', ""); ?>
  <?php endif; ?> 
           
		<?php if ($this->_tpl_vars['gui']->req_cfg->relations->enable && ! $this->_tpl_vars['frozen_version']): ?> 	
				<form method="post" action="lib/requirements/reqEdit.php" 
				onSubmit="javascript:return validate_req_docid_input('relation_destination_req_doc_id', 
				                                                     '<?php echo $this->_tpl_vars['labels']['relation_destination_doc_id']; ?>
');">
		
		<table class="simple" id="relations">
		
			<tr><th colspan="7"><?php echo $this->_tpl_vars['labels']['relations']; ?>
</th></tr>
		
			<?php if ($this->_tpl_vars['gui']->req_add_result_msg): ?>
				<tr style="height:40px; vertical-align: middle;"><td style="height:40px; vertical-align: middle;" colspan="7">
					<?php echo $this->_tpl_vars['gui']->req_add_result_msg; ?>

				</td></tr>
			<?php endif; ?>
		
			<?php if ($this->_tpl_vars['gui']->req_relations['rw']): ?>
			<tr style="height:40px; vertical-align: middle;"><td style="height:40px; vertical-align: middle;" colspan="7">
			
				<span class="bold"><?php echo $this->_tpl_vars['labels']['new_relation']; ?>
:</span> <?php echo $this->_tpl_vars['labels']['current_req']; ?>

					
				<select name="relation_type">
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->req_relation_select['items'],'selected' => $this->_tpl_vars['gui']->req_relation_select['selected']), $this);?>

				</select>
		
				<input type="text" name="relation_destination_req_doc_id" id="relation_destination_req_doc_id"
						   value="<?php echo $this->_tpl_vars['labels']['relation_destination_doc_id']; ?>
" 
				       size="<?php echo $this->_config[0]['vars']['REQ_DOCID_SIZE']; ?>
" maxlength="<?php echo $this->_config[0]['vars']['REQ_DOCID_MAXLEN']; ?>
" 
				       onclick="javascript:this.value=''" />
			
								<?php if ($this->_tpl_vars['gui']->req_cfg->relations->interproject_linking): ?>
						<?php echo $this->_tpl_vars['labels']['relation_project']; ?>
 <select name="relation_destination_testproject_id">
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['gui']->testproject_select['items'],'selected' => $this->_tpl_vars['gui']->testproject_select['selected']), $this);?>

						</select>
				<?php endif; ?>	
				
				<input type="hidden" name="doAction" value="doAddRelation" />
				<input type="hidden" name="relation_source_req_id" value="<?php echo $this->_tpl_vars['gui']->req_id; ?>
" />
				<input type="submit" name="relation_submit_btn" value="<?php echo $this->_tpl_vars['labels']['btn_add']; ?>
" />
				
				</td>
			</tr>
			<?php endif; ?>			
		<?php if ($this->_tpl_vars['gui']->req_relations['num_relations']): ?>
			
			<tr>
				<th><nobr><?php echo $this->_tpl_vars['labels']['relation_id']; ?>
</nobr></th>
				<th><nobr><?php echo $this->_tpl_vars['labels']['relation_type']; ?>
</nobr></th>
				
				<?php if ($this->_tpl_vars['gui']->req_cfg->relations->interproject_linking): ?>
				  <?php $this->assign('colspan', 1); ?>
				<?php else: ?>
				  <?php $this->assign('colspan', 2); ?>
				<?php endif; ?>
				
				<th colspan="<?php echo $this->_tpl_vars['colspan']; ?>
"><?php echo $this->_tpl_vars['labels']['relation_document']; ?>
</th>
				<th><nobr><?php echo $this->_tpl_vars['labels']['relation_status']; ?>
</nobr></th>
				
				<?php if ($this->_tpl_vars['gui']->req_cfg->relations->interproject_linking): ?>
					<th><nobr><?php echo $this->_tpl_vars['labels']['relation_project']; ?>
</nobr></th>
				<?php endif; ?>
				
				<th><nobr><?php echo $this->_tpl_vars['labels']['relation_set_by']; ?>
</nobr></th>
				<?php if ($this->_tpl_vars['gui']->req_relations['rw']): ?>
				<th><nobr><?php echo $this->_tpl_vars['labels']['relation_delete']; ?>
</nobr></th>
				<?php endif; ?>
			</tr>
			
			<?php $_from = $this->_tpl_vars['gui']->req_relations['relations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['relation']):
?>
			<?php $this->assign('status', $this->_tpl_vars['relation']['related_req']['status']); ?>
				<tr>
					<td><?php echo $this->_tpl_vars['relation']['id']; ?>
</td>
					<td class="bold"><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['type_localized'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</nobr></td>
					<td colspan="<?php echo $this->_tpl_vars['colspan']; ?>
"><a href="javascript:openLinkedReqWindow(<?php echo $this->_tpl_vars['relation']['related_req']['id']; ?>
)">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['related_req']['req_doc_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:
						<?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['related_req']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
					<td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->reqStatus[$this->_tpl_vars['status']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</nobr></td>
					
										<?php if ($this->_tpl_vars['gui']->req_cfg->relations->interproject_linking): ?>
						<td><nobr><?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['related_req']['testproject_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</nobr></td>
					<?php endif; ?>
					
					<td><nobr><span title="<?php echo $this->_tpl_vars['labels']['title_created']; ?>
 <?php echo $this->_tpl_vars['relation']['creation_ts']; ?>
 <?php echo $this->_tpl_vars['labels']['by']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['relation']['author'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span></nobr></td>

					<td align="center">
					<?php if ($this->_tpl_vars['gui']->req_relations['rw']): ?>
	             	<a href="javascript:relation_delete_confirmation(<?php echo $this->_tpl_vars['gui']->req_relations['req']['id']; ?>
, <?php echo $this->_tpl_vars['relation']['id']; ?>
, 
	             	                                                 delete_rel_msgbox_title, delete_rel_msgbox_msg, 
	             	                                                 pF_delete_req_relation);">
	      			    <img src="<?php echo @TL_THEME_IMG_DIR; ?>
/trash.png" 
	      			    	   title="<?php echo $this->_tpl_vars['labels']['img_title_delete_relation']; ?>
"  style="border:none" /></a>
	              	<?php endif; ?>
	              </td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
						
		<?php endif; ?>
		
		</table>
		</form>
	
	<?php endif; ?>
	
			     
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_attachments.tpl", 'smarty_include_vars' => array('attach_id' => $this->_tpl_vars['reqID'],'attach_tableName' => $this->_tpl_vars['gui']->attachmentTableName,'attach_attachmentInfos' => $this->_tpl_vars['gui']->attachments[$this->_tpl_vars['reqID']],'attach_downloadOnly' => $this->_tpl_vars['downloadOnly'],'attach_loadOnCancelURL' => $this->_tpl_vars['loadOnCancelURL'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		         
	    <?php if ($this->_tpl_vars['gui']->other_versions[$this->_sections['idx']['index']] != null): ?>
        <?php $this->assign('vid', $this->_tpl_vars['gui']->current_version[$this->_sections['idx']['index']][0]['id']); ?>
        <?php $this->assign('div_id', "vers_".($this->_tpl_vars['vid'])); ?>
        <?php $this->assign('memstatus_id', "mem_".($this->_tpl_vars['div_id'])); ?>
  
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_show_hide_mgmt.tpl", 'smarty_include_vars' => array('show_hide_container_title' => $this->_tpl_vars['labels']['other_versions'],'show_hide_container_id' => $this->_tpl_vars['div_id'],'show_hide_container_draw' => false,'show_hide_container_class' => 'exec_additional_info','show_hide_container_view_status_id' => $this->_tpl_vars['memstatus_id'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
               
        <div id="vers_<?php echo $this->_tpl_vars['vid']; ?>
" class="workBack">
        
  	    <?php $_from = $this->_tpl_vars['gui']->other_versions[$this->_sections['idx']['index']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rdx'] => $this->_tpl_vars['my_req']):
?>
            <?php $this->assign('version_num', $this->_tpl_vars['my_req']['version']); ?>
            <?php $this->assign('title', $this->_tpl_vars['labels']['version']); ?>
            <?php $this->assign('title', ($this->_tpl_vars['title'])." ".($this->_tpl_vars['version_num'])); ?>
            
            <?php $this->assign('div_id', "v_".($this->_tpl_vars['vid'])); ?>
            <?php $this->assign('sep', '_'); ?>
            <?php $this->assign('div_id', ($this->_tpl_vars['div_id']).($this->_tpl_vars['sep']).($this->_tpl_vars['version_num'])); ?>
            <?php $this->assign('memstatus_id', "mem_".($this->_tpl_vars['div_id'])); ?>
           
           	    		    <?php if ($this->_tpl_vars['my_req']['is_open']): ?>
        		  <?php $this->assign('frozen_version', false); ?>
    		    <?php else: ?>
        		  <?php $this->assign('frozen_version', true); ?>
    		    <?php endif; ?>
           
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_show_hide_mgmt.tpl", 'smarty_include_vars' => array('show_hide_container_title' => $this->_tpl_vars['title'],'show_hide_container_id' => $this->_tpl_vars['div_id'],'show_hide_container_draw' => false,'show_hide_container_class' => 'exec_additional_info','show_hide_container_view_status_id' => $this->_tpl_vars['memstatus_id'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	          <div id="<?php echo $this->_tpl_vars['div_id']; ?>
" class="workBack">
           		
		          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['this_template_dir'])."/reqViewVersionsViewer.tpl", 'smarty_include_vars' => array('args_req_coverage' => $this->_tpl_vars['gui']->req_coverage,'args_req' => $this->_tpl_vars['my_req'],'args_gui' => $this->_tpl_vars['gui'],'args_grants' => $this->_tpl_vars['gui']->grants,'args_can_copy' => false,'args_can_delete_req' => false,'args_can_delete_version' => true,'args_frozen_version' => $this->_tpl_vars['frozen_version'],'args_show_version' => true,'args_show_title' => true,'args_cf' => $this->_tpl_vars['gui']->cfields_other_versions[$this->_sections['idx']['index']][$this->_tpl_vars['rdx']])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	         </div>
  	         <br />
  	         
		    <?php endforeach; endif; unset($_from); ?>
		    </div>
  
      	      	      	<?php echo '
      	<script type="text/javascript">
      	'; ?>

 	  	      viewElement(document.getElementById('vers_<?php echo $this->_tpl_vars['vid']; ?>
'),false);
    	  		<?php $_from = $this->_tpl_vars['gui']->other_versions[$this->_sections['idx']['index']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['my_req']):
?>
  	  	      viewElement(document.getElementById('v_<?php echo $this->_tpl_vars['vid']; ?>
_<?php echo $this->_tpl_vars['my_req']['version']; ?>
'),false);
			      <?php endforeach; endif; unset($_from); ?>
      	<?php echo '
      	</script>
      	'; ?>

      	    <?php endif; ?>
    <br>
<?php endfor; endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['gui']->reqHasBeenDeleted): ?>
		<?php echo $this->_tpl_vars['labels']['req_does_not_exist']; ?>

	<?php else: ?>
		<?php echo $this->_tpl_vars['labels']['no_records_found']; ?>

	<?php endif; ?>
<?php endif; ?>

<?php if (isset ( $this->_tpl_vars['gui']->refreshTree ) && $this->_tpl_vars['gui']->refreshTree): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</div>
</body>
</html>