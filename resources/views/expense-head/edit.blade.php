<div id="responsive-modal-{{$hd->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Customer</h4> </div>
            <div class="modal-body">
                <form id="edit-expense-head-{{$hd->id}}">
                    <div>
                        @csrf
                    </div>
                    <div class="form-group ">
                        <label for="name-{{$hd->id}}" class="control-label">Title:</label>
                        <input type="text" value="{{$hd->title}}" name="title" class="form-control" id="title-{{$hd->id}}" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateExpenseHead({{$hd->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


