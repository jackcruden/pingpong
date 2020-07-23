<?php

define('FILENAME', 'data.txt');

if (isset($_POST['add'])) {
    save(clean(@$_POST['player1']), clean(@$_POST['player2']), clean(@$_POST[$_POST['winner']]));
}

function clean($input): string {
    $input = strtolower(preg_replace("/[^A-Za-z ]/", '', $input));
    return ucwords($input);
}

function save($player1, $player2, $winner) {
    if (! $winner) {
        echo 'Oops, you forgot to set a winner.';
        return;
    }

    $current = @file_get_contents(FILENAME);
    $current .= "$player1,$player2,$winner\n";
    file_put_contents(FILENAME, $current);

    setcookie('player1', clean($_POST['player1']));
    setcookie('player2', clean($_POST['player2']));

    header('Location: /');
    exit;
}

function all(): array {
    $games = explode(PHP_EOL, @file_get_contents(FILENAME));
    for ($i = 0; $i < count($games); $i++) {
        $games[$i] = array_filter(explode(',', $games[$i]));
    }
    return array_filter($games);
}

function leaderboard(): array {
    $players = [];

    foreach (all() as $game) {
        // If no player1, initialise them
        if (! isset($players[$game[0]])) {
            $players[$game[0]] = [0, 0];
        }
        // If no player2, initialise them
        if (! isset($players[$game[1]])) {
            $players[$game[1]] = [0, 0];
        }

        // Increment winner
        $players[$game[2]][0]++;

        // Increment loser
        $loser = $game[2] == $game[0] ? $game[1] : $game[0];
        $players[$loser][1]++;
    }

    return $players;
}

function ratio(array $games): string {
    return round($games[0] / array_sum($games) * 100).'%';
}

$debug = '';
if ($debug) {
    echo '<pre>';
    echo json_encode(leaderboard());exit;
}

?>

<html>
<head>
    <title>Ping Pong 🏓</title>

    <meta name="viewport" content="width=device-width, scale=1.0, user-scalable=no, viewport-fit=cover">

    <style>
        html {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            font-size: 1.3em;
        }

        .justify-between {
            display: flex;
            justify-content: space-between;
        }

        button, input, select {
            width: 100%;
            padding: 10px 15px;
            border: 3px solid black;
            border-radius: 3px;
            font-weight: bold;
            appearance: none;
        }

        button {
            background-color: black;
            color: white;
        }

        input, select {
            background-color: white;
            color: black;
        }

        .mt {
            margin-top: 6px;
        }

        .mb {
            margin-bottom: 6px;
        }

        .ml {
            margin-left: 3px;
        }

        .mr {
            margin-right: 3px;
        }
    </style>
</head>
<body>
    <div class="justify-between">
        <div><h1>Ping Pong 🏓</h1></div>
        <button onclick="document.getElementById('add').style.display = 'block';" style="align-self: center; width: auto;">
            Add Game
        </button>
    </div>

    <div id="add" style="display: none;">
        <h3>Add Game</h3>

        <form method="post">
            <div class="justify-between mb">
                <input name="player1" type="text" placeholder="You" class="mr" required value="<?= @$_COOKIE['player1'] ?>">
                <input name="player2" type="text" placeholder="Opponent" class="ml" required value="<?= @$_COOKIE['player2'] ?>">
            </div>

            <div class="justify-between">
                <select name="winner" class="mr" required>
                    <option disabled selected>Winner</option>
                    <option value="player1">Player 1</option>
                    <option value="player2">Player 2</option>
                </select>
                <button name="add" class="ml">Save</button>
            </div>
        </form>
    </div>

    <h3>Leaderboard</h3>
    <?php for ($i = 0; $i < count(leaderboard()); $i++): ?>
        <div class="justify-between">
            <div>
                <?= 0 == $i ? '🥇' : '' ?>
                <?= 1 == $i ? '🥈' : '' ?>
                <?= 2 == $i ? '🥉' : '' ?>
                <?= 3 <= $i ? '👤' : '' ?>
                <?= array_keys(leaderboard())[$i] ?>
            </div>
            <div>
                🏆
                <?= leaderboard()[array_keys(leaderboard())[$i]][0] ?>
                ☠️
                <?= leaderboard()[array_keys(leaderboard())[$i]][1] ?>
                (<?= ratio(leaderboard()[array_keys(leaderboard())[$i]]) ?>)
            </div>
        </div>
    <?php endfor ?>

    <h3>Recent</h3>
    <?php foreach (all() as $game): ?>
        <div class="justify-between">
            <div>🏓 <?= $game[0] ?> v <?= $game[1] ?></div>
            <div>🏆 <?= $game[2] ?></div>
        </div>
    <?php endforeach ?>
</body>
</html>
