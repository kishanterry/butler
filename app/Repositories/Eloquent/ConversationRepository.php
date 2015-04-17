<?php namespace Butler\Repositories\Eloquent;

class ConversationRepository extends Repository
{

    /**
     * Get the Eloquent Model class name
     * @return mixed
     */
    public function model()
    {
        return 'Butler\Models\Conversation';
    }

    /**
     * Get all conversations "involving" the specified user
     *
     * @param $user_id
     * @param int $skip
     * @param int $take
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allForUser($user_id, $skip = 0, $take = 10, $columns = ['*'])
    {
        return $this
            ->query
            ->whereHas('users', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->orderBy('created_at', 'DESC')
            ->skip($skip * $take)
            ->take($take)
            ->get($columns);
    }
}