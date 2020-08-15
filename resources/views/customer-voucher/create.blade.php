<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Customer Voucher</h4> </div>
            <div class="modal-body">
                    <form id="create-customer-voucher">
                        @csrf
                        <input type="hidden" name="balance" id="balance">
                    <div class="form-group ">
                        <label for="name" class="control-label">Date:</label>
                    <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}"  id="date" >
                    </div>
                    <div hidden class="form-group ">
                        <label for="name" class="control-label">Time:</label>
                        <input type="time" name="time" value="now" class="form-control" id="time" >
                    </div>
                    <div class="form-group ">
                        <label for="name" class="control-label">Customer:</label>
                        <select onchange="getCustomerBalance($(this).val())" class="form-control" name="customer_name" id="customer_name">
                            <option value="">Please Select Customer</option>
                            @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->id}}-{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="name" class="control-label">Amount:</label>
                        <input type="text" name="amount" class="form-control" id="amount" >
                    </div>
                    <div class="form-group ">
                        <label for="name" class="control-label">Remarks:</label>
                        <input type="text" maxlength="500" name="remarks" class="form-control" id="remarks" >
                    </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light" onclick="createCustomerVoucher()" >Save changes</button>
                    </div>


            </div>

        </div>
    </div>
</div>


