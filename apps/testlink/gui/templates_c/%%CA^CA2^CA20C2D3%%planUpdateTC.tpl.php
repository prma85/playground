<?php /* Smarty version 2.6.26, created on 2013-12-19 15:45:39
         compiled from plan/planUpdateTC.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/planUpdateTC.tpl', 13, false),array('function', 'html_options', 'plan/planUpdateTC.tpl', 144, false),array('modifier', 'escape', 'plan/planUpdateTC.tpl', 30, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'no_testcase_available,test_plan,update_testcase_versions,
             update_all_testcase_versions,th_test_case,
             warning,no_testcase_checked,
             version,linked_version,newest_version,
             note_keyword_filter,check_uncheck_all,
             check_uncheck_all_checkboxes,th_id,has_been_executed,show_tcase_spec,
             update_to_version,inactive_testcase,btn_update_testplan_tcversions,
             compare,design,execution_history'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array('openHead' => 'yes')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_del_onclick.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_jsCheckboxes.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script type="text/javascript">
'; ?>

var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_no_testcase_checked = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['no_testcase_checked'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
<?php echo '
function validateForm(f)
{
  if( checkbox_count_checked(f.id) == 0)
  {
      alert_message(alert_box_title,warning_no_testcase_checked);
      return false;
  } 
 
  return true;
}
</script>
'; ?>


</head>

<?php $this->assign('update_cb', 'achecked_tc'); ?> <?php $this->assign('item_number', 0); ?>

<body class="testlink">
<h1 class="title"><?php echo $this->_tpl_vars['labels']['test_plan']; ?>
<?php echo @TITLE_SEP; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->testPlanName)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<?php if ($this->_tpl_vars['gui']->hasItems): ?>
  <form name="updateTcForm" id="updateTcForm" method="post"
        onSubmit="javascript:return validateForm(this);">
     <h1 class="title"><?php echo $this->_tpl_vars['gui']->action_descr; ?>
</h1>
     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_update.tpl", 'smarty_include_vars' => array('result' => $this->_tpl_vars['sqlResult'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="workBack">
    <?php if ($this->_tpl_vars['gui']->instructions != ''): ?>
      <?php echo $this->_tpl_vars['gui']->instructions; ?>

      <?php if ($this->_tpl_vars['gui']->user_feedback != ''): ?>
         <br><?php echo $this->_tpl_vars['gui']->user_feedback; ?>

      <?php endif; ?>     
    <?php endif; ?>     


  <?php if ($this->_tpl_vars['gui']->operationType == 'standard'): ?>
    <input type="hidden" name="update_all_value"  id="update_all_value"  value="0" />

  	<?php $_from = $this->_tpl_vars['gui']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ts']):
?>
  	  <?php $this->assign('item_number', $this->_tpl_vars['item_number']+1); ?>
  	  <?php $this->assign('ts_id', $this->_tpl_vars['ts']['testsuite']['id']); ?>
  	  <?php $this->assign('div_id', "div_".($this->_tpl_vars['ts_id'])); ?>
  	
  	  <div id="<?php echo $this->_tpl_vars['div_id']; ?>
"  style="margin:0px 0px 0px <?php echo $this->_tpl_vars['ts']['level']; ?>
0px;">
  	    <h3 class="testlink">
        <?php if ($this->_tpl_vars['item_number'] == 1): ?>
  	    <img src="<?php echo $this->_tpl_vars['tlImages']['toggle_all']; ?>
" border="0" alt="<?php echo $this->_tpl_vars['labels']['check_uncheck_all']; ?>
" 
                   title="<?php echo $this->_tpl_vars['labels']['check_uncheck_all']; ?>
" 
                   onclick="cs_all_checkbox_in_div('updateTcForm','<?php echo $this->_tpl_vars['update_cb']; ?>
','update_all_value');" />
        <?php endif; ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['ts']['testsuite']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
  	    </h3> 
     
              <input type="hidden" name="update_value_<?php echo $this->_tpl_vars['ts_id']; ?>
"  id="update_value_<?php echo $this->_tpl_vars['ts_id']; ?>
"  value="0" />
              
             
       <?php if ($this->_tpl_vars['ts']['testcase_qty'] > 0 || $this->_tpl_vars['ts']['linked_testcase_qty'] > 0): ?>
          <table border="0" cellspacing="0" cellpadding="2" style="font-size:small;" width="100%">
            <tr style="background-color:blue;font-weight:bold;color:white">
  			     <th class="clickable_icon">
  			         <img src="<?php echo $this->_tpl_vars['tlImages']['toggle_all']; ?>
" title="<?php echo $this->_tpl_vars['labels']['check_uncheck_all_checkboxes']; ?>
"
  			              onclick='cs_all_checkbox_in_div("<?php echo $this->_tpl_vars['div_id']; ?>
","<?php echo $this->_tpl_vars['update_cb']; ?>
","update_value_<?php echo $this->_tpl_vars['ts_id']; ?>
");' />
  			     </th>
  			     <th style="width:45%"><?php echo $this->_tpl_vars['labels']['th_test_case']; ?>
</th>
  			     <th class="clickable_icon"><?php echo $this->_tpl_vars['labels']['version']; ?>
</th>
  			     <th>&nbsp;</th>
  			     <th style="width:15%"><?php echo $this->_tpl_vars['labels']['update_to_version']; ?>
</th>
  			     <th>&nbsp;</th>
            </tr>   
            
            <?php $_from = $this->_tpl_vars['ts']['testcases']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tcase']):
?>
              
                            <?php $this->assign('is_active', 0); ?>
              <?php $this->assign('is_linked', 0); ?>
              <?php if ($this->_tpl_vars['tcase']['linked_version_id'] != 0): ?>
                 <?php $this->assign('is_linked', 1); ?>
              <?php endif; ?>
              
                   		  <?php if ($this->_tpl_vars['is_linked']): ?>
      			    <tr class="testlink">
      			      <td width="20">
        				    <input type='hidden' name='a_tcid[<?php echo $this->_tpl_vars['tcase']['id']; ?>
]' value='<?php echo $this->_tpl_vars['tcase']['linked_version_id']; ?>
' />
        				    <?php if ($this->_tpl_vars['tcase']['canUpdateVersion']): ?>
        				      <input type='checkbox' name='<?php echo $this->_tpl_vars['update_cb']; ?>
[<?php echo $this->_tpl_vars['tcase']['id']; ?>
]' 
        				             id='<?php echo $this->_tpl_vars['update_cb']; ?>
<?php echo $this->_tpl_vars['tcase']['id']; ?>
' value='<?php echo $this->_tpl_vars['tcase']['linked_version_id']; ?>
' /> 
        				    <?php endif; ?>
      			      </td>
					<td>
						<img class="clickable" src="<?php echo $this->_tpl_vars['tlImages']['history_small']; ?>
"
						     onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['tcase']['id']; ?>
);"
						     title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
						<img class="clickable" src="<?php echo $this->_tpl_vars['tlImages']['edit']; ?>
"
						     onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['tcase']['id']; ?>
);"
						     title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
						<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->testCasePrefix)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tcase']['external_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo $this->_tpl_vars['gsmarty_gui']->title_separator_1; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tcase']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

      			      </td>
  
                  <td style="text-align:center;">
                  	<?php echo $this->_tpl_vars['tcase']['tcversions'][$this->_tpl_vars['tcase']['linked_version_id']]; ?>

                  </td>
                  <td style="text-align:center;">
                  	&nbsp;
                  </td>
  
                  <td style="text-align:center;">
                  	  <?php if ($this->_tpl_vars['tcase']['updateTarget'] != ''): ?>	
                      <select name="new_tcversion_for_tcid[<?php echo $this->_tpl_vars['tcase']['id']; ?>
]">
           				       <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['tcase']['updateTarget'],'disabled' => 'disabled'), $this);?>

           			  </select>
           			  <?php endif; ?>
                  </td>
         
                        
                  <?php if ($this->_tpl_vars['ts']['linked_testcase_qty'] > 0): ?>
           				<td>
                       <?php if ($this->_tpl_vars['tcase']['executed'] == 'yes'): ?>
                              &nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['labels']['has_been_executed']; ?>

                       <?php endif; ?>    
           				</td>
                  <?php endif; ?>
                        
                </tr>
             <?php endif; ?> 
    	     <?php endforeach; endif; unset($_from); ?>
          </table>
          
          <br />
       <?php endif; ?>        </div>
  
  	<?php endforeach; endif; unset($_from); ?>
  </div>
  <?php endif; ?>  

  <?php if ($this->_tpl_vars['gui']->operationType == 'bulk'): ?>
  <input type="hidden" name="update_all_value"  id="update_all_value"  value="1" />
	    <br/><table class="simple_tableruler">
	      <tr>
			    
			    <th class="clickable_icon">
             <img src="<?php echo @TL_THEME_IMG_DIR; ?>
/toggle_all.gif" border="0" 
	                alt="<?php echo $this->_tpl_vars['labels']['check_uncheck_all']; ?>
" title="<?php echo $this->_tpl_vars['labels']['check_uncheck_all']; ?>
" 
                  onclick="cs_all_checkbox_in_div('updateTcForm','<?php echo $this->_tpl_vars['update_cb']; ?>
','update_all_value');" />
       
	        </th>
			    <th><?php echo $this->_tpl_vars['labels']['th_test_case']; ?>
</th>
			    <th><?php echo $this->_tpl_vars['labels']['linked_version']; ?>
</th>
			    <th><?php echo $this->_tpl_vars['labels']['newest_version']; ?>
</th>
			    <th><?php echo $this->_tpl_vars['labels']['compare']; ?>
</th>
	      </tr>   
	    
	      <?php $_from = $this->_tpl_vars['gui']->testcases; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tc']):
?>
	     	<?php $this->assign('item_number', $this->_tpl_vars['item_number']+1); ?>
	      <tr class="testlink">
	      	<td width="20">
      		 	<input type='checkbox' name='<?php echo $this->_tpl_vars['update_cb']; ?>
[<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
]' id='<?php echo $this->_tpl_vars['update_cb']; ?>
<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
' 
      				     value='<?php echo $this->_tpl_vars['tc']['tcversion_id']; ?>
' checked="checked" /> 
      			<input type='hidden' name='a_tcid[<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
]' value='<?php echo $this->_tpl_vars['tc']['newest_tcversion_id']; ?>
' />
    		</td>
	      
			  <td>
			  <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/history_small.png"
			       onclick="javascript:openExecHistoryWindow(<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
);"
			       title="<?php echo $this->_tpl_vars['labels']['execution_history']; ?>
" />
			  <img class="clickable" src="<?php echo @TL_THEME_IMG_DIR; ?>
/edit_icon.png"
			       onclick="javascript:openTCaseWindow(<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
);"
			       title="<?php echo $this->_tpl_vars['labels']['design']; ?>
" />
			    <?php echo $this->_tpl_vars['tc']['path']; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->testCasePrefix)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['tc_external_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:<?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </td>  
			  <td align="center"> <?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </td>
			  <td align="center">
			  <?php echo ((is_array($_tmp=$this->_tpl_vars['tc']['newest_version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 
			  <input type="hidden" name="new_tcversion_for_tcid[<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
]" value="<?php echo $this->_tpl_vars['tc']['newest_tcversion_id']; ?>
" />
			  </td>
			  <td align="center">
			  <a href="lib/testcases/tcCompareVersions.php?testcase_id=<?php echo $this->_tpl_vars['tc']['tc_id']; ?>
&version_left=<?php echo $this->_tpl_vars['tc']['version']; ?>
&version_right=<?php echo $this->_tpl_vars['tc']['newest_version']; ?>
&compare_selected_versions=1&use_html_comp=1" target="_blank">
			  <img src="<?php echo @TL_THEME_IMG_DIR; ?>
/magnifier.png"></img></a>
			  </td>
	      </tr>
	  	  <?php endforeach; endif; unset($_from); ?>
	  	</table>

  <?php endif; ?>
 
    <br>   
    <input type="submit" id="update_btn" name="update_btn" style="padding-right: 20px;"
           value='<?php echo $this->_tpl_vars['labels']['btn_update_testplan_tcversions']; ?>
'  />
    <input type="hidden" name="doAction" id="doAction" value="<?php echo $this->_tpl_vars['gui']->buttonAction; ?>
" />  
  </form>
<?php else: ?>
  	<h2><?php echo $this->_tpl_vars['gui']->user_feedback; ?>
</h2>
<?php endif; ?>


<?php if ($this->_tpl_vars['gui']->refreshTree): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_refreshTreeWithFilters.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>

</body>
</html>