<?php /* Smarty version 2.6.26, created on 2013-10-25 14:11:22
         compiled from inc_ext_table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang_get', 'inc_ext_table.tpl', 19, false),array('modifier', 'escape', 'inc_ext_table.tpl', 110, false),array('modifier', 'json_encode', 'inc_ext_table.tpl', 191, false),)), $this); ?>


<?php echo lang_get_smarty(array('var' => 'labels','s' => "expand_collapse_groups, show_all_columns,
                          show_all_columns_tooltip, default_state, multisort, multisort_tooltip,
                          multisort_button_tooltip, button_refresh, btn_reset_filters, caption_nav_filters"), $this);?>


<?php echo ' <script type="text/javascript"> '; ?>

var checkedImg = "<?php echo $this->_tpl_vars['tlImages']['checked']; ?>
";
<?php echo ' </script> '; ?>


<?php echo '
<script type="text/javascript" src="gui/javascript/ext_extensions.js" language="javascript"></script>
<script type="text/javascript">

/*
 statusRenderer() 
 translate this code to a localized string and applies formatting
*/
function statusRenderer(item)
{
  item.cssClass = item.cssClass || "";
  return "<span class=\\""+item.cssClass+"\\">" + item.text + "</span>";
}

/*
 statusCompare() 
 handles the sorting order by status. 
 It maps a status code to a number. 
 The statuses are then sorted by comparing those numbers.
 WARNING: Global coupling
          uses variable status_code_order
*/
function statusCompare(item)
{
  var order=0;
  order = status_code_order[item.value];
  if( order == undefined )
  {
    alert(\'Configuration Issue - test case execution status code: \' + val + \' is not configured \');
    order = -1;
  }
  return order;
}

function priorityRenderer(val)
{
  return prio_code_label[val];
}

function importanceRenderer(val)
{
  return importance_code_label[val];
}

/* Unfortunately global coupling is needed to get the image */
function oneZeroImageRenderer(val)
{
  if(val == 1)
  {
    return \'<img src="\' + checkedImg + \'" />\';
  }
  else
  {
    return \'\';
  }
}

 

function columnWrap(val)
{
  return \'<div style="white-space:normal !important; -moz-user-select: text; -webkit-user-select: text;">\'+ val +\'</div>\';
}

// Functions for MultiSort
function createSorterButton(config, table) 
{
  config = config || {};
  Ext.applyIf(config, {
    listeners: {
      "click": function(button, e) {
        if(e.shiftKey == true) 
        {
          button.destroy();
          doSort(table);
        } 
        else
        {
          updateButtons(button, table, true);
        }
      }
    },
    iconCls: \'tbar-sort-\' + config.sortData.direction.toLowerCase(),
    '; ?>
tooltip: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['multisort_button_tooltip'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',<?php echo '
    tooltipType: \'title\',
    multisort: \'yes\',
    reorderable: true
  });
  
  return new Ext.Button(config);
};
    
function updateButtons(button,table,changeDirection){
	sortData = button.sortData;
	iconCls = button.iconCls;
	
	if (sortData != undefined) {
		if (changeDirection != false) {
			button.sortData.direction = button.sortData.direction.toggle(\'ASC\',\'DESC\');
			button.setIconClass(button.iconCls.toggle(\'tbar-sort-asc\', \'tbar-sort-desc\'));
		}
	}
	store[table].clearFilter();
	doSort(table);
}

function doSort(table){
	sorters = getSorters(table);
	store[table].sort(sorters, \'ASC\');
}

function getSorters(table) {
var sorters = [];
	tbar = grid[table].getTopToolbar();
	Ext.each(tbar.find(\'multisort\', \'yes\'), function(button) {
		sorters.push(button.sortData);
	}, this);
	return sorters;
}
//End Functions for MultiSort

Ext.onReady(function() {
'; ?>

  Ext.QuickTips.init();
	Ext.state.Manager.setProvider(new Ext.ux.JsonCookieProvider());
	<?php $_from = $this->_tpl_vars['gui']->tableSet; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['matrix']):
?>
		<?php $this->assign('tableID', $this->_tpl_vars['matrix']->tableID); ?>

		store['<?php echo $this->_tpl_vars['tableID']; ?>
'] = new Ext.data.GroupingStore({
			reader: new Ext.data.ArrayReader({},
				fields['<?php echo $this->_tpl_vars['tableID']; ?>
'])
				<?php if ($this->_tpl_vars['matrix']->groupByColumn >= 0): ?>
					,groupField: '<?php echo $this->_tpl_vars['matrix']->groupByColumn; ?>
'
				<?php endif; ?>
				<?php if (! is_null ( $this->_tpl_vars['matrix']->sortByColumn )): ?>
					,sortInfo:{field:'<?php echo $this->_tpl_vars['matrix']->sortByColumn; ?>
',direction:'<?php echo $this->_tpl_vars['matrix']->sortDirection; ?>
'}
				<?php endif; ?>
			});
		store['<?php echo $this->_tpl_vars['tableID']; ?>
'].loadData(tableData['<?php echo $this->_tpl_vars['tableID']; ?>
']);
			
		grid['<?php echo $this->_tpl_vars['tableID']; ?>
'] = new Ext.ux.SlimGridPanel({
			id: '<?php echo $this->_tpl_vars['tableID']; ?>
',
			store: store['<?php echo $this->_tpl_vars['tableID']; ?>
'],
			<?php if (! $this->_tpl_vars['matrix']->storeTableState): ?>
				stateful: false,
			<?php endif; ?>
			stripeRows: false,

			// init grid plugins
			plugins: [
				//init filter plugin
				filters = new Ext.ux.grid.GridFilters({
					// set to local filtering (on client side)
					local: true,
					showMenu: true,
					menuFilterText: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['caption_nav_filters'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
'
				})
			],
			
			
			//show toolbar
			<?php if ($this->_tpl_vars['matrix']->showToolbar): ?>
			tbar: tbar = new Ext.ux.TableToolbar({
				table_id: '<?php echo $this->_tpl_vars['tableID']; ?>
',
				showExpandCollapseGroupsButton: <?php echo json_encode($this->_tpl_vars['matrix']->toolbarExpandCollapseGroupsButton); ?>
,
				showAllColumnsButton: <?php echo json_encode($this->_tpl_vars['matrix']->toolbarShowAllColumnsButton); ?>
,
				<?php if ($this->_tpl_vars['matrix']->toolbarDefaultStateButton && $this->_tpl_vars['matrix']->showToolbar && $this->_tpl_vars['matrix']->storeTableState): ?>
				showDefaultStateButton: true,
				<?php else: ?>
				showDefaultStateButton: false,
				<?php endif; ?>
				showRefreshButton: <?php echo json_encode($this->_tpl_vars['matrix']->toolbarRefreshButton); ?>
,

				labels: {
					button_refresh: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['button_refresh'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
					default_state:  '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['default_state'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
					expand_collapse_groups: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['expand_collapse_groups'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
					show_all_columns: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['show_all_columns'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
					show_all_columns_tooltip: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['show_all_columns_tooltip'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
'
				}
				//init plugins for multisort
				<?php if ($this->_tpl_vars['matrix']->allowMultiSort): ?>
					// minor syntax error causing problems on IE6
					,plugins: [
						reorderer = new Ext.ux.ToolbarReorderer(),
						droppable = new Ext.ux.ToolbarDroppable({
						
							createItem: function(data) {
								var column = this.getColumnFromDragDrop(data);
								return createSorterButton({
									text    : column.header,
									sortData: {
										field: column.dataIndex,
										direction: "DESC"
									}
								}, '<?php echo $this->_tpl_vars['tableID']; ?>
');
							},

							canDrop: function(dragSource, event, data) {
								var sorters = getSorters('<?php echo $this->_tpl_vars['tableID']; ?>
'),
                					column  = this.getColumnFromDragDrop(data);

								for (var i=0; i < sorters.length; i++) {
									if (sorters[i].field == column.dataIndex) return false;
								}

								return true;
							},
							
							//after multisort buttons changed sort data again 
							afterLayout: function () {
								doSort('<?php echo $this->_tpl_vars['tableID']; ?>
');
							},

							getColumnFromDragDrop: function(data) {
								var index    = data.header.cellIndex,
								colModel = grid['<?php echo $this->_tpl_vars['tableID']; ?>
'].colModel,
								column   = colModel.getColumnById(colModel.getColumnId(index));

								return column;
							}
						})
					],  //END plugins
					items: [], //necessary line as otherwise plugins will throw an error
					listeners: {
						scope    : this,
						reordered: function(button) {
							updateButtons(button,'<?php echo $this->_tpl_vars['tableID']; ?>
', false);
						}
					}
				<?php endif; ?> // end plugins for multisort
			}), // END tbar
			<?php endif; ?> // ENDIF showtoolbar
			
      listeners: {
      <?php if ($this->_tpl_vars['matrix']->allowMultiSort && $this->_tpl_vars['matrix']->showToolbar): ?>
        scope: this,
        render: function() {
          dragProxy = grid['<?php echo $this->_tpl_vars['tableID']; ?>
'].getView().columnDrag;
          ddGroup = dragProxy.ddGroup;
          droppable.addDDGroup(ddGroup);
        }
      <?php endif; ?>
      }, // END listeners

      view: new Ext.grid.GroupingView({
        <?php echo $this->_tpl_vars['matrix']->getGridViewConfig(); ?>

      }), // END view
      
      columns: columnData['<?php echo $this->_tpl_vars['tableID']; ?>
']
      <?php echo $this->_tpl_vars['matrix']->getGridSettings(); ?>

    }); // END grid

		// Export Button
		<?php if ($this->_tpl_vars['matrix']->showExportButton && $this->_tpl_vars['matrix']->showToolbar): ?>
			tbar.add(new Ext.ux.Exporter.Button({
				component: grid['<?php echo $this->_tpl_vars['tableID']; ?>
'],
				store: store['<?php echo $this->_tpl_vars['tableID']; ?>
']
			}));
		<?php endif; ?>
		
		// add button to reset filters
		// TODO : show only as active if at least 1 column is filtered
		<?php if ($this->_tpl_vars['matrix']->toolbarResetFiltersButton && $this->_tpl_vars['matrix']->showToolbar): ?>
			tbar.add({
				text: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['btn_reset_filters'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
				iconCls: 'tbar-reset-filters',
				handler: function() {
					grid['<?php echo $this->_tpl_vars['tableID']; ?>
'].filters.clearFilters();
				}
			});
		<?php endif; ?>

		//MULTISORT
		<?php if ($this->_tpl_vars['matrix']->allowMultiSort && $this->_tpl_vars['matrix']->showToolbar): ?>
			
			//add button seperator
			tbar.add({
				xtype: 'tbseparator'
			});
			
			//add multisort text
			tbar.add({
				handleMouseEvents: false,
				iconCls: 'tbar-info',
				iconAlign: 'right',
				text: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['multisort'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
				tooltip: '<?php echo ((is_array($_tmp=$this->_tpl_vars['labels']['multisort_tooltip'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
',
				tooltipType: 'title'
			});
		<?php endif; ?>
		//END MULTISORT
		
		//render grid
		grid['<?php echo $this->_tpl_vars['tableID']; ?>
'].render('<?php echo $this->_tpl_vars['tableID']; ?>
_target');
	<?php endforeach; endif; unset($_from); ?>

}); // END Ext.onReady
</script>