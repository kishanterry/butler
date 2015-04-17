<?php namespace Butler\Repositories\Eloquent;

class AppRepository extends Repository {

    /**
     * Get the Eloquent Model class name
     * @return mixed
     */
    public function model()
    {
        return 'Butler\Models\App';
    }
    
}