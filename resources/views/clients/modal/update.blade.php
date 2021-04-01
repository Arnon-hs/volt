<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('api.users.update')}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="id" class="col-form-label">ID:</label>
                        <input type="text" readonly class="form-control" id="id" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="col-form-label">Address:</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="country" class="col-form-label">Country:</label>
                        <input type="text" class="form-control" id="country" name="counry">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="col-form-label">EUR for 1 kW:</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary send">Send</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<script>
    $(document).ready(()=>{
        // $("#data-table").on('click-row.bs.table', function (e, row, $element) {
        //     console.log(e,row,$element)
        // });
        $('#data-table').bootstrapTable({
            onClickRow: function (row, $element) {
                console.log(row)
                // row: the record corresponding to the clicked row,
                // $element: the tr element.
                const form = $('#editModal form')
                form.find('#id').val(row[0])
                form.find('#address').val(row[1])
                form.find('#country').val(row[2])
                form.find('#price').val(row[3]) 
            }
        });

        $('#editModal .send').on('click', function () {
            const form = $('#editModal form')
            const data = new FormData()
            $.ajax({
                url: form,
                data: data,
                method: 'PUT',
                success: response => {
                 console.log(response)
                }
            })
        })
    })
</script>