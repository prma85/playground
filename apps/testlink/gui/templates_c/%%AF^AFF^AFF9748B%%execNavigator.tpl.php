<?php /* Smarty version 2.6.26, created on 2013-10-25 13:45:15
         compiled from execute/execNavigator.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'execute/execNavigator.tpl', 18, false),array('function', 'config_load', 'execute/execNavigator.tpl', 136, false),array('modifier', 'escape', 'execute/execNavigator.tpl', 113, false),array('modifier', 'basename', 'execute/execNavigator.tpl', 134, false),array('modifier', 'replace', 'execute/execNavigator.tpl', 134, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => "filter_result,caption_nav_filter_settings,filter_owner,test_plan,filter_on,
             platform,exec_build,btn_apply_filter,build,keyword,filter_tcID,execution_type,
             include_unassigned_testcases,priority,caption_nav_filters,caption_nav_settings,
             block_filter_not_run_latest_exec"), $this);?>
       


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array('bResetEXTCss' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript" src='gui/javascript/ext_extensions.js'></script>

<script type="text/javascript">
var msg_block_filter_not_run_latest_exec = '<?php echo $this->_tpl_vars['labels']['block_filter_not_run_latest_exec']; ?>
';
var code_lastest_exec_method = <?php echo $this->_tpl_vars['gui']->lastest_exec_method; ?>
;
var code_not_run = '<?php echo $this->_tpl_vars['gui']->not_run; ?>
';
</script>

<?php echo '
<script type="text/javascript">
	  treeCfg = { tree_div_id:\'tree_div\',root_name:"",root_id:0,root_href:"",
	              loader:"", enableDD:false, dragDropBackEndUrl:\'\',children:"" };
	  Ext.onReady(function() {
		Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

		// Use a collapsible panel for filter settings
		// and place a help icon in ther header
		var settingsPanel = new Ext.ux.CollapsiblePanel({
			id: \'tl_exec_filter\',
			applyTo: \'settings_panel\',
			tools: [{
				id: \'help\',
				handler: function(event, toolEl, panel) {
					show_help(help_localized_text);
				}
			}]
		});
		var filtersPanel = new Ext.ux.CollapsiblePanel({
			id: \'tl_exec_settings\',
			applyTo: \'filter_panel\'
		});
	});

/**
 * 
 *
 * internal revisions
 */
function openExportTestPlan(windows_title,tproject_id,tplan_id,platform_id,build_id) 
{
  args = "tproject_id=" + tproject_id + "&tplan_id=" + tplan_id + "&platform_id=" + platform_id + "&build_id=" + build_id;  
  args = args + "&exportContent=tree";
  wref = window.open(fRoot+"lib/plan/planExport.php?"+args,
	                 windows_title,"menubar=no,width=650,height=500,toolbar=no,scrollbars=yes");
  wref.focus();
}



/**
 * 
 *
 * internal revisions
 * TICKET 4788
 */
function validateForm(the_form)
{
	var filterMethod = document.getElementById(\'filter_result_method\');
	var execStatus = document.getElementById(\'filter_result_result\');
	var loop2do = execStatus.length;
	var idx = 0;
	var notRunFound = false;
	var status_ok = true;

	if( filterMethod.value == code_lastest_exec_method)
	{
		for(idx=0; idx<loop2do; idx++)
		{
			if(execStatus[idx].selected && execStatus[idx].value == code_not_run)
			{
				status_ok = false;
				alert(msg_block_filter_not_run_latest_exec);
				break;
			}
		}
	}
	return status_ok;
}
</script>
'; ?>



<script type="text/javascript">
	treeCfg.root_name='<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->ajaxTree->root_node->name)) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
';
	treeCfg.root_id=<?php echo $this->_tpl_vars['gui']->ajaxTree->root_node->id; ?>
;
	treeCfg.root_href='<?php echo $this->_tpl_vars['gui']->ajaxTree->root_node->href; ?>
';
	treeCfg.children=<?php echo $this->_tpl_vars['gui']->ajaxTree->children; ?>
;
	treeCfg.cookiePrefix='<?php echo $this->_tpl_vars['gui']->ajaxTree->cookiePrefix; ?>
';
</script>

<script type="text/javascript" src='gui/javascript/execTreeWithMenu.js'></script>

<script language="JavaScript" src="gui/javascript/expandAndCollapseFunctions.js" type="text/javascript"></script>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'inc_filter_panel_js.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


	
<?php $this->assign('cfg_section', ((is_array($_tmp=((is_array($_tmp='execute/execNavigator.tpl')) ? $this->_run_mod_handler('basename', true, $_tmp) : basename($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, ".tpl", "") : smarty_modifier_replace($_tmp, ".tpl", ""))); ?>
<?php $this->assign('build_number', $this->_tpl_vars['control']->settings['setting_build']['selected']); ?>
<?php echo smarty_function_config_load(array('file' => "input_dimensions.conf",'section' => $this->_tpl_vars['cfg_section']), $this);?>


<h1 class="title"><?php echo $this->_tpl_vars['labels']['test_plan']; ?>
<?php echo $this->_tpl_vars['tlCfg']->gui_title_separator_1; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['control']->args->testplan_name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

<?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>
<?php echo $this->_tpl_vars['labels']['build']; ?>
<?php echo $this->_tpl_vars['tlCfg']->gui_title_separator_1; ?>

<?php echo ((is_array($_tmp=$this->_tpl_vars['control']->settings['setting_build']['items'][$this->_tpl_vars['build_number']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</h1>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'inc_filter_panel.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_tree_control.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="tree_div" style="overflow:auto; height:100%;border:1px solid #c3daf9;"></div>


</body>
</html>