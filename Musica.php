<?php
// musica.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reproductor de Música</title>

    <style>
        body{
            background:#0f172a;
            font-family: Arial, sans-serif;
            color:white;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .player{
            background:#020617;
            padding:25px;
            border-radius:15px;
            text-align:center;
            width:300px;
            box-shadow:0 0 20px rgba(0,0,0,0.5);
        }

        h2{
            margin-bottom:15px;
        }

        button{
            margin:5px;
            padding:10px 15px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            background:#2563eb;
            color:white;
            font-weight:bold;
        }

        button:hover{
            background:#1d4ed8;
        }

        input[type=range]{
            width:100%;
            margin-top:10px;
        }
    </style>
</head>

<body>

<div class="player">
    <h2>🎵 Reproductor PHP</h2>

    <audio id="audio">
        <source src="musica.mp3" type="audio/mpeg">
        Tu navegador no soporta audio HTML5.
    </audio>

    <div>
        <button onclick="playAudio()">▶ Play</button>
        <button onclick="pauseAudio()">⏸ Pause</button>
        <button onclick="stopAudio()">⏹ Stop</button>
    </div>

    <div>
        <label>Volumen</label>
        <input type="range" min="0" max="1" step="0.01" onchange="setVolume(this.value)">
    </div>
</div>

<script>
    const audio = document.getElementById("audio");

    function playAudio(){
        audio.play();
    }

    function pauseAudio(){
        audio.pause();
    }

    function stopAudio(){
        audio.pause();
        audio.currentTime = 0;
    }

    function setVolume(value){
        audio.volume = value;
    }
</script>

</body>
</html>
