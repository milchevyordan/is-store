<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ChangeLog;
use App\Services\DataTable\DataTable;
use Illuminate\Database\Eloquent\Model;

class ChangeLogService
{
    /**
     * Return change logs datatable.
     *
     * @param  Model|string $model
     * @return DataTable
     */
    public static function getChangeLogsDataTable(Model|string $model): DataTable
    {
        $all = 'string' == gettype($model);

        if ($all) {
            $dataTable = (new DataTable(
                ChangeLog::where('changeable_type', $model)
            ))
                ->setRelation('creator')
                ->setColumn('changeable_id', 'Id of changed', true, true);
        } else {
            $dataTable = (new DataTable(
                $model->changeLogs()->getQuery()
            ))
                ->setRelation('creator');
        }

        return $dataTable->setColumn('creator.name', 'Creator', true, true)
            ->setColumn('change', 'Change', true)
            ->setColumn('created_at', 'Created', true, true)
            ->setDateColumn('created_at', 'dd.mm.YYYY H:i')
            ->run();
    }

    /**
     * Return index page change logs (latest ones for the model).
     *
     * @param  string $model
     * @return mixed
     */
    public static function getChangeLogsLimited(string $model): mixed
    {
        return ChangeLog::where('changeable_type', $model)->with(['creator'])->latest()->limit(20)->get();
    }
}
