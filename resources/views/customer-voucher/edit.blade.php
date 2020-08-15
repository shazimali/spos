<div id="responsive-modal-{{$vc->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Customer Voucher</h4> </div>
            <div class="modal-body">
                <form id="edit-customer-voucher-{{$vc->id}}">
                    <div>
                        @csrf
                        <input type="hidden" name="edit_balance" id="edit_balance" value="{{$customers->where('id',$vc->customer_id)->first()->cBalance()}}">
                    </div>
                    <div class="form-group ">
                            <label class="control-label">Date:</label>
                    <input type="date" value="{{$vc->date}}" name="date" class="form-control" id="date-{{$vc->id}}" >
                    </div>
                    <div class="form-group ">
                            <label class="control-label">Customer:</label>
                            <select onchange="getCustomerBalanceForUpdate($(this).val())" class="edit_customer_name form-control" name="customer_name" id="customer_name-{{$vc->id}}">
                                    @foreach($customers as $customer)
                                <option @if($customer->id == $vc->customer_id) selected @endif value="{{$customer->id}}">{{$customer->id}}-{{$customer->name}}</option>
                                    @endforeach
                            </select>
                        <span class="edit_customer_balance text-bold text-danger">Balance:{{number_format($customers->where('id',$vc->customer_id)->first()->cBalance(),2)}}</span>
                    </div>
                    <div class="form-group ">
                        <label class="control-label">Amount:</label>
                        <input value="{{$vc->amount}}" name="amount" class="form-control amount" id="amount-{{$vc->id}}" >
                    </div>
                    <div class="form-group ">
                        <label for="name" class="control-label">Remarks:</label>
                        <input type="text" value="{{$vc->remarks}}" maxlength="500" name="remarks" class="form-control" id="remarks" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateCustomerVoucher({{$vc->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


