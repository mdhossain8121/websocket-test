<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Websocket Test</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <style type="text/css">
            body{margin-top:20px;}

            .chat-online {
                color: #34ce57
            }

            .chat-offline {
                color: #e4606d
            }

            .chat-messages {
                display: flex;
                flex-direction: column;
                max-height: 500px;
                overflow-y: scroll
            }

            .chat-message-left,
            .chat-message-right {
                display: flex;
                flex-shrink: 0
            }

            .chat-message-left {
                margin-right: auto
            }

            .chat-message-right {
                flex-direction: row-reverse;
                margin-left: auto
            }
            .py-3 {
                padding-top: 1rem!important;
                padding-bottom: 1rem!important;
            }
            .px-4 {
                padding-right: 1.5rem!important;
                padding-left: 1.5rem!important;
            }
            .flex-grow-0 {
                flex-grow: 0!important;
            }
            .border-top {
                border-top: 1px solid #dee2e6!important;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>

    <body>
        <main class="content">
            <div class="container p-0">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-12 col-lg-12 col-xl-12">
                            <div class="py-2 px-4 border-bottom d-none d-lg-block">
                                <div class="d-flex align-items-center py-1">
                                    <div class="position-relative">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="{{$receiverName}}" width="40" height="40">
                                    </div>
                                    <div class="flex-grow-1 pl-3">
                                        <strong>{{$receiverName}}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="position-relative">
                                <div class="chat-messages p-4">

                                    {{-- <div class="chat-message-right pb-4">
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                            <div class="font-weight-bold mb-1">{{$userName}}</div>
                                            Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                                        </div>
                                    </div>

                                    <div class="chat-message-left pb-4">
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            <div class="font-weight-bold mb-1">{{$receiverName}}</div>
                                            Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                                        </div>
                                    </div> --}}

                                </div>
                            </div>

                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <form class="form-submit" action="{{url('send_message/'.$userName.'/'.$receiverName)}}">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input type="text" name="message" class="form-control" placeholder="Type your message">
                                        <button class="btn btn-primary btn_send_message">Send</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){

            let userName = {!! json_encode($userName) !!};
            let receiverName = {!! json_encode($receiverName) !!};
            let chatMessageSections = $(document).find(".chat-messages");

            $(document).off('submit','.form-submit').on('submit','.form-submit',function(e){
                e.preventDefault();
                let self = $(this);
                let url = $(this).attr('action');
                let messageHtml = $(this).find('input[name=message]');
                let message = messageHtml.val();
                let formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url : url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        self.find('.btn_send_message').prop("disabled",true);
                    },
                    success:function(data){
                        self.find('.btn_send_message').prop("disabled",false);
                        var senderMessageHtml = '<div class="chat-message-right pb-4"> \
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"> \
                                            <div class="font-weight-bold mb-1">'+userName+'</div> \
                                            '+message+'. \
                                        </div> \
                                    </div>';
                        chatMessageSections.append(senderMessageHtml);
                        messageHtml.val("");
                    },
                    error:function(data){
                        self.find('.btn_send_message').prop("disabled",false);
                    }
                });
            });

            window.Echo.channel('channel.send_message.'+receiverName+'.'+userName)
            .listen('.newMessage', (e) => {
                var receiverMessageHtml = '<div class="chat-message-left pb-4"> \
                                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3"> \
                                                <div class="font-weight-bold mb-1">'+receiverName+'</div> \
                                                '+e.message+'. \
                                            </div> \
                                        </div>';
                chatMessageSections.append(receiverMessageHtml);
            });
        });



    </script>
</html>
