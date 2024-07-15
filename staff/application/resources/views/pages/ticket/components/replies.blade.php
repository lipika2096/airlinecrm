<!--each reply-->
@foreach($replies as $reply)
<div class="comment-widgets">
    <div class="d-flex flex-row comment-rowp-b-0">
        <div class="p-2"><span class="round"><img src="{{ getUsersAvatar($reply->avatar_directory, $reply->avatar_filename)  }}"
                    width="50"></span></div>
        <div class="comment-text w-100">
            <h5 class="m-b-0">{{ $reply->first_name ?? runtimeUnkownUser() }}</h5>
            <div class="text-muted m-b-5"><small class="text-muted">{{ runtimeDateAgo($reply->ticketreply_created) }}</small></div>
            {!! clean($reply->ticketreply_text) !!}

            <div class="comment-footer text-right">
                <small class="text-muted">{{ runtimeDate($reply->ticketreply_created) }} {{ cleanLang(__('lang.at')) }} {{
                    runtimeTime($reply->ticketreply_created)}}</small>
            </div>


        </div>
    </div>

    <!--ticket attachements-->
    @if($reply->attachments_count > 0)
    <div class="x-attachements">
        <!--attachments container-->
        <div class="row">
            <!--attachments-->
            @foreach($reply->attachments as $attachment)
            @include('pages.ticket.components.attachments')
            @endforeach
        </div>
    </div>
    @endif
</div>
@endforeach