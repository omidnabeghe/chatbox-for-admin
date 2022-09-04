<script>
    $(document).ready(function(){
        $.ajax({
            dataType: 'json',
            type: 'GET',
            url: '/chat/isSetSession',
            success: function(response){
                if(response.status == 0){
                    $('#setsession').hide();
                    $('#page-content').show();
                }else if(response.status == 1){
                    $('#page-content').hide();
                    $('#setsession').show();
                }else if(response.status == 2){
                    $('#setsession').hide();
                    $('#page-content').show();
                    $('#all-chats').show();

                }

            }
        });


    })
 </script>
 <script>
    $('#frm').submit(function(e){
        e.preventDefault();
        let name = $("input[name=name]").val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: '/chat/start',
            data: {'name': name,
            "_token": "{{ csrf_token() }}"},
            success: function(response){
                if(response.status){
                    $('#setsession').hide();
                    $('#page-content').show();
                }
            }
        });
    })


 </script>
 <script >
    $(document).ready(function(){
         $("#exit").click(function(){
            var exit = confirm("Are You Sure You Want To Leave This Page?");
            var url = "/chat/destroySession";

            if(exit==true){
                $.ajax({
                dataType: 'json',
                url: url,
                type : "GET",
                success : function(response){
                    if(response.status){
                        $('#page-content').hide();
                        $('#setsession').show();

                    }
                }
                });
            }
        });
    });
</script>
<script>

$("#frm2").submit(function(e){
    e.preventDefault();

    let message = $("input[name=usermsg],textarea").val();
    let name = $("input[name=name]").val();
    var clientmsg = $("#usermsg").val();
            $.post("/chat/post", {text: clientmsg,"name": name, "_token": "{{ csrf_token() }}"});

            $("#usermsg").prop("value", "");
            loadLog;
        return false;
});
function loadLog(){
    let id = $("input[name=chatid]").val();
    let name = $("input[name=name]").val();
    var url = "/chat/log";
    var oldscrollHeight = $("#chatbox"+id).prop("scrollHeight") - 20;
    $.ajax({
        url: url,
        cache: false,
        data: {'name': name,
        "_token": "{{ csrf_token() }}"},
        success: function(response){
            $("#chatbox"+id).html(response.contents);
            var newscrollHeight = $("#chatbox"+id).prop("scrollHeight") - 20;
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox"+id).animate({ scrollTop: newscrollHeight }, 'normal');
            }
            if(name == null || name == ''){
                $('#name').val(response.name);
            }

        },
    });
}
setInterval (loadLog, 2500);
 </script>

<script>
        function showChat1(key,name){
            var element = $("#chatbox"+ key )
            var element2 = $("#showChat" + key)
            var url = element2.attr("data-url")
            $(".chatbox").each(function () {
                $(".chatbox").attr("style",'display:none');
            });
            $(".showChat").removeClass("checked2");
            $(".showChat").addClass("showadminchat");


            $(element).show();
            $(element2).removeClass("showadminchat");
            $(element2).addClass("checked2");
            $('#name').val(name);
            $('#chatid').val(key);
            $('#messagesend').removeClass("d-none");
            $('#submitmsg').removeClass("d-none");
            $.ajax({
            dataType: 'json',

            url : url,
            type : "GET",
            data: {'name': name,
            "_token": "{{ csrf_token() }}"},
            success : function(response){
                if(response.comm){
                    $("#chatbadge"+key).hide();
                }
               }
            });



    }
</script>

