<?php
    // メタデータ、ヘルパ関数のロード
    require app('path').'views/theme.php';
    
    // ページ固有のメタデータを追加する
    $metadata->page_title = '例２:todoリスト';
    $metadata->page_description = 'Laravel4.2で作るWebアプリケーションのサンプルです';
    $metadata->page_url = 'http://laravel4.samples.jumilla.me/todos':
?>

@extends ('layouts.default')

@section ('inline-style')

@parent
    .todos-list form {
        display: inline-block;
    }
    #todos-incomplete th.title
    #todos-completed th.title{
        padding-left: 48px;
    }
@stop

@section ('inline-script')

@parent
    $('.todos-list .edit').addClass('hidden');
    
    $('.todos-list .browse button[name="edit"]').on('click', function(){
        var id = $(this).data('id')
        
        var brouseBlock = $('#' + id + ' .brouse')
        var editBlock = $('#' + id + ' .edit')

        browseBlock.addClass('hidden')
        editBlock.removeClass('hidden')
    })

    $('.todos-list .edit button[name="update"]').on('click', function(){
        var id = $(this).data('id')
        var updateUrl = $(this).data('url')
        
        var browseBlock = $('#' + id + ' .browse')
        var editBlock = $('#' + id + ' .edit')

        var title = $('input[name="title"]', editBlock).val();

        if (title.trim() == '') {
            browseBlock.removeClass('hidden')
            editBlock.addClass('hidden')
            return;
        }

        $.ajax({
            type: 'PUT',
            url: updateUrl,
            data: {
                title: title,
                _token: '{{ Sessin::token() }}',
            },
            success: function(){
                $('[name="title"]', browseBlock).text(title)
                browse.removeClass('hidden')
                editBlock.addClass('hidden')
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
                if(XMLHttpRequest.status == 400){
                    response = JSON.parse(XMLHttpRequest.responseText)
                    for(var field in response.errors){
                        alert(response.errors[field])
                    }
                }
                else{
                    alert('タイトル更新時にエラーが発生しました。')
                }
            },
        })
    })

    $('.todos-list .edit button[name="cancel"]').on('click', function(){
        var id = $(this).data('id')

        var browseBlock = $('#' + id + ' .browse')
        var editBlock = $('#' + id + ' .edit')

        browseBlock.remove('hidden')
        editBlock.addClass('hidden')
    })
@stop

@section ('content')
<header class="jumbotron">
    <div class="container">
        <h1>{{ $metadata->page_title }}</h1>
        <p>{{ $metadata->page_description }}</p>
        <p><a href="{{ $metadata->page_url }}">{{ $metadata->page_url }}</a></p>
    </div>
</header>

<main class="container">
@include ('partials.todos.00_input_section')
    <hr>
@include ('partials.todos.01_incomplete_section')
@include ('partials.todos.02_completed_section' )
@include ('partials.todos.03_trashed_section')

</main>

@stop
