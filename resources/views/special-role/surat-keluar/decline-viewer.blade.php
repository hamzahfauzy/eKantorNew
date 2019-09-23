<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Decline Editor</title>
    <!-- Bootstrap Core Css -->
    <link href="{{asset('template/bsbm/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.1.266/build/pdf.min.js"></script>
	<script src="{{asset('js/fabric.min.js')}}"></script>
	<style type="text/css">
	body {
		margin:0;
		padding:0;
		background-color: #eaeaea;
	}
	.top {
		position: fixed;
		width: 100%;
		display: block;
		background-color: #333;
		padding: 25px;
		z-index: 1;
	}
	.canvas-wrapper {
		padding-top: 90px;
	    padding-left: 10px;
	    text-align: center;
	}
	.canvas-container {
		margin-bottom: 20px;
	    margin-left: auto;
	    margin-right: auto;
	}
	</style>
</head>
<body>
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Catatan Penolakan</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-float">
                        <label>Catatan</label>
                        <p>{{$histori->keterangan}}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
        </div>
    </div>
</div>
<div class="top">
	<!-- <button id="pdfData">PDF Data</button>
	<button id="loadPDFData">Load PDF Data</button> -->
	<button id="saveBtn" class="btn btn-primary" data-toggle="modal" data-target="#defaultModal"><i class="fa fa-file"></i> Catatan</button>
	<a href="{{route('pegawai.surat-keluar.index')}}" class="btn btn-warning" id="backBtn"><i class="fa fa-arrow-left"></i> Kembali</a>
</div>
<div class="canvas-wrapper" id="canvas-wrapper"></div>
<!-- Jquery Core Js -->
<script src="{{asset('template/bsbm/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript">
const pdfFileUrl = '{{Storage::url($surat->file_surat_url)}}';

var pdfJSON = '<?= json_encode(unserialize($histori->pdf_serialize)) ?>'
var pdfData = [];
var enableText = false;
var activeCanvas = null;

let pdfDoc = null,
	context = null;

const scale = 1.3,
	  pdf_canvas = document.getElementById("pdf_canvas"),
	  canvas_wrapper = document.getElementById("canvas-wrapper");

pdfjsLib.getDocument(pdfFileUrl).promise.then( doc => {
	console.log("this file has "+doc._pdfInfo.numPages+" page(s)");
	var numPages = doc._pdfInfo.numPages
	pdfDoc = doc
	var pageRendered = 0
	for(i=1;i<=numPages;i++)
	{
		pdfDoc.getPage(i).then(page => {
			const viewport = page.getViewport({ scale })
			var cvs = document.createElement('canvas');
			canvas_wrapper.appendChild(cvs)
			cvs.className = 'pdf-canvas'
			cvs.width = viewport.width
			cvs.height = viewport.height
			context = cvs.getContext('2d')

			const renderCtx = {
				canvasContext: context,
				viewport: viewport
			}
			page.render(renderCtx).promise.then(() => {
				var canvasEl = document.querySelectorAll('.pdf-canvas')
				canvasEl.forEach((el, index) => {
					el.id = 'page-'+(index+1)+'-canvas'
				})
				pageRendered++
				if(pageRendered == numPages) initFabric()
			})
		})
	}
})
.catch(err => {
	console.log(err)
})

function initFabric()
{
	var allCanvas = document.querySelectorAll('#canvas-wrapper canvas');
	allCanvas.forEach((el, index) => {
		var bg = el.toDataURL("image/png");
		var fabricObj = new fabric.Canvas(el.id);
		pdfData.push(fabricObj)
		fabricObj.setBackgroundImage(bg, fabricObj.renderAll.bind(fabricObj));
	})

    loadFromJSON()

}

function loadFromJSON()
{
	var data = JSON.parse(pdfJSON)
	// console.log(data)
	pdfData.forEach((fabricObj, index) => {
		if(data.length > index)
		{
			fabricObj.loadFromJSON(data[index], fabricObj.renderAll.bind(fabricObj), function(o, object) {
                object.set('selectable', false);
            });
		}
	})
}
</script>
</body>
</html>