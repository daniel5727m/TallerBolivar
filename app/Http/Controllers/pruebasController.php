<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Menu;
use App\Models\prueba;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class pruebasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $menu= Menu::orderBy('id', 'ASC')->get();
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $pruebas = prueba::where('adjunto', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $pruebas = prueba::latest()->paginate($perPage);
        }

        return view('pruebas.index', compact('pruebas','menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $menu= Menu::orderBy('id', 'ASC')->get();
        return view('pruebas.create',compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
       
        $menu= Menu::orderBy('id', 'ASC')->get();

       $max_size = (int)ini_get('upload_max_filesize')*10240;
       $files = $request->file('adjunto');
      // dd($max_size);
       $user_id = Auth::id();
       
        foreach($files as $file){
           /* prueba::create([
                'adjunto' => $file->getClientOriginalName(),
            ]);*/
          
            if ($request->hasFile('adjunto')) {
                $requestData['adjunto'] = $file
                    ->store('uploads', 'public');
            }
    
            prueba::create($requestData);
        }
        return "ok";
        $requestData = $request->all();
        
        if ($request->hasFile('adjunto')) {
            $requestData['adjunto'] = $request->file('adjunto')
                ->store('uploads', 'public');
        }

        prueba::create($requestData);

        return redirect('pruebas',compact('menu'))->with('flash_message', 'prueba added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $menu= Menu::orderBy('id', 'ASC')->get();
        $prueba = prueba::findOrFail($id);

        return view('pruebas.show', compact('prueba','menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $menu= Menu::orderBy('id', 'ASC')->get();
        $prueba = prueba::findOrFail($id);

        return view('pruebas.edit', compact('prueba','menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $menu= Menu::orderBy('id', 'ASC')->get();
        $requestData = $request->all();
                if ($request->hasFile('adjunto')) {
            $requestData['adjunto'] = $request->file('adjunto')
                ->store('uploads', 'public');
        }

        $prueba = prueba::findOrFail($id);
        $prueba->update($requestData);

        return redirect('pruebas')->with('flash_message', 'prueba updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        prueba::destroy($id);

        return redirect('pruebas',compact('menu'))->with('flash_message', 'prueba deleted!');
    }
}
