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
            <form id="form_tolak" method="POST" action="{{route('pegawai.surat-keluar.decline')}}">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Tolak Surat</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$histori->id}}">
                    <div class="form-group form-float">
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="top">
	<!-- <button id="pdfData">PDF Data</button>
	<button id="loadPDFData">Load PDF Data</button> -->
	<button id="saveBtn" data-toggle="modal" data-target="#defaultModal"><i class="fa fa-save"></i> Simpan</button>
	<button id="pointerBtn"><i class="fa fa-mouse-pointer"></i></button>
	<button id="pencilBtn"><i class="fa fa-pencil"></i></button>
	<button id="fontBtn"><i class="fa fa-font"></i></button>
	<button id="trashBtn"><i class="fa fa-trash"></i></button>
</div>
<div class="canvas-wrapper" id="canvas-wrapper"></div>
<!-- Jquery Core Js -->
<script src="{{asset('template/bsbm/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core Js -->
<script src="{{asset('template/bsbm/plugins/bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript">
const pdfFileUrl = '{{Storage::url($surat->file_surat_url)}}';

var pdfData = [];
var enableText = false;
var activeCanvas = null;

let pdfDoc = null,
	context = null;

const scale = 1.3,
	  pdf_canvas = document.getElementById("pdf_canvas"),
	  canvas_wrapper = document.getElementById("canvas-wrapper");

var showPdfData = () => {
	var string = JSON.stringify(pdfData);
	console.log(string)
}

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

// document.querySelector("#pdfData").addEventListener('click',showPdfData)
// document.querySelector("#loadPDFData").addEventListener('click',loadFromJSON)
document.querySelector("#pointerBtn").addEventListener('click',enablePointer)
document.querySelector("#pencilBtn").addEventListener('click',enablePencil)
document.querySelector("#fontBtn").addEventListener('click',enableAddText)
document.querySelector("#trashBtn").addEventListener('click',deleteObject)
window.addEventListener('keydown', function(event) {
    const key = event.key; // const {key} = event; ES6+
    if (key === "Delete") {
        deleteObject()
    }
});

function initFabric()
{
	var allCanvas = document.querySelectorAll('#canvas-wrapper canvas');
	allCanvas.forEach((el, index) => {
		var bg = el.toDataURL("image/png");
		var fabricObj = new fabric.Canvas(el.id, {
			freeDrawingBrush: {
				width: 1,
				color: 'red'
			}
		});

		pdfData.push(fabricObj)
		fabricObj.setBackgroundImage(bg, fabricObj.renderAll.bind(fabricObj));
		fabricObj.isDrawingMode = true;
		fabricObj.freeDrawingBrush.color = 'red';

		fabricObj.upperCanvasEl.addEventListener('click', function (event) {
	        canvasClick(event, fabricObj);
	    });

	})

}

function loadFromJSON()
{
	var data = JSON.parse(pdfJSON)
	// console.log(data)
	pdfData.forEach((fabricObj, index) => {
		if(data.length > index)
		{
			fabricObj.loadFromJSON(data[index])
		}
	})
}

function enablePointer()
{
	pdfData.forEach((fabricObj, index) => {
		fabricObj.isDrawingMode = false
	})
}

function enableAddText()
{
	enableText = true
	pdfData.forEach((fabricObj, index) => {
		fabricObj.isDrawingMode = false
	})
}

function enablePencil()
{
	pdfData.forEach((fabricObj, index) => {
		fabricObj.isDrawingMode = true
	})
}

function canvasClick(event, fabricObj) {
	activeCanvas = fabricObj
	if (enableText) {
	    var text = new fabric.IText('Sample text', {
	        left: event.clientX - fabricObj.upperCanvasEl.getBoundingClientRect().left,
	        top: event.clientY - fabricObj.upperCanvasEl.getBoundingClientRect().top,
	        fill: 'red',
	        fontSize: '12',
	        selectable: true
	    });
	    fabricObj.add(text);
	    enableText = false
	}
}

function deleteObject()
{
	activeCanvas.remove(activeCanvas.getActiveObject());
}

$("#form_tolak").submit(() => {
    event.preventDefault();
	var data = JSON.stringify(pdfData)
    var catatan = $("textarea[name=catatan]").val()
	var id = $("input[name=id]").val()
	var _url = $("#form_tolak").attr('action')
    $.post(_url,{
		id:id,
        catatan:catatan,
        pdfData:data,
        _token:'{{csrf_token()}}'
    },res => {
		alert('Surat berhasil ditolak');
		location='{{route("pegawai.surat-keluar.index")}}'
        console.log(res)
    })
})
</script>
</body>
</html>