//upload add 1 ảnh post
$(document).ready(function () {
    $('#Upload-image-post').click(function () {
        var url = $('#file-image-post').attr('data-url');
        var inputFile = $('#file-image-post');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imagePost', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                $('#image_id').val(data.image_id)
                showThumbUpload(data)
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false;
    });

    function showThumbUpload(data) {
        var items;
        items = '<img src="' + urlAsset + data.image_url + '" alt="Asset"/>';
        $('.show_image_post').html(items);
    }
    
});
//update upload 1 ảnh post
$(document).ready(function () {
    $('#Update-upload-image-post').click(function () {
        var url = $('#file-image-post').attr('data-url');
        var post_id = $('#post_id').val();
        var inputFile = $('#file-image-post');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('UpdateImagePost', fileUpload);
        formData.append('post_id', post_id);;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $('#image_id').val(data.image_id)
                showThumbUpload(data)
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false
    });

    function showThumbUpload(data) {
        var items;
        var items = '<img src="' + urlAsset + data.image_url + '" alt="Asset"/>';
        $('.show_image_post').html(items);
    }
});
//upload một ảnh slider
$(document).ready(function () {
    $('#Upload-image-slider').click(function () {
        var url = $('#file-image-slider').attr('data-url');
        var inputFile = $('#file-image-slider');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imageSlider', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#image_id_slider').val(data.image_id_slider);
                $('#show_image_slider').html(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    })
    
});

//update 1 ảnh cho phần slider
$(document).ready(function () {
    $('#update-Upload-image-slider').click(function () {
        var url = $('#file-image-slider').attr('data-url');
        var data_id_slider = $('#show_image_slider img').attr('data-id-slider');
        var inputFile = $('#file-image-slider');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('updateImageSlider', fileUpload);
        formData.append('data_id_slider', data_id_slider);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
               $('#show_image_slider img').remove();
               $('#show_image_slider').html(data.result);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    });
    
});

//upload một ảnh Image2Vexpress
$(document).ready(function () {
    $('#Upload-image-v2express').click(function () {
        var url = $('#file-image-v2express').attr('data-url');
        var inputFile = $('#file-image-v2express');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imageV2express', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#image_id_imageV2express').val(data.image_id_imageV2express);
                $('#show_image_v2express').html(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    })
    
});

// update 1 ảnh cho phần image2vexpress
$(document).ready(function () {
    $('#update-Upload-image-v2express').click(function () {
        var url = $('#file-image-v2express').attr('data-url');
        var data_id_slider = $('#show_image_v2express img').attr('data-id-slider');
        var inputFile = $('#file-image-v2express');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('updateImage2Vexpress', fileUpload);
        formData.append('data_id_slider', data_id_slider);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
               $('#show_image_v2express img').remove();
               $('#show_image_v2express').html(data.result);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    });
    
});

//upload một ảnh fastMoving
$(document).ready(function () {
    $('#Upload-image-fastMoving').click(function () {
        var url = $('#file-image-fastMoving').attr('data-url');
        var inputFile = $('#file-image-fastMoving');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imageFastMoving', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#image_id_fastMoving').val(data.image_id_fastMoving);
                $('#show_image_fastMoving').html(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    })
    
});

// update 1 ảnh cho phần image2vexpress
$(document).ready(function () {
    $('#update-Upload-image-fastMoving').click(function () {
        var url = $('#file-image-fastMoving').attr('data-url');
        var data_id_slider = $('#show_image_fastMoving img').attr('data-id-slider');
        var inputFile = $('#file-image-fastMoving');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('updateImageFastMovingPartner', fileUpload);
        formData.append('data_id_slider', data_id_slider);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
               $('#show_image_fastMoving img').remove();
               $('#show_image_fastMoving').html(data.result);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    });
    
});

//upload một ảnh messageCustomer
$(document).ready(function () {
    $('#Upload-image-messageCutomer').click(function () {
        var url = $('#file-image-messageCutomer').attr('data-url');
        var inputFile = $('#file-image-messageCutomer');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imageMessageCustomer', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $('#image_id_messageCusomer').val(data.image_id_MessageCustomer);
                $('#show_image_messageCutomer').html(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    })
    
});

// update 1 ảnh cho phần message customer
$(document).ready(function () {
    $('#update-Upload-image-messageCustomer').click(function () {
        var url = $('#file-image-messageCutomer').attr('data-url');
        var data_id_slider = $('#show_image_messageCutomer img').attr('data-id-slider');
        var inputFile = $('#file-image-messageCutomer');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('updateImageMessageCustomer', fileUpload);
        formData.append('data_id_slider', data_id_slider);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
               $('#show_image_messageCutomer img').remove();
               $('#show_image_messageCutomer').html(data.result);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    });
    
});

//upload một ảnh postCatHome
$(document).ready(function () {
    $('#Upload-image-postCatHome').click(function () {
        var url = $('#file-image-postCatHome').attr('data-url');
        var inputFile = $('#file-image-postCatHome');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData;
        formData.append('imagePostCatHome', fileUpload);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#image_id_postCatHome').val(data.image_id_postCatHome);
                $('#show_image_postCatHome').html(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    })
    
});

// update 1 ảnh cho phần message customer
$(document).ready(function () {
    $('#update-Upload-image-postCatHome').click(function () {
        var url = $('#file-image-postCatHome').attr('data-url');
        var data_id_slider = $('#show_image_postCatHome img').attr('data-id-slider');
        var inputFile = $('#file-image-postCatHome');
        var fileUpload = inputFile[0].files[0];
        var formData = new FormData();
        formData.append('updateImagePostCatHome', fileUpload);
        formData.append('data_id_slider', data_id_slider);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'post',
            data: formData,
            // thiết lập processData: false và contentType: false trong cấu hình AJAX để tránh xử lý dữ liệu FormData một cách tự động:
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
               $('#show_image_postCatHome img').remove();
               $('#show_image_postCatHome').html(data.result);
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false

    });
    
});

