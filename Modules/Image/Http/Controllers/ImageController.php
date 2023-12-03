<?php

namespace Modules\Image\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Image\Models\Image;

class ImageController extends Controller
{
    public function store($id, $type): JsonResponse
    {
        request()->validate([
            'image' => 'required|mimes:jpg,jpeg,bmp,png',
        ]);

        $model = $this->make($type);
        $model->where('id', $id)->firstOrFail();

        $model->image()->create(
            [
                'image' => request()->file('image')->store(Str::singular($type), 'public'),
            ]
        );

        return $this->returnSuccess();
    }

    /**
     * Remove the specified resource from storage.
     * @param Image $image
     * @return JsonResponse
     */
    public function destroy(Image $image): JsonResponse
    {
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        return $this->returnSuccess();
    }

    /**
     * @param $type
     * @return Model
     */
    protected function make($type): Model
    {
        $className = Str::studly(Str::singular($type));

        $class = "Modules\\${className}\\Models\\" . $className;

        if (!class_exists($class)) {
            throw new ModelNotFoundException('Model not found for ' . $type);
        }

        return new $class();
    }
}
