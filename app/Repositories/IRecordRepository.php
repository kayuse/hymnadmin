<?php
namespace App\Repositories;
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/2/19
 * Time: 8:28 AM
 */
interface IRecordRepository extends IBaseRepository
{
    public function newRecord(string $data);
    public function fetch($page);
}
