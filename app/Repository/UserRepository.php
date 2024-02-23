<?php
namespace App\Repository\UserRepository;
use App\Repository\Interface\BaseUserRepository;

class UserRepository implements BaseUserRepository
{
    public function all()
    {
        return 'all';
    }
    public function create(array $data)
    {
        return 'create';
    }
    public function update(array $data, $id)
    {
        return 'update';
    }
    public function delete($id)
    {
        return 'delete';
    }
    public function show($id)
    {
        return 'show';
    }
}