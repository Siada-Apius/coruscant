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

        //ти обробляєш клік по класу в якого міліон елементів тому шоб дістати той по якому клікнули передавай e  в фунцію і діставай через this
        var question = confirm("Sure?");

        if ( question == true ) {
            $.post(

                '/admin/index/0/controller%3D%3Eadmin/1/action%3D%3Eindex',{

                    'delId' :  $(this).val()

                },function(response){

                    var id = response.id;
                    $('#contentWrapper' + id).fadeOut(50);

                }

            );
        }
    });

});