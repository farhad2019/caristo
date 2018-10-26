function confirmDelete(form) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(function (willDelete) {
        if (willDelete) {
            $(form).submit();
        }
    });
}

function formatFaIcon(state) {
    if (!state.id) return state.text; // optgroup
    return "<i class='fa fa-" + state.id + "'></i> " + state.text;
}

function defaultFormat(state) {
    return state.text;
}

$(function () {

    $('input:checkbox, input:radio').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $('.delete_image').on('click', function () {
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function (willDelete) {
            if (willDelete) {
                $.ajax({
                    url: "../../deleteWTimage/" + id,
                    context: document.body,
                    method: 'GET'
                }).done(function (response) {
                    if (response === 'Success') {
                        swal({
                            title: "Success",
                            text: "Media Successfully Deleted!",
                            icon: "success"
                        }).then(function (willDelete) {
                            location.reload();
                        });
                    }
                    else
                        alert('Something Went Wrong!');
                });
            }
        });
    });

    /*$('.select2').each(function () {
        $(this).css('width', '100%');
        var format = $(this).data('format') ? $(this).data('format') : "defaultFormat";
        $(this).select2({
            theme: "bootstrap",
            templateResult: window[format],
            templateSelection: window[format],
            escapeMarkup: function (m) {
                return m;
            }
        });
    });*/

    $('input:checkbox.checkall').on('ifToggled', function (event) {
        var newState = $(this).is(":checked") ? 'check' : 'uncheck';
        var css = $(this).data('check');
        $('input:checkbox.' + css).iCheck(newState);
    });

    $('.screenContent').show();
    $('.fileUpload').hide();
    $('.url').hide();

    $('.walkThroughSelect2').on('change', function () {
        var value = $(this).val();

        if (value != 10) {
            if (value == 20 || value == 30) {
                $('.fileUpload').show();
                $('.screenContent').hide();
                $('.url').hide();
            }
            if (value == 40 || value == 60) {
                $('.fileUpload').show();
                $('.screenContent').show();
                $('.url').hide();
            }
            if (value == 50 || value == 70) {
                $('.fileUpload').hide();
                $('.screenContent').show();
                $('.url').show();
            }
        } else {
            $('.screenContent').show();
            $('.fileUpload').hide();
            $('.url').hide();
        }
    });

    $('.walkThroughSelect2').trigger('change');

    $(document).on('click', '.btn-up', function () {

        var tr = $(this).parents('tr');
        var trPrev = tr.prev('tr');

        if (trPrev.length != 0) {
            var prevRowPos = $('input.inputSort', trPrev).val();
            var prevRowId = $('input.inputSort', trPrev).data('id');
            var rowPos = $('input.inputSort', tr).val();
            var rowId = $('input.inputSort', tr).data('id');

            // Handle UI
            trPrev.before(tr.clone());
            tr.remove();

            // Init Ajax to send sort values.
            var result = swappingRequest(prevRowPos, prevRowId, rowPos, rowId);

            if (result) {
                // Update chanel position - UI
                $('input.inputSort', tr).val('');
                $('input.inputSort', tr).val(prevRowPos);

                $('input.inputSort', trPrev).val('');
                $('input.inputSort', trPrev).val(RowPos);
            }
        }
    });

    $(document).on('click', '.btn-down', function () {
        var tr = $(this).parents('tr');
        var trPrev = tr.next('tr');
        if (trPrev.length != 0) {
            var prevRowPos = $('input.inputSort', trPrev).val();
            var prevRowId = $('input.inputSort', trPrev).data('id');
            var rowPos = $('input.inputSort', tr).val();
            var rowId = $('input.inputSort', tr).data('id');


            // Init Ajax to send sort values.
            swappingRequest(prevRowPos, prevRowId, rowPos, rowId, function (response) {
                var result = response.msg;
                if (result) {
                    // Update chanel position - UI
                    $('input.inputSort', tr).val(prevRowPos);
                    $('input.inputSort', trPrev).val(rowPos);

                    // Handle UI
                    tr.next('tr').after(tr.clone());
                    tr.remove();
                }
            });

        }
    });
});
$(document).ready(function () {

    $('.select2').css('width', '100%');

    $.fn.customLoad = function () {

        $('.select2').each(function () {
            var format = $(this).data('format') ? $(this).data('format') : "defaultFormat";
            var thisSelectElement = this;
            var options = {
                theme: "bootstrap",
                templateResult: window[format],
                templateSelection: window[format],
                escapeMarkup: function (m) {
                    return m;
                }
            };

            if ($(thisSelectElement).data('url')) {
                var depends;
                if ($(thisSelectElement).data('depends')) {
                    depends = $('[name=' + $(thisSelectElement).data('depends') + ']');
                    depends.on('change', function () {
                        $(thisSelectElement).val(null).trigger('change')
                        // $(thisSelectElement).trigger('change');
                    });
                }
                var url = $(thisSelectElement).data('url');

                options.ajax = {
                    url: url,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term,
                            locale: 'en',
                            depends: $('option:selected', depends).val()
                        }
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (obj, id) {
                                return {id: obj.id, text: obj.name};
                            })
                        };
                    }

                }
            }

            var tabindex = $(thisSelectElement).attr('tabindex');

            $(thisSelectElement).select2(options);

            $(thisSelectElement).attr('tabindex', tabindex);
            $(thisSelectElement).on(
                'select2:select', (
                    function () {
                        $(this).focus();
                    }
                )
            );
        });
    };

    $(document).customLoad();
});

function swappingRequest(prevRowPos, prevRowId, rowPos, rowId, cb) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $.ajax({
        method: "POST",
        url: "updatePosition",
        type: "JSON",
        async: false,
        data: {
            rowId: rowId,
            rowPosition: rowPos,
            prevRowId: prevRowId,
            prevRowPosition: prevRowPos
        },
        success: cb
    });
}


$(function () {
    var imgNum = 0;
    /* BOOTSTRAP SLIDER */
    $('.slider').slider();

    $('#imageGallery .prev').click(function () {
        imgNum--;
        if (imgNum < 1) {
            imgNum = $('.mySlides', $('#imageGallery')).length;
        }
        $.next();
    });
    $('#imageGallery .next').click(function () {
        imgNum++;
        if (imgNum > $('.mySlides', $('#imageGallery')).length) {
            imgNum = 1;
        }
        $.next();
    });

    $('#imageGallery').on('show.bs.modal', function () {
        //showDivs(1);
        imgNum = 1;
        $.next();
    });


    $.next = function () {
        var imagesGallery = $('#imageGallery');
        $('.mySlides', imagesGallery).hide();
        $('img.mySlides:nth-child(' + imgNum + ')', imagesGallery).show();
    };

    $('body').on('click', 'a.showGallery', function () {
        // TODO: Add Content in Modal Body
        var thisid = $(this).data('id');
        $('#displayImage img', $('#imageGallery')).remove();
        $('.showGallery[data-id="' + thisid + '"]').each(function () {
            var src = $(this).find('img').attr('src');
            console.log(src);

            $('#displayImage', $('#imageGallery')).append(
                '<img class="mySlides" src="' + src + '" width="550"/>'
            )
        });

        $('#imageGallery').show();
        // showDivs(1);
    })
});