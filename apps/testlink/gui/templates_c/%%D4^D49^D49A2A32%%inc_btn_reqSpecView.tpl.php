<?php /* Smarty version 2.6.26, created on 2014-03-20 17:02:24
         compiled from requirements/inc_btn_reqSpecView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/inc_btn_reqSpecView.tpl', 7, false),array('function', 'config_load', 'requirements/inc_btn_reqSpecView.tpl', 15, false),array('modifier', 'basename', 'requirements/inc_btn_reqSpecView.tpl', 14, false),array('modifier', 'replace', 'requirements/inc_btn_reqSpecView.tpl', 14, false),array('modifier', 'escape', 'requirements/inc_btn_reqSpecView.tpl', 45, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'btn_req_create,btn_new_req_spec,btn_export_req_spec,
             req_select_create_tc,btn_import_req_spec,btn_import_reqs,
             btn_export_reqs,btn_edit_spec,btn_delete_spec,btn_print_view,
             btn_show_direct_link,btn_copy_requirements,btn_copy_req_spec,
             req_spec_operations, req_operations, btn_freeze_req_spec,btn_new_revision,btn_view_history'), $this);?>

             
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='requirements/inc_btn_reqSpecView.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<!--- inc_btn_reqSpecView.tpl -->
<div class="groupBtn">
  <form style="display: inline;" 
    id="req_spec" name="req_spec" action="<?php echo $this->_tpl_vars['req_module']; ?>
reqSpecEdit.php" method="post">
    <fieldset class="groupBtn">
    <h2><?php echo $this->_tpl_vars['labels']['req_spec_operations']; ?>
</h2>
    <input type="hidden" name="req_spec_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_id; ?>
" />
    <input type="hidden" name="req_spec_revision_id" value="<?php echo $this->_tpl_vars['gui']->req_spec_revision_id; ?>
" />
    <input type="hidden" name="doAction" value="" />
    <input type="hidden" name="log_message" id="log_message" value="" />
    <input type="hidden" name="reqMgrSystemEnabled" id="reqMgrSystemEnabled" 
           value="<?php echo $this->_tpl_vars['gui']->reqMgrSystemEnabled; ?>
" />
    
      
  <?php if ($this->_tpl_vars['gui']->grants->req_mgmt == 'yes'): ?>
    <?php if ($this->_tpl_vars['gui']->btn_import_req_spec == ''): ?>
      <?php $this->assign('btnImportReqSpec', $this->_tpl_vars['labels']['btn_import_req_spec']); ?>
    <?php else: ?>
      <?php $this->assign('btnImportReqSpec', $this->_tpl_vars['gui']->btn_import_req_spec); ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['tlCfg']->req_cfg->child_requirements_mgmt == @ENABLED): ?>
            <input type="button" name="btn_new_req_spec" value="<?php echo $this->_tpl_vars['labels']['btn_new_req_spec']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_spec_new_url']; ?>
'" />  
        <?php endif; ?>
      <input type="submit" name="edit_req_spec"  value="<?php echo $this->_tpl_vars['labels']['btn_edit_spec']; ?>
" 
         onclick="doAction.value='edit'"/>
      <input type="button" name="deleteSRS" value="<?php echo $this->_tpl_vars['labels']['btn_delete_spec']; ?>
"
           onclick="delete_confirmation(<?php echo $this->_tpl_vars['gui']->req_spec['id']; ?>
,'<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['gui']->req_spec['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
                                        '<?php echo $this->_tpl_vars['del_msgbox_title']; ?>
','<?php echo $this->_tpl_vars['warning_msg']; ?>
');"  />

        <input type="button" name="importReqSpec" value="<?php echo $this->_tpl_vars['btnImportReqSpec']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_spec_import_url']; ?>
'" />
         <input type="button" name="exportReq" value="<?php echo $this->_tpl_vars['labels']['btn_export_req_spec']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_spec_export_url']; ?>
'" />
         <input type="button" name="freeze_req_spec" value="<?php echo $this->_tpl_vars['labels']['btn_freeze_req_spec']; ?>
"
                   onclick="delete_confirmation(<?php echo $this->_tpl_vars['gui']->req_spec['id']; ?>
,'<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['gui']->req_spec['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
                   '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['freeze_msgbox_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
', '<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['freeze_warning_msg'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
',
                   pF_freeze_req_spec);"  />
        <input type="button" name="new_revision" id="new_revision" value="<?php echo $this->_tpl_vars['labels']['btn_new_revision']; ?>
" 
                 onclick="doAction.value='doCreateRevision';javascript:ask4log('req_spec','log_message');"/>
  <?php endif; ?>
  
  </form>

    <?php if ($this->_tpl_vars['gui']->revCount > 1): ?>
    <form method="post" 
      action="lib/requirements/reqSpecCompareRevisions.php" name="req_spec_version_compare">
      <input type="hidden" name="req_spec_id" value="<?php echo $this->_tpl_vars['args_reqspec_id']; ?>
" />
      <input type="submit" name="compare_versions" value="<?php echo $this->_tpl_vars['labels']['btn_view_history']; ?>
" />
    </form>
  <?php endif; ?>
  
  <form>
  <input type="button" name="printerFriendly" value="<?php echo $this->_tpl_vars['labels']['btn_print_view']; ?>
"
       onclick="javascript:openPrintPreview('reqSpec',<?php echo $this->_tpl_vars['args_reqspec_id']; ?>
,-1,-1,
                                            'lib/requirements/reqSpecPrint.php');"/>

    </fieldset>
  </form>


  
  <form id="req_operations" name="req_operations">
    <fieldset class="groupBtn">
      <h2><?php echo $this->_tpl_vars['labels']['req_operations']; ?>
</h2>
      <?php if ($this->_tpl_vars['gui']->grants->req_mgmt == 'yes'): ?>
        <input type="button" name="create_req" value="<?php echo $this->_tpl_vars['labels']['btn_req_create']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_edit_url']; ?>
'" />  
        <input type="button" name="importReq" value="<?php echo $this->_tpl_vars['labels']['btn_import_reqs']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_import_url']; ?>
'" />
         <input type="button" name="exportReq" value="<?php echo $this->_tpl_vars['labels']['btn_export_reqs']; ?>
"
               onclick="location='<?php echo $this->_tpl_vars['req_export_url']; ?>
'" />

        <?php if ($this->_tpl_vars['gui']->requirements_count > 0): ?>
                <input type="button" name="create_tcases" value="<?php echo $this->_tpl_vars['labels']['req_select_create_tc']; ?>
"
                       onclick="location='<?php echo $this->_tpl_vars['req_create_tc_url']; ?>
'" />
        
                <input type="button" name="copy_req" value="<?php echo $this->_tpl_vars['labels']['btn_copy_requirements']; ?>
"
                       onclick="location='<?php echo $this->_tpl_vars['req_spec_copy_req_url']; ?>
'" />
        <?php endif; ?>    
      <?php endif; ?>

    </fieldset>
  </form>
</div>