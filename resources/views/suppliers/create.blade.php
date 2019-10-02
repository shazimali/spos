<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Supplier</h4> </div>
            <div class="modal-body">
                <form id="create-supplier">
                    <div>

                    @csrf
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" >
                    </div>
                    <!-- <div class="form-group">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div> -->


                    <div class="form-group">
                        <label for="company_name" class="control-label">Company Name:</label>
                        <input class="form-control" id="company_name" name="company_name" />
                    </div>
                    <div class="form-group">
                        <label for="balance" class="control-label">Balance:</label>
                        <input class="form-control" max_length="10" id="balance" name="balance" />
                    </div>

                    <div class="form-group">
                        <label for="phone1" class="control-label">Phone 1:</label>
                        <input type="text" class="form-control" id="phone1" name="phone1">
                    </div>

                    <div class="form-group">
                        <label for="phone2" class="control-label">Phone 2:</label>
                        <input type="text" class="form-control" id="phone2" name="phone2">
                    </div>

                    <!-- <div class="form-group">
                        <label for="passport_no" class="control-label">Passport No:</label>
                        <input type="text" class="form-control" id="passport_no" name="passport_no">
                    </div> -->

                    <div class="form-group">
                        <label for="nic" class="control-label">CNIC:</label>
                        <input type="text" class="form-control" id="nic" name="nic">
                    </div>

                    <div class="form-group">
                        <label for="city" class="control-label">City:</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>

                    <div class="form-group">
                        <label for="address1" class="control-label">Address:</label>
                        <textarea class="form-control" id="address1" name="address1"></textarea>
                    </div>

                    

                    <!-- <div class="form-group">
                        <label for="address2" class="control-label">Address 2:</label>
                        <textarea class="form-control" id="address2" name="address2"></textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks:</label>
                        <textarea class="form-control" id="remarks" name="remarks"></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="createSupplier()" >Save changes</button>
            </div>
        </div>
    </div>
</div>


