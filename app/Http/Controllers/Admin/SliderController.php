<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SliderService;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class SliderController extends Controller
{
    protected $service;
    protected $repository;

    /**
     * Dependency Injection via Constructor
     */
    public function __construct(SliderService $service, SliderRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * List all sliders
     */

    public function index(Request $request)
    {
        // Default dates (agar filter nahi lagaya toh)
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $filters = [
            'search'    => $request->get('search'),
            'status'    => $request->get('status', 'all'),
            'date_from' => $dateFrom,
            'date_to'   => $dateTo
        ];

        $sliders = $this->repository->getFiltered($filters);

        // Agar AJAX request hai toh sirf table/grid return karega (Alpine.js friendly)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.sliders.partials._list', compact('sliders'))->render()
            ]);
        }

        return view('admin.sliders.index', compact('sliders', 'filters'));
    }

    /**
     * Store a new slider
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'nullable|string|max:255',
            'sub_title'      => 'nullable|string|max:255',
            'image'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'           => 'nullable|url',
            'order_priority' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $this->service->storeSlider($request);
            return response()->json(['success' => true, 'message' => 'Slider added successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show single slider data (For Alpine.js Edit Modal)
     */
    public function edit($id)
    {
        try {
            $slider = $this->repository->find($id);
            return response()->json(['success' => true, 'data' => $slider]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Slider not found'], 404);
        }
    }

    /**
     * Update existing slider
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'nullable|string|max:255',
            'sub_title'      => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link'           => 'nullable|url',
            'order_priority' => 'required|integer|min:0',
            'is_active'      => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $this->service->updateSlider($id, $request);
            return response()->json(['success' => true, 'message' => 'Slider updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete slider
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteSlider($id);
            return response()->json(['success' => true, 'message' => 'Slider deleted successfully!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Delete failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle Active Status (Quick Action)
     */
    public function toggleStatus($id)
    {
        try {
            $slider = $this->repository->find($id);
            $this->repository->update($id, ['is_active' => !$slider->is_active]);
            return response()->json(['success' => true, 'message' => 'Status updated!']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
