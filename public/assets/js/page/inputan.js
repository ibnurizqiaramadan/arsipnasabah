tablePath = $(".table-id").data("path")
CURRENT_PATH = ADMIN_PATH + `/${tablePath}/`;
tableId = `#${$(".table-id").attr("id")}`;

function setStatus(status, id) {
	confirmSweet("Anda yakin ingin merubah status ?").then(result => {
		if (isConfirmed(result)) {
			$.ajax({
				url: CURRENT_PATH + "set/" + id,
				data: {
					_token: TOKEN,
					status: status
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				dataSrc: function ( json ) {
					json?.status == '401' && msgSweetWarning("Sesi Anda berakhir !").then(msg=> {
						doLogoutAjax()
					})
					return json.data;
				},
				success: function (result) {
					"ok" == result.status ? (refreshData(), enableButton(), toastSuccess(result.message)) : (enableButton(), toastError(result.message, "Gagal"))
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
}

function refreshData() {
	table.ajax.reload(null, !1)
}
$(document).ready((function () {
	table = $(tableId).DataTable({
		processing: !0,
		serverSide: !0,
		order: [],
		ajax: {
			url: `${API_PATH}data/${tablePath}`,
			type: "POST",
			data: {
				_token: TOKEN
			},
			complete: function () {
				checkPilihan({
					table: tableId,
					buttons: ['delete'],
					path: CURRENT_PATH
				})
			},
			dataSrc: function ( json ) {
				json?.status == '401' && msgSweetWarning("Sesi Anda berakhir !").then(msg=> {
					doLogoutAjax()
				})
				json?.status == "fail" && toastError(json?.message, "Gagal")
                return json.data;
			},
			error: function (error) {
				errorCode(error)
			}
		},
		fnCreatedRow: function (nRow, aData, iDataIndex) {
			$(nRow).attr('data-id', aData.id)
		},
		columns: dataColumnTable([
		    'id', 'input_label', 'input_type', 'input_required', 'id'
		]),
		columnDefs: [{
			targets: [0],
			orderable: !1,
			sClass: "text-center",
			render: function (data, type, row) {
				return "<input type='checkbox' id='checkItem-" + row.id + "' value='" + row.id + "'>"
			}
		}, {
			targets: [1],
			orderable: 1,
			render: function (data, type, row) {
				return row.input_label
			}
		}, {
			targets: [2],
			orderable: 1,
			sClass: "text-center",
			render: function (data, type, row) {
                let inputType = ['Text', 'Text Area', 'Number', 'Date', 'Time', 'File']
				return inputType[row.input_type]
			}
		}, {
			targets: [3],
			orderable: 1,
			sClass: "text-center",
			render: function (data, type, row) {
				return row.input_required == 0 ? "Tidak" : "Ya"
			}
		}, {
			targets: [4],
			orderable: !1,
			sClass: "text-center",
			render: function (data, type, row) {
				return "<button class='btn btn-danger btn-sm' id='delete' data-id=" + row.id + " data-toggle='tooltip' title='Hapus Data'><i class='fas fa-trash-alt'></i></button> \n <button class='btn btn-warning btn-sm' id='edit' data-id=" + row.id + " data-toggle='tooltip' title='Edit Data'><i class='fas fa-pencil-alt'></i></button> "
			}
		}]
	})
})), $(tableId).delegate("#delete", "click", (function () {
	confirmSweet("Anda yakin ingin menghapus data ?").then((result) => {
		if (isConfirmed(result)) {
			let id = $(this).data("id")
			result && $.ajax({
				url: CURRENT_PATH + "delete",
				data: {
					_token: TOKEN,
					id: id
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				success: function (result) {
					"ok" == result.status ? (enableButton(), toastSuccess(result.message), refreshData()) : toastError(result.message, "Gagal")
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})), $(tableId).delegate("#edit", "click", (function () {
	let id = $(this).data("id");
	$.ajax({
		url: `${API_PATH}row/${tablePath}/${id}`,
		type: "post",
		data: {_token: TOKEN},
		dataType: "json",
		beforeSend: function() {
			disableButton()
			clearFormInput("#formBody")
			addFormInput("#formBody", [{
				type: "hidden",
				name: "id"
			},{
                type: "text",
                name: "input_label",
                label: "Nama Inputan"
            }, {
                type: "select2",
                name: "input_type",
                label: "Jenis Inputan", 
                data: {
                    0: "Text",
                    1: "Text Area",
                    2: "Number",
                    3: "Date",
                    4: "Time",
                    5: "File",
                }
            }, {
                type: "select2",
                name: "input_required",
                label: "Wajib Diisi", 
                data: {
                    0: "Tidak",
                    1: "Ya"
                }
            }])
		}, 
		complete: function() {
			enableButton()
		},
		success: function(result) {
			"ok" == result.status ? ($("#modalForm").modal('show'),$("#modalTitle").html('Edit Pengguna'),$("#formInput").attr('action', CURRENT_PATH + "update"), fillForm(result.data)) : msgSweetError(result.message)
		},
		error: function(err) {
			errorCode(err)
		}
	})
})), $(tableId).delegate("#reset", "click", (function (e) {
	confirmSweet("Anda yakin ingin mereset password ?").then((result) => {
		if (isConfirmed(result)) {
			let id = $(this).data("id");
			result && $.ajax({
				url: CURRENT_PATH + "reset/" + id,
				data: {
					_token: TOKEN
				},
				type: "POST",
				dataType: "JSON",
				beforeSend: function () {
					disableButton()
				},
				complete: function () {
					enableButton()
				},
				success: function (result) {
					"ok" == result.status ? (toastSuccess(result.message)) : toastError(result.message, "Gagal")
				},
				error: function (error) {
					errorCode(error)
				}
			})
		}
	})
})), $(tableId).delegate("#on", "click", (function () {
	setStatus("off", $(this).data("id"))
})), $(tableId).delegate("#off", "click", (function () {
	setStatus("on", $(this).data("id"))
})), $("#btnAdd").on('click', function () {
	clearFormInput("#formBody")
	addFormInput("#formBody", [{
		type: "text",
		name: "input_label",
		label: "Nama Inputan"
	}, {
		type: "select2",
		name: "input_type",
		label: "Jenis Inputan", 
		data: {
			0: "Text",
			1: "Text Area",
			2: "Number",
			3: "Date",
			4: "Time",
			5: "File",
		}
	}, {
		type: "select2",
		name: "input_required",
		label: "Wajib Diisi", 
		data: {
			0: "Tidak",
			1: "Ya"
		}
	}])
	$("#modalForm").modal('show')
	$("#modalTitle").html('Tambah Pengguna')
	$("#formInput").attr('action', CURRENT_PATH + "store")
}), $("#formInput").submit(function(e) {
	e.preventDefault()
	let formData = new FormData(this)
	formData.append("_token", TOKEN)
	$.ajax({
		url: $(this).attr('action'),
		type: "post",
		data: formData, 
		processData: !1,
		contentType: !1,
		cache: !1,
		dataType: "JSON",
		beforeSend: function () {
			disableButton()	
		},
		complete: function () {
			enableButton()
		},
		success: function (e) {
			validate(e.validate.input),e.validate.success&&("ok"==e.status?(toastSuccess(e.message),refreshData(),1==e.modalClose&&$("#modalForm").modal("hide"),clearInput(e.validate.input)):toastWarning(e.message));
		},
		error: function(err) {
			errorCode(err)
		}
	})
})