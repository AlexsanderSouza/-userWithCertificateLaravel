<?php
namespace App\Repository;

abstract class AbstractRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
	protected $model;

    /**
     * retorna o modelo respectivo ao id
     *
     * @return array model
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * retorna todos os modelos cadastrados
     *
     * @return array model
     */
    public function findAll()
    {
        return $this->model->all();
    }

    /**
     * cria um  modelo e retorna o mesmo
     *
     * @return model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * atualiza um  modelo e retorna o mesmo
     *
     * @return model
     */
    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * busca ou cria um modelo e retorna o mesmo
     *
     * @return model
     */
    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * apaga um modelo e retorna o sucesso
     *
     * @return model
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}