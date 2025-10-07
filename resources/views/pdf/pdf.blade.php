<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Otaku - NakamaList</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Poppins:wght@600;700&display=swap');
       
        body {
            background-color: #121212;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            padding: 20px;
        }
       
        .certificate {
            width: 90vw;
            max-width: 900px;
            min-height: 600px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            border: 10px solid transparent;
            border-image: linear-gradient(45deg, #ff2d95, #ff8ac8, #ff2d95) 1;
            border-radius: 15px;
            box-shadow: 0 0 40px rgba(255, 45, 149, 0.3);
            padding: 40px 30px;
            position: relative;
            overflow: hidden;
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }
       
        .certificate-border-glow {
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 18px;
            background: linear-gradient(45deg, #ff2d95, #ff8ac8, #ff2d95);
            z-index: -1;
            filter: blur(10px);
            opacity: 0.7;
        }
       
        h1 {
            font-family: 'Poppins', sans-serif;
            color: #ff2d95;
            font-size: clamp(32px, 5vw, 48px);
            margin: 0;
            text-shadow: 0 0 15px rgba(255, 45, 149, 0.4);
            letter-spacing: 3px;
            font-weight: 700;
        }
       
        .subtitle {
            font-family: 'Poppins', sans-serif;
            color: #ff8ac8;
            font-size: clamp(18px, 3vw, 24px);
            margin: 15px 0 30px;
            letter-spacing: 2px;
            font-weight: 600;
        }
       
        .presented-to {
            font-size: clamp(14px, 2vw, 18px);
            margin-bottom: 10px;
            color: #ddd;
            letter-spacing: 1px;
        }
       
        .name {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(24px, 4vw, 36px);
            color: white;
            margin: 25px 0;
            padding: 20px;
            background: rgba(255, 45, 149, 0.15);
            border: 2px dashed #ff5da2;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.2);
        }
       
        .description {
            font-size: clamp(14px, 2vw, 16px);
            line-height: 1.8;
            margin: 30px 20px;
            color: #ccc;
            text-align: center;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
       
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            flex-wrap: wrap;
            gap: 20px;
        }
       
        .signature {
            flex: 1;
            min-width: 150px;
        }
       
        .signature-line {
            width: 80%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff2d95, transparent);
            margin: 10px auto;
        }
       
        .signature-title {
            color: #ff8ac8;
            font-weight: 600;
            margin-top: 10px;
            font-size: clamp(14px, 2vw, 16px);
        }
       
        .decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 3px solid #ff2d95;
            opacity: 0.3;
        }
       
        .top-left {
            top: 15px;
            left: 15px;
            border-right: none;
            border-bottom: none;
            border-radius: 15px 0 0 0;
        }
       
        .top-right {
            top: 15px;
            right: 15px;
            border-left: none;
            border-bottom: none;
            border-radius: 0 15px 0 0;
        }
       
        .bottom-left {
            bottom: 15px;
            left: 15px;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 15px;
        }
       
        .bottom-right {
            bottom: 15px;
            right: 15px;
            border-left: none;
            border-top: none;
            border-radius: 0 0 15px 0;
        }
       
        .anime-icon {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
            font-size: 60px;
        }
       
        .anime-icon-1 {
            top: 10%;
            left: 5%;
        }
       
        .anime-icon-2 {
            bottom: 15%;
            right: 5%;
            font-size: 50px;
        }
       
        @media (max-width: 768px) {
            .certificate {
                padding: 30px 15px;
            }
           
            .description {
                margin: 20px 10px;
            }
           
            .signatures {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-border-glow"></div>
        <div class="decoration top-left"></div>
        <div class="decoration top-right"></div>
        <div class="decoration bottom-left"></div>
        <div class="decoration bottom-right"></div>
       
        <div class="anime-icon anime-icon-1">✿</div>
        <div class="anime-icon anime-icon-2">❀</div>
       
        <div>
            <h1>CERTIFICADO OTAKU</h1>
            <div class="subtitle">– NAKAMALIST HONRA –</div>
           
            <div class="presented-to">ESTE CERTIFICADO É ORGULHOSAMENTE CONFERIDO A</div>
           
            <div class="name"> {{ $usuario->name}} </div>
           
            <div class="description">
                Por demonstrar conhecimento excepcional em cultura otaku, ter assistido mais de 100 animes,
                colecionado memorabilia rara e dedicado incontáveis horas à apreciação da arte japonesa.
                Este certificado atesta oficialmente seu status como verdadeiro Nakama da comunidade otaku,
                com reconhecimento por sua paixão e dedicação ao mundo dos animes e mangás.
            </div>
        </div>
       
        <div class="signatures">
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-title">Arthur Vinícius | Davi Trefs | Guilherme Siqueira</div>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-title">COMUNIDADE OTAKU</div>
            </div>
        </div>
    </div>
</body>
</html>