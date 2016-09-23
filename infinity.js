// $.get('/dropdown.php', function(data) {
//     $('#links').html(data);
// });
$(document).ready(function() {
    function update_deadline() {
        $.get('/deadlines.php', function(data) {
            $('#deadlines-list').html(data);
            $('#deadlines .badge').html($('#deadlines-new').html());
        });
    }
    $.get('/deadlines.php', function(data) {
        $('#deadlines-list').html(data);
        $('#deadlines .badge').html($('#deadlines-new').html());
        $('.deadline-remove').click(function() {
            if (confirm("Are you sure to remove?")) {
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
    $.get('/contest.php', function(data) {
        $('#contests').html(data);
        $('#codeforces .badge').html($('#contest-new').html());
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
    $('#codeforces').hover(function() {
        $('#contests').fadeIn('fast');
    }, function() {
        $('#contests').fadeOut('fast');
    });
    $('#deadlines-link').click(function() {
        $('#deadlines-list').toggle("fast");
    });
    $('#switch').click(function() {
        $('#navbar-bottom').toggle("fast");
    });
});
