@extends('layouts.default_module')
@section('module_name')
Influencer
@stop

@section('table-properties')
    width="400px" style="table-layout:fixed;"
@endsection



<style>
    td {
        white-space: nowrap;
        overflow: hidden;
        width: 30px;
        height: 30px;
        text-overflow: ellipsis;
    }

    .fhgyt th {
        border: 1px solid #e3e6f3 !important;
    }

    .fhgyt td {
        border: 1px solid #e3e6f3 !important;
        background: #f9f9f9
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('table')

    <table class="fhgyt" id="userTableAppend" style="opacity: 0">
        <thead>
            <tr>


                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>IsFeatured</th>






            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop
@section('app_jquery')

    <script>
        $(document).ready(function() {

            fetchRecords();

            function fetchRecords() {

                $.ajax({
                    url: '{!! asset('admin/get_influencer') !!}',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log('response');
                        $("#userTableAppend").css("opacity", 1);
                        var len = response['data'].length;

                        console.log(response);


                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var influencer_id = response['data'][i].influencer_id;
                            var name = response['data'][i].name;
                            var email = response['data'][i].email;
                            var number = response['data'][i].phone_no;
                            var is_featured = response['data'][i].is_featured;
                            var image = response['data'][i].image ? response['data'][i].image :
                                response['data'][i].avatar;
                            //   var deleted_at   = response['data'][i].deleted_at;

                            if (!image) {
                                image = "{!! asset('public/images/logo.png') !!}"
                                console.log('no image');
                            }

                            // users    role ids
                            // 'admin'    => '1',
                            // 'user'   => '2',
                            // 'teacher'   => '3',
                            // 'employee'   => '4',


                            var is_checked = is_featured ? 'checked' : '';
                            var onclick = "toggle_featured('" + influencer_id + "')";

                            var image_col = `<img width="100px" src="` + image +
                                `" class="show-product-img imgshow">`

                            var tr_str = `<tr>` +
                                `<td>` + image_col + `</td>` +
                                `<td>` + name + `</td>` +
                                `<td>` + email + `</td>` +
                                `<td>` + number + `</td>` +
                                // `<td>` + influencer_id + `</td>` +
                                `<td><label class="switch">
								<input id="featured_` + influencer_id + `" type="checkbox" ` + is_checked + ` onclick="` + onclick + `">
								<span class="slider round "></span>
								</label></td>`
                            //         `<td>
                        // <button id="featured_` + influencer_id + `" class="` + is_featured ? 'class_featured' : 'class_notfeatured' +`"
                        //          onclick('is_featured_on_off(` + influencer_id + `)')>On</button>` +

                            //         +`</td>` +
                            // `<td><button id="featured_` + influencer_id + `" >asd</button></td>`

                            "</tr>";

                            $("#userTableAppend tbody").append(tr_str);
                        }
                        console.log('sadasdasdad');
                        $('#userTableAppend').DataTable({
                            dom: '<"top_datatable"B>lftipr',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ],
                        });
                    }
                });
            }




        });


		
            function toggle_featured(influencer_id) {
                // var featured_ckbox = $('#featured_' + influencer_id);
                // featured_ckbox.prop("checked", !featured_ckbox.prop("checked"));
                // return;
                $.ajax({
                    url: '{!! asset("admin/influencer/set_featured") !!}/' + influencer_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log('response', response);
                        if (response.status) {

                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            }
        function set_msg_modal(msg) {
            $('.set_msg_modal').html(msg);
        }
    </script>
@endsection
