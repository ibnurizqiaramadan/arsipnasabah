CURRENT_PATH = ADMIN_PATH + '/nasabah'

$(document).ready(function() {
    $("#inputNasabah").html("")
    $.ajax({
        url: API_PATH + '/getInput',
        type: 'GET',
        dataType: "JSON",
        success: function(result) {
            result.status == "ok" && result.data.forEach(input => {

                const inputType = {
                    "text": `<input type="text" class="form-control" name="${ input.name }">`,
                    "textarea": `<textarea class="form-control" name="${input.name}" ></textarea><script> autosize($('textarea[name="${input.name}"]')); </script>`,
                    "number": `<input type="number" class="form-control" name="${ input.name }">`,
                    "date": `<input type="date" class="form-control" name="${ input.name }">`,
                    "time": `<input type="time" class="form-control" name="${ input.name }">`,
                    "file": `<div class="custom-file"><input type="file" class="custom-file-input" name="${input.name}"><label class="custom-file-label">Pilih File</label></div>`,
                }

                $("#inputNasabah").append(`
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">${ input.label.toUpperCase() }</label>
                        <div class="col-sm-10">
                            ${inputType[input.type]}
                        </div>
                    </div>
                `)
            })
            $(`.custom-file-input`).on("change", function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        }
    })
})