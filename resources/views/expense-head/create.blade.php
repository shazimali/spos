<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Expense Head</h4> </div>
            <div class="modal-body">
                    <form id="create-expense-head">
                        @csrf
                    <div class="form-group ">
                        <label for="name" class="control-label">Title:</label>
                        <input type="text" name="title" class="form-control" id="title" >
                    </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="createExpenseHead()" >Save changes</button>
                    </div>


            </div>

        </div>
    </div>
</div>


