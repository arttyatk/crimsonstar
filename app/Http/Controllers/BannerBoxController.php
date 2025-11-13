<?php

namespace App\Http\Controllers;

use App\Models\BannerBox;
use App\Models\GachaItem; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerBoxController extends Controller
{
    /**
     * Listar todos os banners e caixas.
     */
   public function index()
    {
        $bannerBoxes = BannerBox::all();
        return response()->json($bannerBoxes);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'tipo' => 'required|in:banner,box',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'itens_ids' => 'nullable|string',
            'status' => 'required|in:ativo,inativo',
        ]);

        try {
        DB::beginTransaction();

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            // A função store() já salva o caminho sem '/storage/'
            $imagemPath = $request->file('imagem')->store('banner_box_images', 'public');
        }

        $bannerBox = BannerBox::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'tipo' => $request->tipo,
            'imagem' => $imagemPath, // Salve apenas o caminho relativo
            'itens_ids' => $request->itens_ids,
            'status' => $request->status,
        ]);

        DB::commit();

        // A resposta JSON agora incluirá a imagem_url graças ao Accessor
        return response()->json(['message' => 'Banner/Box criado com sucesso!', 'data' => $bannerBox], 201);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Erro ao criar o Banner/Box.', 'error' => $e->getMessage()], 500);
    }
    }

    public function show($id)
    {
        $banner = BannerBox::with(['exclusivos'])->findOrFail($id);

        return response()->json([
            'banner' => $banner,
            'exclusivos' => $banner->exclusivos
        ]);
    }

    
    // --- FUNÇÃO DE ATUALIZAÇÃO ---
    public function update(Request $request, $id)
{
    $bannerBox = BannerBox::find($id);

    if (!$bannerBox) {
        return response()->json(['message' => 'Banner/Box não encontrado.'], 404);
    }

    try {
        // Tente validar, se falhar, uma exceção de validação será lançada
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0', // <--- Verifique este campo!
            'tipo' => 'required|in:banner,box',
            // A regra 'imagem' só se aplica se o arquivo foi enviado
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
            'itens_ids' => 'nullable|string',
            'status' => 'required|in:ativo,inativo',
        ]);
    
        DB::beginTransaction();

        $imagemPath = $bannerBox->imagem; // Mantém a imagem antiga por padrão
        
        // CORREÇÃO: Remova os campos que não queremos atualizar diretamente, como o _method, 
        // e use os dados validados.
        $updateData = $validatedData;
        
        if ($request->hasFile('imagem')) {
            // Exclui a imagem antiga, se existir
            if ($bannerBox->imagem) {
                Storage::disk('public')->delete($bannerBox->imagem);
            }
            // Salva a nova imagem e atualiza o caminho nos dados de atualização
            $updateData['imagem'] = $request->file('imagem')->store('banner_box_images', 'public');
        } else {
            // Se não houver novo arquivo, mantenha o caminho antigo
            $updateData['imagem'] = $imagemPath;
        }

        // Garante que o campo 'preco' seja um float para evitar problemas de tipo
        $updateData['preco'] = floatval($validatedData['preco']);


        $bannerBox->update($updateData);

        DB::commit();

        return response()->json(['message' => 'Banner/Box atualizado com sucesso!', 'data' => $bannerBox], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Captura o erro de validação e retorna a mensagem
        return response()->json(['message' => 'Erro de Validação.', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Erro interno ao atualizar o Banner/Box.', 'error' => $e->getMessage()], 500);
    }
    }
    
    // --- FUNÇÃO DE DELETAR ---
    public function destroy($id)
    {
        $bannerBox = BannerBox::find($id);

        if (!$bannerBox) {
            return response()->json(['message' => 'Banner/Box não encontrado.'], 404);
        }

        // Corrigido: Use o caminho da imagem diretamente, pois ele já é o caminho relativo correto
        if ($bannerBox->imagem) {
            Storage::disk('public')->delete($bannerBox->imagem);
        }

        $bannerBox->delete();

        return response()->json(['message' => 'Banner/Box deletado com sucesso.']);
    }
}
