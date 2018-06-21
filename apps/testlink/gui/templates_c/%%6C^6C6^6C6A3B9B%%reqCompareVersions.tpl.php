<?php /* Smarty version 2.6.26, created on 2014-03-31 14:23:11
         compiled from requirements/reqCompareVersions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'requirements/reqCompareVersions.tpl', 18, false),array('function', 'counter', 'requirements/reqCompareVersions.tpl', 222, false),array('function', 'localize_timestamp', 'requirements/reqCompareVersions.tpl', 236, false),array('modifier', 'escape', 'requirements/reqCompareVersions.tpl', 31, false),)), $this); ?>

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

<?php echo lang_get_smarty(array('var' => 'labels','s' => "select_versions,title_compare_versions_req,version,compare,modified,modified_by,
          btn_compare_selected_versions, context, show_all,author,timestamp,timestamp_lastchange,
          warning_context, warning_context_range, warning_empty_context,warning,custom_field, 
          warning_selected_versions, warning_same_selected_versions,revision,attribute,
          custom_fields,attributes,log_message,use_html_code_comp,use_html_comp,diff_method,
          btn_cancel"), $this);?>


<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['basehref']; ?>
third_party/diff/diff.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['basehref']; ?>
third_party/daisydiff/css/diff.css">

<script type="text/javascript">
//BUGID 3943: Escape all messages (string)
var alert_box_title = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_empty_context = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_empty_context'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_context_range = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_context_range'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_selected_versions = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_selected_versions'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_same_selected_versions = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_same_selected_versions'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";
var warning_context = "<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['warning_context'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
";

<?php echo '
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

Ext.onReady(function(){ 
'; ?>

<?php $_from = $this->_tpl_vars['gui']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['info']):
?>
  tip4log(<?php echo $this->_tpl_vars['info']['item_id']; ?>
);
<?php endforeach; endif; unset($_from); ?>
<?php echo '
});

// 20110107 - new diff engine
function triggerContextInput(selected) {
	var context = document.getElementById("context_input");
	if (selected == 0) {
		context.style.display = "none";
	} else {
		context.style.display = "table-row";;
	}
}

function triggerField(field)
{
	if (field.disabled == true) {
    	field.disabled = false;
	} else {
    	field.disabled = true;
	}
}

function triggerRadio(radio, field) {
    	radio[0].checked = false;
    	radio[1].checked = false;
    	radio[field].checked = true;
    	triggerContextInput(field);
}

function valButton(btn) {
    var cnt = -1;
    for (var i=btn.length-1; i > -1; i--) {
        if (btn[i].checked) {
        	cnt = i;
        	i = -1;
        }
    }
    if (cnt > -1) {
    	return true;
    }
    else {
    	return false;
    }
}

function validateForm() {
	if (isWhitespace(document.req_compare_versions.context.value)) {
	    alert_message(alert_box_title,warning_empty_context);
		return false;
	} else {
		value = parseInt(document.req_compare_versions.context.value);
		if (isNaN(value))
		{
		   	alert_message(alert_box_title,warning_context);
		   	return false;
		} else if (value < 0) {
			alert_message(alert_box_title,warning_context_range);
		   	return false;
		}
	}
	
	if (!valButton(document.req_compare_versions.left_item_id)
			|| !valButton(document.req_compare_versions.right_item_id)) {
		alert_message(alert_box_title,warning_selected_versions);
		return false;
	}
	
	for (var i=document.req_compare_versions.left_item_id.length-1; i > -1; i--) {
        if (document.req_compare_versions.left_item_id[i].checked && document.req_compare_versions.right_item_id[i].checked) {
        	alert_message(alert_box_title,warning_same_selected_versions);
        	return false;
        }
    }
}

</script>
'; ?>


</head>
<body>

<?php if ($this->_tpl_vars['gui']->compare_selected_versions): ?>

	<h1 class="title"><?php echo $this->_tpl_vars['labels']['title_compare_versions_req']; ?>
</h1> 
			
		<div class="workBack" style="width:99%; overflow:auto;">	
	<?php echo $this->_tpl_vars['gui']->subtitle; ?>

    <?php if ($this->_tpl_vars['gui']->attrDiff != ''): ?>
      <h2><?php echo $this->_tpl_vars['labels']['attributes']; ?>
</h2>
      <table border="1" cellspacing="0" cellpadding="2" style="width:60%" class="code">
        <thead>
          <tr>
            <th style="text-align:left;"><?php echo $this->_tpl_vars['labels']['attribute']; ?>
</th>
            <th style="text-align:left;"><?php echo $this->_tpl_vars['gui']->leftID; ?>
</th>
            <th style="text-align:left;"><?php echo $this->_tpl_vars['gui']->rightID; ?>
</th>
          </tr>
        </thead>
        <tbody>
	      <?php $_from = $this->_tpl_vars['gui']->attrDiff; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attrDiff']):
?>
          <tr>
            <td class="<?php if ($this->_tpl_vars['attrDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>"; style="font-weight:bold"><?php echo $this->_tpl_vars['attrDiff']['label']; ?>
</td>
            <td class="<?php if ($this->_tpl_vars['attrDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>";><?php echo $this->_tpl_vars['attrDiff']['lvalue']; ?>
</td>
            <td class="<?php if ($this->_tpl_vars['attrDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>";><?php echo $this->_tpl_vars['attrDiff']['rvalue']; ?>
</td>
          </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
      <p />
    <?php endif; ?>
		
	  <?php $_from = $this->_tpl_vars['gui']->diff; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['diff']):
?>
		<h2><?php echo $this->_tpl_vars['diff']['heading']; ?>
</h2>
		<fieldset class="x-fieldset x-form-label-left" >
		<legend class="legend_container" ><?php echo $this->_tpl_vars['diff']['message']; ?>
</legend>
	  	  <?php if ($this->_tpl_vars['diff']['count'] > 0): ?><?php echo $this->_tpl_vars['diff']['diff']; ?>
<?php endif; ?>
	  	  </fieldset>
	  <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['gui']->cfieldsDiff != ''): ?>
      <p />
      <h2><?php echo $this->_tpl_vars['labels']['custom_fields']; ?>
</h2>
      <table border="1" cellspacing="0" cellpadding="2" style="width:60%" class="code">
        <thead>
        <tr>
          <th style="text-align:left;"><?php echo $this->_tpl_vars['labels']['custom_field']; ?>
</th>
          <th style="text-align:left;"><?php echo $this->_tpl_vars['gui']->leftID; ?>
</th>
          <th style="text-align:left;"><?php echo $this->_tpl_vars['gui']->rightID; ?>
</th>
        </tr>
        </thead>
        <tbody>
	      <?php $_from = $this->_tpl_vars['gui']->cfieldsDiff; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cfDiff']):
?>
          <tr>
            <td class="<?php if ($this->_tpl_vars['cfDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>"; style="font-weight:bold"><?php echo $this->_tpl_vars['cfDiff']['label']; ?>
</td>
            <td class="<?php if ($this->_tpl_vars['cfDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>";><?php echo $this->_tpl_vars['cfDiff']['lvalue']; ?>
</td>
            <td class="<?php if ($this->_tpl_vars['cfDiff']['changed']): ?>del<?php else: ?>ins<?php endif; ?>";><?php echo $this->_tpl_vars['cfDiff']['rvalue']; ?>
</td>
          </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
      </table>
		<?php endif; ?>
		</div>
		
<?php else: ?>

	<h1 class="title"><?php echo $this->_tpl_vars['labels']['title_compare_versions_req']; ?>
</h1> 
	
	<div class="workBack" style="width:97%;">
	
	<form target="diffwindow" method="post" action="lib/requirements/reqCompareVersions.php" name="req_compare_versions" id="req_compare_versions"  
			onsubmit="return validateForm();" />			
	
	<p>
		<input type="submit" name="compare_selected_versions" value="<?php echo $this->_tpl_vars['labels']['btn_compare_selected_versions']; ?>
" />
		<input type="button" name="cancel" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
" onclick="javascript:history.back();" />
	</p>
	<br/>
	
	<table border="0" cellspacing="0" cellpadding="2" style="font-size:small;" width="100%">
	
	    <tr style="background-color:blue;font-weight:bold;color:white">
	        <th width="12px" style="font-weight: bold; text-align: center;"><?php echo $this->_tpl_vars['labels']['version']; ?>
</td>
	        <th width="12px" style="font-weight: bold; text-align: center;"><?php echo $this->_tpl_vars['labels']['revision']; ?>
</td>
	        <th width="12px" style="font-weight: bold; text-align: center;">&nbsp;<?php echo $this->_tpl_vars['labels']['compare']; ?>
</td>
	        <th style="font-weight: bold; text-align: center;"><?php echo $this->_tpl_vars['labels']['log_message']; ?>
</td>
	        <th style="font-weight: bold; text-align: center;"><?php echo $this->_tpl_vars['labels']['timestamp_lastchange']; ?>
</td>
	    </tr>
	
	<?php echo smarty_function_counter(array('assign' => 'mycount'), $this);?>

	<?php $_from = $this->_tpl_vars['gui']->items; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['req']):
?>
	   <tr>
	        <td style="text-align: center;"><?php echo $this->_tpl_vars['req']['version']; ?>
</td>
	        <td style="text-align: center;"><?php echo $this->_tpl_vars['req']['revision']; ?>
</td>
	        <td style="text-align: center;"><input type="radio" name="left_item_id" value="<?php echo $this->_tpl_vars['req']['item_id']; ?>
" 
	            <?php if ($this->_tpl_vars['mycount'] == 2): ?> 	 checked="checked"  <?php endif; ?> />
	            <input type="radio" name="right_item_id" value="<?php echo $this->_tpl_vars['req']['item_id']; ?>
" <?php if ($this->_tpl_vars['mycount'] == 1): ?> checked="checked"	<?php endif; ?>/>
	        </td>
        		        <td id="tooltip-<?php echo $this->_tpl_vars['req']['item_id']; ?>
">
        	<?php echo $this->_tpl_vars['req']['log_message']; ?>

        	</td>
        	<td style="text-align: left; cursor: pointer; color: rgb(0, 85, 153);" onclick="javascript:openReqRevisionWindow(<?php echo $this->_tpl_vars['req']['item_id']; ?>
);">
	            <nobr><?php echo localize_timestamp_smarty(array('ts' => $this->_tpl_vars['req']['timestamp']), $this);?>
, <?php echo $this->_tpl_vars['req']['last_editor']; ?>
</nobr>
	        </td>
	    </tr>
	<?php echo smarty_function_counter(array(), $this);?>

	<?php endforeach; endif; unset($_from); ?>
	
	</table><br/>
	
		<h2><?php echo $this->_tpl_vars['labels']['diff_method']; ?>
</h2>
	<table border="0" cellspacing="0" cellpadding="2" style="font-size:small;" width="100%">
	<tr><td style="width:8px;">
	
	<input type="radio" id="use_html_comp" name="use_html_comp" 
	       checked="checked" onclick="triggerRadio(this.form.use_html_comp, 0);"/> </td><td> <?php echo $this->_tpl_vars['labels']['use_html_comp']; ?>
 </td></tr>
	<tr><td><input type="radio" id="use_html_comp" name="use_html_code_comp"
	       onclick="triggerRadio(this.form.use_html_comp, 1);"/> </td><td> <?php echo $this->_tpl_vars['labels']['use_html_code_comp']; ?>
 </td></tr>
	<tr id="context_input" style="display: none;"> <td>&nbsp;</td><td>
		<?php echo $this->_tpl_vars['labels']['context']; ?>
 <input type="text" name="context" id="context" maxlength="4" size="4" value="<?php echo $this->_tpl_vars['gui']->context; ?>
" /> 
		<input type="checkbox" id="context_show_all" name="context_show_all" 
		       onclick="triggerField(this.form.context);"/> <?php echo $this->_tpl_vars['labels']['show_all']; ?>
 	</td></tr></table>
	
	<p>
		<input type="hidden" name="requirement_id" value="<?php echo $this->_tpl_vars['gui']->req_id; ?>
" />
		<input type="submit" name="compare_selected_versions" value="<?php echo $this->_tpl_vars['labels']['btn_compare_selected_versions']; ?>
" />
		<input type="button" name="cancel" value="<?php echo $this->_tpl_vars['labels']['btn_cancel']; ?>
" onclick="javascript:history.back();" />
	</p>
	
	</form>

	</div>

<?php endif; ?>

</body>

</html>