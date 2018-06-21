<?php /* Smarty version 2.6.26, created on 2013-10-25 16:35:52
         compiled from results/resultsGeneral.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'results/resultsGeneral.tpl', 11, false),array('modifier', 'escape', 'results/resultsGeneral.tpl', 58, false),array('modifier', 'date_format', 'results/resultsGeneral.tpl', 229, false),)), $this); ?>

<?php echo lang_get_smarty(array('var' => 'labels','s' => 'trep_kw,trep_owner,trep_comp,generated_by_TestLink_on, priority,
       	 th_overall_priority, th_progress, th_expected, th_overall, th_milestone,
       	 th_tc_priority_high, th_tc_priority_medium, th_tc_priority_low,
         title_res_by_kw,title_res_by_owner,title_res_by_top_level_suites,
         title_report_tc_priorities,title_report_milestones,elapsed_seconds,
         title_metrics_x_build,title_res_by_platform,th_platform,important_notice,
         report_tcase_platorm_relationship, th_tc_total, th_completed, th_goal,
         th_build, th_tc_assigned, th_perc_completed, from, until,
         info_res_by_top_level_suites, info_report_tc_priorities, info_res_by_platform,
         info_report_milestones_prio, info_report_milestones_no_prio, info_res_by_kw,
         info_gen_test_rep'), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<h1 class="title"><?php echo $this->_tpl_vars['gui']->title; ?>
</h1>

<div class="workBack">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc_result_tproject_tplan.tpl", 'smarty_include_vars' => array('arg_tproject_name' => $this->_tpl_vars['gui']->tproject_name,'arg_tplan_name' => $this->_tpl_vars['gui']->tplan_name)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	

<?php if ($this->_tpl_vars['gui']->do_report['status_ok']): ?>

  <?php if ($this->_tpl_vars['gui']->showPlatforms): ?>
   <hr>
   <h2> <?php echo $this->_tpl_vars['labels']['important_notice']; ?>
</h2>
   <?php echo $this->_tpl_vars['labels']['report_tcase_platorm_relationship']; ?>

   <hr>
  <?php endif; ?>  
  		<h2><?php echo $this->_tpl_vars['labels']['title_metrics_x_build']; ?>
</h1>

	<?php if ($this->_tpl_vars['gui']->displayBuildMetrics): ?>
	<table class="simple_tableruler sortable" style="text-align: center; margin-left: 0px;">
  	<tr>
  		<th style="width: 10%;"><?php echo $this->_tpl_vars['labels']['th_build']; ?>
</th>
    	    	<th><?php echo $this->_tpl_vars['labels']['th_tc_assigned']; ?>
</th>
      	<?php $_from = $this->_tpl_vars['gui']->statistics->overallBuildStatus->colDefinition; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['the_column']):
?>
        	<th><?php echo $this->_tpl_vars['the_column']['qty']; ?>
</th>
        	<th><?php echo $this->_tpl_vars['the_column']['percentage']; ?>
</th>
    	<?php endforeach; endif; unset($_from); ?>
    	<th><?php echo $this->_tpl_vars['labels']['th_perc_completed']; ?>
</th>
  	</tr>

	<?php $_from = $this->_tpl_vars['gui']->statistics->overallBuildStatus->info; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
  	<tr>
  		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['res']['build_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
  		<td><?php echo $this->_tpl_vars['res']['total_assigned']; ?>
</td>
	    	<?php $_from = $this->_tpl_vars['gui']->statistics->overallBuildStatus->colDefinition; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status'] => $this->_tpl_vars['the_column']):
?>
	        	<td><?php echo $this->_tpl_vars['res']['details'][$this->_tpl_vars['status']]['qty']; ?>
</td>
	        	<td><?php echo $this->_tpl_vars['res']['details'][$this->_tpl_vars['status']]['percentage']; ?>
</td>
	    	<?php endforeach; endif; unset($_from); ?>
  		<td><?php echo $this->_tpl_vars['res']['percentage_completed']; ?>
</td>
  	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php endif; ?>
	
			<?php if ($this->_tpl_vars['gui']->buildMetricsFeedback != ''): ?>
		<p class="italic"><?php echo ((is_array($_tmp=$this->_tpl_vars['gui']->buildMetricsFeedback)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
	<?php endif; ?>
	<br />
  	
  	  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "results/inc_results_show_table.tpl", 'smarty_include_vars' => array('args_title' => $this->_tpl_vars['labels']['title_res_by_top_level_suites'],'args_first_column_header' => $this->_tpl_vars['labels']['trep_comp'],'args_first_column_key' => 'name','args_show_percentage' => true,'args_column_definition' => $this->_tpl_vars['gui']->columnsDefinition->testsuites,'args_column_data' => $this->_tpl_vars['gui']->statistics->testsuites)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
           
    <?php if ($this->_tpl_vars['gui']->columnsDefinition->testsuites != ""): ?>
  	  <p class="italic"><?php echo $this->_tpl_vars['labels']['info_res_by_top_level_suites']; ?>
</p>
  	  <br />
  	<?php endif; ?>

  
  	
    <?php if ($this->_tpl_vars['gui']->showPlatforms): ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "results/inc_results_show_table.tpl", 'smarty_include_vars' => array('args_title' => $this->_tpl_vars['labels']['title_res_by_platform'],'args_first_column_header' => $this->_tpl_vars['labels']['th_platform'],'args_first_column_key' => 'name','args_show_percentage' => true,'args_column_definition' => $this->_tpl_vars['gui']->columnsDefinition->platform,'args_column_data' => $this->_tpl_vars['gui']->statistics->platform)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             
      <?php if ($this->_tpl_vars['gui']->columnsDefinition->platform != ""): ?>
        <p class="italic"><?php echo $this->_tpl_vars['labels']['info_res_by_platform']; ?>
</p>
        <br />
      <?php endif; ?>
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['gui']->testprojectOptions->testPriorityEnabled): ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "results/inc_results_show_table.tpl", 'smarty_include_vars' => array('args_title' => $this->_tpl_vars['labels']['title_report_tc_priorities'],'args_first_column_header' => $this->_tpl_vars['labels']['priority'],'args_first_column_key' => 'name','args_show_percentage' => true,'args_column_definition' => $this->_tpl_vars['gui']->columnsDefinition->priorities,'args_column_data' => $this->_tpl_vars['gui']->statistics->priorities)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             
      <?php if ($this->_tpl_vars['gui']->columnsDefinition->priorities != ""): ?>
        <p class="italic"><?php echo $this->_tpl_vars['labels']['info_report_tc_priorities']; ?>
</p>
        <br />
      <?php endif; ?>
    <?php endif; ?>
  
  	  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "results/inc_results_show_table.tpl", 'smarty_include_vars' => array('args_title' => $this->_tpl_vars['labels']['title_res_by_kw'],'args_first_column_header' => $this->_tpl_vars['labels']['trep_kw'],'args_first_column_key' => 'name','args_show_percentage' => true,'args_column_definition' => $this->_tpl_vars['gui']->columnsDefinition->keywords,'args_column_data' => $this->_tpl_vars['gui']->statistics->keywords)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
           
    <?php if ($this->_tpl_vars['gui']->columnsDefinition->keywords != ""): ?>
      <p class="italic"><?php echo $this->_tpl_vars['labels']['info_res_by_kw']; ?>
</p>
      <br />
    <?php endif; ?>


  	
	<?php if ($this->_tpl_vars['gui']->testprojectOptions->testPriorityEnabled): ?>
		<?php if ($this->_tpl_vars['gui']->statistics->milestones != ""): ?>

			<h2><?php echo $this->_tpl_vars['labels']['title_report_milestones']; ?>
</h2>

			<table class="simple_tableruler sortable" style="text-align: center; margin-left: 0px;">
			<tr>
				<th><?php echo $this->_tpl_vars['labels']['th_milestone']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_tc_priority_high']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_expected']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_tc_priority_medium']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_expected']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_tc_priority_low']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_expected']; ?>
</th>
				<th><?php echo $this->_tpl_vars['labels']['th_overall']; ?>
</th>
			</tr>
 			<?php $_from = $this->_tpl_vars['gui']->statistics->milestones; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
  			<tr>
  				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['res']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>

  						<?php if (((is_array($_tmp=$this->_tpl_vars['res']['start_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)) != "0000-00-00"): ?>
						<?php echo $this->_tpl_vars['labels']['from']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['start_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

						<?php endif; ?>
  						<?php echo $this->_tpl_vars['labels']['until']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['target_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
	  			<td class="<?php if ($this->_tpl_vars['res']['high_incomplete']): ?>failed<?php else: ?>passed<?php endif; ?>">
	  					<?php echo $this->_tpl_vars['res']['result_high_percentage']; ?>
 % <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>
 
	  					<?php echo $this->_tpl_vars['res']['results']['3']; ?>
/<?php echo $this->_tpl_vars['res']['tcs_priority']['3']; ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
	  			<td><?php echo $this->_tpl_vars['res']['high_percentage']; ?>
 %</td>
	  			<td class="<?php if ($this->_tpl_vars['res']['medium_incomplete']): ?>failed<?php else: ?>passed<?php endif; ?>">
	  					<?php echo $this->_tpl_vars['res']['result_medium_percentage']; ?>
 % <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>
 
	  					<?php echo $this->_tpl_vars['res']['results']['2']; ?>
/<?php echo $this->_tpl_vars['res']['tcs_priority']['2']; ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
	  			<td><?php echo $this->_tpl_vars['res']['medium_percentage']; ?>
 %</td>
	  			<td class="<?php if ($this->_tpl_vars['res']['low_incomplete']): ?>failed<?php else: ?>passed<?php endif; ?>">
	  					<?php echo $this->_tpl_vars['res']['result_low_percentage']; ?>
 % <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>
 
	  					<?php echo $this->_tpl_vars['res']['results']['1']; ?>
/<?php echo $this->_tpl_vars['res']['tcs_priority']['1']; ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
	  			<td><?php echo $this->_tpl_vars['res']['low_percentage']; ?>
 %</td>
				<td><?php echo $this->_tpl_vars['res']['percentage_completed']; ?>
 %</td>
  			</tr>
  			<?php endforeach; endif; unset($_from); ?>
		</table>
      <p class="italic"><?php echo $this->_tpl_vars['labels']['info_report_milestones_prio']; ?>
</p>
      <br />

	<?php endif; ?>
		
	<?php elseif ($this->_tpl_vars['gui']->statistics->milestones != ""): ?>
		<h2><?php echo $this->_tpl_vars['labels']['title_report_milestones']; ?>
</h2>

		<table class="simple_tableruler sortable" style="text-align: center; margin-left: 0px;">
		<tr>
			<th><?php echo $this->_tpl_vars['labels']['th_milestone']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_tc_total']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_completed']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_progress']; ?>
</th>
			<th><?php echo $this->_tpl_vars['labels']['th_goal']; ?>
</th>
		</tr>

 		<?php $_from = $this->_tpl_vars['gui']->statistics->milestones; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
  		<tr>
  			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['res']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>

  					<?php if (((is_array($_tmp=$this->_tpl_vars['res']['start_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)) != "0000-00-00"): ?>
					<?php echo $this->_tpl_vars['labels']['from']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['start_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

					<?php endif; ?>
  					<?php echo $this->_tpl_vars['labels']['until']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['target_date'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
  			<td><?php echo $this->_tpl_vars['res']['tc_total']; ?>
</td>
  			<td><?php echo $this->_tpl_vars['res']['tc_completed']; ?>
</td>
			<td class="<?php if ($this->_tpl_vars['res']['medium_incomplete']): ?>failed<?php else: ?>passed<?php endif; ?>">
					<?php echo $this->_tpl_vars['res']['percentage_completed']; ?>
 % <?php echo $this->_tpl_vars['tlCfg']->gui_separator_open; ?>
 
					<?php echo $this->_tpl_vars['res']['results']['2']; ?>
/<?php echo $this->_tpl_vars['res']['tcs_priority']['2']; ?>
 <?php echo $this->_tpl_vars['tlCfg']->gui_separator_close; ?>
</td>
			<td><?php echo $this->_tpl_vars['res']['medium_percentage']; ?>
 %</td>
  		</tr>
  		<?php endforeach; endif; unset($_from); ?>
		</table>
      <p class="italic"><?php echo $this->_tpl_vars['labels']['info_report_milestones_no_prio']; ?>
</p>
      <br />
	<?php endif; ?>
	
	<p class="italic"><?php echo $this->_tpl_vars['labels']['info_gen_test_rep']; ?>
</p>
	<p><?php echo $this->_tpl_vars['labels']['generated_by_TestLink_on']; ?>
 <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_tpl_vars['gsmarty_timestamp_format']) : smarty_modifier_date_format($_tmp, $this->_tpl_vars['gsmarty_timestamp_format'])); ?>
</p>
	<p><?php echo $this->_tpl_vars['labels']['elapsed_seconds']; ?>
 <?php echo $this->_tpl_vars['gui']->elapsed_time; ?>
</p>

<?php else: ?>
  	<?php echo $this->_tpl_vars['gui']->do_report['msg']; ?>

<?php endif; ?>  
</div>

</body>
</html>