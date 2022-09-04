@include('chat-layouts.head')
@extends('layouts.app')

@section('content')


<section style="background-color: #eee;">
    <div class="container py-5">

      <div class="row">

        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

          <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>

          <div class="card">
            <div class="card-body">

              <ul class="list-unstyled mb-0">
                @if($chats->count() >0)

                @foreach ($chats as $key => $chat)
                <li class="p-2 border-bottom showadminchat showChat"  onclick="showChat1('{{ $key }}', '{{ $chat->name }}' )" id="{{ 'showChat'. $key }}" data-url ="{{ route('admin.notification.adminNewChat') }}">
                  <a type="button" id="changechat" class="d-flex justify-content-between" >
                    <div class="d-flex flex-row">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar"
                        class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                      <div class="pt-1">
                        <p class="fw-bold mb-0">{{ $chat->name. '   ' }}


                            @php
                                $countchat = 0;
                            @endphp

                            @foreach ($admin->unreadNotifications  as $unreadNotifications)

                            @if($unreadNotifications->type == 'App\Notifications\NewAdminChat')
                            @if($chat->name == $unreadNotifications->data['message']['name'])
                                @php

                                $countchat += 1
                               @endphp

                            

                            @endif


                            @endif

                            @endforeach




                            @if($countchat != 0)


                            <span class=" badge bg-danger text-light" id="{{ 'chatbadge' . $key }}"><strong> {{ $countchat . ' ' }} </strong>New</span>

                            @endif


                        </p>
                      </div>
                    </div>
                    <div class="pt-1 ">
                      <p class="small text-muted mb-1">{{ dateDifference(date($chat->updated_at)) }}</p>
                      <div class="d-flex flex-row-reverse">
                      <form action="{{ route('chat.destroy',$chat->id) }}" method="POST">
                        @csrf
                        {{ method_field('delete') }}
                        <input type="hidden" name="id" value="{{ $chat->id }}">
                      <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i></button>
                    </form>
                   </div>
                    </div>
                  </a>
                </li>
                @endforeach
                @endif


{{--                 <li class="p-2 border-bottom">
                    <a href="#!" class="d-flex justify-content-between">
                      <div class="d-flex flex-row">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" alt="avatar"
                          class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                        <div class="pt-1">
                          <p class="fw-bold mb-0">Kate Moss</p>
                          <p class="small text-muted">Lorem ipsum dolor sit.</p>
                        </div>
                      </div>
                      <div class="pt-1">
                        <p class="small text-muted mb-1">Yesterday</p>
                      </div>
                    </a>
                  </li>
 --}}

              </ul>

            </div>
          </div>

        </div>

        <div class="col-md-6 col-lg-7 col-xl-8 ">

          <ul class="list-unstyled mt-5 " >
            <form id="frm2" action="#" method="POST" >
                @csrf


            @foreach ($chats as $key =>$chat)

            <li class=" "    >
              <div class="card ">
                <div class="chatbox card-body"  style="display: none" id="{{ 'chatbox'. $key }}" data-url="{{ dirname(dirname(__DIR__))."\logs\omid.log" }}">
                  <p class="mb-0">
                    {!! Illuminate\Support\Facades\Storage::get($chat->address) !!}
                  </p>
                </div>
              </div>
            </li>
            <input type="hidden" name="name" id="name" value="">
            <input type="hidden" name="chatid" id="chatid" value="">

            @endforeach

{{--             <li class="d-flex justify-content-between mb-4">
              <div class="card w-100">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0">Lara Croft</p>
                  <p class="text-muted small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                </div>
                <div class="card-body">
                  <p class="mb-0">
                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                    laudantium.
                  </p>
                </div>
              </div>
              <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
                class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
            </li>
 --}}
            <li class="bg-white mb-3 d-none" id="messagesend" >
              <div class="form-outline">
                <textarea class="form-control"  name="usermsg" id="usermsg"  rows="4"></textarea>
                <label class="form-label" for="textAreaExample2">Message</label>
              </div>
            </li>
            <button type="submit"   name="submitmsg" id="submitmsg" class="btn btn-primary btn-flat d-none">Send</button>

        </ul>

    </form>

        </div>

      </div>

    </div>
  </section>



@include('chat-layouts.script')
@include('alerts.sweetalert.delete-confirm', ['className' => 'delete'])


<script type="text/javascript">
    function changeChat(){
        var url = $('#changechat').attr('data-url');

        $.ajax({
            dataType: 'json',

            url : url,
            type : "GET",
            success : function(response){
                if(response.comm){
                    $('#chatbadge').hide();
                }
/*
*/
                }
            });
        };


</script>
@endsection
