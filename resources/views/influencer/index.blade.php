@extends('layouts.default_module')
@section('module_name')
    User
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
                            var name = response['data'][i].first_name;
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




                            var image_col = `<img width="100px" src="` + image +
                                `" class="show-product-img imgshow">`

                            var tr_str = `<tr>` +
                                `<td>` + image + `</td>` +
                                `<td>` + name + `</td>` +
                                `<td>` + email + `</td>` +
                                `<td>` + number + `</td>` +
                                // `<td>` + influencer_id + `</td>` +
								`<td><button class="btn btn-danger" id="featured_` + influencer_id + `" >featured</button></td>`
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


            function is_featured_on_off(influencer_id) {
                // $.ajax({
                // 	url:'{!! asset('influencer/set_featured') !!}'
                // 	success(function(res){
                // 		if(res.status){
                if ($('#featured_' + influencer_id).hasClass('class_featured')) {
                    $('#featured_' + influencer_id).removeClass('class_featured');
                    $('#featured_' + influencer_id).addClass('class_notfeatured');
                } else {
                    $('#featured_' + influencer_id).removeClass('class_notfeatured');
                    $('#featured_' + influencer_id).addClass('class_featured');
                }
                // 	}
                // }),
                // error(function(e){
                // 	console.log(e);
                // })
                // })
            }

        });

        function set_msg_modal(msg) {
            $('.set_msg_modal').html(msg);
        }
    </script>
@endsection
