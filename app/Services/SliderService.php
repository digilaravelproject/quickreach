<?php

namespace App\Services;

use App\Repositories\SliderRepository;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    protected $repository;

    public function __construct(SliderRepository $repository)
    {
        $this->repository = $repository;
    }


    public function storeSlider($request)
    {
        // data directly request se lo kyunki validate controller mein ho chuka hai
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }
        return $this->repository->create($data);
    }

    public function updateSlider($id, $request)
    {
        $data = $request->all();
        $slider = $this->repository->find($id);

        if ($request->hasFile('image')) {
            if ($slider->image_path) {
                Storage::disk('public')->delete($slider->image_path);
            }
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }
        return $this->repository->update($id, $data);
    }


    public function deleteSlider($id)
    {
        $slider = $this->repository->find($id);

        // Physical image delete karna zaroori hai
        if ($slider->image_path && Storage::disk('public')->exists($slider->image_path)) {
            Storage::disk('public')->delete($slider->image_path);
        }

        return $this->repository->delete($id);
    }
}
