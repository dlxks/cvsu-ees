<?php

namespace App\Repositories;

interface MessageRepositoryInterface
{
    /**
     * Get all inquiry.
     *
     * @return Collection
     */
    public function all();

    /**
     * Store new todo.
     *
     * @param  array $data
     * @return Collection
     */
    public function store(array $data);

    /**
     * Delete todo.
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Update todo.
     *
     * @param  array $data
     * @param  int $id
     * @return Collection
     */
    public function update(array $data, $id);
}
