<?php

namespace App\Http\Controllers\staffperpus;

use App\Models\buku;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\kategori_buku;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    protected $staff_account;

    public function __construct()
    {
        if (!session()->has('bio') || session('bio') === null) {
            $this->staff_account = DB::table('staffperpus')
                ->select('username', 'nama_staff_perpustakaan', 'email')
                ->where('username', '=', session('username'))
                ->first();

            session(['bio' => $this->staff_account]);
        }
    }
    public function manageCategory()
    {
        $Category = DB::table('kategori_buku')
            // ->orderBy('nama_kategori')
            ->get();
        // ->paginate(7);
        return view('staff_perpus.kategori_buku', ['arrayCategory' => $Category]);
    }
    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:kategori_buku,nama_kategori',
        ], [
            'name.required' => 'Please input the name.',
            'name.max' => 'The maximum length for name is 255 characters.',
            'name.unique' => 'The name must be unique.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff_perpus.managecategories')
                ->withErrors($validator)
                ->withInput();
        }

        kategori_buku::create([
            'id_kategori_buku' => Str::uuid(),
            'nama_kategori' => $request->input('name'),
        ]);

        return redirect()->route('staff_perpus.managecategories')
            ->with('success', 'Category added successfully!');
    }

    public function deleteCategory(Request $request)
    {
        $categories = $request->input();
        $categories = explode(',', $categories['selected_categories']);
        foreach ($categories as $category) {
            $categoriesDeleted = DB::table('kategori_buku')->where('id_kategori_buku', '=', $category)->delete();
        }
        if ($categoriesDeleted) {
            return redirect()->route('staff_perpus.managecategories')->with('success', 'Categories Deleted Successfully!');
        } else {
            return redirect()->route('staff_perpus.managecategories')->with('failed', 'Cannot Delete Categories!');
        }
    }
    public function updateCategory(Request $request)
    {
        // Validate input
        $valid = $request->validate([
            'name' => 'required|string|max:255|unique:kategori_buku,nama_kategori',
        ]);

        // Find the category to update
        $category = kategori_buku::find($request->input('target'));
        if ($category) {
            // Update the category name
            $category->nama_kategori = $request->input('name');
            $category->save();

            // Redirect with success message
            return redirect()->route('staff_perpus.managecategories')->with('success', 'Category updated successfully!');
        }

        // If category not found, return an error message
        return redirect()->route('staff_perpus.managecategories')->with('failed', 'Category update failed!');
    }
}
