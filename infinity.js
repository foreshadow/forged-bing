// $.get('/dropdown.php', function(data) {
//     $('#links').html(data);
// });
$(document).ready(function() {
    $('#deadline-create').click(function() {
        $.post('deadlines.php', {
            name: $('#deadline-name').val(),
            time: $('#deadline-time').val()
        }).done(function(data) {
            $('#modal').modal('hide');
            $.get('/deadlines.php', function(data) {
                $('.panel-deadline').html(data);
            });
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
    $('#codeforces').hover(function() {
        $('#contests').fadeIn('fast');
    }, function() {
        $('#contests').fadeOut('fast');
    });
    $.get('/deadlines.php', function(data) {
        $('.panel-deadline').html(data);
        $('.deadline-remove').click(function() {
            if (confirm("Are you sure to remove?")) {
                $.post('deadlines.php', {
                    id: $(this).attr('id')
                }).done(function(data) {
                    $.get('/deadlines.php', function(data) {
                        $('.panel-deadline').html(data);
                    });
                });
            }
        });
    });
    $.get('/events.php', function(data) {
        $('.panel-event').html(data);
    });
    $.get('/trends.php', function(data) {
        $('.dropdown-trend').html(data);
        $('#bilibili .badge').html($('#trend-new').html());
    });
    $.get('/contest.php', function(data) {
        $('.dropdown-codeforces').html(data);
        $('#codeforces .badge').html($('#contest-new').html());
    });
});
