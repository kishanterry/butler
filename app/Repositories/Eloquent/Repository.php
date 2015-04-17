<?php namespace Butler\Repositories\Eloquent;

use Butler\Repositories\Contracts\RepositoryInterface;
use Butler\Repositories\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface {

    /**
     * @var App
     */
    private $app;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var
     */
    protected $query;

    /**
     * @param App $app
     */
    function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();

        $this->query = $this->model->newQuery();
    }

    /**
     * Get the Eloquent Model class name
     * @return mixed
     */
    abstract function model();

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->query->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->query->paginate($perPage, $columns);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @param string $key
     * @return mixed
     */
    public function update(array $attributes, $id, $key = 'id')
    {
        return $this->model->where($key, $id)->update($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->query->find($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->query->where($field, $value)->get($columns);
    }

    /**
     * Make a Model instance from the supplied Eloquent Model name
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
        {
            throw new RepositoryException("Class {$this->model()} must be an instance of Model");
        }

        return $this->model = $model;
    }

    /**
     * Apply any Model Relationships
     *
     * @param array $with
     * @return $this
     */
    public function with($with = [])
    {
        $this->query = $this->query->with($with);
        return $this;
    }

    /**
     * Apply a Query Scope
     *
     * @param $scope
     * @param null $query_by
     * @return mixed
     */
    public function scope($scope, $query_by = null)
    {
        $this->query = $this->model->{$scope}($query_by);
        return $this;
    }
}