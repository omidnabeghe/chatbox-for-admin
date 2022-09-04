@include('chat-layouts.head')

<div class="setsession form-group " id="setsession">
    <div  class="bg-primary text-light">
       <form id="frm" action="#">
          @csrf
          <h1 class="text-center">Live Chat</h1>
          <hr/>
          <label class="m-2" for="name2">Please Enter Your Name To Proceed..</label>
          <input type="text" name="name" id="name2" class="form-control" placeholder="Enter Your Name" required/>
          <button type="submit"  class="btn btn-lg btn-secondary m-3" name="submit" id="submit">Submit</button>
       </form>
    </div>
 </div>


    <div class="box bg-primary direct-chat direct-chat-warning " id="page-content" >
    <div class="box-header " >
        <h3 class="box-title">Chat Messages</h3>
        <div class="box-tools pull-right">
            <i class="fa fa-comments"></i>


            <button type="button" class="btn btn-danger {{ hideExit("d-none") }}" id="exit" data-widget="remove"><i class="fa fa-times" ></i>Exit</button>
        </div>
    </div>
    <div class="box-body">
        <div id="chatbox" >
    </div>
    <div class="box-footer">
        <form name="message" id="frm2" action="#">
            <div class="input-group">
                <input type="text" name="usermsg" id="usermsg" placeholder="Type Message ..."
                class="form-control">
                <input type="hidden" name="name" id="name" value="">
                <input type="hidden" name="chatid" id="chatid" value="">

                <span class="input-group-btn">
                <button type="submit"   name="submitmsg" id="submitmsg" class="btn btn-primary btn-flat">Send</button>
                </span>
            </div>
        </form>
    </div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-center" >
    <a href="{{ route('chat') }}"   name="all-chats" id="all-chats" style="display:none;" class="btn btn-lg btn-secondary ">all chats to watch</a>
</div>

</div>
</div>

@include('chat-layouts.script')

