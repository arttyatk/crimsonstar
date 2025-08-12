<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Certifique-se de importar Storage
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class AnimeController extends Controller
{
    public function catalogo()
    {
        // Busca todos os animes do banco de dados
        $animes = Anime::all();

        // Retorna a view com os dados
        return view('animes', compact('animes'));
    }

    /**
     * Retorna a lista de animes (para API AJAX).
     */
    public function index(Request $request)
    {
        $query = Anime::query();

        // Filtro por gênero (busca parcial)
        if ($request->filled('genero')) {
            $query->where('generos', 'like', '%' . $request->input('genero') . '%');
        }

        // Filtro por nota mínima e máxima
        if ($request->filled('nota_min')) {
            $query->where('nota', '>=', $request->input('nota_min'));
        }

        if ($request->filled('nota_max')) {
            $query->where('nota', '<=', $request->input('nota_max'));
        }

        // Filtro por popularidade mínima
        if ($request->filled('popularidade_min')) {
            $query->where('popularidade', '>=', $request->input('popularidade_min'));
        }
        if ($request->filled('popularidade_max')) {
            $query->where('popularidade', '<=', $request->input('popularidade_max'));
        }

        // Ordenação
        if ($request->filled('ordenar_por')) {
            $direcao = $request->input('ordenar_direcao', 'asc'); // padrão asc
            $query->orderBy($request->input('ordenar_por'), $direcao);
        }

        // Para cada anime, adicione a URL completa da capa
        $animes = $query->get()->map(function ($anime) {
            if ($anime->cover_image) {
                // Se a imagem está em public/images/animes, use asset()
                $anime->full_cover_image_url = asset($anime->cover_image);
            } else {
                $anime->full_cover_image_url = null;
            }
            return $anime;
        });

        return response()->json($animes);
    }

    /**
     * Cria um novo anime no armazenamento (para API AJAX).
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário, incluindo a imagem
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'titulo_alternativo' => 'nullable|string|max:255',
            'nota' => 'required|numeric|min:0|max:10', // Alterado para required como no seu HTML
            'popularidade' => 'required|integer|min:0', // Alterado para required como no seu HTML
            'generos' => 'required|string',
            'autor' => 'nullable|string|max:255',
            'estudio' => 'nullable|string|max:255',
            'ano_lancamento' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'episodios' => 'required|integer|min:0', // Alterado para required como no seu HTML
            'descricao' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagem é opcional no upload
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cria uma nova instância do Anime
        $anime = new Anime();
        $anime->fill($request->except('cover_image')); // Preenche todos os campos exceto a imagem

        // Lidar com o upload da imagem
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            
            // Garante que o diretório exista
            $directory = public_path('images/animes');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Gera um nome único para a imagem
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Move a imagem para a pasta public/images/animes
            $image->move($directory, $imageName);
            
            // Armazena o caminho relativo (ex: 'images/animes/12345.jpg')
            $anime->cover_image = 'images/animes/' . $imageName;
        }

        $anime->save();

        return response()->json($anime, 201); // Retorna JSON com o novo anime
    }

    /**
     * Exibe o anime especificado (para API AJAX).
     */
    public function show($id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            return response()->json(['message' => 'Anime não encontrado'], 404);
        }

        // Adiciona a URL completa da capa antes de retornar
        if ($anime->cover_image) {
            $anime->full_cover_image_url = asset($anime->cover_image);
        } else {
            $anime->full_cover_image_url = null;
        }

        return response()->json($anime);
    }

    /**
     * Atualiza o anime especificado no armazenamento (para API AJAX).
     */
    public function update(Request $request, $id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            return response()->json(['message' => 'Anime não encontrado'], 404);
        }

        // Validação dos dados do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255', // Alterado para required
            'titulo_alternativo' => 'nullable|string|max:255',
            'nota' => 'required|numeric|min:0|max:10', // Alterado para required
            'popularidade' => 'required|integer|min:0', // Alterado para required
            'generos' => 'required|string', // Alterado para required
            'autor' => 'nullable|string|max:255',
            'estudio' => 'nullable|string|max:255',
            'ano_lancamento' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'episodios' => 'required|integer|min:0', // Alterado para required
            'descricao' => 'required|string', // Alterado para required
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagem é opcional na edição
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $anime->fill($request->except('cover_image', '_method')); // Preenche todos os campos exceto a imagem e _method

        // Lidar com o upload da nova imagem, se houver
        if ($request->hasFile('cover_image')) {
            // Remove a imagem antiga se existir
            if ($anime->cover_image && file_exists(public_path($anime->cover_image))) {
                unlink(public_path($anime->cover_image));
            }

            // Garante que o diretório exista
            $directory = public_path('images/animes');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $image = $request->file('cover_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($directory, $imageName);
            $anime->cover_image = 'images/animes/' . $imageName;
        } elseif ($request->has('clear_cover_image') && $request->input('clear_cover_image') === 'true') {
            // Lógica para remover a imagem se o cliente indicar
            if ($anime->cover_image && file_exists(public_path($anime->cover_image))) {
                unlink(public_path($anime->cover_image));
            }
            $anime->cover_image = null; // Limpa o campo no banco de dados
        }


        $anime->save();

        return response()->json($anime); // Retorna JSON com o anime atualizado
    }

    /**
     * Remove o anime especificado do armazenamento.
     */
    public function destroy($id)
    {
        $anime = Anime::findOrFail($id);

        // Remover a imagem de capa do disco ao excluir o anime
        if ($anime->cover_image && file_exists(public_path($anime->cover_image))) {
            unlink(public_path($anime->cover_image));
        }

        $anime->delete();
        
        return response()->json(['success' => 'Anime excluído com sucesso!']);
    }

    // Os métodos 'showlaravel', 'edit', 'updateFromForm' e 'atualizar', 'excluir', 'gerapdf'
    // parecem ser para rotas de Blade ou para usuários. Mantidos como estavam.
    // Lembre-se de que se 'updateFromForm' não for usado por um formulário HTML normal, pode ser removido.

    public function showlaravel($id)
    {
        $anime = Anime::findOrFail($id);
        return view('descricaoanime', compact('anime'));
    }

    public function edit($id)
    {
        $anime = Anime::findOrFail($id);
        return view('animeedit', compact('anime'));
    }

    public function updateFromForm(Request $request, $id)
    {
        $anime = Anime::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'titulo_alternativo' => 'nullable|string|max:255',
            'nota' => 'required|numeric|min:0|max:10',
            'popularidade' => 'required|integer|min:0',
            'generos' => 'required|string',
            'autor' => 'nullable|string|max:255',
            'estudio' => 'nullable|string|max:255',
            'ano_lancamento' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'episodios' => 'required|integer|min:0',
            'descricao' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $anime->nome = $request->nome;
        $anime->titulo_alternativo = $request->titulo_alternativo;
        $anime->nota = $request->nota;
        $anime->popularidade = $request->popularidade;
        $anime->generos = $request->generos;
        $anime->autor = $request->autor;
        $anime->estudio = $request->estudio;
        $anime->ano_lancamento = $request->ano_lancamento;
        $anime->episodios = $request->episodios;
        $anime->descricao = $request->descricao;

        if ($request->hasFile('cover_image')) {
            if ($anime->cover_image && file_exists(public_path($anime->cover_image))) {
                unlink(public_path($anime->cover_image));
            }

            if (!file_exists(public_path('images/animes'))) {
                mkdir(public_path('images/animes'), 0777, true);
            }

            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('images/animes'), $imageName);
            $anime->cover_image = 'images/animes/'.$imageName;
        }

        $anime->save();

        return redirect()->route('catalogo')->with('success', 'Anime atualizado com sucesso!');
    }

    public function atualizar(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'username' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->filled('username')) {
            $user->name = $request->input('username');
        }
    
        if ($request->filled('bio')) {
            $user->bio = $request->input('bio');
        }
    
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $oldAvatarPath = public_path('images/avatars/' . basename($user->avatar));
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
    
            $avatar = $request->file('avatar');
            $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            
            if (!file_exists(public_path('images/avatars'))) {
                mkdir(public_path('images/avatars'), 0777, true);
            }
            
            $avatar->move(public_path('images/avatars'), $avatarName);
            $user->avatar = 'images/avatars/' . $avatarName;
        }
    
        if ($request->filled('generos')) {
            $user->generos = $request->input('generos');
        }
    
        $user->save();
    
        return redirect()->route('inicio')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function excluir()
    {
        $user = auth()->user();

        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        $user->delete();

        return redirect()->route('inicio')->with('success', 'Perfil excluído com sucesso!');
    }

    public function gerapdf($id){
        $user = User::where('id',$id)->get()->first();

        $data = [];
        $data['usuario'] = $user;
        
        $pdf = Pdf::loadView('pdf.pdf',$data);
        return $pdf->download('insane.pdf');
    }

    public function dashboardStats()
    {
        $totalAnimes = Anime::count();
        $totalUsers = User::count();
        $totalEpisodes = Anime::sum('episodios');
        $averageRating = Anime::avg('nota');

        $latestAnimes = Anime::orderBy('created_at', 'desc')->take(5)->get();

        $latestAnimes->transform(function ($anime) {
            $anime->full_cover_image_url = $anime->cover_image
                ? asset($anime->cover_image)
                : null;
            return $anime;
        });

        return response()->json([
            'total_animes' => $totalAnimes,
            'total_users' => $totalUsers,
            'total_episodes' => $totalEpisodes,
            'average_rating' => round($averageRating, 1),
            'latest_animes' => $latestAnimes
        ]);
    }

    public function genreDistribution()
    {
        $animes = Anime::all();
        $genreCount = [];
        
        foreach ($animes as $anime) {
            $genres = explode(',', $anime->generos);
            foreach ($genres as $genre) {
                $genre = trim($genre);
                if (!isset($genreCount[$genre])) {
                    $genreCount[$genre] = 0;
                }
                $genreCount[$genre]++;
            }
        }
        
        arsort($genreCount);
        
        return response()->json([
            'labels' => array_keys($genreCount),
            'data' => array_values($genreCount)
        ]);
    }

    public function monthlyActivity()
    {
        $activity = Anime::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($activity as $item) {
            $labels[] = date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year));
            $data[] = $item->count;
        }
        
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    public function getUserInfo(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Retorna a URL completa da foto do usuário se existir, caso contrário, null
            $photoUrl = $user->photo_url ? asset($user->avatar) : null;
            // Se o seu campo 'avatar' for usado como 'photo_url'
            // $photoUrl = $user->avatar ? asset($user->avatar) : null;


            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'photo_url' => $photoUrl,
            ]);
        }

        return response()->json(['message' => 'Não autenticado.'], 401);
    }

    public function getAnimesByPopularity(Request $request)
    {


        $query = Anime::query(); 

        
        if ($request->has('search') && !empty($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where('nome', 'like', '%' . $searchTerm . '%');
        }

        // 2. Filtrar por popularidade mínima (se fornecida)
        if ($request->has('min_popularidade') && is_numeric($request->input('min_popularidade'))) {
            $minPopularidade = (int) $request->input('min_popularidade');
            $query->where('popularidade', '>=', $minPopularidade);
        }

        // 3. Filtrar por popularidade máxima (se fornecida)
        if ($request->has('max_popularidade') && is_numeric($request->input('max_popularidade'))) {
            $maxPopularidade = (int) $request->input('max_popularidade');
            $query->where('popularidade', '<=', $maxPopularidade);
        }

        // 4. Ordenar os resultados por popularidade (do maior para o menor)
        $animes = $query->orderBy('popularidade', 'desc')->get();

        return response()->json($animes);
    }
    
}