<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{asset('/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

</head>
<body>
    <h1>Heading</h1>
<div id="pdf" >
    <h1>Invoice # {{$invoice->id}}</h1>
</div>

<script>

    $(window).on('load',function () {
        var doc = new jsPDF();


       var data = doc.fromHTML($('#pdf').get(0), 10, 10, {'width': 180});

        function debugBase64(base64URL){
            var win = window.open();
            win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
        }

        debugBase64(doc.output('datauri'))
        window.close()
       })

</script>


</body>
</html>