<?php /* Smarty version 2.6.26, created on 2013-11-06 13:57:19
         compiled from plan/inc_controls_planEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'plan/inc_controls_planEdit.tpl', 9, false),)), $this); ?>
<?php echo lang_get_smarty(array('var' => 'labels','s' => 'testplan_copy_builds,testplan_copy_tcases,testplan_copy_tcases_latest,
		         testplan_copy_tcases_current,testplan_copy_builds,
		         testplan_copy_priorities,testplan_copy_milestones,
		         testplan_copy_assigned_to,testplan_copy_user_roles,
		         testplan_copy_platforms_links,testplan_copy_attachments'), $this);?>


<table style="float: left; text-align:left">
	<tr>
		<td align='left'>
			<input type="checkbox" name="copy_tcases" checked="checked"/>
			<?php echo $this->_tpl_vars['labels']['testplan_copy_tcases']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="tcversion_type" value="latest" /><?php echo $this->_tpl_vars['labels']['testplan_copy_tcases_latest']; ?>

		</td>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="tcversion_type" value="current" checked="1"/><?php echo $this->_tpl_vars['labels']['testplan_copy_tcases_current']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="copy_priorities" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_priorities']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			<input type="checkbox" name="copy_builds" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_builds']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="copy_assigned_to" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_assigned_to']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			<input type="checkbox" name="copy_milestones" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_milestones']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			<input type="checkbox" name="copy_user_roles" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_user_roles']; ?>

		</td>
	</tr>
	<tr>
		<td align='left'>
			<input type="checkbox" name="copy_attachments" checked="checked"/><?php echo $this->_tpl_vars['labels']['testplan_copy_attachments']; ?>

		</td>
	</tr>
	
		<input type="hidden" name="copy_platforms_links" value="1"/>

</table>