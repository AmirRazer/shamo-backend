<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use app\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if($id)
        {
            $category = ProductCategory::with(['product'])->find($id);
            if($category)
            {
                return ResponseFormatter::success(
                    $category,
                    'Data kategory berhasil diambil'
                );
            }
            else
            {
                return ResponseFormatter::error(
                    null,
                    'Data Kategory tidak ada',
                    404
                );
            }
            $category = ProductCategory::query();

            if($name)
            {
                $category->where('name', 'like', '%' . $name . '%');
            }

            if($show_product)
            {
                $category->with('product');
            }  
            
            return ResponseFormatter::success(
                $category->paginate($limit),
                'Data list kategory berhasil diambil'
            );
        }
    }
}