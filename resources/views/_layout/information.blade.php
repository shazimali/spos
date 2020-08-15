<div class="col-sm-6">
                        <h6 class="mb-3">By:</h6>
                        <div>
                            <strong>{{ $info->title }}</strong>
                        </div>
                        <div>{{ $info->address }}</div>
                        <div>Mob:{{ $info->mobile }}</div>
                        <div>Phone: {{ $info->phone }}</div>
                        @if(count($tax_id))
                        <div>NTN: {{ $info->ntn }}</div>
                        @endif
</div>