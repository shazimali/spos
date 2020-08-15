<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Create Product Head</h4> </div>
            <div class="modal-body">
                <form onsubmit="createRecord()" id="create-record">
                    <div>

                    @csrf
                    </div>
                    <div class="form-group ">
                        <label for="title" class="control-label">Name:</label>
                        <input type="text" name="title" class="form-control" id="title" >
                    </div>
                    <div class="form-group ">
                        <label for="code" class="control-label">Code #:</label>
                        <input type="text" name="code" class="form-control" id="code" >
                    </div>
                    <div class="form-group ">
                        <label for="code" class="control-label">Unit:</label>
                        <select class="form-control" name="unit_id" id="unit_id">
                            <option value="">Please Select</option>
                            @foreach($units as $unit)
                            @if($loop->first)
                            <option selected value="{{ $unit->id }}">{{ $unit->title }}</option>
                            @else
                            <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="code" class="control-label">Brand:</label>
                        <select class="form-control" name="brand_id" id="brand_id">
                            <option value="">Please Select</option>
                            @foreach($brands as $brand)
                            @if($loop->first)
                            <option selected value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @else
                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="purchase" class="control-label">Purchase Price:</label>
                        <input type="number" name="purchase" class="form-control" id="purchase" >
                    </div>
                    <div class="form-group ">
                        <label for="sale" class="control-label">Sale Price:</label>
                        <input type="number" name="sale" class="form-control" id="sale" >
                    </div>
                    <div class="form-group ">
                        <label for="min_stock" class="control-label">Minimum Stock:</label>
                        <input type="number" value="1" name="min_stock" class="form-control" id="min_stock" >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="createRecord()" >Save changes</button>
            </div>
        </div>
    </div>
</div>


