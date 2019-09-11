<div id="responsive-modal-{{$customer->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Customer</h4> </div>
            <div class="modal-body">
                <form id="edit-supplier-{{$customer->id}}">
                    <div>
                        @csrf
                    </div>
                    <div class="form-group ">
                        <label for="name-{{$customer->id}}" class="control-label">Name:</label>
                        <input type="text" value="{{$customer->name}}" name="name" class="form-control" id="name-{{$customer->id}}" >
                    </div>
                    <div class="form-group">
                        <label for="email-{{$customer->id}}" class="control-label">Email:</label>
                        <input type="email" value="{{$customer->email}}"  class="form-control" id="email-{{$customer->id}}" name="email">
                    </div>


                    <div class="form-group">
                        <label for="company_name-{{$customer->id}}" class="control-label">Company Name:</label>
                        <input class="form-control" value="{{$customer->company_name}}"  id="company_name-{{$customer->id}}" name="company_name" />
                    </div>

                    <div class="form-group">
                        <label for="phone1-{{$customer->id}}" class="control-label">Phone 1:</label>
                        <input type="text" class="form-control" value="{{$customer->phone1}}" id="phone1-{{$customer->id}}" name="phone1">
                    </div>

                    <div class="form-group">
                        <label for="phone2-{{$customer->id}}" class="control-label">Phone 2:</label>
                        <input type="text" class="form-control" value="{{$customer->phone2}}" id="phone2-{{$customer->id}}" name="phone2">
                    </div>

                    <div class="form-group">
                        <label for="passport_no-{{$customer->id}}" class="control-label">Passport No:</label>
                        <input type="text" class="form-control" value="{{$customer->passport_no}}" id="passport_no-{{$customer->id}}" name="passport_no">
                    </div>

                    <div class="form-group">
                        <label for="nic-{{$customer->id}}" class="control-label">NIC:</label>
                        <input type="text" class="form-control" value="{{$customer->nic}}" id="nic-{{$customer->id}}" name="nic">
                    </div>

                    <div class="form-group">
                        <label for="city-{{$customer->id}}" class="control-label">City:</label>
                        <input type="text" class="form-control" value="{{$customer->city}}" id="city-{{$customer->id}}" name="city">
                    </div>

                    <div class="form-group">
                        <label for="address1" class="control-label">Address 1:</label>
                        <textarea class="form-control" id="address1-{{$customer->id}}" name="address1">{{$customer->address1}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="address2-{{$customer->id}}" class="control-label">Address 2:</label>
                        <textarea class="form-control" id="address2-{{$customer->id}}" name="address2">{{$customer->address2}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="remarks-{{$customer->id}}" class="control-label">Remarks:</label>
                        <textarea class="form-control" id="remarks-{{$customer->id}}" name="remarks">{{$customer->remarks}}</textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateCustomer({{$customer->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


