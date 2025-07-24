<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ImageService
{
    private FormRequest $request;

    private Model $model;

    private ?string $field;

    public function __construct(FormRequest $request, Model &$model, ?string $field = 'image')
    {
        $this->request = $request;
        $this->model = &$model;
        $this->field = $field;
    }

    /**
     * @return void
     */
    public function storeImage(): void
    {
        if ($this->request->file($this->field)) {
            $path = $this->request->file($this->field)->store('', 'public');
            $this->model->{$this->field} = $path;
        }

        $this->model->save();
    }
}
