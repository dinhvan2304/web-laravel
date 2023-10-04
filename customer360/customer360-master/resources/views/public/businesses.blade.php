@extends('layouts.template')

@section('title', 'Lĩnh vực')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class=" row mb-2">
				<div class="col-sm-6">
					<h1>Ngành nghề - Lĩnh vực</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item">
							<a href="/">{{__('app.home')}}</a>
						</li>
						<li class="breadcrumb-item active">Businesses</li>
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
					<div id="business"></div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('script')
<script>
	var business = new DevExpress.data.CustomStore({
		key: "id",
		loadMode: "raw",
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
                "userData"
            ].forEach(function(i) {
                if(i in loadOptions && isNotEmpty(loadOptions[i])) {
                    params[i] = JSON.stringify(loadOptions[i]);
                }
            });
			$.getJSON("{{url('/businesses')}}", params)
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
				url: "{{url('/businesses/store')}}",
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
                url: "{{url('/businesses/destroy')}}" +"/"+ encodeURIComponent(key),
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
                url: "{{url('/businesses/edit')}}" + "/" + encodeURIComponent(key),
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

	const treeList = $("#business").dxTreeList({
		dataSource:business,
		rootValue: 0,
		keyExpr: 'id',
		searchPanel: {
			visible: true,
		},
		headerFilter: {
			visible: true,
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
					business.update(e.itemData.id, { head_id: e.itemData.head_id }).then(() => {
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

					const sourceIndex = business.indexOf(sourceData);
					business.splice(sourceIndex, 1);

					const targetIndex = business.indexOf(targetData) + 1;
					business.splice(targetIndex, 0, sourceData);
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
		},
		columns: [
			{
				caption: 'Tên',
				dataField: 'name',
				dataType: 'string',
			}, 
			{
				caption:'Head',
				dataField: 'head_id',
				lookup:{
					dataSource:{
						store: business,
						sort: 'name',
					},
					valueExpr: 'id',
					displayExpr: 'name',
				}
			},
			{
				caption: 'Mã',
				dataField: 'code',
				dataType: 'string',
			},
			{
				type: 'buttons',
				buttons: ['edit', 'delete'],
			}
		],
		onEditorPreparing(e){
			if (e.dataField === "head_id" && e.row.data.id === 0){
				e.cancel = true;
			}
		},
		onInitNewRow(e){
			e.data.head_id =0;
		},
		expandedRowKeys: [1],
	}).dxTreeList('instance');
</script>
@endsection