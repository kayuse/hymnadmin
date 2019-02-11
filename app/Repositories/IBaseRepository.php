<?php
namespace App\Repositories;
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/2/19
 * Time: 8:24 AM
 */
interface IBaseRepository
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}
