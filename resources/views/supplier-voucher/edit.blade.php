<div id="responsive-modal-{{$vc->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Supplier Voucher</h4> </div>
            <div class="modal-body">
                <form id="edit-supplier-voucher-{{$vc->id}}">
                    <div>
                        @csrf
                        <input type="hidden" name="edit_balance" id="edit_balance" value="{{$suppliers->where('id',$vc->supplier_id)->pluck('balance')->first()}}">
                    </div>
                    <div class="form-group ">
                            <label class="control-label">Date:</label>
                    <input type="date" value="{{$vc->date}}" name="date" class="form-control" id="date-{{$vc->id}}" >
                    </div>
                    <div class="form-group ">
                            <label class="control-label">Supplier:</label>
                            <select onchange="getSupplierBalanceForUpdate($(this).val())" class="edit_supplier_name form-control" name="supplier_name" id="supplier_name-{{$vc->id}}">
                                    @foreach($suppliers as $supplier)
                                <option @if($supplier->id == $vc->supplier_id) selected @endif value="{{$supplier->id}}">{{$supplier->id}}-{{$supplier->name}}</option>
                                    @endforeach
                            </select>
                        <span class="edit_supplier_balance">Balance:{{$supplier->where('id',$vc->supplier_id)->pluck('balance')->first()}}</span>
                    </div>
                    <div class="form-group ">
                        <label class="control-label">Amount:</label>
                        <input type="number" value="{{$vc->amount}}" name="amount" class="form-control" id="amount-{{$vc->id}}" >
                    </div>
                    <div class="form-group ">
                        <label for="name" class="control-label">Remarks:</label>
                        <input type="text" value="{{$vc->remarks}}" value={{$vc->remarks}} maxlength="500" name="remarks" class="form-control" id="remarks" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateSupplierVoucher({{$vc->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


