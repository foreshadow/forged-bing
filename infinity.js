$(document).ready(function() {
    function update_deadline() {
        $.get('/deadlines.php', function(data) {
            $('#deadlines-list').html(data);
            $('#deadlines .badge').html($('#deadlines-new').html());
            $('.deadline-remove').click(function() {
                if (confirm('Are you sure to remove?')) {
                    $.post('deadlines.php', {
                        id: $(this).attr('id')
                    }).done(function(data) {
                        update_deadline();
                    });
                }
            });
        });
    }

    function update_github() {
        $.get('/github.php', function(data) {
            $('#feeds').html(data);
            $('#github .badge').html($('#github-new').html());
        });
    }

    function realtime() {
        var date = new Date();
        var time = date.getHours() + ':';
        if (date.getMinutes() < 10) {
            time += '0';
        }
        time += date.getMinutes();
        // time += ':';
        // if (date.getSeconds()) {
        //     time += '0';
        // }
        // time += date.getSeconds();
        $('#realtime').html(
            (date.getYear() + 1900) + '/' + (date.getMonth() + 1) + '/' + date.getDay() + '&nbsp;&nbsp;' + time
        );
        setTimeout(realtime, 1000);
    }

    realtime();
    $('a[href^="http"]').each(function() {
        $(this).attr('target', '_blank');
    });
    $.get('/deadlines.php', function(data) {
        $('#deadlines-list').html(data);
        $('#deadlines .badge').html($('#deadlines-new').html());
        $('.deadline-remove').click(function() {
            if (confirm('Are you sure to remove?')) {
                $.post('deadlines.php', {
                    id: $(this).attr('id')
                }).done(function(data) {
                    update_deadline();
                });
            }
        });
    });
    $.get('/events.php', function(data) {
        $('.panel-event').html(data);
    });
    $.get('/trends.php', function(data) {
        $('#trends').html(data);
        $('#bilibili .badge').html($('#trend-new').html());
    });
    $.get('/github.php', function(data) {
        $('#feeds').html(data);
        $('#github .badge').html($('#github-new').html());
        $('#feeds a').each(function() {
            $(this).attr('href', 'https://github.com' + $(this).attr('href'));
            $(this).attr('target', '_blank');
        });
    });
    $.get('/contest.php?handle=Infinity25', function(data) {
        $('#contests').html(data);
        $('#codeforces .badge').html($('#contest-new').html());
        $('a[href^="http"]').each(function() {
            $(this).attr('target', '_blank');
        });
        $('#contests .verdict').tooltip({
            html: true,
            placement: 'right'
        });
    });
    $('#deadline-create').click(function() {
        $.post('deadlines.php', {
            name: $('#deadline-name').val(),
            time: $('#deadline-time').val()
        }).done(function(data) {
            $('#modal').modal('hide');
            update_deadline();
        });
    });
    $('#sb_form_q').focus(function() {
        $('.foreground').fadeIn('fast');
    });
    $('#sb_form_q').blur(function() {
        $('.foreground').fadeOut('fast');
    });
    $('#bilibili').hover(function() {
        $('#trends').fadeIn('fast');
    }, function() {
        $('#trends').fadeOut('fast');
    });
    $('#github').hover(function() {
        $('#feeds').fadeIn('fast');
    }, function() {
        $('#feeds').fadeOut('fast');
    });
    $('#codeforces').hover(function() {
        $('#contests').fadeIn('fast');
    }, function() {
        $('#contests').fadeOut('fast');
    });
    $('#deadlines-link').click(function() {
        $('#deadlines-list').toggle('fast');
    });
    $('#switch').click(function() {
        $('#navbar-bottom').toggle('fast');
    });
});
