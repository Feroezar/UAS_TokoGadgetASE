<?php

namespace App\Http\Controllers;

use App\Models\suplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SuplierControllers extends Controller
{
     /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get posts
        $suplier= suplier::latest()->paginate(5);

        //render view with posts
        return view('suplai.index', compact('suplier'));
    }
    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('suplai.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'   => 'required'
        ]);

        //create post
        suplier::create([
            'name'   => $request->name
        ]);

        //redirect to index
        return redirect()->route('suplai.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get post by ID
        $suplier = suplier::findOrFail($id);

        //render view with post
        return view('suplai.edit', compact('suplier'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'name'   => 'required'
        ]);

        //get post by ID
        $suplier = suplier::findOrFail($id);

            //update post with new image
            $suplier->update([
                'name'   => $request->name
            ]);

        //redirect to index
        return redirect()->route('suplai.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
