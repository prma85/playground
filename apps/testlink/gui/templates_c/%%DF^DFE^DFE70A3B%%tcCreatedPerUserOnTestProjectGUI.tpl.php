<?php /* Smarty version 2.6.26, created on 2013-10-29 14:15:52
         compiled from results/tcCreatedPerUserOnTestProjectGUI.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'results/tcCreatedPerUserOnTestProjectGUI.tpl', 11, false),array('function', 'html_select_time', 'results/tcCreatedPerUserOnTestProjectGUI.tpl', 54, false),array('modifier', 'escape', 'results/tcCreatedPerUserOnTestProjectGUI.tpl', 33, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'th_user,th_start_time,th_end_time,date,hour,submit_query,show_calender'), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_ext_js.tpl", 'smarty_include_vars' => array('bResetEXTCss' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<body>
	<h1 class="title"><?php echo $this->_tpl_vars['gui']->pageTitle; ?>
</h1>
    <div class="workBack">
      <form action="lib/results/tcCreatedPerUserOnTestProject.php" method="post">
        <input type="hidden" id="tproject_id" name="tproject_id" value="<?php echo $this->_tpl_vars['gui']->tproject_id; ?>
" />
        <input type="hidden" id="do_action" name="do_action" value="result" />
        <div>
          <table class="simple" style="text-align: center; margin-left: 0px;">
            <tr>
                <th width="34%"><?php echo $this->_tpl_vars['labels']['th_user']; ?>
</th>
                <th width="33%"><?php echo $this->_tpl_vars['labels']['th_start_time']; ?>
</th>
                <th width="33%"><?php echo $this->_tpl_vars['labels']['th_end_time']; ?>
</th>
            </tr>
            <tr>
            	<td align="center">
                <select name="user_id">
                  <?php $_from = $this->_tpl_vars['gui']->users->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user'] => $this->_tpl_vars['userid']):
?>
                    <option value="<?php echo $this->_tpl_vars['user']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['userid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
                  <?php endforeach; endif; unset($_from); ?>
		  	        </select>
                </td>
                <td align="center">
                   <table border='0'>
                    <tr>
                        <td><?php echo $this->_tpl_vars['labels']['date']; ?>
</td>
                        <td>
                            <input type="text" 
                                   name="selected_start_date" id="selected_start_date" 
                                   value="<?php echo $this->_tpl_vars['gui']->selected_start_date; ?>
" 
                                   onclick="showCal('selected_start_date-cal','selected_start_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" 
                                   readonly="readonly" />
                            <img title="<?php echo $this->_tpl_vars['labels']['show_calender']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/calendar.gif"
                                 onclick="showCal('selected_start_date-cal','selected_start_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" />
                            <div id="selected_start_date-cal" style="position:absolute;width:240px;left:300px;z-index:1;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $this->_tpl_vars['labels']['hour']; ?>
</td>
                        <td align='left'><?php echo smarty_function_html_select_time(array('prefix' => 'start_','display_minutes' => false,'time' => $this->_tpl_vars['gui']->selected_start_time,'display_seconds' => false,'use_24_hours' => true), $this);?>

                        </td>
                    </tr>
                  </table>
                </td>
                <td align="center">
                   <table border='0'>
                       <tr>
                           <td><?php echo $this->_tpl_vars['labels']['date']; ?>
</td>
                           <td>
                                <input type="text" 
                                       name="selected_end_date" id="selected_end_date" 
                                       value="<?php echo $this->_tpl_vars['gui']->selected_end_date; ?>
" 
                                       onclick="showCal('selected_end_date-cal','selected_end_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" readonly />
                                <img title="<?php echo $this->_tpl_vars['labels']['show_calender']; ?>
" src="<?php echo @TL_THEME_IMG_DIR; ?>
/calendar.gif"
                                     onclick="showCal('selected_end_date-cal','selected_end_date','<?php echo $this->_tpl_vars['gsmarty_datepicker_format']; ?>
');" >
                                <div id="selected_end_date-cal" style="position:absolute;width:240px;left:300px;z-index:1;"></div>
                           </td>
                       </tr>
                       <tr>
                           <td><?php echo $this->_tpl_vars['labels']['hour']; ?>
</td>
                           <td align='left'><?php echo smarty_function_html_select_time(array('prefix' => 'end_','display_minutes' => false,'time' => $this->_tpl_vars['gui']->selected_end_time,'display_seconds' => false,'use_24_hours' => true), $this);?>
</td>
                       </tr>
                   </table>
                </td>
            </tr>
          </table>
        </div>
        <div>
        	<input type="submit" value="<?php echo $this->_tpl_vars['labels']['submit_query']; ?>
"/>
        </div>
      </form>
    </div>
</body>
</html>