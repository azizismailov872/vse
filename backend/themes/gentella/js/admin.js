let get_data = '';

$(document).ready(function() {

    //Добавление каретки
    addCaretToMenu();

    $('.mask').inputmask({
        mask: "+\\9\\9\\6(999)999-999"
       
    });
    //Загрузка фото
    $('.input__file__button').append('<span class="fas fa fa-download"></span>');
    fileCount();
    
    //Сброс
    $('#reset_btn').click(function() {
        resetUrl();
    });

    $('.delete_profile_btn').click(function(){
        id = $(this).attr('id');

        data = {id:id};

        url = '/admin/user/delete-image';

        grid_id = '#user-photo'
        make_action(url,data,grid_id);
    })

    $('.delete_category_btn').click(function(){
        id = $(this).attr('id');

        data = {id:id};

        url = '/admin/category/delete-image';

        grid_id = '#category-photo'
        make_action(url,data,grid_id);
    });

});

//Добавление каретки
function addCaretToMenu() {
    let item = $('.side-menu li');

    if (item.length > 0) {
        let i;
        for (i = 0; i < item.length; i++) {
            if ($(item[i]).children('.child_menu').length > 0) {

                let link = $(item[i]).children('a');

                $(link).append('<span class="fa fa-chevron-down"></span>');

                $(link).click(function(event) {
                    event.preventDefault();
                });
            }
        }
    }
}

//Сброс
function resetUrl() {
    pathname = location.href;

    if (pathname.indexOf('?') > -1) {
        pathname = pathname.split("?");
        //get_data = pathname[1];
        pathname = pathname[0];
    }

    pathname = pathname.substr(pathname.lastIndexOf('/') + 1) + get_data;

    $.ajax({
        url: 'pathname',
    })
    .always(function() {
        window.location.replace(pathname);
    })

    return false;
}

//Загрузка фото
function fileCount()
{
    let inputs = document.querySelectorAll('.input__file');

    Array.prototype.forEach.call(inputs, function (input) {
        let label = input.nextElementSibling;

        let labelVal = label.innerText;

        input.addEventListener('change', function (e) {
        let countFiles = '';
        if (this.files && this.files.length >= 1)
          countFiles = this.files.length;
 
        if (countFiles)

          label.innerText= 'Выбрано файлов: ' + countFiles;
        else
         label.innerText = labelVal;
        });
    });
}

//Действие
function make_action(url,data,grid_id)
{
    if(data !== null)
    {   
        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(res)
            {
                if(grid_id !== null)
                {   
                    $.pjax.defaults.timeout = 500;

                    $.pjax.reload({container: grid_id});

                    if(res !== null)
                    {
                        console.log(res.msg);
                    }
                }
                else
                {   
                    if(res !== null)
                    {
                        console.log(res.msg);
                    }
                }
            },
            error: function (){
                console.log(res.msg);
            }
        });
    }
}

