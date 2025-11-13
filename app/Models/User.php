<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'codigo',
        'validado',
        'username',
        'bio',
        'avatarpf',
        'coverp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function salvaPdf($id){

        $user = User::find($id);

        $data = [];

        $data['usuario'] = $user;

        $pdf = Pdf::loadView('pdf.pdf',$data);

        $output = $pdf->output();

    
        $caminho = public_path('pdfs/insane.pdf');

    
        if (!File::exists(public_path('pdfs'))) {
            File::makeDirectory(public_path('pdfs'), 0755, true);
        }

    
        file_put_contents($caminho, $output);

        return response()->json(['message' => 'PDF gerado e salvo com sucesso!', 'caminho' => asset('pdfs/insane.pdf')]);
    }
}
