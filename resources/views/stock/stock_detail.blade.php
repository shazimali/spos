<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">{{$stock->productHead->code}}-{{$stock->productHead->title}} Stock Detail</h4> </div>
            <div class="modal-body">
                <div class="row">
                    <h5 class="col-sm-4 font-bold"><ul>Total Qty</ul></h5>
                    <h5 class="col-sm-4 font-bold"><ul>Net Price</ul></h5>
                    <h5 class="col-sm-4 font-bold"><ul>Created</ul></h5>
                </div>
                @foreach($stock->productHead->allPurchases as $item)
                <hr>
                <div class="row">
                <span class="col-sm-4"><ul>{{$item->total_qty}}</ul></span>
                <span class="col-sm-4"><ul>{{$item->total_price}}</ul></span>
                <span class="col-sm-4"><ul>{{$item->created_at->toFormattedDateString()}}</ul></span>
                </div>
                @endforeach
                <div class="row">
                        <span class="col-sm-4"><ul>{{$item->total_qty}}</ul></span>
                        <span class="col-sm-4"><ul>{{$item->total_price}}</ul></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
