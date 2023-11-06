<p data-toggle="modal" data-target="#templateAlert_content" id="templateAlert_logo">
</p>
<div class="modal fade" id="templateAlert_content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header backgroud-style p-0">
                <div class="gradient-bg"></div>

                <div class="popup-logo">
                    <img src="{{asset('storage/logos/popup-logo.png')}}" alt="">
                </div>

                <div class="popup-text text-center p-2">
                    <h2 class="mt-5 alert-title"></h2>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert-content"></div>
                <div class="nws-button text-right white text-capitalize">
                    <button type="button" style="height:unset;width:unset;font-size:1.2rem;" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>