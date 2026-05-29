@extends('web.layout.app')
@section('content')
<section class="inner_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner_section_banner">
                    <h4>Mutual Fund Taxation</h4>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="pentatech_section section">
    <div class="container">
        <div class="row">
            <div class="co-md-12">
                <div class="pentatech_inner_wrapper">
                    <div class="pentatech_filter_title m-3">
                        <h4>{{$fundTxnMdl->title}}</h4>
                    </div>

                    <div id="pdf-container2"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@push('style')
<style>
    canvas {
        display: block;
        margin: 20px auto;
        border: 1px solid #ccc;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    

    document.addEventListener('DOMContentLoaded', () => {
        const url = '{{ url('storage/pdf/'.$fundTxnMdl->file) }}'; // Replace with the actual PDF path
        const container = document.getElementById('pdf-container2');

        const renderPDF = async (url) => {
            const loadingTask = pdfjsLib.getDocument(url);
            const pdf = await loadingTask.promise;

            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                const page = await pdf.getPage(pageNum);
                const viewport = page.getViewport({
                    scale: 1.75
                });

                const canvas = document.createElement("canvas");
                const context = canvas.getContext("2d");
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                container.appendChild(canvas);

                await page.render({
                    canvasContext: context,
                    viewport
                }).promise;
            }
        };

        renderPDF(url).catch(console.error);
    });
</script>
@endpush