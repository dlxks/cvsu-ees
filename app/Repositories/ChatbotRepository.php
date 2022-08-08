<?php

namespace App\Repositories;

use App\Models\Chatbot;
use App\Repositories\ChatbotRepositoryInterface;

class ChatbotRepository implements ChatbotRepositoryInterface
{
        /**
     * @var App\Models\Chatbot
     */
    protected $model;

    /**
     * Constrcutor.
     *
     * @param Chatbot $model
     */
    public function __construct(Chatbot $model)
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
