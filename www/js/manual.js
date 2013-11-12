/**
 * Created by Siada-Apius on 29.10.13.
 */
$(document).ready(function () {
    $(function() {

        /**
         * wysiwyg
         */

        // Add markItUp! to your textarea in one line
        // $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
        $('.wysiwyg').markItUp(mySettings);
    });

    $('.delete_article').click(function(e){

        /**
         * delete whole article in ADMIN/(INDEX, MOVIE, GAMES)
         *
         * @var id = article id
         * @var url = router address
         */

        if ($(this).attr('data-param') == 'article') {

            var id = $(this).val();
            var url = '/admin';

        } else if ($(this).attr('data-param') == 'movie') {

            var id = $(this).val();
            var url = '/admin/movie';

        } else if ($(this).attr('data-param') == 'games') {

            var id = $(this).attr('data-id');
            var url = '/admin/games'
        }

        var parent = $(this).parent().parent().parent();
        if (confirm("Sure?")) {

            params = {
                delete_id : $(this).val(),
                param: $(this).attr('data-param')
            };

            $.ajax({

                type: 'POST',
                url: url,
                data: params,
                dataType: 'json',

                success: function(data){ parent.fadeOut(50); },
                failure: function() { alert('Not good, error!'); }

            });
        }

    });

    $('.delete_picture').click(function(e){

        /**
         * delete picture from article or movie or games
         *
         * @var = img
         * @var = image name
         * @var = param
         * @var = id
         */

        if ($(this).attr('data-param') == 'article') var param = 'article';
        else if ($(this).attr('data-param') == 'movie') var param = 'movie';
        else if ($(this).attr('data-param') == 'games') var param = 'games';

        var img = $(this);
        var name = $(this).val();
        var id = $(this).attr('data-id');

        if (confirm('Sure?')) {

            params = {
                name: name,
                id: id,
                param: param
            };

            $.ajax({
                type: 'POST',
                url: '/admin/edit',
                data: params,
                dataType: 'json',

                success: function(data){ $(img).parent().parent().fadeOut(50); },
                failure: function() { alert('Not good, error!'); }
            });
        }
    });

    $(function()
    {
        /**
         * check length for short description textarea in article
         */

        var maxLength = $('#shortDescAdd').attr('maxlength');        //(1)
        $('#shortDescAdd').keyup(function()
        {
            var curLength = $('#shortDescAdd').val().length;         //(2)
            $(this).val($(this).val().substr(0, maxLength));     //(3)
            var remaning = maxLength - curLength;
            if (remaning < 0) remaning = 0;
            $('#textareaFeedback').html(remaning + ' symbols left');//(4)
            if (remaning < 10)          //(5)
            {
                $('#textareaFeedback').addClass('alert-danger');
                $('#textareaFeedback').removeClass('alert-success');
                $('#textareaFeedback').removeClass('alert-info');
            }
            else if (remaning < 30)
            {
                $('#textareaFeedback').addClass('alert-info');
                $('#textareaFeedback').removeClass('alert-danger');
                $('#textareaFeedback').removeClass('alert-success');
            }
            else
            {
                $('#textareaFeedback').addClass('alert-success');
                $('#textareaFeedback').removeClass('alert-danger');
                $('#textareaFeedback').removeClass('alert-info');
            }
        })
    })


});
