<?php namespace Butler\Repositories\Eloquent;

class MessageRepository extends Repository
{

    /**
     * Get the Eloquent Model class name
     * @return mixed
     */
    function model()
    {
        return 'Butler\Models\Message';
    }
}