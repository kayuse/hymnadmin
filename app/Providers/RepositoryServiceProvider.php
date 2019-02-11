<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/2/19
 * Time: 8:30 AM
 */

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\IBaseRepository;
use App\Repositories\IRecordRepository;
use App\Repositories\RecordRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            IBaseRepository::class,
            BaseRepository::class,
            IRecordRepository::class,
            RecordRepository::class
        );
    }
}
