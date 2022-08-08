<?php

namespace App\Repositories;

use App\Repositories\ChatbotRepositoryInterface;
use App\Models\Message;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var App\Models\Message
     */
    protected $model;

    /**
     * Constrcutor.
     *
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        $inquiry = $this->model->findOrFail($id);

        return $inquiry->delete();
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, $id)
    {
        $inquiry = $this->model->findOrFail($id);

        return $inquiry->update($data);
    }
}
