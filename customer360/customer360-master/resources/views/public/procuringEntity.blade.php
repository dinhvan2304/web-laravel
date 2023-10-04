@extends('layouts.template')

@section('title', 'Bên mời thầu')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class=" row mb-2">
				<div class="col-sm-6">
					<h1>Bên mời thầu</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">
							<a href="/">{{__('app.home')}}</a>
						</li>
						<li class="breadcrumb-item active">Clients</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				@include('layouts.includes.alerts')
			</div>
			<div class="row">
				<div class="col-md-12" id="searchResult">
					<div id="clients"></div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('script')
<script>
	var clients = new DevExpress.data.CustomStore({
		key: "id",
		// loadMode: "raw",
		load: function(loadOptions){
			var d = $.Deferred();
			var params = {};
			[
                "filter",
                "group", 
                "groupSummary",
                "parentIds",
                "requireGroupCount",
                "requireTotalCount",
                "searchExpr",
                "searchOperation",
                "searchValue",
                "select",
                "sort",
                "skip",     
                "take",
                "totalSummary", 
            ].forEach(function(i) {
                if(i in loadOptions && isNotEmpty(loadOptions[i])) {
                    params[i] = JSON.stringify(loadOptions[i]);
                }
            });
			$.getJSON("{{url('/api/manage-clients')}}", params)
			.done(function(result){
				d.resolve(result.data, {
					totalCount: result.totalCount,
					summary: result.summary,
					groupCount: result.groupCount
				});
			});
			return d.promise();
		},
		insert: function(values){
			console.log(values);
			var deferred = $.Deferred();
			$.ajax({
				url: "{{url('/client/store')}}",
				method: "POST",
				data: JSON.stringify(values),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			})
			.done(deferred.resolve)
			.fail(function(e){
				deferred.reject("Insertion failed")
			});
			return deferred.promise();
		},
		remove: function(key) {
			console.log(key);
            var deferred = $.Deferred();
            $.ajax({
                url: "{{url('/client/destroy')}}" +"/"+ encodeURIComponent(key),
                method: "DELETE",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
            })
            .done(deferred.resolve)
            .fail(function(e){
                deferred.reject("Deletion failed");
            });
            return deferred.promise();
        },
        update: function(key, values) {
			console.log(values);
            var deferred = $.Deferred();
            $.ajax({
                url: "{{url('/client/edit')}}" + "/" + encodeURIComponent(key),
                method: "PUT",
                data: JSON.stringify(values),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
            })
            .done(deferred.resolve)
            .fail(function(e){
                deferred.reject("Update failed");
            });
            return deferred.promise();
        }
	});
	function isNotEmpty(value){
		return value !== undefined && value !== null && value !== "";
	}

	var companies = new DevExpress.data.CustomStore({
		key: "id",
		// loadMode: "raw",
	
		load: function(loadOptions){
			var d = $.Deferred();
			var params = {};

			[
                "filter",
                "group", 
                "groupSummary",
                "parentIds",
                "requireGroupCount",
                "requireTotalCount",
                "searchExpr",
                "searchOperation",
                "searchValue",
                "select",
                "sort",
                "skip",     
                "take",
                "totalSummary", 
            ].forEach(function(i) {
                if(i in loadOptions && isNotEmpty(loadOptions[i])) {
                    params[i] = JSON.stringify(loadOptions[i]);
                }
            });
			$.getJSON("{{url('/api/companies_client')}}", params)
			.done(function(result){
				d.resolve(result.data, {
					totalCount: result.totalCount,
					summary: result.summary,
					groupCount: result.groupCount
				});
			});
			return d.promise();
		},
	
		byKey: function (key) {
			var d = new $.Deferred();
			if (key == 0){
				key = 1
			}
			$.get(`{{url('/api/companies_key?id=${key}')}}`)
			.done(function (dataItem) {
				d.resolve(dataItem);
			});
			return d.promise();
		
		}
	});

	console.log(clients);
	const treeList = $("#clients").dxTreeList({
		dataSource:clients,
		rootValue: 0,
		keyExpr: 'id',
		// dataStructure: 'plain',
		remoteOperations: { 
			groupPaging: true,
			paging: true,
		},
		// remoteOperations: {
		// 	filtering: true,
		// },
		searchPanel: {
			visible: true,
		},
		headerFilter: {
			visible: true,
		},
		scrolling: {
			mode: 'standard',
		},
		paging: {
			enabled: true,
			pageSize: 10,
		},
		pager: {
			showPageSizeSelector: true,
			allowedPageSizes: [5, 10, 20],
			showInfo: true,
		},
		rowDragging: {
			allowDropInsideItem: true,
			allowReordering: true,
			onDragChange(e) {
				const visibleRows = treeList.getVisibleRows();
				const sourceNode = treeList.getNodeByKey(e.itemData.id);
				let targetNode = visibleRows[e.toIndex].node;

				while (targetNode && targetNode.data) {
					if (targetNode.data.id === sourceNode.data.id) {
						e.cancel = true;
						break;
					}
					targetNode = targetNode.parent;
				}
			},
			onReorder(e) {
				const visibleRows = e.component.getVisibleRows();
				const d = $.Deferred();
				if (e.dropInsideItem) {
					e.itemData.head_id = visibleRows[e.toIndex].key;
					clients.update(e.itemData.id, { head_id: e.itemData.head_id }).then(() => {
						e.component.refresh().then(d.resolve, d.reject);
					}, d.reject);
					e.promise = d.promise();
				} else {
					const sourceData = e.itemData;
					const toIndex = e.fromIndex > e.toIndex ? e.toIndex - 1 : e.toIndex;
					let targetData = toIndex >= 0 ? visibleRows[toIndex].node.data : null;

					if (targetData && e.component.isRowExpanded(targetData.id)) {
						sourceData.head_id = targetData.id;
						targetData = null;
					} else {
						sourceData.head_id = targetData ? targetData.head_id : e.component.option('rootValue');
					}

					const sourceIndex = clients.indexOf(sourceData);
					clients.splice(sourceIndex, 1);

					const targetIndex = clients.indexOf(targetData) + 1;
					clients.splice(targetIndex, 0, sourceData);
				}

				
				e.component.refresh();
			},
		},
		parentIdExpr: 'head_id',
		showRowLines: true,
		showBorders: true,
		// columnAutoWidth: true,
		editing: {
			mode: 'row',
			allowUpdating: true,
			allowDeleting: true,
			allowAdding: true,
			// popup: {
			// 	title: 'Employee Info',
			// 	showTitle: true,
			// 	width: 700,
			// 	height: 525,
			// },
		},
		columns: [
			{
				caption: 'Tên',
				dataField: 'company_name',
				dataType: 'string',
			},
			{
				caption: 'Tỉnh, thành phố',
				dataField: 'city',
				dataType: 'string',
			}, 
			{
				caption: 'Địa chỉ',
				dataField: 'address',
				dataType: 'string',
			},
			{
				caption:'Head',
				dataField: 'head_id',
				width: 125,
				lookup:{
					dataSource: companies,
					valueExpr: 'id',
					displayExpr: 'company_name',
				},
				editCellTemplate: dropDownBoxEditorTemplate,
			},
			{
				type: 'buttons',
				buttons: ['edit', 'delete'],
			}
		],
		onEditorPreparing(e){
			if (e.dataField === "head_id" && e.row.data.id === 0){
				// e.cancel = true;
				e.editorOptions.disabled = true;
				e.editorOptions.value = null;
			}
		},
		onInitNewRow(e){
			e.data.head_id =0;
		},
		expandedRowKeys: [1],
	}).dxTreeList('instance');

	function dropDownBoxEditorTemplate(cellElement, cellInfo) {
    return $('<div>').dxDropDownBox({
      dropDownOptions: { width: 500 },
      dataSource: companies,
      value: cellInfo.value,
      valueExpr: 'id',
      displayExpr: 'company_name',
      contentTemplate(e) {
        return $('<div>').dxDataGrid({
          dataSource: companies,
          remoteOperations: true,
          columns: ['company_name'],
          hoverStateEnabled: true,
          scrolling: { mode: 'virtual' },
          height: 500,
          selection: { mode: 'single' },
          selectedRowKeys: [cellInfo.value],
          focusedRowEnabled: true,
          focusedRowKey: cellInfo.value,
          onSelectionChanged(selectionChangedArgs) {
            e.component.option('value', selectionChangedArgs.selectedRowKeys[0]);
            cellInfo.setValue(selectionChangedArgs.selectedRowKeys[0]);
            if (selectionChangedArgs.selectedRowKeys.length > 0) {
              e.component.close();
            }
          },
        });
      },
    });
  }
</script>
@endsection