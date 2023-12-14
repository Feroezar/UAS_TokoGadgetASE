<?php

namespace App\Http\Controllers;

use App\Models\handphone;
use App\Models\modelhp;
use App\Models\suplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class handpohoneControllers extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;
        
        $handphone = $handphone = handphone::join('supliers', 'handphones.supplier', '=', 'supliers.id')
        ->join('modelhps', 'handphones.kategori', '=', 'modelhps.id')
        ->select(
        'supliers.name',
        'handphones.*',
        'modelhps.mod'
        )
        ->where('merk','like',"%$search%")
        ->orWhere('mod','like',"%$search%")
        ->orwhere('name','like',"%$search%")
        ->orwhere('stok','like',"%$search%")
        ->orwhere('harga','like',"%$search%")
        ->get();
        
        // $handphone = handphone::where(function($query) use ($search){

        //     $query
        //     ->join('handphones', 'modelhps.id','=','handphones.kategori')
        //     ->select('handphones.*','modelhps.mod')
        //     ->where('merk','like',"%$search%")
        //     ->orWhere('mod','like',"%$search%");
            
        // })
        // ->get();

        return view('gadget.index', compact('handphone','search'));
    }
     /**
     * index
     *
     * @return View
     */
    public function index(Request $request): View
    {
        // $handphone = DB::Table('handphones')
        // ->join('handphones', 'modelhps.id','=','handphones.kategori')
        // ->join('hadnphones', 'supliers.id','=','handphones.supplier')
        // ->select('handphones.*','modelhps.mod','supliers.name')
        // ->get();
        $handphone = handphone::join('supliers', 'handphones.supplier', '=', 'supliers.id')
        ->join('modelhps', 'handphones.kategori', '=', 'modelhps.id')
        ->select(
        'supliers.name',
        'handphones.*',
        'modelhps.mod'
        )
        ->get();
        // $handphone = handphone::all();
        // $kat = modelhp::all();

        //render view with posts
        return view('gadget.index', compact('handphone'));
    }
    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        $kat = modelhp::all();
        $suplai = suplier::all();

        return view('gadget.create1', compact('kat','suplai'));
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
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'merk'     => 'required',
            'kategori'   => 'required',
            'supplier' => 'required',
            'harga'   => 'required',
            'stok'   => 'required',
            'satuan'   => 'required',
            
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        //create post
        handphone::create([
            'image'     => $image->hashName(),
            'merk'     => $request->merk,
            'kategori'     => $request->kategori,
            'supplier' => $request->supplier,
            'harga'     => $request->harga,
            'stok'     => $request->stok,
            'satuan'     => $request->satuan,
        ]);

        //redirect to index
        return redirect()->route('hpbase.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
      /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get post by ID
        // $b = handphone::findOrFail($id);
        $a = handphone::join('supliers', 'handphones.supplier', '=', 'supliers.id')
        ->join('modelhps', 'handphones.kategori', '=', 'modelhps.id')
        ->select(
        'supliers.name',
        'handphones.*',
        'modelhps.mod'
        )
        ->where('handphones.id',$id )
        ->get();
        //render view with post
        return view('gadget.show', compact('a'));
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
        $kat = modelhp::all();
        $suplai = suplier::all();
        $handphone = handphone::findOrFail($id);

        //render view with post
        return view('gadget.edit', compact('handphone','kat','suplai'));
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
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'merk'     => 'required',
            'kategori'   => 'required',
            'supplier' => 'required',
            'harga'   => 'required',
            'stok'   => 'required',
            'satuan'   => 'required',
        ]);

        //get post by ID
        $handphone = handphone::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            $jalan = public_path().'/posts'.$handphone->image;
            dd($jalan);
            Storage::delete('public/posts/'.$handphone->image);

            //update post with new image
            $handphone->update([
                'image'     => $image->hashName(),
                'merk'     => $request->merk,
                'kategori'     => $request->kategori,
                'supplier' => $request->supplier,
                'harga'     => $request->harga,
                'stok'     => $request->stok,
                'satuan'     => $request->satuan,
            ]);

        } else {

            //update post without image
            $handphone->update([
                'merk'     => $request->merk,
                'kategori'     => $request->kategori,
                'supplier' => $request->supplier,
                'harga'     => $request->harga,
                'stok'     => $request->stok,
                'satuan'     => $request->satuan,
            ]);
        }
        
        //redirect to index
        return redirect()->route('hpbase.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $handphone = handphone::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $handphone->image);

        //delete post
        $handphone->delete();

        //redirect to index
        return redirect()->route('hpbase.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
