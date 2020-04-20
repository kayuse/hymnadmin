<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/11/19
 * Time: 6:01 PM
 */

namespace App\Repositories;


interface IHymnRepository extends IBaseRepository
{
    public function getStats();
    public function saveHymn($data,$recordId = null);
    public function getHymn($number);
    public function new($data);
    public function all();
    public function userHymns($user);
}
