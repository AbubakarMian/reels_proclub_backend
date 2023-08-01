<style>
    .vdvjib img {
        /* max-height: 80px; */
        max-width: 100px;
        margin-bottom: 7px;
        border: 1px solid;
        border-radius: 11px;
    }

    .image_area {
        position: relative;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }

    .overlay {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        background-color: rgba(255, 255, 255, 0.5);
        overflow: hidden;
        height: 0;
        transition: .5s ease;
        width: 100%;
    }

    .medsaveclick {
        color: white;
        padding: 1px !important;
    }

    .image_area:hover .overlay {
        height: 50%;
        cursor: pointer;
    }

    .tickbox input {
        height: 23px;
    }

    .text {
        color: blue;
        font-size: 15px;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .vsdas {
        margin: -29px -10px;
        margin-bottom: 3%;
    }

    .installmet_div_row {
        padding: 5px 10px;
        border: 1px solid #e6e6e6;
        margin-bottom: 5px;
    }
</style>
<div class="modal fade" id="crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="text-align: center; font-size: 14px; font-weight: 600;" class="modal-title">
                    Crop Image Before Upload</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button> --}}
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="" id="cropper_sample_image" />
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>

{{-- <input type="file" {!! $required !!} name="image" class="image crop_upload_image"
image_width="378"
image_height="226"
aspect_ratio_width="16"
aspect_ratio_height="9"
id="upload_image" style="display:block" /> --}}


<!-- cropper open -->

<!-- endbuild -->
{{-- <script src="{{ asset('theme/vendor/parsleyjs/dist/parsley.min.js') }}"></script> --}}
{{-- <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" /> --}}
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
<script src="https://unpkg.com/cropperjs"></script>
<!-- cropper close -->

<script>
    $(function() {
        var modal = $('#crop-modal');
        var image = document.getElementById('cropper_sample_image');
        var cropper;
        var image_width;
        var image_height;
        var aspect_ratio_width;
        var aspect_ratio_height;
        var selected_image_input;

        $('.crop_upload_image').change(function(event) {
            var image_num = '';
            selected_image_input = event.target;
            image_width = $($(event)).attr('image_width');
            image_height = $(this).attr('image_height');
            aspect_ratio_width = $(this).attr('aspect_ratio_width');
            aspect_ratio_height = $(this).attr('aspect_ratio_height');
            console.log('image_widthimage_widthimage_width', image_width)
            console.log('image_heightimage_height', image_height)
            console.log('aspect_ratiowidthaspect_ratio_width', aspect_ratio_width)
            console.log('aspect_ratio_heightaspect_ratio_height', aspect_ratio_height)
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                modal.modal('show');
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function() {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
            image_num = event.target.id;
            console.log('image num ', image_num);
        });

        modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: aspect_ratio_width / aspect_ratio_height,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });


        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: image_width,
                height: image_height
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                
                var remove_previous = $(selected_image_input).attr('keep_previous') === "true" ? true:false;
               
                    console.log('keep pre 2',remove_previous);
               

                var upload_input_by_name = $(selected_image_input).attr('upload_input_by_name');
                var pre_image = $('input[name="'+upload_input_by_name+'"]');
                var pre_image_url = '';
                if(pre_image.length > 0 && remove_previous){
                    pre_image_url = pre_image.val();
                }
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $.ajax({
                        url: "{!! asset('cropper/crop_image') !!}",
                        method: 'POST',
                        data: {
                            image: base64data,
                            pre_image:pre_image_url,
                            _token: '{!! csrf_token() !!}',
                        },
                        success: function(data) {
                            modal.modal('hide');
                            console.log('data image upload  ', data);
                            if (data.status) {
                                var cropped_file_input =
                                    '<input type="hidden" name="' +
                                    upload_input_by_name + '" value="' + data
                                    .image + '">';
                                console.log('m2', cropped_file_input);
                                $(selected_image_input).parent().find('input[name="'+upload_input_by_name+'"]').remove();
                                $(selected_image_input).parent().append(
                                    cropped_file_input);
                            } else {
                                alert('Invalid upload');
                            }
                        }
                    });
                };
            });
        });

        $('.crop_upload_image').click(function() {
            $(this).val('');
        });
    });
</script>
