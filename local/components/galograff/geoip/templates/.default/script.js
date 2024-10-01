$(document).ready(function () {
    $("#ip").inputmask({
        alias: "ip",
        greedy: false,
        "clearIncomplete": true
    });

    $('body').on('click', '.remove_ip', function (e) {
        e.preventDefault();
        // console.log('+');
        let ip = $(this).data('ip');
        BX.ajax.runComponentAction('galograff:geoip',
            'deleteIp', {
                mode: 'class',
                data: {get: {ip: ip}},
            })
            .then(function (response) {
                if (response.status === 'success') {
                    console.log('deleted');
                    $('.result').show();
                    $('.result').text(response.data).addClass('alert-info');
                    console.log((window.location.origin + window.location.pathname));
                    $.get((window.location.origin + window.location.pathname), function (data) {
                        data = $(data);
                        $('.ip-list').html($('.ip-list', data).html());
                    });
                    setTimeout(() => $('.result').text('').removeClass('alert-info'), 1000);

                }
            });

    });
    $('body').on('submit', '#search_ip', function (e) {
        e.preventDefault();
        // console.log('+');
        let ip = $(this).find('input[name="ip"]');
        BX.ajax.runComponentAction('galograff:geoip',
            'searchIp', {
                mode: 'class',
                data: {get: {ip: ip.val()}},
            })
            .then(function (response) {
                if (response.status === 'success') {
                    console.log(response);
                    $('.result').show();
                    $('.result').text(response.data).addClass('alert-info');
                    $.get((window.location.origin + window.location.pathname), function (data) {
                        data = $(data);
                        $('.ip-list').html($('.ip-list', data).html());
                    });
                    setTimeout(() => $('.result').text('').removeClass('alert-info'), 10000);

                }
            });

    });
});