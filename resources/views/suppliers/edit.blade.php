<div id="responsive-modal-{{$supplier->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Supplier</h4> </div>
            <div class="modal-body">
                <form id="edit-supplier-{{$supplier->id}}">
                    <div>
                    @csrf
                    </div>
                    <div class="form-group ">
                        <label for="name-{{$supplier->id}}" class="control-label">Name:</label>
                        <input type="text" value="{{$supplier->name}}" name="name" class="form-control" id="name-{{$supplier->id}}" >
                    </div>
                    <!-- <div class="form-group">
                        <label for="email-{{$supplier->id}}" class="control-label">Email:</label>
                        <input type="email" value="{{$supplier->email}}"  class="form-control" id="email-{{$supplier->id}}" name="email">
                    </div> -->


                    <div class="form-group">
                        <label for="company_name-{{$supplier->id}}" class="control-label">Company Name:</label>
                        <input class="form-control" value="{{$supplier->company_name}}"  id="company_name-{{$supplier->id}}" name="company_name" />
                    </div>

                    <div class="form-group">
                        <label for="balance-{{$supplier->id}}" class="control-label">Balance:</label>
                        <input class="form-control supplier_balance" max_length="10" value="{{$supplier->balance}}" id="balance-{{$supplier->id}}" name="balance" />
                    </div>

                    <div class="form-group">
                        <label for="phone1-{{$supplier->id}}" class="control-label">Phone 1:</label>
                        <input type="text" class="form-control" value="{{$supplier->phone1}}" id="phone1-{{$supplier->id}}" name="phone1">
                    </div>

                    <div class="form-group">
                        <label for="phone2-{{$supplier->id}}" class="control-label">Phone 2:</label>
                        <input type="text" class="form-control" value="{{$supplier->phone2}}" id="phone2-{{$supplier->id}}" name="phone2">
                    </div>

                    <!-- <div class="form-group">
                        <label for="passport_no-{{$supplier->id}}" class="control-label">Passport No:</label>
                        <input type="text" class="form-control" value="{{$supplier->passport_no}}" id="passport_no-{{$supplier->id}}" name="passport_no">
                    </div> -->

                    <div class="form-group">
                        <label for="nic-{{$supplier->id}}" class="control-label">CNIC:</label>
                        <input type="text" class="form-control" value="{{$supplier->nic}}" id="nic-{{$supplier->id}}" name="nic">
                    </div>

                    <div class="form-group">
                        <label for="city-{{$supplier->id}}" class="control-label">City:</label>
                        <input type="text" class="form-control" value="{{$supplier->city}}" id="city-{{$supplier->id}}" name="city">
                    </div>

                    <div class="form-group">
                        <label for="address1" class="control-label">Address:</label>
                        <textarea class="form-control" id="address1-{{$supplier->id}}" name="address1">{{$supplier->address1}}</textarea>
                    </div>

                    <!-- <div class="form-group">
                        <label for="address2-{{$supplier->id}}" class="control-label">Address 2:</label>
                        <textarea class="form-control" id="address2-{{$supplier->id}}" name="address2">{{$supplier->address2}}</textarea>
                    </div> -->
                    <div class="form-group">
                        <label for="remarks-{{$supplier->id}}" class="control-label">Remarks:</label>
                        <textarea class="form-control" id="remarks-{{$supplier->id}}" name="remarks">{{$supplier->remarks}}</textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateSupplier({{$supplier->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


