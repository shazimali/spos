@if(session('success'))
 <div style="display:block;" id="main-error" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-right">
        <a href="javascript:" onclick="$('#main-error').hide();" class="closed">&times;</a>
 <h4>You have a Message!</h4>{{session('success')}}</div>
@endif
