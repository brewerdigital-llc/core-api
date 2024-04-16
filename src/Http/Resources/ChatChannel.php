<?php

namespace Fleetbase\Http\Resources;

use Fleetbase\Support\Auth;
use Fleetbase\Support\Http;

class ChatChannel extends FleetbaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = Auth::getUserFromSession();

        return [
            'id'                                 => $this->when(Http::isInternalRequest(), $this->id, $this->public_id),
            'uuid'                               => $this->when(Http::isInternalRequest(), $this->uuid),
            'public_id'                          => $this->when(Http::isInternalRequest(), $this->public_id),
            'company_uuid'                       => $this->when(Http::isInternalRequest(), $this->company_uuid),
            'created_by_uuid'                    => $this->when(Http::isInternalRequest(), $this->created_by_uuid),
            'name'                               => $this->name,
            'title'                              => $this->title,
            'last_message'                       => new ChatMessage($this->last_message),
            'unread_count'                       => $this->getUnreadMessageCountForUser($user),
            'slug'                               => $this->slug,
            'feed'                               => $this->resource_feed,
            'participants'                       => ChatParticipant::collection($this->participants),
            'meta'                               => $this->meta,
            'updated_at'                         => $this->updated_at,
            'created_at'                         => $this->created_at,
            'deleted_at'                         => $this->deleted_at,
        ];
    }
}
