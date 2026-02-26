<?php

namespace App\Repositories;

use App\Models\Slider;


class SliderRepository
{
    public function getAll()
    {
        return Slider::orderBy('order_priority', 'asc')->get();
    }

    public function create(array $data)
    {
        return Slider::create($data);
    }

    public function find($id)
    {
        return Slider::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $slider = $this->find($id);
        $slider->update($data);
        return $slider;
    }

    public function delete($id)
    {
        $slider = $this->find($id);
        return $slider->delete();
    }

    // App/Repositories/SliderRepository.php

    public function getFiltered($filters = [])
    {
        $query = Slider::query();

        // 1. Search by Title
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        // 2. Filter by Status (Active/Inactive)
        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('is_active', $filters['status'] == 'active' ? 1 : 0);
        }

        // 3. Filter by Date Range
        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('created_at', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->orderBy('order_priority', 'asc')->get();
    }
}
