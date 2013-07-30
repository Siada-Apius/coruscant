$(document).ready(function () {

    //registration validate
    $('#reg').click(function () {

        $.post(

            '/user/registration/0/controller%3D%3Euser/1/action%3D%3Eregistration',{

                'email' : $('#email').val(),
                'nickname' : $('#nickname').val(),
                'password' : $('#password').val()

            },

            function(response){

                //по циклу йдем через ерори які дістали в респонзі
                //key е назва інпута яка = id
                //response.errors[key]) значення помилки для інпута

                if(response.mail == 0){

                    alert('E-mail exists');

                }
                else if(response.status == 1){

                    alert('Successes');

                }else{

                        //for (key in response.errors)
                        //foreach ($value as $array )


                    for (key in response.errors){

                        $("#" + key).val('');
                        $("#" + key).attr("placeholder", response.errors[key]);
                        $("#" + key).addClass("input-error");

                    }

                }

            }

        );

        return false;

    });


    $('.likeBut').click(function(){


        $.post(

            '/media/article/0/controller%3D%3Emedia/1/action%3D%3Earticle',{

                'siada' : '1',
                'id' : $('#artId').val()},

            function(response){

                $('#like').text(response.good);
                $('#dislike').text(response.bad);

            }

        );

        return false;

    });


    $('.dislikeBut').click(function(){

        $.post(

            '/media/article/0/controller%3D%3Emedia/1/action%3D%3Earticle',{

                'siada' : '-1',
                'id' : $('#artId').val()},

            function(response){

                $('#like').text(response.good);
                $('#dislike').text(response.bad);

            }

        );

        return false;

    });


    $('#com_but').click(function(){

        $.post(

            '/media/article/0/controller%3D%3Emedia/1/action%3D%3Earticle',{

                'article_id' : $('#artId').val(),
                'user_name' : $('#user_name').val(),
                'com_text' : $('#com_text').val()

            },
            function(response){

                var today = new Date();
                var comment = '<li>' +
                    '<div class="comments">' +
                    '<div class="user_name">'+ $('#user_name').val() +'</div>' +
                    '<div class="com_date">'+ today +'</div>' +
                    '<div class="com_text">'+ $('#com_text').val() +'</div>' +
                    '</div>' +
                    '</li>';

                $('.contentRight ul').append(comment);

            }

        );

        return false

    });


    $('.comDeleteInput').click(function(e){

        //ти обробляєш клік по класу в якого міліон елементів тому шоб дістати той по якому клікнули передавай e  в фунцію і діставай через this

        $.post(

            '/admin/edit/0/controller%3D%3Eadmin/1/action%3D%3Eedit',{

                'delId' :  $(this).val()

            },function(response){

                var id = response.id;
                $('#comment' + id).fadeOut(1000);

            }

        );

    });


    $('.artDeleteInput').click(function(e){

        /**
         * delete article ADMIN/INDEX
         */

        var question = confirm("Sure?");

        if (question == true) {

            $.post(

                '/admin/index/0/controller%3D%3Eadmin/1/action%3D%3Eindex',{

                    'delId' :  $(this).val()

                },function(response){

                    var id = response.id;
                    $('#contentWrapper'+id).fadeOut(50);

                }

            );
        }

    });


    $('.deleteGame').click(function() {

        /**
         * delete game ADMIN/GAMES
         */
        $(this).addClass('clicked');

        //var question = confirm("Sure?");

        //if (question == true) {
//alert($(this).children().val());
            $.post(

                '/admin/games/0/controller%3D%3Eadmin/1/action%3D%3Egames',{

                    'gameId' :  $(this).children().val()

                },function(response){

                    $('.clicked').parent('.descBlock').parent('.gameBlock').parent('.oneWrap').fadeOut(50);
                }

            );
//        }


    });

    $('.artImgDeleteInput').click(function(e){

        /**
         * delete picture /admin/edit/article/
         */

        $(this).addClass('clicked');

        var question = confirm("Sure?");

        if (question == true) {

            $.post(

                '/admin/edit/0/controller%3D%3Eadmin/1/action%3D%3Eedit',{

                    'articlePicName' :  $(this).val(),
                    'articleId' : $('.articleId').val()

                },function(response){

                    $('.clicked').parent('.delete_cross').parent('.delImg').fadeOut(50);

                }

            );

        }

    });

    $('.movieDeleteInput').click(function(e){

        /**
         * delete picture /admin/edit/movie/
         */

        $(this).addClass('clicked');

        var question = confirm("Sure?");

        if (question == true) {

            $.post(

                '/admin/edit/0/controller%3D%3Eadmin/1/action%3D%3Eedit',{

                    'moviePicValue' :  $(this).val()

                },function(response){

                    $('.clicked').parent('.delete_cross').parent('.deletePic').fadeOut(50);

                }

            );

        }

    });

    $('.movDeleteInput').click(function(e){

        /**
         * delete movie article - ADMIN/MOVIE
         */

        $(this).addClass('clicked');

        var question = confirm("Sure?");

        if (question == true) {

            $.post(

                '/admin/movie/0/controller%3D%3Eadmin/1/action%3D%3Emovie',{

                    'movieId' :  $(this).val()

                },function(response){

                    $('.clicked').parent('.delete_cross').parent('.episodeWrap').fadeOut(50);

                }

            );

        }

    });

    $(function() {

        /**
         * wysiwyg
         */

        // Add markItUp! to your textarea in one line
        // $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
        $('.wysiwyg').markItUp(mySettings);
    });

    $("#slider").easySlider({

        /**
         * slider
         */

        auto: true,
        continuous: true
    });

});
