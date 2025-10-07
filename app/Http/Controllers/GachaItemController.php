<?php

namespace App\Http\Controllers;

use App\Models\GachaItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\BannerBox;

class GachaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = GachaItem::query();

            // Filtrar por tipo se o parâmetro existir
            if ($request->has('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            $items = $query->get();

            return response()->json($items, Response::HTTP_OK);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'tipo' => 'required|in:personagem,item',
            'raridade' => 'required|in:comum,incomum,raro,epico,legendario',
            'descricao' => 'nullable|string',
            'passivas' => 'nullable|array',
            'habilidades' => 'nullable|array',
            'status' => 'sometimes|boolean',
            'taxa_drop' => 'required|numeric|between:0,100',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            // CORREÇÃO: Apenas armazena o caminho relativo do arquivo.
            $path = $request->file('imagem')->store('gacha_images', 'public');
            $validatedData['imagem'] = $path;
        }

        $item = GachaItem::create($validatedData);

        return response()->json($item, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GachaItem  $item
     * @return \Illuminate\Http\Response
     */
    public function show(GachaItem $gacha_item)
    {
        return response()->json($gacha_item, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GachaItem  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GachaItem $gacha_item)
    {
        $validatedData = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'titulo' => 'nullable|string|max:255',
            'tipo' => 'sometimes|required|in:personagem,item',
            'raridade' => 'sometimes|required|in:comum,incomum,raro,epico,legendario',
            'descricao' => 'nullable|string',
            'passivas' => 'nullable|array',
            'habilidades' => 'nullable|array',
            'status' => 'sometimes|boolean',
            'taxa_drop' => 'sometimes|required|numeric|between:0,100',
            'imagem' => 'nullable|image|max:2048',
        ]);

        // CORREÇÃO: Apenas armazena o caminho relativo do arquivo.
        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('gacha_images', 'public');
            $validatedData['imagem'] = $path;
        }

        $gacha_item->update($validatedData);
        return response()->json($gacha_item, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GachaItem  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(GachaItem $gacha_item)
    {
        $gacha_item->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function retorna_itens(Request $request){

        $itens = GachaItem::get()->all();

        //foreach($itens as $a){

            // $user = User::find($a['user_id']);

            // $a['name'] = $user->name;
        //}

        $data = [
            "erro" => 'n',
            "data" => $itens];

        return response()->json($data, 200);
        
    }

    public function atribuirExclusivo(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:banner_boxes,id',
            'item_id'   => 'required|exists:table_gacha_items,id',
        ]);

        $banner = BannerBox::findOrFail($request->banner_id);
        $item = GachaItem::findOrFail($request->item_id);

        // vincula o item como exclusivo, usando a taxa_drop do próprio item
        $banner->exclusivos()->syncWithoutDetaching([
            $item->id => ['taxa_drop' => $item->taxa_drop]
        ]);

        return response()->json([
            'message' => 'Item exclusivo atribuído com sucesso!',
            'banner' => $banner->load('exclusivos')
        ]);
    }

    
}