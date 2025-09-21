<?php
session_start();

// Inicializar o jogo se não existir
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = ['', '', '', '', '', '', '', '', ''];
    $_SESSION['currentPlayer'] = 'X';
    $_SESSION['gameActive'] = true;
    $_SESSION['gameMode'] = 'multiplayer'; // 'multiplayer' ou 'singleplayer'
    $_SESSION['scoreX'] = 0;
    $_SESSION['scoreO'] = 0;
}

// Garantir que todas as variáveis existam
if (!isset($_SESSION['gameMode'])) $_SESSION['gameMode'] = 'multiplayer';
if (!isset($_SESSION['scoreX'])) $_SESSION['scoreX'] = 0;
if (!isset($_SESSION['scoreO'])) $_SESSION['scoreO'] = 0;

// Processar movimento se recebido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'move' && isset($_POST['index'])) {
        $index = (int)$_POST['index'];
        
        if ($index >= 0 && $index < 9 && $_SESSION['board'][$index] === '' && $_SESSION['gameActive']) {
            $_SESSION['board'][$index] = $_SESSION['currentPlayer'];
            
            if (checkWinner($_SESSION['board'])) {
                $_SESSION['gameActive'] = false;
                // Incrementar contador de vitórias
                if ($_SESSION['currentPlayer'] === 'X') {
                    $_SESSION['scoreX']++;
                } else {
                    $_SESSION['scoreO']++;
                }
                echo json_encode([
                    'status' => 'win',
                    'winner' => $_SESSION['currentPlayer'],
                    'board' => $_SESSION['board'],
                    'scoreX' => $_SESSION['scoreX'],
                    'scoreO' => $_SESSION['scoreO']
                ]);
            } elseif (checkDraw($_SESSION['board'])) {
                $_SESSION['gameActive'] = false;
                echo json_encode([
                    'status' => 'draw',
                    'board' => $_SESSION['board'],
                    'scoreX' => $_SESSION['scoreX'],
                    'scoreO' => $_SESSION['scoreO']
                ]);
            } else {
                $_SESSION['currentPlayer'] = $_SESSION['currentPlayer'] === 'X' ? 'O' : 'X';
                
                // Se for single player e for a vez da IA (O)
                if ($_SESSION['gameMode'] === 'singleplayer' && $_SESSION['currentPlayer'] === 'O') {
                    $aiMove = getAIMove($_SESSION['board']);
                    $_SESSION['board'][$aiMove] = 'O';
                    
                    if (checkWinner($_SESSION['board'])) {
                        $_SESSION['gameActive'] = false;
                        $_SESSION['scoreO']++;
                        echo json_encode([
                            'status' => 'win',
                            'winner' => 'O',
                            'board' => $_SESSION['board'],
                            'scoreX' => $_SESSION['scoreX'],
                            'scoreO' => $_SESSION['scoreO']
                        ]);
                    } elseif (checkDraw($_SESSION['board'])) {
                        $_SESSION['gameActive'] = false;
                        echo json_encode([
                            'status' => 'draw',
                            'board' => $_SESSION['board'],
                            'scoreX' => $_SESSION['scoreX'],
                            'scoreO' => $_SESSION['scoreO']
                        ]);
                    } else {
                        $_SESSION['currentPlayer'] = 'X';
                        echo json_encode([
                            'status' => 'continue',
                            'currentPlayer' => $_SESSION['currentPlayer'],
                            'board' => $_SESSION['board'],
                            'scoreX' => $_SESSION['scoreX'],
                            'scoreO' => $_SESSION['scoreO']
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status' => 'continue',
                        'currentPlayer' => $_SESSION['currentPlayer'],
                        'board' => $_SESSION['board'],
                        'scoreX' => $_SESSION['scoreX'],
                        'scoreO' => $_SESSION['scoreO']
                    ]);
                }
            }
        } else {
            echo json_encode(['status' => 'invalid']);
        }
    } elseif ($action === 'reset') {
        $_SESSION['board'] = ['', '', '', '', '', '', '', '', ''];
        $_SESSION['currentPlayer'] = 'X';
        $_SESSION['gameActive'] = true;
        echo json_encode([
            'status' => 'reset',
            'currentPlayer' => $_SESSION['currentPlayer'],
            'board' => $_SESSION['board'],
            'scoreX' => $_SESSION['scoreX'],
            'scoreO' => $_SESSION['scoreO']
        ]);
    } elseif ($action === 'toggle_mode') {
        $_SESSION['gameMode'] = $_SESSION['gameMode'] === 'multiplayer' ? 'singleplayer' : 'multiplayer';
        $_SESSION['board'] = ['', '', '', '', '', '', '', '', ''];
        $_SESSION['currentPlayer'] = 'X';
        $_SESSION['gameActive'] = true;
        echo json_encode([
            'status' => 'mode_changed',
            'gameMode' => $_SESSION['gameMode'],
            'currentPlayer' => $_SESSION['currentPlayer'],
            'board' => $_SESSION['board'],
            'scoreX' => $_SESSION['scoreX'],
            'scoreO' => $_SESSION['scoreO']
        ]);
    }
    exit;
}

function checkWinner($board) {
    $winningConditions = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // linhas
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // colunas
        [0, 4, 8], [2, 4, 6] // diagonais
    ];
    
    foreach ($winningConditions as $condition) {
        [$a, $b, $c] = $condition;
        if ($board[$a] && $board[$a] === $board[$b] && $board[$a] === $board[$c]) {
            return true;
        }
    }
    return false;
}

function checkDraw($board) {
    return !in_array('', $board);
}

function getAIMove($board) {
    // Estratégia simples da IA: tentar ganhar, depois bloquear, depois centro, depois cantos, depois laterais
    
    // 1. Tentar ganhar
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === '') {
            $board[$i] = 'O';
            if (checkWinner($board)) {
                return $i;
            }
            $board[$i] = '';
        }
    }
    
    // 2. Bloquear jogador
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === '') {
            $board[$i] = 'X';
            if (checkWinner($board)) {
                $board[$i] = '';
                return $i;
            }
            $board[$i] = '';
        }
    }
    
    // 3. Centro
    if ($board[4] === '') return 4;
    
    // 4. Cantos
    $corners = [0, 2, 6, 8];
    foreach ($corners as $corner) {
        if ($board[$corner] === '') return $corner;
    }
    
    // 5. Laterais
    $sides = [1, 3, 5, 7];
    foreach ($sides as $side) {
        if ($board[$side] === '') return $side;
    }
    
    return 0; // fallback
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo da Velha - Jogue Online Grátis</title>
    <meta name="description" content="Jogue Jogo da Velha online grátis! Interface moderna com tema dark, perfeito para 2 jogadores. Divirta-se com este clássico jogo de estratégia.">
    <meta name="keywords" content="jogo da velha, tic tac toe, jogo online, grátis, 2 jogadores, estratégia">
    <meta name="author" content="elinaldo-nasc">
    <meta property="og:title" content="Jogo da Velha - Jogue Online Grátis">
    <meta property="og:description" content="Jogue Jogo da Velha online grátis! Interface moderna com tema dark, perfeito para 2 jogadores.">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Jogo da Velha</h1>
        <div class="game-info">
            <div class="score-board">
                <div class="score">
                    <span class="player-x">X</span>
                    <span id="score-x"><?php echo $_SESSION['scoreX']; ?></span>
                </div>
                <div class="vs">VS</div>
                <div class="score">
                    <span class="player-o">O</span>
                    <span id="score-o"><?php echo $_SESSION['scoreO']; ?></span>
                </div>
            </div>
            <p>Jogador atual: <span id="current-player"><?php echo $_SESSION['currentPlayer']; ?></span></p>
            <div class="controls">
                <button id="mode-btn">Modo: <?php echo $_SESSION['gameMode'] === 'multiplayer' ? '2 Jogadores' : 'vs IA'; ?></button>
                <button id="reset-btn">Novo Jogo</button>
            </div>
        </div>
        <div class="board" id="board">
            <?php for ($i = 0; $i < 9; $i++): ?>
                <div class="cell" data-index="<?php echo $i; ?>"><?php echo $_SESSION['board'][$i]; ?></div>
            <?php endfor; ?>
        </div>
        <div class="message" id="message"></div>
    </div>
    
    <script>
        class JogoDaVelhaPHP {
            constructor() {
                this.initializeGame();
            }
            
            initializeGame() {
                const cells = document.querySelectorAll('.cell');
                const resetBtn = document.getElementById('reset-btn');
                const modeBtn = document.getElementById('mode-btn');
                
                cells.forEach((cell, index) => {
                    cell.addEventListener('click', () => this.handleCellClick(index));
                });
                
                resetBtn.addEventListener('click', () => this.resetGame());
                modeBtn.addEventListener('click', () => this.toggleMode());
            }
            
            async handleCellClick(index) {
                const formData = new FormData();
                formData.append('action', 'move');
                formData.append('index', index);
                
                try {
                    const response = await fetch('game.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    this.updateBoard(result.board);
                    this.updateScore(result.scoreX, result.scoreO);
                    
                    if (result.status === 'win') {
                        this.showMessage(`Jogador ${result.winner} venceu!`);
                    } else if (result.status === 'draw') {
                        this.showMessage('Empate!');
                    } else if (result.status === 'continue') {
                        document.getElementById('current-player').textContent = result.currentPlayer;
                    }
                } catch (error) {
                    console.error('Erro:', error);
                }
            }
            
            async resetGame() {
                const formData = new FormData();
                formData.append('action', 'reset');
                
                try {
                    const response = await fetch('game.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    this.updateBoard(result.board);
                    this.updateScore(result.scoreX, result.scoreO);
                    document.getElementById('current-player').textContent = result.currentPlayer;
                    document.getElementById('message').textContent = '';
                    document.getElementById('message').className = 'message';
                } catch (error) {
                    console.error('Erro:', error);
                }
            }
            
            updateBoard(board) {
                document.querySelectorAll('.cell').forEach((cell, index) => {
                    cell.textContent = board[index];
                    cell.className = 'cell';
                    if (board[index]) {
                        cell.classList.add(board[index].toLowerCase());
                    }
                });
            }
            
            
            async toggleMode() {
                const formData = new FormData();
                formData.append('action', 'toggle_mode');
                
                try {
                    const response = await fetch('game.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    this.updateBoard(result.board);
                    this.updateScore(result.scoreX, result.scoreO);
                    document.getElementById('current-player').textContent = result.currentPlayer;
                    document.getElementById('mode-btn').textContent = `Modo: ${result.gameMode === 'multiplayer' ? '2 Jogadores' : 'vs IA'}`;
                    document.getElementById('message').textContent = '';
                    document.getElementById('message').className = 'message';
                } catch (error) {
                    console.error('Erro:', error);
                }
            }
            
            updateScore(scoreX, scoreO) {
                document.getElementById('score-x').textContent = scoreX;
                document.getElementById('score-o').textContent = scoreO;
            }
            
            showMessage(message) {
                const messageElement = document.getElementById('message');
                messageElement.textContent = message;
                if (message.includes('venceu')) {
                    if (message.includes('X')) {
                        messageElement.className = 'message win';
                    } else if (message.includes('O')) {
                        messageElement.className = 'message draw';
                    }
                } else {
                    messageElement.className = 'message draw';
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            new JogoDaVelhaPHP();
        });
    </script>
</body>
</html>
