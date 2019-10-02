<div id="responsive-modal-{{$head->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Product head</h4> </div>
            <div class="modal-body">
                <form id="edit-record-{{$head->id}}">
                    <div>
                    @csrf
                    </div>
                    <div class="form-group ">
                        <label for="title-{{$head->id}}" class="control-label">Name:</label>
                        <input type="text" value="{{$head->title}}" name="title" class="form-control" id="title-{{$head->id}}" >
                    </div>

                    <div class="form-group ">
                        <label for="code-{{$head->id}}" class="control-label">Code #:</label>
                        <input readonly type="text" value="{{$head->code}}" name="code" class="form-control" id="code-{{$head->id}}" >
                    </div>
                    <div class="form-group ">
                        <label for="code" class="control-label">Unit:</label>
                        <select class="form-control" name="unit_id">
                            <option value="">Please Select</option>
                            @foreach($units as $unit)
                            <option @if($unit->id == $head->unit_id) selected @endif  value="{{ $unit->id }}">{{ $unit->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="purchase" class="control-label">Purchase Price:</label>
                    <input type="number" value="{{$head->purchase}}" name="purchase" class="form-control" id="purchase-{{$head->id}}" >
                    </div>
                    <div class="form-group ">
                        <label for="sale" class="control-label">Sale Price:</label>
                    <input type="number" value="{{$head->sale}}" name="sale" class="form-control" id="sale-{{$head->id}}" >
                    </div>
                    <div class="form-group ">
                        <label for="code" class="control-label">Minimum Stock:</label>
                        <input type="number" value="{{$head->min_stock}}" name="min_stock" class="form-control" id="min_stock" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="updateRecord({{$head->id}})" >Update changes</button>
            </div>
        </div>
    </div>
</div>


